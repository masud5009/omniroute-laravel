@extends('layouts.dashboard')

@section('title', 'Architecture & Security Settings')

@section('content')
<div class="space-y-6">


    <!-- Diagnostic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- 1. System Specifications -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="server" class="w-4 h-4 text-emerald-400"></i>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">System Specifications</h3>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Shared Hosting Ready</span>
            </div>

            <div class="text-xs space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">PHP Version:</span>
                    <span class="text-white font-bold">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Laravel Framework:</span>
                    <span class="text-white font-bold">13.x</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Database Driver:</span>
                    <span class="text-white font-bold">{{ config('database.default') }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Cache Driver:</span>
                    <span class="text-white font-bold">{{ config('cache.default') }} <span class="text-emerald-400 text-[11px]">(No Redis Needed)</span></span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">cURL SSE Streaming:</span>
                    <span class="text-emerald-400 font-bold">Active (X-Accel-Buffering: no)</span>
                </div>
            </div>
        </div>

        <!-- 2. Security & Encryption -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Security & Encryption</h3>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Protected</span>
            </div>

            <div class="text-xs space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">API Key Encryption:</span>
                    <span class="text-emerald-400 font-bold">AES-256-CBC (App Key)</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">CORS Preflight:</span>
                    <span class="text-emerald-400 font-bold">Universal (*) Options Enabled</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Active Admin Session:</span>
                    <span class="text-white font-bold">{{ auth()->user()->email }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Front Controller:</span>
                    <span class="text-white font-bold">Root .htaccess Rewrite to /public</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Client Key Auth:</span>
                    <span class="text-emerald-400 font-bold">Bearer & x-api-key Middleware</span>
                </div>
            </div>
        </div>
    </div>

    <!-- cPanel / Shared Hosting Deployment Checklist -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-5 shadow-lg space-y-3">
        <h3 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
            <span>Shared Hosting & cPanel Deployment Verification</span>
        </h3>
        <p class="text-xs text-zinc-400">This gateway is configured to work out-of-the-box on standard Apache or LiteSpeed shared hosting servers without Node.js or Redis background workers.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-2 text-xs font-mono">
            <div class="p-3 rounded-xl bg-[#09090b] border border-white/5 space-y-1">
                <div class="text-emerald-400 font-bold flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Root .htaccess Active</span>
                </div>
                <p class="text-[11px] text-zinc-500 font-sans">Passes Authorization header and routes queries to public/ safely.</p>
            </div>

            <div class="p-3 rounded-xl bg-[#09090b] border border-white/5 space-y-1">
                <div class="text-emerald-400 font-bold flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>No Build Dependencies</span>
                </div>
                <p class="text-[11px] text-zinc-500 font-sans">Tailwind & Alpine loaded from CDN. No npm run build required.</p>
            </div>

            <div class="p-3 rounded-xl bg-[#09090b] border border-white/5 space-y-1">
                <div class="text-emerald-400 font-bold flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Self-Contained DB Cache</span>
                </div>
                <p class="text-[11px] text-zinc-500 font-sans">Rate-limiting and provider cooldowns use MySQL/SQLite database cache.</p>
            </div>
        </div>
    </div>
</div>
@endsection
