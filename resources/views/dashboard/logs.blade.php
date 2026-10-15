@extends('layouts.dashboard')

@section('title', 'Live Request Telemetry & Logs')

@section('content')
<div class="space-y-6">
    <!-- Logs Table Container -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#09090b] text-zinc-400 uppercase text-[10px] font-semibold border-b border-white/[0.06] tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Time</th>
                        <th class="py-3 px-4">Client Key</th>
                        <th class="py-3 px-4">Requested Model</th>
                        <th class="py-3 px-4">Routed Upstream</th>
                        <th class="py-3 px-4">Account Label</th>
                        <th class="py-3 px-4">Tokens (Prompt + Compl)</th>
                        <th class="py-3 px-4">Tokens Saved</th>
                        <th class="py-3 px-4">Latency</th>
                        <th class="py-3 px-4 text-right">
                            @if($logs->isNotEmpty())
                                <form action="{{ route('dashboard.logs.clear') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button"
                                        @click="confirmDelete($el.closest('form'), 'Clear Telemetry Logs', 'Clear all request telemetry trace logs? This cannot be undone.', 'Yes, Clear All Logs')"
                                        class="p-1.5 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Clear All Logs">
                                        <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                                    </button>
                                </form>
                            @else
                                Status
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.05]">
                    @forelse($logs as $log)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-4 text-zinc-400 font-mono whitespace-nowrap">
                                <div>{{ $log->created_at->format('H:i:s') }}</div>
                                <div class="text-[10px] text-zinc-600">{{ $log->created_at->format('M d') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($log->gatewayKey)
                                    <span class="text-zinc-200 font-medium">{{ $log->gatewayKey->name }}</span>
                                @else
                                    <span class="text-zinc-500 font-mono text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-white truncate max-w-[150px]">
                                {{ $log->requested_model }}
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                @if($log->routed_provider)
                                    <span class="text-emerald-400 font-semibold">{{ $log->routed_provider }}</span>/<span class="text-zinc-300">{{ $log->routed_model }}</span>
                                @else
                                    <span class="text-zinc-600">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-zinc-400 font-mono text-[11px]">
                                {{ $log->account_label ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                <span class="text-white font-medium">{{ number_format($log->total_tokens) }}</span>
                                <span class="text-zinc-500 text-[10px]">({{ $log->prompt_tokens }} + {{ $log->completion_tokens }})</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-emerald-400">
                                @if($log->saved_tokens > 0)
                                    +{{ number_format($log->saved_tokens) }}
                                @else
                                    <span class="text-zinc-600">0</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono text-amber-400 whitespace-nowrap">
                                {{ $log->latency_ms }} ms
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($log->status_code === 200)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1"></span>
                                        200 OK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20" title="{{ $log->error_message }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-1"></span>
                                        {{ $log->status_code }} Error
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-zinc-500 text-xs">
                                <div class="w-12 h-12 rounded-2xl bg-zinc-800/80 border border-white/5 mx-auto flex items-center justify-center text-zinc-500 mb-3">
                                    <i data-lucide="activity" class="w-6 h-6"></i>
                                </div>
                                <div class="text-sm text-zinc-400 font-medium">No gateway requests logged yet</div>
                                <p class="text-xs text-zinc-600 mt-1">Use the <a href="{{ route('dashboard.playground') }}" class="text-emerald-400 underline underline-offset-2">Live Playground</a> or send prompts from Cursor/client to start generating telemetry traces.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
