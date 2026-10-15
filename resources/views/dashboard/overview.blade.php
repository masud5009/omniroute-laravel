@extends('layouts.dashboard')

@section('title', 'Overview & Live Analytics')

@section('content')
<div class="space-y-6">
    <!-- 4 Bento KPI Cards with subtle radial gradient glow -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Requests -->
        <div class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.15] rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-400">Total Requests Today</span>
                <div class="w-8 h-8 rounded-lg bg-zinc-800/80 border border-white/5 flex items-center justify-center text-zinc-400 group-hover:text-white transition-colors">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold tracking-tight text-white">{{ number_format($stats['total_requests_today']) }}</div>
            <div class="flex items-center gap-1.5 text-[11px] text-zinc-500 mt-2 font-mono">
                <span class="text-emerald-400">100% gateway uptime</span>
            </div>
        </div>

        <!-- Card 2: Tokens Consumed -->
        <div class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.15] rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-400">Tokens Processed</span>
                <div class="w-8 h-8 rounded-lg bg-zinc-800/80 border border-white/5 flex items-center justify-center text-zinc-400 group-hover:text-indigo-400 transition-colors">
                    <i data-lucide="zap" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold tracking-tight text-white">{{ number_format($stats['total_tokens_today']) }}</div>
            <div class="flex items-center gap-1 text-[11px] text-zinc-500 mt-2 font-mono">
                <span>Across all client keys</span>
            </div>
        </div>

        <!-- Card 3: Tokens Saved -->
        <div class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.15] rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-emerald-400">Tokens Saved</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold tracking-tight text-emerald-400">+{{ number_format($stats['total_saved_tokens']) }}</div>
            <div class="flex items-center gap-1 text-[11px] text-emerald-500/80 mt-2 font-mono">
                <span>Prompt compression savings</span>
            </div>
        </div>

        <!-- Card 4: Avg Latency & Key Health -->
        <div class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.15] rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-zinc-400">Speed & Health</span>
                <div class="w-8 h-8 rounded-lg bg-zinc-800/80 border border-white/5 flex items-center justify-center text-amber-400">
                    <i data-lucide="gauge" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold tracking-tight text-white">
                {{ $stats['avg_latency_ms'] }} <span class="text-xs font-normal text-zinc-400 font-mono">ms</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] mt-2 font-mono">
                <span class="text-emerald-400">{{ $stats['active_accounts_count'] }} Healthy</span>
                <span class="text-zinc-600">/</span>
                <span class="{{ $stats['cooldown_accounts_count'] > 0 ? 'text-rose-400' : 'text-zinc-500' }}">{{ $stats['cooldown_accounts_count'] }} Cooldown</span>
            </div>
        </div>
    </div>

    <!-- 2-Column Split: Active Provider Matrix (2/3) + Quick Integration (1/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{
        testingAccountId: null,
        testResult: null,
        async pingAccount(accountId) {
            this.testingAccountId = accountId;
            this.testResult = null;
            try {
                const res = await fetch(`/dashboard/accounts/${accountId}/test`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                this.testResult = { id: accountId, ...data };
                if (data.success) {
                    $dispatch('show-toast', { message: data.message });
                }
                setTimeout(() => { this.testResult = null; }, 5000);
            } catch (err) {
                this.testResult = { id: accountId, success: false, message: err.message };
            } finally {
                this.testingAccountId = null;
                this.$nextTick(() => lucide.createIcons());
            }
        }
    }">
        <!-- Left 2/3: Active Provider Health Matrix -->
        <div class="lg:col-span-2 bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3">
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <span>Active Provider Health Matrix</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    </h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Live status, quota progress, and priority order of configured upstream keys.</p>
                </div>
                <a href="{{ route('dashboard.providers') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium flex items-center gap-1">
                    <span>Manage All Providers</span>
                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>

            @php
                $configuredProviders = $providers->filter(fn($p) => $p->accounts->count() > 0);
            @endphp

            @if($configuredProviders->isEmpty())
                <div class="py-10 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800/80 border border-white/5 mx-auto flex items-center justify-center text-zinc-500">
                        <i data-lucide="key" class="w-6 h-6"></i>
                    </div>
                    <div class="text-sm text-zinc-300 font-medium">No provider keys connected yet</div>
                    <p class="text-xs text-zinc-500 max-w-sm mx-auto">Add your free Groq, Gemini, OpenRouter, or OpenAI API key to start routing requests through OmniRoute.</p>
                    <button type="button" @click="openAddKeyModal()" class="px-4 py-2 bg-white text-zinc-950 font-semibold text-xs rounded-xl shadow-lg hover:bg-zinc-200 transition-colors inline-flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Connect Your First Key</span>
                    </button>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($configuredProviders as $provider)
                        @foreach($provider->accounts as $acc)
                            <div class="p-3.5 rounded-xl bg-[#0e0e11] border border-white/[0.05] hover:border-white/[0.1] transition-all flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <!-- Provider Tag -->
                                    <div class="w-8 h-8 rounded-lg bg-zinc-800 border border-white/10 flex items-center justify-center font-bold text-xs text-emerald-400 flex-shrink-0">
                                        {{ strtoupper(substr($provider->slug, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-white truncate">{{ $acc->label }}</span>
                                            <span class="text-[10px] font-mono text-zinc-400 bg-zinc-800/80 px-1.5 py-0.5 rounded border border-white/5">{{ $provider->slug }}</span>
                                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-zinc-800 text-indigo-300">P{{ $acc->priority }}</span>
                                        </div>
                                        <div class="text-[11px] text-zinc-500 font-mono mt-0.5">
                                            Tokens today: <span class="text-zinc-300">{{ number_format($acc->tokens_used_today) }}</span>
                                            @if($acc->daily_token_limit)
                                                / {{ number_format($acc->daily_token_limit) }}
                                            @endif
                                        </div>
                                        @php
                                            $quotaPct = $acc->daily_token_limit ? min(100, round(($acc->tokens_used_today / $acc->daily_token_limit) * 100)) : min(100, round(($acc->tokens_used_today / 50000) * 100));
                                        @endphp
                                        <div class="mt-1 flex items-center gap-2">
                                            <div class="w-24 sm:w-36 bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                                <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ max(4, $quotaPct) }}%"></div>
                                            </div>
                                            <span class="text-[10px] text-zinc-500 font-mono">{{ $quotaPct }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <!-- Status Badge -->
                                    @if($acc->isInCooldown())
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-ping"></span>
                                            Cooldown ({{ $acc->cooldown_until->diffForHumans() }})
                                        </span>
                                        <form action="{{ route('dashboard.accounts.clear-cooldown', $acc) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[10px] text-emerald-400 hover:underline font-semibold">Reset</button>
                                        </form>
                                    @elseif(!$acc->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-zinc-800 text-zinc-400 border border-zinc-700">
                                            Disabled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Ready
                                        </span>
                                    @endif

                                    <!-- Quick Ping Button -->
                                    <button type="button" @click="pingAccount({{ $acc->id }})"
                                        :disabled="testingAccountId === {{ $acc->id }}"
                                        class="px-2.5 py-1 text-[11px] font-medium bg-zinc-800 hover:bg-zinc-700 text-zinc-200 rounded-lg border border-white/5 transition-colors disabled:opacity-50">
                                        <span x-text="testingAccountId === {{ $acc->id }} ? 'Testing...' : 'Test'">Test</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right 1/3: Quick Integration & Combos -->
        <div class="space-y-6">
            <!-- Integration Snippet -->
            <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-3" x-data="{ intTab: 'cursor' }">
                <div class="flex items-center justify-between border-b border-white/[0.06] pb-2.5">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Quick Integration</h3>
                    <div class="flex items-center gap-1 bg-[#09090b] p-0.5 rounded-lg border border-white/5 text-[11px]">
                        <button type="button" @click="intTab = 'cursor'" :class="intTab === 'cursor' ? 'bg-zinc-800 text-white' : 'text-zinc-500'" class="px-2 py-0.5 rounded">Cursor</button>
                        <button type="button" @click="intTab = 'python'" :class="intTab === 'python' ? 'bg-zinc-800 text-white' : 'text-zinc-500'" class="px-2 py-0.5 rounded">Python</button>
                        <button type="button" @click="intTab = 'js'" :class="intTab === 'js' ? 'bg-zinc-800 text-white' : 'text-zinc-500'" class="px-2 py-0.5 rounded">Node/JS</button>
                        <button type="button" @click="intTab = 'curl'" :class="intTab === 'curl' ? 'bg-zinc-800 text-white' : 'text-zinc-500'" class="px-2 py-0.5 rounded">cURL</button>
                    </div>
                </div>

                <div x-show="intTab === 'cursor'" class="bg-[#09090b] rounded-xl p-3 border border-white/5 text-[11px] font-mono space-y-1.5 text-zinc-300">
                    <div class="text-zinc-500">// Cursor IDE -> Settings -> Models:</div>
                    <div><span class="text-emerald-400">Base URL:</span> {{ url('/v1') }}</div>
                    <div><span class="text-emerald-400">API Key:</span> {{ $gatewayKeys->first()?->key ?? 'sk-omni-master-key-...' }}</div>
                    <div><span class="text-emerald-400">Model:</span> auto</div>
                </div>

                <div x-show="intTab === 'python'" class="bg-[#09090b] rounded-xl p-3 border border-white/5 text-[11px] font-mono text-zinc-300 overflow-x-auto" x-cloak>
<pre>client = OpenAI(
  base_url="{{ url('/v1') }}",
  api_key="{{ $gatewayKeys->first()?->key ?? 'sk-omni-...' }}"
)
res = client.chat.completions.create(
  model="auto",
  messages=[{"role":"user","content":"Hi!"}]
)</pre>
                </div>

                <div x-show="intTab === 'js'" class="bg-[#09090b] rounded-xl p-3 border border-white/5 text-[11px] font-mono text-zinc-300 overflow-x-auto" x-cloak>
<pre>import OpenAI from 'openai';

const client = new OpenAI({
  baseURL: '{{ url('/v1') }}',
  apiKey: '{{ $gatewayKeys->first()?->key ?? 'sk-omni-...' }}',
});
const res = await client.chat.completions.create({
  model: 'auto',
  messages: [{ role: 'user', content: 'Hi!' }]
});</pre>
                </div>

                <div x-show="intTab === 'curl'" class="bg-[#09090b] rounded-xl p-3 border border-white/5 text-[11px] font-mono text-zinc-300 overflow-x-auto" x-cloak>
<pre>curl {{ url('/v1/chat/completions') }} \
 -H "Authorization: Bearer {{ $gatewayKeys->first()?->key ?? 'sk-omni-...' }}" \
 -d '{"model":"auto","messages":[{"role":"user","content":"Hi"}]}'</pre>
                </div>
            </div>

            <!-- Active Smart Combos List -->
            <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-3">
                <div class="flex items-center justify-between border-b border-white/[0.06] pb-2.5">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Active Smart Combos</h3>
                    <a href="{{ route('dashboard.combos') }}" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-medium">View All</a>
                </div>

                <div class="space-y-2">
                    @foreach($combos->take(3) as $c)
                        <div class="p-2.5 rounded-xl bg-[#09090b] border border-white/5 text-xs flex items-center justify-between">
                            <div>
                                <div class="font-bold text-white">{{ $c->name }}</div>
                                <div class="text-[10px] text-zinc-500 font-mono">{{ count($c->models ?? []) }} model fallback sequence</div>
                            </div>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-zinc-800 text-indigo-300 font-mono">{{ $c->strategy }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
