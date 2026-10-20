<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($globalSiteSettings->site_title ?? 'OmniRoute') }} {{ ($globalSiteSettings->subtitle ?? 'Lite') }} - Sign In</title>
    @if(isset($globalSiteSettings) && $globalSiteSettings->faviconUrl())
    <link rel="icon" href="{{ $globalSiteSettings->faviconUrl() }}">
    @endif

    <!-- Theme Initializer -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('omni_theme');
                if (savedTheme === 'light' || (!savedTheme && window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches)) {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {
                console.error(e);
            }
        })();
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        zinc: {
                            850: '#1f1f23',
                            925: '#121215',
                            950: '#09090b',
                        }
                    },
                    fontSize: {
                        '2xs': ['0.6875rem', { lineHeight: '1rem' }],       /* 11px */
                        'xs': ['0.75rem', { lineHeight: '1.125rem' }],       /* 12px */
                        'sm': ['0.8125rem', { lineHeight: '1.25rem' }],     /* 13px */
                        'base': ['0.875rem', { lineHeight: '1.375rem' }],   /* 14px */
                        'md': ['0.9375rem', { lineHeight: '1.45rem' }],     /* 15px */
                        'lg': ['1.0625rem', { lineHeight: '1.55rem' }],     /* 17px */
                        'xl': ['1.25rem', { lineHeight: '1.75rem' }],       /* 20px */
                        '2xl': ['1.5rem', { lineHeight: '1.875rem' }],      /* 24px */
                        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],     /* 30px */
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        html { font-size: 16px; }
        body { font-family: 'Inter', sans-serif; font-size: 0.875rem; line-height: 1.5; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
        [x-cloak] { display: none !important; }

        /* Light Mode Styles */
        html:not(.dark) body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }
        html:not(.dark) .bg-\[\#121215\] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        }
        html:not(.dark) h1,
        html:not(.dark) .text-white {
            color: #0f172a !important;
        }
        html:not(.dark) .text-zinc-100,
        html:not(.dark) .text-zinc-200 {
            color: #1e293b !important;
        }
        html:not(.dark) .text-zinc-400 {
            color: #64748b !important;
        }
        html:not(.dark) input:not([type="checkbox"]) {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        html:not(.dark) input::placeholder {
            color: #94a3b8 !important;
        }
        html:not(.dark) .bg-white.text-zinc-950 {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }
        html:not(.dark) .bg-white.text-zinc-950:hover {
            background-color: #1e293b !important;
        }
        html:not(.dark) .border-white\/10,
        html:not(.dark) .border-white\/\[0\.08\],
        html:not(.dark) .border-white\/\[0\.06\] {
            border-color: #e2e8f0 !important;
        }
        html:not(.dark) .bg-zinc-900 {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
        }
    </style>
</head>
<body class="bg-[#09090b] text-zinc-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden antialiased selection:bg-emerald-500 selection:text-white"
    x-data="{
        currentTheme: localStorage.getItem('omni_theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light'),
        toggleTheme() {
            if (this.currentTheme === 'dark') {
                this.currentTheme = 'light';
                document.documentElement.classList.remove('dark');
                localStorage.setItem('omni_theme', 'light');
            } else {
                this.currentTheme = 'dark';
                document.documentElement.classList.add('dark');
                localStorage.setItem('omni_theme', 'dark');
            }
            this.$nextTick(() => lucide.createIcons());
        }
    }" x-init="$nextTick(() => lucide.createIcons())">
    <!-- Theme Switcher Top-Right Button -->
    <div class="absolute top-5 right-5 z-20">
        <button type="button" @click="toggleTheme()"
            class="p-2.5 rounded-xl border border-white/10 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300 transition-colors shadow-sm flex items-center justify-center cursor-pointer"
            :title="currentTheme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
            <span x-show="currentTheme === 'dark'" class="flex items-center">
                <i data-lucide="sun" class="w-4 h-4 text-amber-400"></i>
            </span>
            <span x-show="currentTheme !== 'dark'" class="flex items-center" x-cloak>
                <i data-lucide="moon" class="w-4 h-4 text-indigo-600"></i>
            </span>
        </button>
    </div>

    <!-- Subtle Background Ambient Mesh -->
    <div class="absolute -top-48 -left-48 w-96 h-96 bg-emerald-500/10 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute -bottom-48 -right-48 w-96 h-96 bg-violet-600/10 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff05_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-b from-zinc-800 to-zinc-900 border border-white/10 shadow-2xl mb-4 relative group overflow-hidden">
                <div class="absolute inset-0 rounded-2xl bg-emerald-500/20 blur group-hover:bg-emerald-500/30 transition-colors"></div>
                @if(isset($globalSiteSettings) && $globalSiteSettings->logoUrl())
                    <img src="{{ $globalSiteSettings->logoUrl() }}" alt="Logo" class="w-full h-full object-cover relative z-10">
                @else
                    <i data-lucide="zap" class="w-7 h-7 text-emerald-400 relative z-10"></i>
                @endif
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-white">{{ ($globalSiteSettings->site_title ?? 'OmniRoute') }} {{ ($globalSiteSettings->subtitle ?? 'Lite') }}</h1>
        </div>

        <!-- Login Card -->
        <div class="bg-[#121215] border border-white/[0.08] shadow-2xl shadow-black/80 rounded-2xl p-6 sm:p-8 backdrop-blur-xl relative">
            <!-- Errors Alert -->
            @if (isset($errors) && $errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs sm:text-sm flex items-start gap-2.5">
                    <i data-lucide="alert-circle" class="w-4.5 h-4.5 text-red-400 flex-shrink-0 mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">Admin Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="name@example.com"
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            placeholder="••••••••"
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                </div>

                <div class="flex items-center text-xs pt-1">
                    <label class="flex items-center gap-2 text-zinc-400 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" checked class="rounded border-white/10 bg-[#09090b] text-emerald-500 focus:ring-emerald-500/30">
                        <span>Remember session</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold rounded-xl text-sm tracking-wide shadow-md transition-all duration-150 transform active:scale-[0.99] flex items-center justify-center gap-2 mt-2 cursor-pointer">
                    <span>Enter Gateway Console</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
