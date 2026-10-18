@extends('layouts.dashboard')

@section('title', 'Architecture & Security Settings')

@section('content')
<div class="space-y-6">

    <!-- Appearance & Theme Selector Card -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
            <div class="flex items-center gap-2.5">
                <i data-lucide="palette" class="w-5 h-5 text-emerald-400"></i>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Appearance & Theme Mode</h3>
            </div>
            <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Dual Mode Ready</span>
        </div>

        <p class="text-sm text-zinc-400">Customize the visual presentation of your OmniRoute Lite admin console. Your preference is persisted locally across sessions.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
            <!-- Dark Mode Option Card -->
            <button type="button" @click="setTheme('dark')"
                :class="currentTheme === 'dark' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-white/10 hover:border-white/20'"
                class="p-5 rounded-2xl bg-[#09090b] border text-left transition-all relative flex flex-col justify-between cursor-pointer group">
                <div class="flex items-center justify-between mb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-800 border border-white/10 flex items-center justify-center text-amber-400">
                            <i data-lucide="moon" class="w-4.5 h-4.5"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">Dark Mode</div>
                            <div class="text-xs text-zinc-400 font-mono mt-0.5">Obsidian Zinc Aesthetic</div>
                        </div>
                    </div>
                    <span x-show="currentTheme === 'dark'" class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="h-11 rounded-xl bg-[#121215] border border-white/5 p-2.5 flex items-center gap-2.5">
                    <div class="w-3.5 h-3.5 rounded-full bg-emerald-500/30"></div>
                    <div class="h-2.5 w-20 bg-zinc-700 rounded"></div>
                    <div class="h-2.5 w-10 bg-zinc-800 rounded ml-auto"></div>
                </div>
            </button>

            <!-- Light / White Mode Option Card -->
            <button type="button" @click="setTheme('light')"
                :class="currentTheme === 'light' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-white/10 hover:border-white/20'"
                class="p-5 rounded-2xl bg-[#09090b] border text-left transition-all relative flex flex-col justify-between cursor-pointer group">
                <div class="flex items-center justify-between mb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-800 border border-white/10 flex items-center justify-center text-amber-400">
                            <i data-lucide="sun" class="w-4.5 h-4.5"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">White / Light Mode</div>
                            <div class="text-xs text-zinc-400 font-mono mt-0.5">High-Clarity Daylight Surface</div>
                        </div>
                    </div>
                    <span x-show="currentTheme === 'light'" class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="h-11 rounded-xl bg-[#f8fafc] border border-zinc-200 p-2.5 flex items-center gap-2.5">
                    <div class="w-3.5 h-3.5 rounded-full bg-emerald-600/30"></div>
                    <div class="h-2.5 w-20 bg-zinc-300 rounded"></div>
                    <div class="h-2.5 w-10 bg-zinc-200 rounded ml-auto"></div>
                </div>
            </button>
        </div>
    </div>

    <!-- Diagnostic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 1. System Specifications -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="server" class="w-5 h-5 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">System Specifications</h3>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Shared Hosting Ready</span>
            </div>

            <div class="text-sm space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">PHP Version:</span>
                    <span class="text-white font-bold">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Laravel Framework:</span>
                    <span class="text-white font-bold">13.x</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Database Driver:</span>
                    <span class="text-white font-bold">{{ config('database.default') }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Cache Driver:</span>
                    <span class="text-white font-bold">{{ config('cache.default') }} <span class="text-emerald-400 text-xs font-normal">(No Redis Needed)</span></span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">cURL SSE Streaming:</span>
                    <span class="text-emerald-400 font-bold">Active (X-Accel-Buffering: no)</span>
                </div>
            </div>
        </div>

        <!-- 2. Security & Encryption -->
        <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3.5">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Security & Encryption</h3>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">Protected</span>
            </div>

            <div class="text-sm space-y-2.5 font-mono">
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">API Key Encryption:</span>
                    <span class="text-emerald-400 font-bold">AES-256-CBC (App Key)</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">CORS Preflight:</span>
                    <span class="text-emerald-400 font-bold">Universal (*) Options Enabled</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Active Admin Session:</span>
                    <span class="text-white font-bold">{{ auth()->user()->email }}</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Front Controller:</span>
                    <span class="text-white font-bold">Root .htaccess Rewrite to /public</span>
                </div>
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#09090b] border border-white/5">
                    <span class="text-zinc-400">Client Key Auth:</span>
                    <span class="text-emerald-400 font-bold">Bearer & x-api-key Middleware</span>
                </div>
            </div>
        </div>
    </div>

    <!-- cPanel / Shared Hosting Deployment Checklist -->
    <div class="bg-[#121215] border border-white/[0.07] rounded-2xl p-6 shadow-lg space-y-3.5">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2.5">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
            <span>Shared Hosting & cPanel Deployment Verification</span>
        </h3>
        <p class="text-sm text-zinc-400">This gateway is configured to work out-of-the-box on standard Apache or LiteSpeed shared hosting servers without Node.js or Redis background workers.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 text-xs font-mono">
            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Root .htaccess Active</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Passes Authorization header and routes queries to public/ safely.</p>
            </div>

            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>No Build Dependencies</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Tailwind & Alpine loaded from CDN. No npm run build required.</p>
            </div>

            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-1.5">
                <div class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Self-Contained DB Cache</span>
                </div>
                <p class="text-xs text-zinc-400 font-sans">Rate-limiting and provider cooldowns use MySQL/SQLite database cache.</p>
            </div>
        </div>
    </div>
</div>
@endsection
