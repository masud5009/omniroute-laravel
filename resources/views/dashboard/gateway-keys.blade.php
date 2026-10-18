@extends('layouts.dashboard')

@section('title', 'Client Gateway API Keys')

@section('content')
<div class="space-y-6">
    <!-- Generator Box -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg">
        <form action="{{ route('dashboard.gateway-keys.store') }}" method="POST" class="flex flex-col sm:flex-row items-end gap-3.5">
            @csrf
            <div class="flex-1 w-full">
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">Application or Client Label</label>
                <input type="text" name="name" placeholder="e.g. Cursor IDE - Primary Workstation" required
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500">
            </div>
            <div class="w-full sm:w-56">
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">Daily Token Quota</label>
                <input type="number" name="daily_token_limit" placeholder="Optional (unlimited)" min="1"
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500">
            </div>
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-sm rounded-xl shadow-md transition-colors whitespace-nowrap flex items-center justify-center gap-2">
                <i data-lucide="key" class="w-4 h-4"></i>
                <span>Generate Key</span>
            </button>
        </form>
    </div>

    <!-- Keys Table -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#09090b] text-zinc-400 uppercase text-xs font-bold border-b border-white/[0.06] tracking-wider">
                    <tr>
                        <th class="py-3.5 px-5">Key Name</th>
                        <th class="py-3.5 px-5">API Key Token</th>
                        <th class="py-3.5 px-5">Daily Token Usage</th>
                        <th class="py-3.5 px-5">Last Activity</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.05]">
                    @foreach($gatewayKeys as $gKey)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-5 font-semibold text-white">{{ $gKey->name }}</td>
                            <td class="py-4 px-5 font-mono">
                                <div class="flex items-center gap-2">
                                    <span class="bg-[#09090b] border border-white/10 px-2.5 py-1 rounded-lg text-emerald-300 font-mono text-xs select-all">
                                        {{ $gKey->key }}
                                    </span>
                                    <button type="button" @click="copyText('{{ $gKey->key }}', 'API key copied!')" class="p-1.5 text-zinc-400 hover:text-white" title="Copy Key">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-bold text-white">{{ number_format($gKey->tokens_used_today) }}</span>
                                <span class="text-zinc-500">/ {{ $gKey->daily_token_limit ? number_format($gKey->daily_token_limit) : '∞' }}</span>
                            </td>
                            <td class="py-4 px-5 text-zinc-400 font-mono text-xs">
                                {{ $gKey->last_used_at ? $gKey->last_used_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $gKey->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-800 text-zinc-400' }}">
                                    {{ $gKey->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <form action="{{ route('dashboard.gateway-keys.toggle', $gKey) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-xl transition-colors {{ $gKey->is_active ? 'text-amber-400 hover:bg-amber-500/10' : 'text-emerald-400 hover:bg-emerald-500/10' }}" title="{{ $gKey->is_active ? 'Pause Key' : 'Enable Key' }}">
                                            <i data-lucide="{{ $gKey->is_active ? 'pause-circle' : 'play-circle' }}" class="w-4.5 h-4.5 pointer-events-none"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('dashboard.gateway-keys.delete', $gKey) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            @click="confirmDelete($el.closest('form'), 'Delete Gateway Key', 'Permanently delete gateway key &quot;{{ $gKey->name }}&quot;? External clients using this key will immediately lose access.', 'Yes, Delete Key')"
                                            class="p-2 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-colors cursor-pointer" title="Delete Key">
                                            <i data-lucide="trash-2" class="w-4.5 h-4.5 pointer-events-none"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
