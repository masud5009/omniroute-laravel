<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AiProvider;
use App\Models\GatewayKey;
use App\Models\GatewayLog;
use App\Models\RoutingCombo;
use App\Services\Gateway\FormatTranslator;
use App\Services\Gateway\OmniRouterService;
use App\Services\Gateway\PromptCompressor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GatewayController extends Controller
{
    /**
     * Create a new GatewayController instance.
     */
    public function __construct(
        protected OmniRouterService $router,
        protected PromptCompressor $compressor,
        protected FormatTranslator $translator
    ) {}

    /**
     * Return OpenAI-compatible model list.
     *
     * GET /v1/models
     */
    public function models(Request $request): JsonResponse
    {
        $models = [];

        // 1. Include active RoutingCombos
        $combos = RoutingCombo::where('is_active', true)->get();
        foreach ($combos as $combo) {
            $models[] = [
                'id' => $combo->name,
                'object' => 'model',
                'created' => $combo->created_at?->timestamp ?? time(),
                'owned_by' => 'omniroute',
                'permission' => [],
                'root' => $combo->name,
                'parent' => null,
            ];
        }

        // 2. Include provider_slug/model_name for active providers with at least one active account
        $providers = AiProvider::where('is_active', true)
            ->whereHas('accounts', function ($q) {
                $q->where('is_active', true);
            })
            ->get();

        foreach ($providers as $provider) {
            $catalog = $provider->models_catalog ?? [];
            if (is_array($catalog)) {
                foreach ($catalog as $modelName) {
                    $fullId = "{$provider->slug}/{$modelName}";
                    $models[] = [
                        'id' => $fullId,
                        'object' => 'model',
                        'created' => $provider->created_at?->timestamp ?? time(),
                        'owned_by' => $provider->slug,
                        'permission' => [],
                        'root' => $fullId,
                        'parent' => null,
                    ];
                }
            }
        }

        return response()->json([
            'object' => 'list',
            'data' => $models,
        ]);
    }

    /**
     * Handle OpenAI Chat Completions requests (sync or streaming).
     *
     * POST /v1/chat/completions
     */
    public function chatCompletions(Request $request): JsonResponse|StreamedResponse
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string',
            'messages' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'message' => $validator->errors()->first(),
                    'type' => 'invalid_request_error',
                    'code' => 'missing_required_parameter',
                ],
            ], 400);
        }

        /** @var GatewayKey|null $gatewayKey */
        $gatewayKey = $request->attributes->get('gateway_key');
        $payload = $request->all();

        // If client requested SSE streaming
        if ($request->boolean('stream')) {
            return $this->streamCompletions($payload, $gatewayKey);
        }

        // Synchronous dispatch
        try {
            $result = $this->router->dispatchSync($payload, $gatewayKey);

            return response()->json($result['response'], 200, [
                'X-OmniRoute-Provider' => $result['meta']['provider'] ?? '',
                'X-OmniRoute-Model' => $result['meta']['model'] ?? '',
                'X-OmniRoute-Account' => $result['meta']['account'] ?? '',
                'X-OmniRoute-Saved-Tokens' => (string) ($result['meta']['saved_tokens'] ?? 0),
                'X-OmniRoute-Latency-Ms' => (string) ($result['meta']['latency_ms'] ?? 0),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                    'type' => 'api_error',
                    'code' => 'gateway_dispatch_error',
                ],
            ], 502);
        }
    }

    /**
     * Stream completions using shared-hosting compatible SSE via native cURL.
     */
    public function streamCompletions(array $payload, ?GatewayKey $gatewayKey): StreamedResponse
    {
        return new StreamedResponse(function () use ($payload, $gatewayKey) {
            // Disable all PHP output buffering for shared hosting compatibility
            @ini_set('output_buffering', 'off');
            @ini_set('zlib.output_compression', 'Off');
            @set_time_limit(0);

            while (ob_get_level() > 0) {
                @ob_end_flush();
            }
            @ob_implicit_flush(true);

            $streamStartTime = microtime(true);
            $requestedModel = $payload['model'] ?? 'auto';

            // Resolve target sequence and compression modes
            $resolved = $this->router->resolveTargets($requestedModel);
            $targets = $resolved['targets'];
            $compressionModes = $resolved['compression_modes'] ?? ['dedup', 'lite'];

            $savedTokens = 0;
            if (!empty($payload['messages']) && is_array($payload['messages'])) {
                $compressed = $this->compressor->compress($payload['messages'], $compressionModes);
                $payload['messages'] = $compressed['messages'];
                $savedTokens = $compressed['saved_tokens'];
            }

            $attemptErrors = [];
            $streamSuccess = false;

            foreach ($targets as $target) {
                if ($streamSuccess) {
                    break;
                }

                $providerSlug = $target['provider'];
                $modelName = $target['model'];

                if (Cache::has("circuit_open:{$providerSlug}")) {
                    $attemptErrors[] = "Provider '{$providerSlug}' circuit open";
                    continue;
                }

                $provider = AiProvider::where('slug', $providerSlug)
                    ->where('is_active', true)
                    ->first();

                if (!$provider) {
                    $attemptErrors[] = "Provider '{$providerSlug}' inactive or not found";
                    continue;
                }

                $accounts = $this->router->getHealthyAccounts($providerSlug);
                if ($accounts->isEmpty()) {
                    $attemptErrors[] = "Provider '{$providerSlug}' has no healthy accounts";
                    continue;
                }

                foreach ($accounts as $account) {
                    if ($streamSuccess) {
                        break;
                    }

                    $targetPayload = $payload;
                    $targetPayload['model'] = $modelName;
                    $targetPayload['stream'] = true;

                    $format = $provider->format;
                    $baseUrl = rtrim($provider->base_url, '/');

                    if ($format === 'anthropic') {
                        $url = str_ends_with($baseUrl, '/messages') ? $baseUrl : $baseUrl . '/messages';
                        $curlHeaders = [
                            'x-api-key: ' . $account->api_key,
                            'anthropic-version: 2023-06-01',
                            'Content-Type: application/json',
                            'Accept: text/event-stream',
                        ];
                        $bodyJson = json_encode($this->translator->toAnthropicPayload($modelName, $targetPayload));
                    } else {
                        $url = str_ends_with($baseUrl, '/chat/completions') ? $baseUrl : $baseUrl . '/chat/completions';
                        $curlHeaders = [
                            'Authorization: Bearer ' . $account->api_key,
                            'Content-Type: application/json',
                            'Accept: text/event-stream',
                        ];
                        $bodyJson = json_encode($targetPayload);
                    }

                    // Native cURL handle for precise streaming control
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $httpStatusCode = 0;
                    $errorBuffer = '';
                    $streamStartedForThisAttempt = false;
                    $sseBuffer = '';
                    $streamedChunksCount = 0;

                    // Inspect HTTP headers as they arrive
                    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $headerLine) use (&$httpStatusCode) {
                        if (preg_match('/^HTTP\/[\d\.]+\s+(\d+)/i', $headerLine, $matches)) {
                            $httpStatusCode = (int) $matches[1];
                        }
                        return strlen($headerLine);
                    });

                    // Stream response body chunks directly if 200, buffer if error
                    curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $chunk) use (
                        &$httpStatusCode,
                        &$errorBuffer,
                        &$streamStartedForThisAttempt,
                        &$sseBuffer,
                        &$streamedChunksCount,
                        $format,
                        $modelName
                    ) {
                        // If status is not 200, collect error body without emitting to client
                        if ($httpStatusCode !== 200) {
                            $errorBuffer .= $chunk;
                            return strlen($chunk);
                        }

                        $streamStartedForThisAttempt = true;

                        if ($format === 'anthropic') {
                            $sseBuffer .= $chunk;
                            while (($pos = strpos($sseBuffer, "\n")) !== false) {
                                $line = substr($sseBuffer, 0, $pos);
                                $sseBuffer = substr($sseBuffer, $pos + 1);

                                $translated = $this->translator->translateAnthropicStreamChunk($line, $modelName);
                                if ($translated !== null) {
                                    echo $translated;
                                    $streamedChunksCount++;
                                    if (ob_get_level() > 0) @ob_flush();
                                    @flush();
                                }
                            }
                        } else {
                            echo $chunk;
                            $streamedChunksCount++;
                            if (ob_get_level() > 0) @ob_flush();
                            @flush();
                        }

                        return strlen($chunk);
                    });

                    $reqStartTime = microtime(true);
                    curl_exec($ch);
                    $curlError = curl_error($ch);
                    curl_close($ch);

                    // Flush any leftover buffer for Anthropic stream
                    if ($format === 'anthropic' && $streamStartedForThisAttempt && trim($sseBuffer) !== '') {
                        $translated = $this->translator->translateAnthropicStreamChunk($sseBuffer, $modelName);
                        if ($translated !== null) {
                            echo $translated;
                            if (ob_get_level() > 0) @ob_flush();
                            @flush();
                        }
                    }

                    $latencyMs = (int) round((microtime(true) - $reqStartTime) * 1000);

                    // If stream succeeded, finalize and record success
                    if ($streamStartedForThisAttempt) {
                        $streamSuccess = true;

                        // Increment usage tokens
                        $account->increment('tokens_used_today', max(1, $streamedChunksCount));
                        $account->update(['fail_count' => 0, 'last_error' => null]);

                        if ($gatewayKey) {
                            $gatewayKey->increment('tokens_used_today', max(1, $streamedChunksCount));
                            $gatewayKey->update(['last_used_at' => now()]);
                        }

                        GatewayLog::create([
                            'gateway_key_id' => $gatewayKey?->id,
                            'requested_model' => $requestedModel,
                            'routed_provider' => $providerSlug,
                            'routed_model' => $modelName,
                            'account_label' => $account->label,
                            'prompt_tokens' => 0,
                            'completion_tokens' => $streamedChunksCount,
                            'total_tokens' => $streamedChunksCount,
                            'saved_tokens' => $savedTokens,
                            'latency_ms' => $latencyMs,
                            'status_code' => 200,
                            'error_message' => null,
                        ]);

                        return;
                    }

                    // Otherwise request failed before stream started: put in cooldown and try next key/provider
                    $errText = !empty($errorBuffer) ? $errorBuffer : ($curlError ?: 'Unknown error');
                    $errSnippet = substr($errText, 0, 500);

                    if ($httpStatusCode === 429) {
                        $account->markCooldown(2, "HTTP 429: {$errSnippet}");
                    } elseif (in_array($httpStatusCode, [401, 402, 403], true)) {
                        $account->markCooldown(60, "HTTP {$httpStatusCode}: {$errSnippet}");
                    } elseif ($httpStatusCode >= 500) {
                        $account->markCooldown(1, "HTTP {$httpStatusCode}: {$errSnippet}");
                    } else {
                        $account->update(['last_error' => "HTTP {$httpStatusCode}: {$errSnippet}"]);
                    }

                    $attemptErrors[] = "[{$providerSlug}/{$modelName} - {$account->label}] HTTP {$httpStatusCode}: " . substr($errText, 0, 200);

                    if ($account->fresh()->fail_count >= 5) {
                        Cache::put("circuit_open:{$providerSlug}", true, now()->addMinutes(1));
                    }
                }
            }

            // If all fallback targets failed
            if (!$streamSuccess) {
                $summary = implode(' | ', $attemptErrors);
                $errPayload = [
                    'error' => [
                        'message' => 'OmniRoute streaming fallback exhausted: ' . ($summary ?: 'No healthy accounts available.'),
                        'type' => 'gateway_error',
                        'code' => 'stream_fallback_failed',
                    ],
                ];

                echo "data: " . json_encode($errPayload) . "\n\n";
                echo "data: [DONE]\n\n";
                if (ob_get_level() > 0) @ob_flush();
                @flush();

                GatewayLog::create([
                    'gateway_key_id' => $gatewayKey?->id,
                    'requested_model' => $requestedModel,
                    'routed_provider' => null,
                    'routed_model' => null,
                    'account_label' => null,
                    'prompt_tokens' => 0,
                    'completion_tokens' => 0,
                    'total_tokens' => 0,
                    'saved_tokens' => $savedTokens,
                    'latency_ms' => (int) round((microtime(true) - $streamStartTime) * 1000),
                    'status_code' => 502,
                    'error_message' => $summary ?: 'All providers failed in streaming mode.',
                ]);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, no-transform',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type, X-Requested-With, x-api-key',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
        ]);
    }
}
