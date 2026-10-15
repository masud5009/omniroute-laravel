<?php

namespace App\Services\Gateway;

use App\Models\AiProvider;
use App\Models\GatewayKey;
use App\Models\GatewayLog;
use App\Models\ProviderAccount;
use App\Models\RoutingCombo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OmniRouterService
{
    /**
     * Create a new OmniRouterService instance.
     */
    public function __construct(
        protected PromptCompressor $promptCompressor,
        protected FormatTranslator $formatTranslator
    ) {}

    /**
     * Resolve target providers and models for a given requested model or combo.
     *
     * @param string $requestedModel
     * @return array{targets: array<int, array{provider: string, model: string}>, compression_modes: array<int, string>}
     */
    public function resolveTargets(string $requestedModel): array
    {
        // 1. Check if the model matches an active RoutingCombo
        $combo = RoutingCombo::where('name', $requestedModel)
            ->where('is_active', true)
            ->first();

        if ($combo) {
            $models = $combo->models ?? [];

            // If round-robin strategy, rotate the starting order
            if ($combo->strategy === 'round-robin' && count($models) > 1) {
                $cacheKey = "combo_rr:{$combo->id}";
                if (!Cache::has($cacheKey)) {
                    Cache::forever($cacheKey, 0);
                }
                $counter = (int) Cache::increment($cacheKey);
                $offset = $counter % count($models);
                $models = array_merge(
                    array_slice($models, $offset),
                    array_slice($models, 0, $offset)
                );
            }

            $targets = [];
            foreach ($models as $entry) {
                if (str_contains($entry, '/')) {
                    [$providerSlug, $modelName] = explode('/', $entry, 2);
                } else {
                    $providerSlug = 'openai';
                    $modelName = $entry;
                }

                $targets[] = [
                    'provider' => $providerSlug,
                    'model' => $modelName,
                ];
            }

            return [
                'targets' => $targets,
                'compression_modes' => $combo->compression_modes ?? ['dedup', 'lite'],
            ];
        }

        // 2. Not a combo: parse "provider/model" or search catalogs
        if (str_contains($requestedModel, '/')) {
            [$providerSlug, $modelName] = explode('/', $requestedModel, 2);
            $targets = [
                [
                    'provider' => $providerSlug,
                    'model' => $modelName,
                ],
            ];
        } else {
            $matchedProvider = null;
            $activeProviders = AiProvider::where('is_active', true)->get();

            foreach ($activeProviders as $provider) {
                $catalog = $provider->models_catalog ?? [];
                if (is_array($catalog) && in_array($requestedModel, $catalog, true)) {
                    $matchedProvider = $provider->slug;
                    break;
                }
            }

            if (!$matchedProvider) {
                // Fallback to the first provider that actually has configured active accounts
                $providerWithAccounts = AiProvider::where('is_active', true)
                    ->whereHas('accounts', fn ($q) => $q->where('is_active', true))
                    ->first();
                $matchedProvider = $providerWithAccounts?->slug ?? 'openai';
            }

            $targets = [
                [
                    'provider' => $matchedProvider,
                    'model' => $requestedModel,
                ],
            ];
        }

        return [
            'targets' => $targets,
            'compression_modes' => ['dedup', 'lite'],
        ];
    }

    /**
     * Get healthy and available accounts for a provider slug, ordered by priority and usage.
     *
     * @param string $providerSlug
     * @return Collection<int, ProviderAccount>
     */
    public function getHealthyAccounts(string $providerSlug): Collection
    {
        $today = now()->toDateString();

        // Auto-reset daily usage if the date has changed or is null
        ProviderAccount::whereHas('provider', function ($query) use ($providerSlug) {
            $query->where('slug', $providerSlug);
        })
        ->where(function ($query) use ($today) {
            $query->whereNull('usage_reset_date')
                ->orWhere('usage_reset_date', '<', $today);
        })
        ->update([
            'tokens_used_today' => 0,
            'usage_reset_date' => $today,
        ]);

        return ProviderAccount::with('provider')
            ->whereHas('provider', function ($query) use ($providerSlug) {
                $query->where('slug', $providerSlug)->where('is_active', true);
            })
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('cooldown_until')
                    ->orWhere('cooldown_until', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('daily_token_limit')
                    ->orWhereColumn('tokens_used_today', '<', 'daily_token_limit');
            })
            ->orderBy('priority', 'asc')
            ->orderBy('tokens_used_today', 'asc')
            ->get();
    }

    /**
     * Dispatch chat completion request synchronously across target providers and fallback accounts.
     *
     * @param array<string, mixed> $payload
     * @param GatewayKey|null $gatewayKey
     * @return array{response: array<string, mixed>, meta: array<string, mixed>}
     *
     * @throws RuntimeException
     */
    public function dispatchSync(array $payload, ?GatewayKey $gatewayKey = null): array
    {
        @set_time_limit(120);

        $overallStartTime = microtime(true);
        $requestedModel = $payload['model'] ?? 'auto';

        // 1. Resolve targets and compression modes
        $resolved = $this->resolveTargets($requestedModel);
        $targets = $resolved['targets'];
        $compressionModes = $resolved['compression_modes'] ?? ['dedup', 'lite'];

        if (empty($targets)) {
            throw new RuntimeException("No targets could be resolved for model '{$requestedModel}'.");
        }

        // 2. GatewayKey validation and daily token limits check
        if ($gatewayKey) {
            $today = now()->toDateString();
            if (!$gatewayKey->usage_reset_date || $gatewayKey->usage_reset_date->toDateString() < $today) {
                $gatewayKey->tokens_used_today = 0;
                $gatewayKey->usage_reset_date = $today;
                $gatewayKey->save();
            }

            if (!$gatewayKey->is_active) {
                throw new RuntimeException("Gateway key '{$gatewayKey->name}' is inactive.");
            }

            if ($gatewayKey->daily_token_limit !== null && $gatewayKey->tokens_used_today >= $gatewayKey->daily_token_limit) {
                throw new RuntimeException("Daily token limit exceeded for gateway key '{$gatewayKey->name}'.");
            }
        }

        // 3. Compress prompts
        $savedTokens = 0;
        if (!empty($payload['messages']) && is_array($payload['messages'])) {
            $compressed = $this->promptCompressor->compress($payload['messages'], $compressionModes);
            $payload['messages'] = $compressed['messages'];
            $savedTokens = $compressed['saved_tokens'];
        }

        $attemptErrors = [];

        // 4. Try targets and accounts in priority/fallback sequence
        foreach ($targets as $target) {
            $providerSlug = $target['provider'];
            $modelName = $target['model'];

            // Circuit breaker check
            if (Cache::has("circuit_open:{$providerSlug}")) {
                $attemptErrors[] = "Provider '{$providerSlug}' circuit breaker is open";
                continue;
            }

            $provider = AiProvider::where('slug', $providerSlug)
                ->where('is_active', true)
                ->first();

            if (!$provider) {
                $attemptErrors[] = "Provider '{$providerSlug}' is inactive or not found";
                continue;
            }

            $accounts = $this->getHealthyAccounts($providerSlug);
            if ($accounts->isEmpty()) {
                $attemptErrors[] = "Provider '{$providerSlug}': No healthy accounts (in cooldown or daily limit reached)";
                continue;
            }

            foreach ($accounts as $account) {
                $targetPayload = $payload;
                $targetPayload['model'] = $modelName;

                $format = $provider->format;
                $baseUrl = rtrim($provider->base_url, '/');

                if ($format === 'anthropic') {
                    $url = str_ends_with($baseUrl, '/messages') ? $baseUrl : $baseUrl . '/messages';
                    $headers = [
                        'x-api-key' => $account->api_key,
                        'anthropic-version' => '2023-06-01',
                        'Content-Type' => 'application/json',
                    ];
                    $body = $this->formatTranslator->toAnthropicPayload($modelName, $targetPayload);
                } else {
                    $url = str_ends_with($baseUrl, '/chat/completions') ? $baseUrl : $baseUrl . '/chat/completions';
                    $headers = [
                        'Authorization' => 'Bearer ' . $account->api_key,
                        'Content-Type' => 'application/json',
                    ];
                    $body = $targetPayload;
                }

                $reqStartTime = microtime(true);

                try {
                    $response = Http::withHeaders($headers)
                        ->timeout(90)
                        ->post($url, $body);

                    $latencyMs = (int) round((microtime(true) - $reqStartTime) * 1000);
                    $statusCode = $response->status();
                } catch (\Throwable $e) {
                    $latencyMs = (int) round((microtime(true) - $reqStartTime) * 1000);
                    $statusCode = 500;
                    $response = null;
                    $networkError = $e->getMessage();
                }

                // HTTP 200 Success
                if ($statusCode === 200 && $response && $response->successful()) {
                    $rawJson = $response->json();
                    if ($format === 'anthropic') {
                        $normalizedData = $this->formatTranslator->fromAnthropicResponse($rawJson, $modelName);
                    } else {
                        $normalizedData = $rawJson;
                    }

                    $promptTokens = (int) ($normalizedData['usage']['prompt_tokens'] ?? 0);
                    $completionTokens = (int) ($normalizedData['usage']['completion_tokens'] ?? 0);
                    $totalTokens = (int) ($normalizedData['usage']['total_tokens'] ?? ($promptTokens + $completionTokens));

                    // Increment account tokens and clear errors
                    $account->increment('tokens_used_today', $totalTokens);
                    $account->update([
                        'fail_count' => 0,
                        'last_error' => null,
                    ]);

                    // Increment gateway key tokens if provided
                    if ($gatewayKey) {
                        $gatewayKey->increment('tokens_used_today', $totalTokens);
                        $gatewayKey->update([
                            'last_used_at' => now(),
                        ]);
                    }

                    // Create successful GatewayLog record
                    GatewayLog::create([
                        'gateway_key_id' => $gatewayKey?->id,
                        'requested_model' => $requestedModel,
                        'routed_provider' => $providerSlug,
                        'routed_model' => $modelName,
                        'account_label' => $account->label,
                        'prompt_tokens' => $promptTokens,
                        'completion_tokens' => $completionTokens,
                        'total_tokens' => $totalTokens,
                        'saved_tokens' => $savedTokens,
                        'latency_ms' => $latencyMs,
                        'status_code' => 200,
                        'error_message' => null,
                    ]);

                    return [
                        'response' => $normalizedData,
                        'meta' => [
                            'provider' => $providerSlug,
                            'model' => $modelName,
                            'account' => $account->label,
                            'saved_tokens' => $savedTokens,
                            'latency_ms' => $latencyMs,
                        ],
                    ];
                }

                // Handle Failure: Rate limit, Auth/Quota, or 5xx
                $errorBody = $response ? $response->body() : ($networkError ?? 'Connection error');
                $errorSnippet = substr($errorBody, 0, 500);

                if ($statusCode === 429) {
                    $account->markCooldown(2, "HTTP 429 Rate Limit: {$errorSnippet}");
                } elseif (in_array($statusCode, [401, 402, 403], true)) {
                    $account->markCooldown(60, "HTTP {$statusCode} Auth/Quota: {$errorSnippet}");
                } elseif ($statusCode >= 500) {
                    $account->markCooldown(1, "HTTP {$statusCode}: {$errorSnippet}");
                } else {
                    // Client/model mismatch errors (e.g. 400 Bad Request, 404) do not disable the API account
                    $account->update(['last_error' => "HTTP {$statusCode}: {$errorSnippet}"]);
                }

                $attemptErrors[] = "[{$providerSlug}/{$modelName} - {$account->label}] Status {$statusCode}: " . substr($errorBody, 0, 200);

                // Trip circuit breaker if fail_count reaches 5
                if ($account->fresh()->fail_count >= 5) {
                    Cache::put("circuit_open:{$providerSlug}", true, now()->addMinutes(1));
                }
            }
        }

        // All accounts and providers failed: log 502 and throw RuntimeException
        $totalLatency = (int) round((microtime(true) - $overallStartTime) * 1000);
        $summary = implode(' | ', $attemptErrors);

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
            'latency_ms' => $totalLatency,
            'status_code' => 502,
            'error_message' => $summary ?: 'All providers and accounts failed.',
        ]);

        throw new RuntimeException("OmniRoute upstream fallback exhausted for '{$requestedModel}': " . ($summary ?: 'No healthy accounts available.'));
    }
}
