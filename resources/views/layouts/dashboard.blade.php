<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OmniRoute Lite - @yield('title', 'AI Gateway Console')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        zinc: {
                            850: '#1a1a1e',
                            900: '#121215',
                            925: '#0e0e11',
                            950: '#09090b',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #27272a; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #3f3f46; }

        /* SweetAlert2 Zinc Dark Theme */
        .swal2-popup.omni-swal {
            background: #121215 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 1rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
            padding: 1.5rem !important;
            font-family: 'Inter', sans-serif !important;
        }
        .swal2-popup.omni-swal .swal2-title {
            color: #ffffff !important;
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.25rem !important;
        }
        .swal2-popup.omni-swal .swal2-html-container {
            color: #a1a1aa !important;
            font-size: 0.8125rem !important;
            line-height: 1.4 !important;
            margin: 0.5rem 0 1.25rem 0 !important;
        }
        .swal2-popup.omni-swal .swal2-actions {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 0.5rem !important;
            width: 100% !important;
            margin-top: 0.75rem !important;
        }
        .swal2-popup.omni-swal .swal2-confirm {
            background-color: #e11d48 !important;
            color: #ffffff !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.75rem !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.3) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }
        .swal2-popup.omni-swal .swal2-confirm:hover {
            background-color: #f43f5e !important;
        }
        .swal2-popup.omni-swal .swal2-cancel {
            background-color: #27272a !important;
            color: #d4d4d8 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.75rem !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }
        .swal2-popup.omni-swal .swal2-cancel:hover {
            background-color: #3f3f46 !important;
            color: #ffffff !important;
        }
        .swal2-container {
            backdrop-filter: blur(4px) !important;
            background: rgba(0, 0, 0, 0.75) !important;
            z-index: 9999 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#09090b] text-zinc-100 antialiased selection:bg-emerald-500 selection:text-white"
    x-data="{
        showAccountModal: false,
        showProviderModal: false,
        selectedProviderId: {{ $modalProviders->first()?->id ?? 1 }},
        copyToast: false,
        copyToastText: 'Copied to clipboard!',
        copyText(text, label = 'Copied to clipboard!') {
            navigator.clipboard.writeText(text);
            this.copyToastText = label;
            this.copyToast = true;
            setTimeout(() => this.copyToast = false, 2500);
        },
        clearCache() {
            this.copyToastText = 'Gateway runtime cache purged successfully!';
            this.copyToast = true;
            setTimeout(() => this.copyToast = false, 2500);
        },
        openAddKeyModal(providerId = null) {
            if (providerId) {
                this.selectedProviderId = providerId;
            }
            this.showAccountModal = true;
            this.$nextTick(() => lucide.createIcons());
        },
        customProviderFormat: 'openai',
        openAddCustomProviderModal(format = 'openai') {
            this.customProviderFormat = format;
            this.showProviderModal = true;
            this.$nextTick(() => lucide.createIcons());
        }
    }"
    x-init="
        lucide.createIcons();
        $watch('showAccountModal', () => $nextTick(() => lucide.createIcons()));
        $watch('showProviderModal', () => $nextTick(() => lucide.createIcons()));
    ">

    <!-- Copy Toast Floating Notification -->
    <div x-show="copyToast" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 bg-emerald-500 text-zinc-950 font-semibold px-4 py-2.5 rounded-xl shadow-2xl flex items-center gap-2 text-xs" x-cloak>
        <i data-lucide="check" class="w-4 h-4 text-zinc-950"></i>
        <span x-text="copyToastText"></span>
    </div>

    <!-- App Shell Layout: Sidebar + Main Content -->
    <div class="flex h-screen overflow-hidden">

        <!-- ============================================================== -->
        <!-- FIXED LEFT SIDEBAR (w-64)                                      -->
        <!-- ============================================================== -->
        <aside class="w-64 h-screen bg-[#10141e] border-r border-white/[0.07] flex flex-col justify-between flex-shrink-0 z-30 select-none">
            <!-- Sidebar Top: Brand -->
            <div>
                <a href="{{ route('dashboard.overview') }}" class="h-16 px-5 border-b border-white/[0.07] flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-zinc-800 to-zinc-900 border border-white/10 flex items-center justify-center shadow-lg relative">
                            <i data-lucide="zap" class="w-4 h-4 text-emerald-400"></i>
                        </div>
                        <div>
                            <span class="font-bold text-sm tracking-tight text-white block">OmniRoute</span>
                            <span class="text-[10px] text-zinc-500 font-mono">Lite Gateway</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-1.5 py-0.5 rounded">v1.0</span>
                </a>

                <!-- Navigation Links with Dedicated Routes -->
                <nav class="p-3 space-y-1">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 px-3 pt-2 pb-1">Navigation</div>

                    <!-- 1. Overview -->
                    <a href="{{ route('dashboard.overview') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.index') || request()->routeIs('dashboard.overview') || request()->routeIs('dashboard'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !(request()->routeIs('dashboard.index') || request()->routeIs('dashboard.overview') || request()->routeIs('dashboard')),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 transition-colors {{ (request()->routeIs('dashboard.index') || request()->routeIs('dashboard.overview') || request()->routeIs('dashboard')) ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Overview & Analytics</span>
                        </div>
                    </a>

                    <!-- 2. AI Providers -->
                    <a href="{{ route('dashboard.providers') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.providers'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.providers'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="cpu" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.providers') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>AI Providers</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-mono {{ request()->routeIs('dashboard.providers') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-zinc-800 text-zinc-400' }}">
                            {{ $sidebarProvidersCount }}
                        </span>
                    </a>

                    <!-- 3. Smart Combos -->
                    <a href="{{ route('dashboard.combos') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.combos'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.combos'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="git-branch" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.combos') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Smart Combos</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-mono bg-zinc-800 text-zinc-400">{{ $sidebarCombosCount }}</span>
                    </a>

                    <!-- 4. Gateway Client Keys -->
                    <a href="{{ route('dashboard.gateway-keys') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.gateway-keys'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.gateway-keys'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="key-round" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.gateway-keys') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Gateway Keys</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-mono bg-zinc-800 text-zinc-400">{{ $sidebarKeysCount }}</span>
                    </a>

                    <div class="text-[10px] font-semibold uppercase tracking-wider text-zinc-500 px-3 pt-4 pb-1">Studio & Inspector</div>

                    <!-- 5. Live Playground -->
                    <a href="{{ route('dashboard.playground') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.playground'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.playground'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="terminal" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.playground') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Live Playground</span>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    </a>

                    <!-- 6. Telemetry Logs -->
                    <a href="{{ route('dashboard.logs') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.logs'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.logs'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="activity" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.logs') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Telemetry Logs</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-mono bg-zinc-800 text-zinc-400">{{ $sidebarLogsCount }}</span>
                    </a>

                    <!-- 7. Settings & Security -->
                    <a href="{{ route('dashboard.settings') }}"
                        @class([
                            'w-full py-2 pr-3 rounded-lg text-xs flex items-center justify-between transition-all group',
                            'bg-white/[0.08] text-white font-medium border-l-2 border-emerald-400 pl-2.5' => request()->routeIs('dashboard.settings'),
                            'text-zinc-400 hover:text-zinc-200 hover:bg-white/[0.03] pl-3' => !request()->routeIs('dashboard.settings'),
                        ])>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="shield-check" class="w-4 h-4 transition-colors {{ request()->routeIs('dashboard.settings') ? 'text-emerald-400' : 'text-zinc-500 group-hover:text-zinc-300' }}"></i>
                            <span>Settings & Security</span>
                        </div>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Bottom: System Health, Clear Cache & User Profile -->
            <div class="p-3 border-t border-white/[0.07] space-y-2 bg-[#0c101a]">
                <!-- Health Pulse -->
                <div class="p-2.5 rounded-xl bg-[#141926] border border-white/[0.06] flex items-center justify-between text-[11px]">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-zinc-300 font-medium">All Systems Operational</span>
                    </div>
                    <span class="text-zinc-500 font-mono text-[10px]">No-Redis</span>
                </div>

                <!-- Clear Cache Button -->
                <button type="button" @click="clearCache()"
                    class="w-full py-1.5 px-2.5 rounded-xl bg-[#141926] hover:bg-[#1a2133] border border-white/[0.06] hover:border-white/10 text-zinc-300 text-[11px] font-medium flex items-center justify-between transition-colors group">
                    <div class="flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-zinc-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span>Clear Gateway Cache</span>
                    </div>
                    <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Purge</span>
                </button>

                <!-- Admin Profile Card -->
                <div class="flex items-center justify-between px-1 pt-1">
                    <div class="flex items-center gap-2 truncate">
                        <div class="w-7 h-7 rounded-lg bg-zinc-800 border border-white/10 flex items-center justify-center font-bold text-xs text-zinc-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-zinc-500 truncate">{{ auth()->user()->email }}</div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-1.5 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors" title="Sign Out">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ============================================================== -->
        <!-- MAIN CONTENT AREA                                              -->
        <!-- ============================================================== -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#09090b]">
            <!-- Top Sticky Glass Header -->
            <header class="h-16 border-b border-white/[0.07] bg-[#09090b]/80 backdrop-blur-md px-6 flex items-center justify-between z-20 flex-shrink-0">
                <!-- Page Title -->
                <div class="flex items-center gap-3">
                    <h1 class="text-base font-bold text-white tracking-tight">@yield('title', 'Overview & Live Analytics')</h1>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-3">
                    <!-- Quick Add Key Button -->
                    <button type="button" @click="openAddKeyModal()"
                        class="px-3.5 py-1.5 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl shadow-lg shadow-white/5 transition-all flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Add Key</span>
                    </button>
                </div>
            </header>

            <!-- Scrollable Content Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#090b10] bg-[radial-gradient(rgba(255,255,255,0.035)_1px,transparent_1px)] [background-size:24px_24px]">

                <!-- Global Success Alert -->
                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-300">&times;</button>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="p-3.5 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" @click="$el.parentElement.remove()" class="text-red-500 hover:text-red-300">&times;</button>
                    </div>
                @endif

                <!-- Content Slot for Dedicated Route Views -->
                @yield('content')

            </div>
        </main>
    </div>

    <!-- ============================================================== -->
    <!-- SLIDE-OVER / MODAL: ADD PROVIDER API KEY                       -->
    <!-- ============================================================== -->
    <div x-show="showAccountModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div class="bg-[#121215] border border-white/[0.08] rounded-2xl w-full max-w-md p-6 shadow-2xl relative" @click.away="showAccountModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-white/[0.06] mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="key" class="w-4 h-4 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white">Add Provider API Key</h3>
                </div>
                <button type="button" @click="showAccountModal = false" class="text-zinc-500 hover:text-white">&times;</button>
            </div>

            <form action="{{ route('dashboard.accounts.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Target AI Provider</label>
                    <select name="ai_provider_id" x-model="selectedProviderId" class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                        @foreach($modalProviders as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }} ({{ $provider->slug }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Key Label / Identifier</label>
                    <input type="text" name="label" placeholder="e.g. Free Tier Account 1" required
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Raw Provider Secret API Key</label>
                    <input type="password" name="api_key" placeholder="Will be encrypted in database with AES-256" required
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 font-mono">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Priority (1 = Highest)</label>
                        <input type="number" name="priority" value="1" min="1"
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Daily Token Limit</label>
                        <input type="number" name="daily_token_limit" placeholder="Optional" min="1"
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="pt-3 border-t border-white/[0.06] flex items-center justify-end gap-2">
                    <button type="button" @click="showAccountModal = false" class="px-3.5 py-2 text-xs font-medium text-zinc-400 hover:text-white rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl transition-all shadow-md">
                        Save Encrypted Key
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL: ADD CUSTOM AI PROVIDER                                  -->
    <!-- ============================================================== -->
    <div x-show="showProviderModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div class="bg-[#121215] border border-white/[0.08] rounded-2xl w-full max-w-md p-6 shadow-2xl relative" @click.away="showProviderModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-white/[0.06] mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="cpu" class="w-4 h-4 text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white">Add Custom AI Provider</h3>
                </div>
                <button type="button" @click="showProviderModal = false" class="text-zinc-500 hover:text-white">&times;</button>
            </div>

            <form action="{{ route('dashboard.providers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Provider Name</label>
                    <input type="text" name="name" placeholder="e.g. Together AI, vLLM Local, Perplexity" required
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Slug (Optional)</label>
                        <input type="text" name="slug" placeholder="e.g. together"
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Protocol</label>
                        <select name="format" x-model="customProviderFormat" class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                            <option value="openai">OpenAI (/chat/completions)</option>
                            <option value="anthropic">Anthropic (/messages)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Base URL</label>
                    <input type="url" name="base_url" placeholder="https://api.together.xyz/v1" required
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Model Catalog (Comma-separated)</label>
                    <textarea name="models_catalog" rows="3" placeholder="meta-llama/Llama-3-70b-chat-hf, mistralai/Mixtral-8x7B"
                        class="w-full bg-[#09090b] border border-white/10 rounded-xl p-3 text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 font-mono resize-none"></textarea>
                </div>

                <div class="pt-3 border-t border-white/[0.06] flex items-center justify-end gap-2">
                    <button type="button" @click="showProviderModal = false" class="px-3.5 py-2 text-xs font-medium text-zinc-400 hover:text-white rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold text-xs rounded-xl transition-all shadow-md">
                        Add Provider
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- SweetAlert2 Dark Modal Handler -->
    <script>
        window.confirmDelete = function(form, title = 'Are you sure?', text = 'This action cannot be undone.', btnText = 'Yes, delete') {
            if (typeof Swal === 'undefined') {
                if (window.confirm(title + '\n\n' + text)) {
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                iconColor: '#f43f5e',
                showCancelButton: true,
                confirmButtonText: btnText,
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    popup: 'omni-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        };
    </script>
    @stack('scripts')
</body>
</html>
