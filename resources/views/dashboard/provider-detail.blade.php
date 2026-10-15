@extends('layouts.dashboard')

@section('title', $provider->name . ' — Provider Details')

@section('content')
@php
    $freeSlugs = ['gemini', 'groq', 'cerebras', 'openrouter', 'mistral'];
    $isFreeTier = in_array($provider->slug, $freeSlugs);
    $models = $provider->models_catalog ?? [];

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

<div class="space-y-6" x-data="providerDetailManager()">
    <!-- ============================================================== -->
    <!-- BREADCRUMB & HEADER                                            -->
    <!-- ============================================================== -->
    <div>
        <!-- Breadcrumb & Back Link -->
        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-2">
            <a href="{{ route('dashboard.providers') }}" class="hover:text-zinc-300 transition-colors">Dashboard</a>
            <span>&rsaquo;</span>
            <a href="{{ route('dashboard.providers') }}" class="hover:text-zinc-300 transition-colors">Providers</a>
            <span>&rsaquo;</span>
            <span class="text-zinc-300 font-medium">{{ $provider->name }}</span>
        </div>

        <a href="{{ route('dashboard.providers') }}" class="inline-flex items-center gap-1.5 text-xs text-zinc-400 hover:text-white transition-colors mb-4 group">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform"></i>
            <span>Back to Providers</span>
        </a>

        <!-- Provider Title Header -->
        <div class="flex items-center justify-between gap-4 flex-wrap bg-[#121622]/90 border border-white/[0.07] rounded-2xl p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr {{ $brandColor }} border flex items-center justify-center font-bold text-xl shadow-lg flex-shrink-0">
                    {{ strtoupper(substr($provider->slug, 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-xl font-bold text-white tracking-tight">{{ $provider->name }}</h2>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-white/[0.05] text-zinc-300 border border-white/10 uppercase">
                            {{ $provider->format }}
                        </span>
                        @if($isFreeTier)
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-teal-500/10 text-teal-300 border border-teal-500/20">Free Tier</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 mt-1 text-xs text-zinc-400">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full {{ $provider->accounts->count() > 0 ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-600' }}"></span>
                            <span>{{ $provider->accounts->count() }} {{ Str::plural('connection', $provider->accounts->count()) }}</span>
                        </span>
                        <span>&bull;</span>
                        <code class="font-mono text-zinc-400 select-all text-[11px]">{{ $provider->base_url }}</code>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="openAddKeyModal({{ $provider->id }})"
                    class="px-4 py-2 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white font-semibold text-xs rounded-xl transition-all shadow-md flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Add Connection</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 1: CONNECTIONS PANEL                                   -->
    <!-- ============================================================== -->
    <div class="bg-[#121622]/90 border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-4">
        <!-- Panel Header -->
        <div class="flex items-center justify-between pb-3 border-b border-white/[0.06] flex-wrap gap-2">
            <div class="flex items-center gap-2.5">
                <h3 class="text-sm font-bold text-white">Connections</h3>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-400 border border-white/5">Provider Proxy</span>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="openAddKeyModal({{ $provider->id }})"
                    class="px-3 py-1.5 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white font-semibold text-xs rounded-xl transition-all flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add</span>
                </button>
            </div>
        </div>

        @if($provider->accounts->isEmpty())
            <div class="border border-dashed border-white/10 rounded-2xl p-10 text-center text-zinc-500 text-xs flex flex-col items-center justify-center gap-3 bg-[#0d1017]">
                <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-400">
                    <i data-lucide="key" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white">No connections yet</h4>
                    <p class="text-xs text-zinc-400 mt-1">Add your first API key connection to activate this provider and start routing.</p>
                </div>
                <button type="button" @click="openAddKeyModal({{ $provider->id }})"
                    class="px-4 py-2 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5 shadow-md">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add Connection</span>
                </button>
            </div>
        @else
            <!-- Accounts List -->
            <div class="space-y-2.5">
                @foreach($provider->accounts as $acc)
                    <div class="p-3.5 rounded-xl bg-[#161c2c] border border-white/[0.06] hover:border-white/[0.12] transition-colors flex items-center justify-between gap-4 flex-wrap text-xs">
                        <!-- Left Details -->
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <i data-lucide="lock" class="w-4 h-4 text-zinc-500 flex-shrink-0"></i>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-mono font-medium text-white text-xs truncate">{{ $acc->label }}</span>
                                    @if($acc->isInCooldown())
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-ping"></span>
                                            <span>Cooldown Active</span>
                                        </span>
                                    @elseif($acc->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            <span>connected</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-zinc-800 text-zinc-400 border border-white/5">
                                            disabled
                                        </span>
                                    @endif
                                    <span class="text-[10px] font-mono bg-zinc-800 px-1.5 py-0.5 rounded text-indigo-300 font-semibold">#{{ $acc->priority }}</span>
                                </div>
                                <div class="text-[11px] text-zinc-400 mt-1 flex items-center gap-3">
                                    <span>Today: <strong class="text-zinc-200">{{ number_format($acc->tokens_used_today) }}</strong> tokens</span>
                                    @if($acc->daily_token_limit)
                                        <span>Limit: {{ number_format($acc->daily_token_limit) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <!-- Retest Button -->
                            <button type="button" @click="pingAccount({{ $acc->id }})"
                                :disabled="testingAccountId === {{ $acc->id }}"
                                class="px-2.5 py-1 text-xs text-zinc-300 hover:text-white bg-zinc-800 hover:bg-zinc-700 rounded-lg border border-white/5 transition-colors flex items-center gap-1" title="Retest Connection">
                                <i data-lucide="refresh-cw" class="w-3 h-3 text-zinc-400" :class="testingAccountId === {{ $acc->id }} ? 'animate-spin' : ''"></i>
                                <span x-text="testingAccountId === {{ $acc->id }} ? 'Testing...' : 'Retest'"></span>
                            </button>

                            <!-- Active Toggle Switch -->
                            <form action="{{ route('dashboard.accounts.toggle', $acc) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1.5 rounded-lg transition-colors {{ $acc->is_active ? 'text-emerald-400 hover:bg-emerald-500/10' : 'text-zinc-500 hover:bg-zinc-800' }}" title="{{ $acc->is_active ? 'Disable Account' : 'Enable Account' }}">
                                    <i data-lucide="{{ $acc->is_active ? 'toggle-right' : 'toggle-left' }}" class="w-5 h-5 pointer-events-none"></i>
                                </button>
                            </form>

                            <!-- Delete Button -->
                            <form action="{{ route('dashboard.accounts.delete', $acc) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click="confirmDelete($el.closest('form'), 'Delete Provider Connection', 'Permanently delete key &quot;{{ $acc->label }}&quot;?', 'Yes, Delete Key')"
                                    class="p-1.5 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Delete Connection">
                                    <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 2: AVAILABLE MODELS PANEL (WITH IMPORT FROM /MODELS)   -->
    <!-- ============================================================== -->
    <div class="bg-[#121622]/90 border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-4">
        <!-- Panel Header: Title + Import from /models Button -->
        <div class="flex items-center justify-between pb-3 border-b border-white/[0.06] flex-wrap gap-3">
            <div>
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <span>Available Models</span>
                    <span class="text-xs font-mono font-normal text-zinc-400">({{ count($models) }} active)</span>
                </h3>
                <p class="text-[11px] text-zinc-400 mt-0.5">Models mapped to this upstream provider. Dynamically imported or manually configured.</p>
            </div>

            <!-- Import from /models Action -->
            <div class="flex items-center gap-2">
                <button type="button" @click="importModels()" :disabled="isImporting"
                    class="px-3.5 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 hover:text-white font-semibold text-xs rounded-xl border border-white/10 transition-all flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5 text-emerald-400" :class="isImporting ? 'animate-bounce' : ''"></i>
                    <span x-text="isImporting ? 'Importing models...' : 'Import from /models'"></span>
                </button>
            </div>
        </div>

        <!-- Toolbar: Search / Filter Models -->
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 pointer-events-none"></i>
                <input type="text" x-model="modelFilterQuery" placeholder="Filter models..."
                    class="w-full bg-[#161c2c] border border-white/10 rounded-xl pl-9 pr-3 py-1.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <span class="text-xs text-zinc-400 font-mono" x-text="`${filteredModels().length} / ${modelsList.length} shown`"></span>
        </div>

        <!-- Models Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
            <template x-for="modelName in filteredModels()" :key="modelName">
                <div class="p-3.5 rounded-xl bg-[#161c2c] border border-white/[0.06] hover:border-white/[0.12] transition-colors flex flex-col justify-between min-h-[96px] group">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-6 h-6 rounded-lg bg-zinc-800 border border-white/5 flex items-center justify-center text-zinc-400 flex-shrink-0">
                                <i data-lucide="bot" class="w-3.5 h-3.5"></i>
                            </div>
                            <span class="font-mono text-xs text-white group-hover:text-emerald-400 transition-colors font-medium truncate" x-text="modelName"></span>
                        </div>
                        <span class="text-[9px] uppercase font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex-shrink-0">
                            Imported
                        </span>
                    </div>

                    <div class="pt-2 border-t border-white/[0.04] flex items-center justify-between text-xs mt-2">
                        <span class="text-[10px] text-zinc-500 truncate" x-text="'{{ $provider->slug }}/' + modelName"></span>
                        <div class="flex items-center gap-1.5">
                            <button type="button" @click="copyText(modelName, `Copied model '${modelName}'!`)"
                                class="p-1 text-zinc-400 hover:text-white transition-colors" title="Copy Model ID">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            </button>
                            <a :href="`{{ route('dashboard.playground') }}?model={{ $provider->slug }}/${encodeURIComponent(modelName)}`"
                                class="p-1 text-zinc-400 hover:text-emerald-400 transition-colors" title="Test in Playground">
                                <i data-lucide="play" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty state when no models match filter or catalog is empty -->
        <div x-show="filteredModels().length === 0" class="border border-dashed border-white/10 rounded-2xl p-8 text-center text-zinc-500 text-xs flex flex-col items-center justify-center gap-2 bg-[#0d1017]">
            <i data-lucide="box" class="w-6 h-6 text-zinc-600"></i>
            <span class="text-zinc-300 font-semibold">No models found</span>
            <span class="text-zinc-500">Click "Import from /models" above to fetch available models directly from the provider endpoint.</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
window.providerDetailManager = function() {
    return {
        modelFilterQuery: '',
        isImporting: false,
        testingAccountId: null,
        modelsList: @json(array_values($models)),
        filteredModels() {
            if (!this.modelFilterQuery.trim()) {
                return this.modelsList;
            }
            const q = this.modelFilterQuery.toLowerCase().trim();
            return this.modelsList.filter(m => (m || '').toLowerCase().includes(q));
        },
        async importModels() {
            this.isImporting = true;
            try {
                const res = await fetch(`{{ route('dashboard.providers.import-models', $provider) }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    if (Array.isArray(data.models)) {
                        this.modelsList = data.models;
                    }
                    if (typeof copyText === 'function') {
                        copyText('', data.message);
                    } else {
                        alert(data.message);
                    }
                } else {
                    alert(data.message || 'Failed to import models from provider endpoint.');
                }
            } catch (err) {
                alert('Connection error: ' + err.message);
            } finally {
                this.isImporting = false;
                this.$nextTick(() => lucide.createIcons());
            }
        },
        async pingAccount(accountId) {
            this.testingAccountId = accountId;
            try {
                const res = await fetch(`/dashboard/accounts/${accountId}/test`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (Array.isArray(data.models) && data.models.length > 0) {
                    this.modelsList = data.models;
                }
                if (typeof copyText === 'function') {
                    copyText(data.message, data.success ? 'Key Verified OK!' : 'Test Failed');
                }
            } catch (err) {
                alert('Test failed: ' + err.message);
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
