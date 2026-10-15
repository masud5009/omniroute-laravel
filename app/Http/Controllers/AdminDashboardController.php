<?php

namespace App\Http\Controllers;

use App\Models\AiProvider;
use App\Models\GatewayKey;
use App\Models\GatewayLog;
use App\Models\ProviderAccount;
use App\Models\RoutingCombo;
use App\Services\Gateway\OmniRouterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Create a new AdminDashboardController instance.
     */
    public function __construct(
        protected OmniRouterService $router
    ) {}

    /**
     * Display the Overview & Analytics page.
     */
    public function overview(): View
    {
        $today = today();

        $stats = [
            'total_requests_today' => GatewayLog::whereDate('created_at', $today)->count(),
            'total_tokens_today' => (int) GatewayLog::whereDate('created_at', $today)->sum('total_tokens'),
            'total_saved_tokens' => (int) GatewayLog::whereDate('created_at', $today)->sum('saved_tokens'),
            'avg_latency_ms' => (int) round(GatewayLog::whereDate('created_at', $today)->where('status_code', 200)->avg('latency_ms') ?? 0),
            'active_accounts_count' => ProviderAccount::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('cooldown_until')->orWhere('cooldown_until', '<=', now());
                })->count(),
            'cooldown_accounts_count' => ProviderAccount::where('is_active', true)
                ->whereNotNull('cooldown_until')
                ->where('cooldown_until', '>', now())
                ->count(),
        ];

        $providers = AiProvider::with([
            'accounts' => fn ($q) => $q->orderBy('priority', 'asc')->orderBy('tokens_used_today', 'asc')
        ])->get();

        $combos = RoutingCombo::all();
        $gatewayKeys = GatewayKey::latest()->get();

        return view('dashboard.overview', compact(
            'stats',
            'providers',
            'combos',
            'gatewayKeys'
        ));
    }

    /**
     * Display AI Providers & Key Pool page.
     */
    public function providers(): View
    {
        $providers = AiProvider::with([
            'accounts' => fn ($q) => $q->orderBy('priority', 'asc')->orderBy('tokens_used_today', 'asc')
        ])->get();

        return view('dashboard.providers', compact('providers'));
    }

    /**
     * Display Smart Combos & Fallback Router page.
     */
    public function combos(): View
    {
        $combos = RoutingCombo::all();
        $providers = AiProvider::where('is_active', true)->get();

        return view('dashboard.combos', compact('combos', 'providers'));
    }

    /**
     * Display Gateway Client API Keys page.
     */
    public function gatewayKeys(): View
    {
        $gatewayKeys = GatewayKey::latest()->get();

        return view('dashboard.gateway-keys', compact('gatewayKeys'));
    }

    /**
     * Display Live AI Studio Playground page.
     */
    public function playground(): View
    {
        $combos = RoutingCombo::all();
        $providers = AiProvider::with([
            'accounts' => fn ($q) => $q->orderBy('priority', 'asc')
        ])->where('is_active', true)->get();

        return view('dashboard.playground', compact('combos', 'providers'));
    }

    /**
     * Display Request Telemetry & Error Logs page.
     */
    public function logs(): View
    {
        $logs = GatewayLog::with('gatewayKey')->latest()->take(100)->get();

        return view('dashboard.logs', compact('logs'));
    }

    /**
     * Display Architecture & Security Settings page.
     */
    public function settings(): View
    {
        return view('dashboard.settings');
    }

    /**
     * Alias for overview page.
     */
    public function index(): View
    {
        return $this->overview();
    }

    /**
     * Add a custom AI provider.
     */
    public function storeProvider(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:100|unique:ai_providers,slug',
            'base_url' => 'required|string|url|max:255',
            'format' => 'required|in:openai,anthropic',
            'models_catalog' => 'nullable|string',
        ]);

        $catalog = [];
        if (!empty($validated['models_catalog'])) {
            $catalog = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['models_catalog']))));
        }

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        AiProvider::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'base_url' => $validated['base_url'],
            'format' => $validated['format'],
            'models_catalog' => $catalog,
            'is_active' => true,
        ]);

        return back()->with('success', "Provider '{$validated['name']}' created successfully.");
    }

    /**
     * Delete a custom AI provider.
     */
    public function deleteProvider(AiProvider $provider): RedirectResponse
    {
        $coreSlugs = ['gemini', 'groq', 'openrouter', 'deepseek', 'cerebras', 'mistral', 'openai', 'anthropic'];

        if (in_array($provider->slug, $coreSlugs)) {
            return back()->withErrors(['error' => "Core system provider '{$provider->name}' cannot be deleted."]);
        }

        $name = $provider->name;
        $provider->delete();

        return back()->with('success', "Custom provider '{$name}' deleted successfully.");
    }

    /**
     * Add a new provider account API key.
     */
    public function storeAccount(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ai_provider_id' => 'required|exists:ai_providers,id',
            'label' => 'required|string|max:255',
            'api_key' => 'required|string',
            'priority' => 'nullable|integer|min:1',
            'daily_token_limit' => 'nullable|integer|min:1',
        ]);

        $account = ProviderAccount::create([
            'ai_provider_id' => $validated['ai_provider_id'],
            'label' => $validated['label'],
            'api_key' => $validated['api_key'],
            'priority' => $validated['priority'] ?? 1,
            'daily_token_limit' => $validated['daily_token_limit'] ?? null,
            'is_active' => true,
        ]);

        $provider = $account->provider;
        $syncNotice = '';
        if ($provider) {
            $beforeCount = count($provider->models_catalog ?? []);
            $models = $this->syncProviderModels($provider, $validated['api_key']);
            $newCount = count($models) - $beforeCount;
            if ($newCount > 0) {
                $syncNotice = " Auto-synced {$newCount} new models into catalog.";
            }
        }

        return back()->with('success', "Account '{$validated['label']}' added successfully.{$syncNotice}");
    }

    /**
     * Toggle provider account active status.
     */
    public function toggleAccount(ProviderAccount $account): RedirectResponse
    {
        $account->update(['is_active' => !$account->is_active]);

        $status = $account->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Account '{$account->label}' {$status}.");
    }

    /**
     * Clear cooldown and fail count on an account.
     */
    public function clearCooldown(ProviderAccount $account, Request $request): JsonResponse|RedirectResponse
    {
        $account->update([
            'cooldown_until' => null,
            'fail_count' => 0,
            'last_error' => null,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Cooldown and fail counters reset for '{$account->label}'.",
            ]);
        }

        return back()->with('success', "Cooldown and fail counters reset for '{$account->label}'.");
    }

    /**
     * Delete an account.
     */
    public function deleteAccount(ProviderAccount $account): RedirectResponse
    {
        $account->delete();

        return back()->with('success', "Account '{$account->label}' deleted.");
    }

    /**
     * Test an account with a quick ping and auto-sync models catalog.
     */
    public function testAccount(ProviderAccount $account): JsonResponse
    {
        $provider = $account->provider;

        // Auto-sync available models list from upstream provider
        $beforeCount = count($provider->models_catalog ?? []);
        $models = $this->syncProviderModels($provider, $account->api_key);
        $newCount = count($models) - $beforeCount;

        $provider->refresh();
        $model = (!empty($provider->models_catalog) && is_array($provider->models_catalog))
            ? $provider->models_catalog[0]
            : ($provider->format === 'anthropic' ? 'claude-3-5-haiku-latest' : 'gpt-4o-mini');

        $startTime = microtime(true);

        try {
            $baseUrl = rtrim($provider->base_url, '/');

            if ($provider->format === 'anthropic') {
                $url = str_ends_with($baseUrl, '/messages') ? $baseUrl : $baseUrl . '/messages';
                $response = Http::withHeaders([
                    'x-api-key' => $account->api_key,
                    'anthropic-version' => '2023-06-01',
                    'Content-Type' => 'application/json',
                ])->timeout(12)->post($url, [
                    'model' => $model,
                    'messages' => [['role' => 'user', 'content' => 'Say OK']],
                    'max_tokens' => 5,
                ]);
            } else {
                $url = str_ends_with($baseUrl, '/chat/completions') ? $baseUrl : $baseUrl . '/chat/completions';
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $account->api_key,
                    'Content-Type' => 'application/json',
                ])->timeout(12)->post($url, [
                    'model' => $model,
                    'messages' => [['role' => 'user', 'content' => 'Say OK']],
                    'max_tokens' => 5,
                ]);
            }

            $latencyMs = (int) round((microtime(true) - $startTime) * 1000);

            if ($response->successful()) {
                $totalModels = count($provider->models_catalog ?? []);
                $syncMsg = $newCount > 0 
                    ? " • Synced {$newCount} new models ({$totalModels} total in catalog)" 
                    : ($totalModels > 0 ? " • {$totalModels} models ready" : "");

                return response()->json([
                    'success' => true,
                    'message' => "Success (200 OK) with model '{$model}'{$syncMsg}",
                    'latency_ms' => $latencyMs,
                    'models_count' => $totalModels,
                    'models' => $provider->models_catalog ?? [],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "HTTP {$response->status()}: " . substr($response->body(), 0, 250),
                'latency_ms' => $latencyMs,
            ]);
        } catch (\Throwable $e) {
            $latencyMs = (int) round((microtime(true) - $startTime) * 1000);

            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
                'latency_ms' => $latencyMs,
            ]);
        }
    }

    /**
     * Attempt to fetch and sync available models from an OpenAI-compatible provider.
     *
     * @param AiProvider $provider
     * @param string $apiKey
     * @return array<int, string>
     */
    protected function syncProviderModels(AiProvider $provider, string $apiKey): array
    {
        if ($provider->format !== 'openai') {
            return $provider->models_catalog ?? [];
        }

        try {
            $baseUrl = rtrim($provider->base_url, '/');
            if (str_ends_with($baseUrl, '/chat/completions')) {
                $modelsUrl = substr($baseUrl, 0, -strlen('/chat/completions')) . '/models';
            } elseif (str_ends_with($baseUrl, '/models')) {
                $modelsUrl = $baseUrl;
            } else {
                $modelsUrl = $baseUrl . '/models';
            }

            $res = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
            ])->timeout(6)->get($modelsUrl);

            if ($res->successful()) {
                $json = $res->json();
                $modelList = [];

                if (isset($json['data']) && is_array($json['data'])) {
                    foreach ($json['data'] as $item) {
                        $id = is_array($item) ? ($item['id'] ?? null) : (is_string($item) ? $item : null);
                        if ($id && is_string($id)) {
                            $modelList[] = $id;
                        }
                    }
                } elseif (isset($json['models']) && is_array($json['models'])) {
                    foreach ($json['models'] as $item) {
                        $id = is_array($item) ? ($item['id'] ?? $item['name'] ?? null) : (is_string($item) ? $item : null);
                        if ($id && is_string($id)) {
                            $modelList[] = $id;
                        }
                    }
                } elseif (is_array($json) && !empty($json)) {
                    foreach ($json as $item) {
                        if (is_string($item)) {
                            $modelList[] = $item;
                        } elseif (is_array($item) && isset($item['id']) && is_string($item['id'])) {
                            $modelList[] = $item['id'];
                        }
                    }
                }

                if (!empty($modelList)) {
                    $existing = is_array($provider->models_catalog) ? $provider->models_catalog : [];
                    $merged = array_values(array_unique(array_merge($existing, $modelList)));
                    $provider->models_catalog = $merged;
                    $provider->save();

                    return $merged;
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore if provider does not support /models
        }

        return $provider->models_catalog ?? [];
    }

    /**
     * Create or update a RoutingCombo.
     */
    public function storeCombo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:routing_combos,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'strategy' => 'required|in:priority,round-robin',
            'models' => 'required',
            'compression_modes' => 'nullable|array',
        ]);

        if (is_string($validated['models'])) {
            $models = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['models']))));
        } else {
            $models = is_array($validated['models']) ? $validated['models'] : [];
        }

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'strategy' => $validated['strategy'],
            'models' => $models,
            'compression_modes' => $validated['compression_modes'] ?? null,
            'is_active' => true,
        ];

        if (!empty($validated['id'])) {
            RoutingCombo::where('id', $validated['id'])->update($data);
        } else {
            RoutingCombo::updateOrCreate(['name' => $data['name']], $data);
        }

        return back()->with('success', "Routing combo '{$validated['name']}' saved.");
    }

    /**
     * Toggle combo active status.
     */
    public function toggleCombo(RoutingCombo $combo): RedirectResponse
    {
        $combo->update(['is_active' => !$combo->is_active]);

        $status = $combo->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Combo '{$combo->name}' {$status}.");
    }

    /**
     * Delete a routing combo.
     */
    public function deleteCombo(RoutingCombo $combo): RedirectResponse
    {
        $combo->delete();

        return back()->with('success', "Routing combo '{$combo->name}' deleted.");
    }

    /**
     * Generate a new master or client Gateway Key.
     */
    public function storeGatewayKey(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'daily_token_limit' => 'nullable|integer|min:1',
        ]);

        $key = 'sk-omni-' . bin2hex(random_bytes(16));

        GatewayKey::create([
            'name' => $validated['name'],
            'key' => $key,
            'daily_token_limit' => $validated['daily_token_limit'] ?? null,
            'is_active' => true,
        ]);

        return back()->with('success', "Generated key '{$validated['name']}': {$key}");
    }

    /**
     * Toggle Gateway Key active status.
     */
    public function toggleGatewayKey(GatewayKey $gatewayKey): RedirectResponse
    {
        $gatewayKey->update(['is_active' => !$gatewayKey->is_active]);

        $status = $gatewayKey->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Gateway key '{$gatewayKey->name}' {$status}.");
    }

    /**
     * Delete a Gateway Key.
     */
    public function deleteGatewayKey(GatewayKey $gatewayKey): RedirectResponse
    {
        $gatewayKey->delete();

        return back()->with('success', "Gateway key '{$gatewayKey->name}' deleted.");
    }

    /**
     * Truncate the gateway_logs table.
     */
    public function clearLogs(): RedirectResponse
    {
        GatewayLog::truncate();

        return back()->with('success', 'Gateway logs cleared successfully.');
    }

    /**
     * Live playground chat endpoint.
     */
    public function playgroundChat(Request $request): JsonResponse
    {
        $request->validate([
            'model' => 'required|string',
            'messages' => 'required|array|min:1',
        ]);

        try {
            $result = $this->router->dispatchSync($request->all());

            $response = $result['response'];
            $response['_omniroute_meta'] = $result['meta'];
            $response['meta'] = $result['meta'];
            $response['success'] = true;

            return response()->json($response);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => $e->getMessage(),
                ],
                'message' => $e->getMessage(),
            ], 502);
        }
    }
}
