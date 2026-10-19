@extends('layouts.dashboard')

@section('title', 'Architecture & Security Settings')

@section('content')
<div class="space-y-6">

    <!-- Appearance & Theme Selector Card -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
            <div class="flex items-center gap-2.5">
                <i data-lucide="palette" class="w-5 h-5 text-emerald-400"></i>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Appearance & Theme Mode</h3>
            </div>
            <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Dual Mode Ready</span>
        </div>

        <p class="text-sm text-zinc-400">Customize the visual presentation of your OmniRoute Lite admin console. Your preference is persisted locally across sessions.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
            <!-- Dark Mode Option Card -->
            <button type="button" @click="setTheme('dark')"
                :class="currentTheme === 'dark' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-white/10 hover:border-white/20'"
                class="p-5 rounded-2xl bg-[#09090b] border text-left transition-all relative flex flex-col justify-between cursor-pointer group">
                <div class="flex items-center justify-between mb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-800 border border-white/10 flex items-center justify-center text-amber-400">
                            <i data-lucide="moon" class="w-4.5 h-4.5"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">Dark Mode</div>
                            <div class="text-xs text-zinc-400 font-mono mt-0.5">Obsidian Zinc Aesthetic</div>
                        </div>
                    </div>
                    <span x-show="currentTheme === 'dark'" class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="h-11 rounded-xl bg-[#121215] border border-white/5 p-2.5 flex items-center gap-2.5">
                    <div class="w-3.5 h-3.5 rounded-full bg-emerald-500/30"></div>
                    <div class="h-2.5 w-20 bg-zinc-700 rounded"></div>
                    <div class="h-2.5 w-10 bg-zinc-800 rounded ml-auto"></div>
                </div>
            </button>

            <!-- Light / White Mode Option Card -->
            <button type="button" @click="setTheme('light')"
                :class="currentTheme === 'light' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-white/10 hover:border-white/20'"
                class="p-5 rounded-2xl bg-[#09090b] border text-left transition-all relative flex flex-col justify-between cursor-pointer group">
                <div class="flex items-center justify-between mb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-800 border border-white/10 flex items-center justify-center text-amber-400">
                            <i data-lucide="sun" class="w-4.5 h-4.5"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">White / Light Mode</div>
                            <div class="text-xs text-zinc-400 font-mono mt-0.5">High-Clarity Daylight Surface</div>
                        </div>
                    </div>
                    <span x-show="currentTheme === 'light'" class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="h-11 rounded-xl bg-[#f8fafc] border border-zinc-200 p-2.5 flex items-center gap-2.5">
                    <div class="w-3.5 h-3.5 rounded-full bg-emerald-600/30"></div>
                    <div class="h-2.5 w-20 bg-zinc-300 rounded"></div>
                    <div class="h-2.5 w-10 bg-zinc-200 rounded ml-auto"></div>
                </div>
            </button>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- REAL-TIME FAILOVER ALERTS & WEBHOOKS CARD -->
    <!-- ============================================================== -->
    <div x-data="{
        webhookType: '{{ $alertSettings->webhook_type }}',
        sendingTest: false,
        testResult: null,
        async sendTest() {
            this.sendingTest = true;
            this.testResult = null;
            try {
                const res = await fetch('{{ route('dashboard.settings.alerts.test') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                this.testResult = data;
                if (data.success) {
                    $dispatch('show-toast', { message: data.message });
                }
            } catch (err) {
                this.testResult = { success: false, message: 'Network error: ' + err.message };
            } finally {
                this.sendingTest = false;
                this.$nextTick(() => lucide.createIcons());
            }
        }
    }" class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-5">
        <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
            <div class="flex items-center gap-2.5">
                <i data-lucide="bell-ring" class="w-5 h-5 text-amber-400"></i>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Real-Time Failover Alerts & Webhooks</h3>
            </div>
            <div class="flex items-center gap-2">
                @if($alertSettings->last_alert_sent_at)
                    <span class="text-xs text-zinc-500 font-mono hidden sm:inline">Last sent: {{ $alertSettings->last_alert_sent_at->diffForHumans() }}</span>
                @endif
                <span class="text-xs font-mono px-2.5 py-1 rounded-md font-semibold {{ $alertSettings->is_enabled ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border border-white/5' }}">
                    {{ $alertSettings->is_enabled ? 'Alerts Active' : 'Alerts Disabled' }}
                </span>
            </div>
        </div>

        <p class="text-sm text-zinc-400">
            Instantly dispatch rich notifications to your team's Discord, Slack, or Telegram channel when an upstream provider experiences circuit breaker failure, rate limit cooldown, or quota limits.
        </p>

        <!-- Test Result Banner -->
        <template x-if="testResult">
            <div :class="testResult.success ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300' : 'bg-rose-500/10 border-rose-500/30 text-rose-300'"
                class="p-4 rounded-xl border text-xs sm:text-sm flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <i :data-lucide="testResult.success ? 'check-circle' : 'alert-triangle'" class="w-4.5 h-4.5 shrink-0"></i>
                    <span x-text="testResult.message"></span>
                </div>
                <button type="button" @click="testResult = null" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>
        </template>

        <form action="{{ route('dashboard.settings.alerts.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Master Toggle -->
            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 flex items-center justify-between">
                <div>
                    <div class="text-sm font-bold text-white">Enable Real-Time Alerts</div>
                    <div class="text-xs text-zinc-400 mt-0.5">Activate background webhook dispatching across configured trigger events</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_enabled" value="1" {{ $alertSettings->is_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            <!-- Webhook Channel Type Selector Cards -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-2">Notification Channel</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Discord -->
                    <label class="p-3.5 rounded-xl border cursor-pointer transition-all flex flex-col items-center text-center gap-2"
                        :class="webhookType === 'discord' ? 'bg-indigo-500/10 border-indigo-500 text-white' : 'bg-[#09090b] border-white/5 text-zinc-400 hover:border-white/10'">
                        <input type="radio" name="webhook_type" value="discord" x-model="webhookType" class="sr-only">
                        <i data-lucide="message-square" class="w-5 h-5" :class="webhookType === 'discord' ? 'text-indigo-400' : 'text-zinc-500'"></i>
                        <span class="text-xs font-bold">Discord</span>
                    </label>

                    <!-- Slack -->
                    <label class="p-3.5 rounded-xl border cursor-pointer transition-all flex flex-col items-center text-center gap-2"
                        :class="webhookType === 'slack' ? 'bg-emerald-500/10 border-emerald-500 text-white' : 'bg-[#09090b] border-white/5 text-zinc-400 hover:border-white/10'">
                        <input type="radio" name="webhook_type" value="slack" x-model="webhookType" class="sr-only">
                        <i data-lucide="hash" class="w-5 h-5" :class="webhookType === 'slack' ? 'text-emerald-400' : 'text-zinc-500'"></i>
                        <span class="text-xs font-bold">Slack</span>
                    </label>

                    <!-- Telegram -->
                    <label class="p-3.5 rounded-xl border cursor-pointer transition-all flex flex-col items-center text-center gap-2"
                        :class="webhookType === 'telegram' ? 'bg-sky-500/10 border-sky-500 text-white' : 'bg-[#09090b] border-white/5 text-zinc-400 hover:border-white/10'">
                        <input type="radio" name="webhook_type" value="telegram" x-model="webhookType" class="sr-only">
                        <i data-lucide="send" class="w-5 h-5" :class="webhookType === 'telegram' ? 'text-sky-400' : 'text-zinc-500'"></i>
                        <span class="text-xs font-bold">Telegram</span>
                    </label>

                    <!-- Generic Webhook -->
                    <label class="p-3.5 rounded-xl border cursor-pointer transition-all flex flex-col items-center text-center gap-2"
                        :class="webhookType === 'generic' ? 'bg-purple-500/10 border-purple-500 text-white' : 'bg-[#09090b] border-white/5 text-zinc-400 hover:border-white/10'">
                        <input type="radio" name="webhook_type" value="generic" x-model="webhookType" class="sr-only">
                        <i data-lucide="globe" class="w-5 h-5" :class="webhookType === 'generic' ? 'text-purple-400' : 'text-zinc-500'"></i>
                        <span class="text-xs font-bold">Generic HTTP</span>
                    </label>
                </div>
            </div>

            <!-- Dynamic Input: Discord / Slack / Generic Webhook URL -->
            <div x-show="webhookType !== 'telegram'" class="space-y-1.5">
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                    <span x-text="webhookType === 'discord' ? 'Discord Webhook URL' : (webhookType === 'slack' ? 'Slack Webhook URL' : 'HTTP Webhook Endpoint')"></span>
                </label>
                <input type="url" name="webhook_url" value="{{ $alertSettings->webhook_url }}"
                    :placeholder="webhookType === 'discord' ? 'https://discord.com/api/webhooks/123456789/token...' : (webhookType === 'slack' ? 'https://hooks.slack.com/services/T.../B.../...' : 'https://api.yourdomain.com/webhooks/omniroute')"
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 font-mono">
                <p class="text-xs text-zinc-500">Incoming payloads will be formatted specifically for the selected service.</p>
            </div>

            <!-- Dynamic Input: Telegram Bot Token & Chat ID -->
            <div x-show="webhookType === 'telegram'" class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-cloak>
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Telegram Bot Token</label>
                    <input type="text" name="telegram_bot_token" value="{{ $alertSettings->telegram_bot_token }}" placeholder="123456789:ABCdefGhIJKlmNoPQRsTUVwxyZ"
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-sky-500 font-mono">
                    <p class="text-xs text-zinc-500">Obtained from <a href="https://t.me/BotFather" target="_blank" class="text-sky-400 underline">@BotFather</a>.</p>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Telegram Chat / Channel ID</label>
                    <input type="text" name="telegram_chat_id" value="{{ $alertSettings->telegram_chat_id }}" placeholder="-1001234567890 or @channelname"
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-sky-500 font-mono">
                    <p class="text-xs text-zinc-500">Target chat or group ID where notifications will be sent.</p>
                </div>
            </div>

            <!-- Trigger Events Checklist -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-2">Trigger Event Subscriptions</label>
                <div class="space-y-2.5 text-xs text-zinc-300">
                    <label class="flex items-center gap-3 p-3 rounded-xl bg-[#09090b] border border-white/5 cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="alert_circuit_breaker" value="1" {{ $alertSettings->alert_circuit_breaker ? 'checked' : '' }}
                            class="rounded border-zinc-700 text-rose-500 focus:ring-rose-500">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="font-bold text-white">Circuit Breaker Tripped:</span>
                            <span class="text-zinc-400">Immediate alert when 5 consecutive upstream failures suspend a provider for 1 minute.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl bg-[#09090b] border border-white/5 cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="alert_account_cooldown" value="1" {{ $alertSettings->alert_account_cooldown ? 'checked' : '' }}
                            class="rounded border-zinc-700 text-amber-500 focus:ring-amber-500">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="font-bold text-white">Account Rate-Limit Cooldown:</span>
                            <span class="text-zinc-400">Alert when an individual upstream API key hits HTTP 429 or quota depletion.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl bg-[#09090b] border border-white/5 cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="alert_key_limit_exceeded" value="1" {{ $alertSettings->alert_key_limit_exceeded ? 'checked' : '' }}
                            class="rounded border-zinc-700 text-indigo-500 focus:ring-indigo-500">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                            <span class="font-bold text-white">Gateway Client Key Limits:</span>
                            <span class="text-zinc-400">Alert when a client Gateway Key exceeds its daily token quota, RPM, or TPM limits.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-3 border-t border-white/[0.06] flex items-center justify-between gap-3 flex-wrap">
                <button type="button" @click="sendTest()" :disabled="sendingTest"
                    class="px-4 py-2.5 rounded-xl border border-white/10 hover:border-white/20 text-zinc-300 hover:text-white font-semibold text-xs transition-colors flex items-center gap-2 cursor-pointer disabled:opacity-40">
                    <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-400" x-show="!sendingTest"></i>
                    <span x-show="sendingTest" class="inline-block animate-spin">&#9696;</span>
                    <span x-text="sendingTest ? 'Sending Test...' : 'Send Test Notification'"></span>
                </button>

                <button type="submit"
                    class="px-5 py-2.5 bg-white text-zinc-950 hover:bg-zinc-200 font-bold text-xs rounded-xl transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <i data-lucide="save" class="w-3.5 h-3.5"></i>
                    <span>Save Alert Settings</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Diagnostic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 1. System Specifications -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="server" class="w-5 h-5 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">System Specifications</h3>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Shared Hosting Ready</span>
            </div>

            <div class="text-sm space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">PHP Version:</span>
                    <span class="text-white font-bold">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Laravel Framework:</span>
                    <span class="text-white font-bold">13.x</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Database Driver:</span>
                    <span class="text-white font-bold">{{ config('database.default') }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Cache Driver:</span>
                    <span class="text-white font-bold">{{ config('cache.default') }} <span class="text-emerald-400 text-xs font-normal">(No Redis Needed)</span></span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">cURL SSE Streaming:</span>
                    <span class="text-emerald-400 font-bold">Active (X-Accel-Buffering: no)</span>
                </div>
            </div>
        </div>

        <!-- 2. Security & Encryption -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Security & Encryption</h3>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Protected</span>
            </div>

            <div class="text-sm space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">API Key Encryption:</span>
                    <span class="text-emerald-400 font-bold">AES-256-CBC (App Key)</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">CORS Preflight:</span>
                    <span class="text-emerald-400 font-bold">Universal (*) Options Enabled</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Active Admin Session:</span>
                    <span class="text-white font-bold">{{ auth()->user()->email }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Front Controller:</span>
                    <span class="text-white font-bold">Root .htaccess Rewrite to /public</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Client Key Auth:</span>
                    <span class="text-emerald-400 font-bold">Bearer & x-api-key Middleware</span>
                </div>
            </div>
        </div>
    </div>

    <!-- cPanel / Shared Hosting Deployment Checklist -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-3.5">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2.5">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
            <span>Shared Hosting & cPanel Deployment Verification</span>
        </h3>
        <p class="text-sm text-zinc-400">This gateway is configured to work out-of-the-box on standard Apache or LiteSpeed shared hosting servers without Node.js or Redis background workers.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 text-xs font-mono">
            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Root .htaccess Active</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Passes Authorization header and routes queries to public/ safely.</p>
            </div>

            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>No Build Dependencies</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Tailwind & Alpine loaded from CDN. No npm run build required.</p>
            </div>

            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Self-Contained DB Cache</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Rate-limiting and provider cooldowns use MySQL/SQLite database cache.</p>
            </div>
        </div>
    </div>
</div>
@endsection
