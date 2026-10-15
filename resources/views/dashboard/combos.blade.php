@extends('layouts.dashboard')

@section('title', 'Smart Combos & Fallback Router')

@section('content')
<div class="space-y-6" x-data="{
    addModelChip(modelString) {
        const input = document.getElementById('combo-models-input');
        if (!input) return;
        const current = input.value.trim();
        if (!current) {
            input.value = modelString;
        } else if (!current.includes(modelString)) {
            input.value = current + ', ' + modelString;
        }
    }
}">
    <!-- Visual Fallback Pipeline Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($combos as $combo)
            <div class="bg-[#121215] border border-white/[0.07] hover:border-white/[0.14] rounded-2xl p-5 shadow-lg flex flex-col justify-between transition-all">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="font-bold text-sm text-white flex items-center gap-2">
                            <i data-lucide="git-branch" class="w-4 h-4 text-emerald-400"></i>
                            <span>{{ $combo->name }}</span>
                        </h3>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $combo->strategy === 'round-robin' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' : 'bg-indigo-500/10 text-indigo-300 border border-indigo-500/20' }}">
                                {{ $combo->strategy }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $combo->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-800 text-zinc-500' }}">
                                {{ $combo->is_active ? 'Active' : 'Paused' }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-zinc-400 mb-4">{{ $combo->description ?: 'Smart multi-provider fallback sequence.' }}</p>

                    <!-- Visual Fallback Chain Pipeline Design -->
                    <div class="space-y-1.5 mb-4">
                        <div class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 mb-2">Fallback Pipeline Sequence:</div>
                        @foreach($combo->models ?? [] as $step => $m)
                            <div class="relative">
                                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#09090b] border border-white/[0.06] text-xs font-mono">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="w-5 h-5 rounded-md bg-zinc-800 text-emerald-400 text-[10px] font-bold flex items-center justify-center flex-shrink-0">
                                            {{ $step + 1 }}
                                        </span>
                                        <span class="text-zinc-200 truncate">{{ $m }}</span>
                                    </div>
                                    <span class="text-[10px] text-zinc-500 font-sans font-medium flex-shrink-0">Step {{ $step + 1 }}</span>
                                </div>
                                @if(!$loop->last)
                                    <div class="flex items-center justify-center my-1 text-zinc-600">
                                        <div class="flex items-center gap-1 text-[10px] font-mono text-zinc-500 bg-[#09090b] px-2 py-0.5 rounded-full border border-white/5">
                                            <i data-lucide="arrow-down" class="w-3 h-3 text-emerald-400"></i>
                                            <span>fallback on 429 / failover</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(!empty($combo->compression_modes))
                        <div class="flex items-center gap-1.5 flex-wrap text-[10px] mb-2">
                            <span class="text-zinc-500 font-medium">Compression:</span>
                            @foreach($combo->compression_modes as $mode)
                                <span class="bg-zinc-900 border border-white/5 text-emerald-400 px-1.5 py-0.5 rounded font-mono">{{ $mode }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-white/[0.06] flex items-center justify-between">
                    <span class="text-[11px] text-zinc-500 font-mono">{{ count($combo->models ?? []) }} steps</span>
                    <div class="flex items-center gap-1">
                        <form action="{{ route('dashboard.combos.toggle', $combo) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-1.5 rounded-lg transition-colors {{ $combo->is_active ? 'text-amber-400 hover:bg-amber-500/10' : 'text-emerald-400 hover:bg-emerald-500/10' }}" title="{{ $combo->is_active ? 'Pause Combo' : 'Enable Combo' }}">
                                <i data-lucide="{{ $combo->is_active ? 'pause-circle' : 'play-circle' }}" class="w-4 h-4 pointer-events-none"></i>
                            </button>
                        </form>

                        <form action="{{ route('dashboard.combos.delete', $combo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                @click="confirmDelete($el.closest('form'), 'Delete Smart Combo', 'Delete smart combo &quot;{{ $combo->name }}&quot;? Fallback routing for this model will cease.', 'Yes, Delete Combo')"
                                class="p-1.5 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Delete Combo">
                                <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Builder Form Box -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center gap-2 border-b border-white/[0.06] pb-3">
            <i data-lucide="plus-circle" class="w-4 h-4 text-emerald-400"></i>
            <h3 class="text-sm font-bold text-white">Create New Smart Combo</h3>
        </div>

        <form action="{{ route('dashboard.combos.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Combo Name (e.g. auto/code, auto/cheap)</label>
                    <input type="text" name="name" placeholder="auto/custom" required
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Description</label>
                    <input type="text" name="description" placeholder="Fallback sequence for high availability"
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Strategy</label>
                    <select name="strategy" class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="priority">Priority Fallback (Step 1 ➔ Step 2 ➔ Step 3)</option>
                        <option value="round-robin">Round-Robin (Rotate starting model)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-2">Prompt Compression Pipeline</label>
                <div class="flex items-center gap-4 flex-wrap text-xs text-zinc-300">
                    <label class="flex items-center gap-2 bg-[#09090b] border border-white/5 px-3 py-2 rounded-xl cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="compression_modes[]" value="dedup" checked class="rounded border-white/10 text-emerald-500 focus:ring-emerald-500">
                        <span><strong>dedup</strong>: Deduplicate repeated system messages</span>
                    </label>
                    <label class="flex items-center gap-2 bg-[#09090b] border border-white/5 px-3 py-2 rounded-xl cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="compression_modes[]" value="lite" checked class="rounded border-white/10 text-emerald-500 focus:ring-emerald-500">
                        <span><strong>lite</strong>: Collapse 3+ newlines & spaces outside code</span>
                    </label>
                    <label class="flex items-center gap-2 bg-[#09090b] border border-white/5 px-3 py-2 rounded-xl cursor-pointer hover:border-white/10">
                        <input type="checkbox" name="compression_modes[]" value="caveman" class="rounded border-white/10 text-emerald-500 focus:ring-emerald-500">
                        <span><strong>caveman</strong>: Strip conversational filler phrases</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                    Ordered Fallback Sequence (<code class="text-emerald-400">provider_slug/model_name</code>, comma-separated)
                </label>
                <input type="text" id="combo-models-input" name="models" placeholder="gemini/gemini-2.5-flash, groq/llama-3.3-70b-versatile, openrouter/meta-llama/llama-3.3-70b-instruct:free" required
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white font-mono placeholder-zinc-600 focus:outline-none focus:border-emerald-500 mb-2">

                <!-- Quick Chips -->
                <div class="text-[11px] text-zinc-400 flex items-center gap-1.5 flex-wrap">
                    <span class="text-zinc-500 font-semibold">Quick Chips:</span>
                    @foreach($providers->filter(fn($p) => $p->accounts->count() > 0)->take(4) as $p)
                        @foreach(array_slice($p->models_catalog ?? [], 0, 1) as $m)
                            <button type="button" @click="addModelChip('{{ $p->slug }}/{{ $m }}')"
                                class="px-2 py-0.5 rounded bg-zinc-800 hover:bg-emerald-500/20 border border-white/5 text-zinc-300 font-mono transition-colors">
                                + {{ $p->slug }}/{{ $m }}
                            </button>
                        @endforeach
                        @if(count($p->models_catalog ?? []) > 1)
                            <span class="text-zinc-600">+{{ count($p->models_catalog) - 1 }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl transition-all shadow-md">
                Save Smart Combo
            </button>
        </form>
    </div>
</div>
@endsection
