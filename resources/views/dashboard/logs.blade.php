@extends('layouts.dashboard')

@section('title', 'Live Request Telemetry & Logs')

@section('content')
<div class="space-y-6">
    <!-- Logs Table Container -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#09090b] text-zinc-400 uppercase text-xs font-bold border-b border-white/[0.06] tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Time</th>
                        <th class="py-3.5 px-4">Client Key</th>
                        <th class="py-3.5 px-4">Requested Model</th>
                        <th class="py-3.5 px-4">Routed Upstream</th>
                        <th class="py-3.5 px-4">Account Label</th>
                        <th class="py-3.5 px-4">Tokens (Prompt + Compl)</th>
                        <th class="py-3.5 px-4">Tokens Saved</th>
                        <th class="py-3.5 px-4">Latency</th>
                        <th class="py-3.5 px-4 text-right">
                            @if($logs->isNotEmpty())
                                <form action="{{ route('dashboard.logs.clear') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button"
                                        @click="confirmDelete($el.closest('form'), 'Clear Telemetry Logs', 'Clear all request telemetry trace logs? This cannot be undone.', 'Yes, Clear All Logs')"
                                        class="p-2 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-colors cursor-pointer" title="Clear All Logs">
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
                                <div class="text-xs font-semibold text-zinc-200">{{ $log->created_at->format('H:i:s') }}</div>
                                <div class="text-xs text-zinc-500">{{ $log->created_at->format('M d') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($log->gatewayKey)
                                    <span class="text-zinc-200 font-semibold text-sm">{{ $log->gatewayKey->name }}</span>
                                @else
                                    <span class="text-zinc-500 font-mono text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-white text-xs truncate max-w-[160px]">
                                {{ $log->requested_model }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs">
                                @if($log->routed_provider)
                                    <span class="text-emerald-400 font-semibold">{{ $log->routed_provider }}</span>/<span class="text-zinc-300">{{ $log->routed_model }}</span>
                                @else
                                    <span class="text-zinc-500">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-zinc-300 font-mono text-xs">
                                {{ $log->account_label ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                <span class="text-white font-medium text-xs">{{ number_format($log->total_tokens) }}</span>
                                <span class="text-zinc-500 text-xs">({{ $log->prompt_tokens }} + {{ $log->completion_tokens }})</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-emerald-400 text-xs font-medium">
                                @if($log->saved_tokens > 0)
                                    +{{ number_format($log->saved_tokens) }}
                                @else
                                    <span class="text-zinc-600">0</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono text-amber-400 text-xs font-medium whitespace-nowrap">
                                {{ $log->latency_ms }} ms
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($log->status_code === 200)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5"></span>
                                        200 OK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20" title="{{ $log->error_message }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-1.5"></span>
                                        {{ $log->status_code }} Error
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-14 text-center text-zinc-500 text-sm">
                                <div class="w-14 h-14 rounded-2xl bg-zinc-800/80 border border-white/5 mx-auto flex items-center justify-center text-zinc-400 mb-3.5">
                                    <i data-lucide="activity" class="w-7 h-7"></i>
                                </div>
                                <div class="text-base text-zinc-300 font-semibold">No gateway requests logged yet</div>
                                <p class="text-xs text-zinc-500 mt-1 max-w-sm mx-auto">Use the <a href="{{ route('dashboard.playground') }}" class="text-emerald-400 underline underline-offset-2">Live Playground</a> or send prompts from Cursor/client to start generating telemetry traces.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
