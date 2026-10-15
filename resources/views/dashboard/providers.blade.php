@extends('layouts.dashboard')

@section('title', 'AI Providers & Key Pool')

@section('content')
@php
    $freeSlugs = ['gemini', 'groq', 'cerebras', 'openrouter', 'mistral'];
    $connectedCount = $providers->filter(fn($p) => $p->accounts->count() > 0)->count();
    $freeTierCount = $providers->filter(fn($p) => in_array($p->slug, $freeSlugs))->count();
    $openaiCount = $providers->filter(fn($p) => $p->format === 'openai')->count();
    $anthropicCount = $providers->filter(fn($p) => $p->format === 'anthropic')->count();

    $providersList = $providers->map(fn($p) => [
        'name' => $p->name,
        'slug' => $p->slug,
        'format' => $p->format,
        'hasKeys' => $p->accounts->count() > 0,
        'isFree' => in_array($p->slug, $freeSlugs),
        'models' => $p->models_catalog ?? [],
    ])->values();
@endphp

<div class="space-y-6" x-data="providersManager()">
    <!-- ============================================================== -->
    <!-- TOP TOOLBAR: SEARCH, VIEWS & QUICK ACTIONS                     -->
    <!-- ============================================================== -->
    <div class="bg-[#121622]/90 border border-white/[0.07] rounded-2xl p-4 shadow-lg space-y-3">
        <!-- Row 1: Search Inputs & Action Buttons -->
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-2.5 flex-1 min-w-[280px] flex-wrap">
                <!-- Search Providers Input -->
                <div class="relative flex-1 min-w-[180px] max-w-xs">
                    <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 pointer-events-none"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search Providers"
                        class="w-full bg-[#161c2c] border border-white/10 rounded-xl pl-9 pr-3 py-1.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Search by Model Input -->
                <div class="relative flex-1 min-w-[180px] max-w-xs">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 pointer-events-none"></i>
                    <input type="text" x-model="modelQuery" placeholder="Search by model..."
                        class="w-full bg-[#161c2c] border border-white/10 rounded-xl pl-9 pr-3 py-1.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Segmented View Filter -->
                <div class="flex items-center bg-[#161c2c] p-0.5 rounded-xl border border-white/10 text-xs">
                    <button type="button" @click="providerFilter = 'all'"
                        :class="providerFilter === 'all' ? 'bg-zinc-800 text-white font-medium shadow-sm' : 'text-zinc-400 hover:text-white'"
                        class="px-2.5 py-1 rounded-lg transition-colors flex items-center gap-1">
                        <i data-lucide="layout-grid" class="w-3 h-3"></i>
                        <span>All</span>
                    </button>
                    <button type="button" @click="providerFilter = 'connected'"
                        :class="providerFilter === 'connected' ? 'bg-zinc-800 text-emerald-400 font-medium shadow-sm' : 'text-zinc-400 hover:text-white'"
                        class="px-2.5 py-1 rounded-lg transition-colors flex items-center gap-1">
                        <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                        <span>Configured</span>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" @click="openAddCustomProviderModal('openai')"
                    class="px-3.5 py-1.5 text-xs font-semibold bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white rounded-xl transition-all shadow-md shadow-rose-950/30 flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add Custom Provider</span>
                </button>
            </div>
        </div>

        <!-- Row 2: Category Filter Chips -->
        <div class="flex items-center gap-1.5 flex-wrap pt-2 border-t border-white/[0.05] text-[11px]">
            <button type="button" @click="providerFilter = 'all'"
                :class="providerFilter === 'all' ? 'bg-rose-600 text-white shadow-sm' : 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-300 border border-white/5'"
                class="px-2.5 py-1 rounded-full font-semibold transition-colors flex items-center gap-1">
                <span>Total</span>
                <span class="opacity-90">{{ $providers->count() }}</span>
            </button>

            <button type="button" @click="providerFilter = 'connected'"
                :class="providerFilter === 'connected' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-300 border border-white/5'"
                class="px-2.5 py-1 rounded-full transition-colors flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Connected</span>
                <span class="text-zinc-500">{{ $connectedCount }}</span>
            </button>

            <button type="button" @click="providerFilter = 'free'"
                :class="providerFilter === 'free' ? 'bg-teal-500/20 text-teal-300 border border-teal-500/30' : 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-300 border border-white/5'"
                class="px-2.5 py-1 rounded-full transition-colors flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                <span>Free Tier</span>
                <span class="text-zinc-500">{{ $freeTierCount }}</span>
            </button>

            <button type="button" @click="providerFilter = 'openai'"
                :class="providerFilter === 'openai' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-300 border border-white/5'"
                class="px-2.5 py-1 rounded-full transition-colors flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                <span>OpenAI</span>
                <span class="text-zinc-500">{{ $openaiCount }}</span>
            </button>

            <button type="button" @click="providerFilter = 'anthropic'"
                :class="providerFilter === 'anthropic' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-300 border border-white/5'"
                class="px-2.5 py-1 rounded-full transition-colors flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span>Anthropic</span>
                <span class="text-zinc-500">{{ $anthropicCount }}</span>
            </button>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- UNIFIED AI PROVIDERS SECTION                                   -->
    <!-- ============================================================== -->
    <div class="space-y-3" x-show="hasMatches()">
        <div class="flex items-center justify-between gap-4 flex-wrap pb-1">
            <div>
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <span>AI Providers</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                    <span class="text-xs font-mono font-normal text-zinc-400">({{ $connectedCount }}/{{ $providers->count() }})</span>
                </h3>
                <p class="text-[11px] text-zinc-400 mt-0.5">Configured upstream AI providers with failover, load balancing, and rate limit cooldowns.</p>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="openAddCustomProviderModal('anthropic')"
                    class="px-3 py-1.5 text-xs font-semibold bg-pink-700/80 hover:bg-pink-600 text-pink-100 rounded-xl border border-pink-500/30 transition-colors flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add Anthropic Compatible</span>
                </button>
                <button type="button" @click="openAddCustomProviderModal('openai')"
                    class="px-3 py-1.5 text-xs font-semibold bg-rose-700/80 hover:bg-rose-600 text-rose-100 rounded-xl border border-rose-500/30 transition-colors flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add OpenAI Compatible</span>
                </button>
            </div>
        </div>

        @if($providers->isEmpty())
            <div class="border border-dashed border-white/10 rounded-2xl p-12 text-center text-zinc-500 text-xs flex flex-col items-center justify-center gap-3 bg-[#121622]/40">
                <i data-lucide="box" class="w-8 h-8 text-zinc-600"></i>
                <span class="text-zinc-300 font-semibold text-sm">No AI providers configured yet</span>
                <span class="text-zinc-500 text-xs">Add your first OpenAI or Anthropic compatible provider using the buttons above.</span>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3.5">
                @foreach($providers as $provider)
                    @php
                        $hasKeys = $provider->accounts->count() > 0;
                        $brandGradients = [
                            'gemini' => 'from-blue-500/20 to-indigo-500/20 text-blue-400 border-blue-500/30',
                            'groq' => 'from-orange-500/20 to-amber-500/20 text-orange-400 border-orange-500/30',
                            'openrouter' => 'from-purple-500/20 to-indigo-500/20 text-purple-400 border-purple-500/30',
                            'deepseek' => 'from-cyan-500/20 to-blue-500/20 text-cyan-400 border-cyan-500/30',
                            'cerebras' => 'from-emerald-500/20 to-teal-500/20 text-emerald-400 border-emerald-500/30',
                            'mistral' => 'from-amber-500/20 to-red-500/20 text-amber-400 border-amber-500/30',
                            'openai' => 'from-emerald-500/20 to-zinc-700/20 text-emerald-400 border-emerald-500/30',
                            'anthropic' => 'from-orange-500/20 to-amber-700/20 text-amber-300 border-amber-500/30',
                        ];
                        $brandColor = $brandGradients[$provider->slug] ?? 'from-purple-900/40 to-pink-900/40 text-purple-300 border-purple-500/30';
                    @endphp
                    <div x-show="matchesProviderBySlug('{{ $provider->slug }}')"
                        @click="window.location.href = '{{ route('dashboard.providers.show', $provider->slug) }}'"
                        class="bg-[#121622] hover:bg-[#151b2a] border border-white/[0.08] hover:border-white/[0.18] rounded-2xl p-4 flex flex-col justify-between transition-all group min-h-[105px] shadow-md cursor-pointer">
                        
                        <!-- Card Header -->
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <a href="{{ route('dashboard.providers.show', $provider->slug) }}" class="flex items-center gap-2.5 min-w-0 group/link">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr {{ $brandColor }} border flex items-center justify-center font-bold text-xs flex-shrink-0 group-hover/link:scale-105 transition-transform">
                                        {{ strtoupper(substr($provider->slug, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <h4 class="font-bold text-xs text-white group-hover/link:text-emerald-400 transition-colors truncate">{{ $provider->name }}</h4>
                                        </div>
                                        <div class="text-[10px] text-zinc-400 font-mono truncate">{{ $provider->slug }}</div>
                                    </div>
                                </a>

                                <div class="flex items-center gap-1 flex-shrink-0">
                                    <span class="text-[9px] uppercase font-bold px-1.5 py-0.5 rounded {{ $provider->format === 'anthropic' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' : 'bg-blue-500/10 text-blue-300 border border-blue-500/20' }}">
                                        {{ $provider->format }}
                                    </span>
                                    <form action="{{ route('dashboard.providers.delete', $provider) }}" method="POST" @click.stop>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            @click.stop="confirmDelete($el.closest('form'), 'Delete Provider', 'Delete &quot;{{ $provider->name }}&quot; and all associated keys?', 'Yes, Delete Provider')"
                                            class="p-1 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Delete Provider">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5 pointer-events-none"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-2.5 border-t border-white/[0.06] flex items-center justify-between text-xs mt-3">
                            <div>
                                @if($hasKeys)
                                    <div class="font-semibold text-emerald-400 flex items-center gap-1.5 text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        <span>{{ $provider->accounts->count() }} Connected</span>
                                    </div>
                                @else
                                    <span class="text-zinc-500 text-[11px]">No connections</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-1">
                                @if($hasKeys)
                                    <button type="button" @click.stop="pingAccount({{ $provider->accounts->first()->id }})"
                                        :disabled="testingAccountId === {{ $provider->accounts->first()->id }}"
                                        class="px-2 py-0.5 text-[11px] text-zinc-300 hover:text-white bg-zinc-800/80 hover:bg-zinc-700 rounded-lg border border-white/5 transition-colors flex items-center gap-1 cursor-pointer">
                                        <i data-lucide="play" class="w-2.5 h-2.5 text-zinc-400"></i>
                                        <span x-text="testingAccountId === {{ $provider->accounts->first()->id }} ? 'Testing...' : 'Test'"></span>
                                    </button>
                                @else
                                    <button type="button" @click.stop="openAddKeyModal({{ $provider->id }})"
                                        class="px-2.5 py-1 text-[11px] font-medium text-zinc-300 hover:text-white bg-zinc-800 hover:bg-zinc-700 rounded-lg border border-white/10 transition-colors flex items-center gap-1 cursor-pointer">
                                        <i data-lucide="plus" class="w-3 h-3 text-emerald-400"></i>
                                        <span>Connect</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ============================================================== -->
    <!-- ZERO SEARCH MATCHES EMPTY STATE                                -->
    <!-- ============================================================== -->
    <div x-show="!hasMatches()"
        class="border border-dashed border-white/10 rounded-2xl p-12 text-center text-zinc-500 text-xs flex flex-col items-center justify-center gap-2 bg-[#121622]/40">
        <i data-lucide="search-x" class="w-8 h-8 text-zinc-600"></i>
        <span class="text-zinc-300 font-semibold text-sm">No matching providers found</span>
        <span class="text-zinc-500">Try adjusting your provider name or model search filter.</span>
    </div>

    <!-- ============================================================== -->
    <!-- DEDICATED MANAGE MODAL (KEEPS MAIN PAGE 100% CLEAN!)            -->
    <!-- ============================================================== -->
    @foreach($providers as $provider)
        <div x-show="manageModalProviderId === {{ $provider->id }}"
            class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-[#121622] border border-white/[0.08] rounded-2xl w-full max-w-lg p-6 shadow-2xl relative"
                @click.away="manageModalProviderId = null">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-white/[0.06] mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-800 border border-white/10 flex items-center justify-center font-bold text-xs text-emerald-400">
                            {{ strtoupper(substr($provider->slug, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">{{ $provider->name }}</h3>
                            <p class="text-[11px] text-zinc-400 font-mono truncate max-w-xs">{{ $provider->base_url }}</p>
                        </div>
                    </div>
                    <button type="button" @click="manageModalProviderId = null" class="text-zinc-500 hover:text-white text-xl leading-none">&times;</button>
                </div>

                <!-- Configured Keys List -->
                <div class="space-y-2 mb-4 max-h-64 overflow-y-auto pr-1">
                    @forelse($provider->accounts as $acc)
                        <div class="p-2.5 rounded-xl bg-[#161c2c] border border-white/[0.06] flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="w-2 h-2 rounded-full {{ $acc->isInCooldown() ? 'bg-red-400 animate-ping' : ($acc->is_active ? 'bg-emerald-400' : 'bg-zinc-600') }}"></span>
                                <div class="min-w-0">
                                    <div class="font-medium text-white truncate text-xs">{{ $acc->label }}</div>
                                    <div class="text-[10px] text-zinc-400 flex items-center gap-2 mt-0.5">
                                        <span class="bg-zinc-800 px-1.5 py-0.5 rounded text-indigo-300 font-mono font-semibold">Priority P{{ $acc->priority }}</span>
                                        <span>Today: {{ number_format($acc->tokens_used_today) }} tokens</span>
                                        @if($acc->isInCooldown())
                                            <span class="text-red-400">Cooldown active</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                <button type="button" @click="pingAccount({{ $acc->id }})"
                                    :disabled="testingAccountId === {{ $acc->id }}"
                                    class="p-1.5 text-zinc-400 hover:text-white bg-zinc-800 hover:bg-zinc-700 rounded-lg transition-colors" title="Test Key">
                                    <i data-lucide="play" class="w-3.5 h-3.5"></i>
                                </button>
                                <form action="{{ route('dashboard.accounts.delete', $acc) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click="confirmDelete($el.closest('form'), 'Delete Provider API Key', 'Delete key &quot;{{ $acc->label }}&quot;?', 'Yes, Delete Key')"
                                        class="p-1.5 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Delete Key">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5 pointer-events-none"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-zinc-500 border border-dashed border-white/10 rounded-xl">
                            No credentials configured for this provider yet.
                        </div>
                    @endforelse
                </div>

                <!-- Modal Footer -->
                <div class="pt-3 border-t border-white/[0.06] flex items-center justify-between">
                    <span class="text-xs text-zinc-400">{{ $provider->accounts->count() }} active {{ Str::plural('credential', $provider->accounts->count()) }}</span>
                    <button type="button" @click="manageModalProviderId = null; openAddKeyModal({{ $provider->id }})"
                        class="px-3.5 py-2 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl transition-all shadow-md flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5 text-zinc-950"></i>
                        <span>Add New Key</span>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
window.providersManager = function() {
    return {
        searchQuery: '',
        modelQuery: '',
        providerFilter: 'all',
        testingAccountId: null,
        testResult: null,
        manageModalProviderId: null,
        providersList: @json($providersList),
        matchesProvider(name, slug, format, hasKeys, isFree, models) {
            if (this.searchQuery.trim() !== '') {
                const q = this.searchQuery.toLowerCase().trim();
                if (!name.toLowerCase().includes(q) && !slug.toLowerCase().includes(q)) {
                    return false;
                }
            }
            if (this.modelQuery.trim() !== '') {
                const mq = this.modelQuery.toLowerCase().trim();
                const matchesModel = (models || []).some(m => (m || '').toLowerCase().includes(mq));
                if (!matchesModel) return false;
            }
            if (this.providerFilter === 'connected' && !hasKeys) return false;
            if (this.providerFilter === 'free' && !isFree) return false;
            if (this.providerFilter === 'openai' && format !== 'openai') return false;
            if (this.providerFilter === 'anthropic' && format !== 'anthropic') return false;
            return true;
        },
        matchesProviderBySlug(slug) {
            const p = this.providersList.find(item => item.slug === slug);
            if (!p) return true;
            return this.matchesProvider(p.name, p.slug, p.format, p.hasKeys, p.isFree, p.models);
        },
        hasMatches() {
            return this.providersList.some(p => this.matchesProvider(p.name, p.slug, p.format, p.hasKeys, p.isFree, p.models));
        },
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
                if (typeof copyText === 'function') {
                    copyText(data.message, data.success ? 'Key Verified OK!' : 'Test Failed');
                }
                setTimeout(() => { this.testResult = null; }, 5000);
            } catch (err) {
                this.testResult = { id: accountId, success: false, message: err.message };
            } finally {
                this.testingAccountId = null;
                this.$nextTick(() => lucide.createIcons());
            }
        }
    };
};
</script>
@endpush
@endsection
