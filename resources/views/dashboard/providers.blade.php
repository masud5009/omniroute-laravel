@extends('layouts.dashboard')

@section('title', 'AI Providers & Key Pool')

@section('content')
<div class="space-y-6" x-data="{
    providerFilter: 'all',
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
            copyText(data.message, data.success ? 'Key Verified OK!' : 'Test Failed');
            setTimeout(() => { this.testResult = null; }, 5000);
        } catch (err) {
            this.testResult = { id: accountId, success: false, message: err.message };
        } finally {
            this.testingAccountId = null;
            this.$nextTick(() => lucide.createIcons());
        }
    }
}">
    <!-- Header with Filter Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/[0.06] pb-4">
        <div>
            <h2 class="text-base font-bold text-white">AI Provider Registry & Key Pool</h2>
            <p class="text-xs text-zinc-400 mt-0.5">Manage upstream credentials with automatic failover, priority balancing, and rate limit cooldowns.</p>
        </div>

        <!-- Filter Bar -->
        <div class="flex items-center gap-2 flex-wrap">
            @php
                $freeSlugs = ['gemini', 'groq', 'cerebras', 'openrouter', 'mistral'];
                $coreSlugs = ['gemini', 'groq', 'openrouter', 'deepseek', 'cerebras', 'mistral', 'openai', 'anthropic'];
                $freeTierCount = $providers->filter(fn($p) => in_array($p->slug, $freeSlugs))->count();
                $customCount = $providers->filter(fn($p) => !in_array($p->slug, $coreSlugs))->count();
            @endphp
            <div class="flex items-center bg-[#121215] p-1 rounded-xl border border-white/[0.07] text-xs">
                <button type="button" @click="providerFilter = 'all'" :class="providerFilter === 'all' ? 'bg-zinc-800 text-white font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    All ({{ $providers->count() }})
                </button>
                <button type="button" @click="providerFilter = 'connected'" :class="providerFilter === 'connected' ? 'bg-zinc-800 text-white font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    Connected ({{ $providers->filter(fn($p) => $p->accounts->count() > 0)->count() }})
                </button>
                <button type="button" @click="providerFilter = 'free'" :class="providerFilter === 'free' ? 'bg-zinc-800 text-emerald-400 font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    Free Tier ({{ $freeTierCount }})
                </button>
                <button type="button" @click="providerFilter = 'custom'" :class="providerFilter === 'custom' ? 'bg-zinc-800 text-purple-400 font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    Custom ({{ $customCount }})
                </button>
                <button type="button" @click="providerFilter = 'openai'" :class="providerFilter === 'openai' ? 'bg-zinc-800 text-white font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    OpenAI Format
                </button>
                <button type="button" @click="providerFilter = 'anthropic'" :class="providerFilter === 'anthropic' ? 'bg-zinc-800 text-white font-medium' : 'text-zinc-400 hover:text-white'" class="px-3 py-1 rounded-lg transition-colors">
                    Anthropic
                </button>
            </div>

            <button type="button" @click="showProviderModal = true" class="px-3 py-1.5 text-xs font-semibold bg-zinc-800 hover:bg-zinc-700 text-zinc-200 border border-white/10 rounded-xl transition-colors flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Add Custom Provider</span>
            </button>
        </div>
    </div>

    <!-- 3-Column Bento Grid of Provider Cards (NO MORE STACKED TABLES!) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($providers as $provider)
            @php
                $hasKeys = $provider->accounts->count() > 0;
                $isFreeTier = in_array($provider->slug, $freeSlugs);
                $isCustom = !in_array($provider->slug, $coreSlugs);
            @endphp
            <div x-show="(providerFilter === 'all') || (providerFilter === 'connected' && {{ $hasKeys ? 'true' : 'false' }}) || (providerFilter === 'free' && {{ $isFreeTier ? 'true' : 'false' }}) || (providerFilter === 'custom' && {{ $isCustom ? 'true' : 'false' }}) || (providerFilter === '{{ $provider->format }}')"
                class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.14] rounded-2xl p-5 shadow-lg flex flex-col justify-between transition-all group">
                
                <div>
                    <!-- Card Header: Icon, Name, Protocol Pill & Status -->
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-zinc-800 to-zinc-900 border border-white/10 flex items-center justify-center font-bold text-sm {{ $isCustom ? 'text-purple-400' : 'text-emerald-400' }} shadow-md">
                                {{ strtoupper(substr($provider->slug, 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <h3 class="font-bold text-sm text-white group-hover:text-emerald-400 transition-colors">{{ $provider->name }}</h3>
                                    @if($isCustom)
                                        <span class="text-[9px] uppercase font-bold px-1.5 py-0.2 rounded bg-purple-500/10 text-purple-300 border border-purple-500/20">Custom</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-[10px] font-mono text-zinc-400">{{ $provider->slug }}</span>
                                    <span class="text-[9px] uppercase font-bold px-1.5 py-0.2 rounded {{ $provider->format === 'anthropic' ? 'bg-purple-500/10 text-purple-300 border border-purple-500/20' : 'bg-blue-500/10 text-blue-300 border border-blue-500/20' }}">
                                        {{ $provider->format }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge + Actions -->
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            @if($hasKeys)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    {{ $provider->accounts->count() }} {{ Str::plural('Key', $provider->accounts->count()) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-zinc-800 text-zinc-500 border border-white/5">
                                    Not Connected
                                </span>
                            @endif

                            @if($isCustom)
                                <form action="{{ route('dashboard.providers.delete', $provider) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        @click="confirmDelete($el.closest('form'), 'Delete Custom Provider', 'Are you sure you want to delete the custom provider &quot;{{ $provider->name }}&quot; and all its configured keys? This action cannot be undone.', 'Yes, Delete Provider')"
                                        class="p-1 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors ml-0.5 cursor-pointer" title="Delete Custom Provider">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5 pointer-events-none"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Base URL & Models -->
                    <div class="bg-[#09090b] rounded-xl p-2.5 border border-white/[0.05] mb-3">
                        <div class="text-[10px] text-zinc-500 font-mono truncate mb-1.5">{{ $provider->base_url }}</div>
                        <div class="flex items-center gap-1 flex-wrap">
                            @foreach(array_slice($provider->models_catalog ?? [], 0, 3) as $modelItem)
                                <span class="text-[10px] font-mono bg-zinc-800/80 text-zinc-300 px-1.5 py-0.5 rounded border border-white/5 truncate max-w-[140px]">
                                    {{ $modelItem }}
                                </span>
                            @endforeach
                            @if(count($provider->models_catalog ?? []) > 3)
                                <span class="text-[10px] font-mono text-zinc-500 px-1">+{{ count($provider->models_catalog) - 3 }} more</span>
                            @endif
                        </div>
                    </div>

                    <!-- Configured API Keys List in Card -->
                    @if($hasKeys)
                        <div class="space-y-1.5 mb-4">
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500">Configured Accounts:</div>
                            @foreach($provider->accounts as $acc)
                                <div class="p-2 rounded-lg bg-zinc-900 border border-white/[0.05] flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $acc->isInCooldown() ? 'bg-red-400 animate-ping' : ($acc->is_active ? 'bg-emerald-400' : 'bg-zinc-600') }}"></span>
                                        <span class="font-medium text-white truncate text-[11px]">{{ $acc->label }}</span>
                                        <span class="text-[10px] bg-zinc-800 px-1 rounded text-indigo-300 font-mono">P{{ $acc->priority }}</span>
                                    </div>

                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <button type="button" @click="pingAccount({{ $acc->id }})"
                                            :disabled="testingAccountId === {{ $acc->id }}"
                                            class="p-1 text-zinc-400 hover:text-white" title="Test Key">
                                            <i data-lucide="play" class="w-3 h-3"></i>
                                        </button>
                                        <form action="{{ route('dashboard.accounts.delete', $acc) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                @click="confirmDelete($el.closest('form'), 'Delete Provider API Key', 'Are you sure you want to delete the key &quot;{{ $acc->label }}&quot;?', 'Yes, Delete Key')"
                                                class="p-1 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Delete">
                                                <i data-lucide="trash-2" class="w-3 h-3 pointer-events-none"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Card Footer: + Add Key Button -->
                <div class="pt-3 border-t border-white/[0.06] flex items-center justify-between">
                    <span class="text-[11px] text-zinc-500 font-mono">
                        {{ count($provider->models_catalog ?? []) }} models
                    </span>
                    <button type="button" @click="openAddKeyModal({{ $provider->id }})"
                        class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-white font-medium text-xs rounded-xl border border-white/5 transition-colors flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3 h-3 text-emerald-400"></i>
                        <span>Add Key</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
