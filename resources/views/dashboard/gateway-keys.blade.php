@extends('layouts.dashboard')

@section('title', 'Client Gateway API Keys')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between border-b border-white/[0.06] pb-4">
        <div>
            <h2 class="text-base font-bold text-white">Client Gateway API Keys</h2>
            <p class="text-xs text-zinc-400 mt-0.5">Issue master and application keys to authenticate external clients, code editors, and LLM applications.</p>
        </div>
    </div>

    <!-- Generator Box -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg">
        <form action="{{ route('dashboard.gateway-keys.store') }}" method="POST" class="flex flex-col sm:flex-row items-end gap-3">
            @csrf
            <div class="flex-1 w-full">
                <label class="block text-xs font-medium text-zinc-400 mb-1.5">Application or Client Label</label>
                <input type="text" name="name" placeholder="e.g. Cursor IDE - Primary Workstation" required
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
            </div>
            <div class="w-full sm:w-48">
                <label class="block text-xs font-medium text-zinc-400 mb-1.5">Daily Token Quota</label>
                <input type="number" name="daily_token_limit" placeholder="Optional (unlimited)" min="1"
                    class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
            </div>
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl shadow-md transition-colors whitespace-nowrap flex items-center justify-center gap-1.5">
                <i data-lucide="key" class="w-3.5 h-3.5"></i>
                <span>Generate Key</span>
            </button>
        </form>
    </div>

    <!-- Keys Table -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#09090b] text-zinc-400 uppercase text-[10px] font-semibold border-b border-white/[0.06] tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Key Name</th>
                        <th class="py-3 px-4">API Key Token</th>
                        <th class="py-3 px-4">Daily Token Usage</th>
                        <th class="py-3 px-4">Last Activity</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.05]">
                    @foreach($gatewayKeys as $gKey)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-white">{{ $gKey->name }}</td>
                            <td class="py-3.5 px-4 font-mono">
                                <div class="flex items-center gap-2">
                                    <span class="bg-[#09090b] border border-white/10 px-2 py-1 rounded text-emerald-300 font-mono text-[11px] select-all">
                                        {{ $gKey->key }}
                                    </span>
                                    <button type="button" @click="copyText('{{ $gKey->key }}', 'API key copied!')" class="p-1 text-zinc-400 hover:text-white" title="Copy Key">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-white">{{ number_format($gKey->tokens_used_today) }}</span>
                                <span class="text-zinc-500">/ {{ $gKey->daily_token_limit ? number_format($gKey->daily_token_limit) : '∞' }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-zinc-400 font-mono text-[11px]">
                                {{ $gKey->last_used_at ? $gKey->last_used_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $gKey->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-800 text-zinc-500' }}">
                                    {{ $gKey->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1 whitespace-nowrap">
                                <form action="{{ route('dashboard.gateway-keys.toggle', $gKey) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 text-[11px] font-semibold {{ $gKey->is_active ? 'text-amber-400 hover:bg-amber-500/10' : 'text-emerald-400 hover:bg-emerald-500/10' }} rounded-lg border border-white/5 transition-colors">
                                        {{ $gKey->is_active ? 'Pause' : 'Enable' }}
                                    </button>
                                </form>

                                <form action="{{ route('dashboard.gateway-keys.delete', $gKey) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click="confirmDelete($el.closest('form'), 'Delete Gateway Key', 'Permanently delete gateway key &quot;{{ $gKey->name }}&quot;? External clients using this key will immediately lose access.', 'Yes, Delete Key')"
                                        class="px-2 py-1 text-[11px] font-semibold text-red-400 hover:bg-red-500/10 rounded-lg border border-white/5 transition-colors cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
