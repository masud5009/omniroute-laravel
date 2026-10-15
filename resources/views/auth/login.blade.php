<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OmniRoute Lite - Sign In</title>
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
        body { font-family: 'Inter', sans-serif; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#09090b] text-zinc-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Subtle Background Ambient Mesh -->
    <div class="absolute -top-48 -left-48 w-96 h-96 bg-emerald-500/10 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute -bottom-48 -right-48 w-96 h-96 bg-violet-600/10 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff05_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10" x-data="{
        email: 'admin@omniroute.local',
        password: 'password',
        fillDefaults() {
            this.email = 'admin@omniroute.local';
            this.password = 'password';
        }
    }" x-init="$nextTick(() => lucide.createIcons())">

        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-b from-zinc-800 to-zinc-900 border border-white/10 shadow-2xl mb-4 relative group">
                <div class="absolute inset-0 rounded-xl bg-emerald-500/20 blur group-hover:bg-emerald-500/30 transition-colors"></div>
                <i data-lucide="zap" class="w-6 h-6 text-emerald-400 relative z-10"></i>
            </div>
            <div class="flex items-center justify-center gap-2">
                <h1 class="text-2xl font-bold tracking-tight text-white">OmniRoute Lite</h1>
                <span class="text-[10px] font-semibold tracking-wider uppercase px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Gateway</span>
            </div>
            <p class="text-xs text-zinc-400 mt-1.5 font-normal">Next-Gen Shared-Hosting Compatible AI Proxy</p>
        </div>

        <!-- Login Card -->
        <div class="bg-[#121215] border border-white/[0.08] shadow-2xl shadow-black/80 rounded-2xl p-6 sm:p-8 backdrop-blur-xl relative">
            <!-- Errors Alert -->
            @if (isset($errors) && $errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs flex items-start gap-2.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-medium text-zinc-400 mb-1.5">Admin Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" id="email" name="email" x-model="email" required autofocus
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-zinc-100 placeholder-zinc-600 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-medium text-zinc-400">Password</label>
                        <button type="button" @click="fillDefaults()" class="text-[11px] text-emerald-400 hover:text-emerald-300 font-medium">Use Default</button>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" id="password" name="password" x-model="password" required
                            class="w-full bg-[#09090b] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-zinc-100 placeholder-zinc-600 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-zinc-400 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" checked class="rounded border-white/10 bg-[#09090b] text-emerald-500 focus:ring-emerald-500/30">
                        <span>Remember session</span>
                    </label>
                    <span class="text-zinc-500 font-mono text-[11px]">PHP 8.3 • MySQL</span>
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 bg-white text-zinc-950 hover:bg-zinc-200 font-semibold rounded-xl text-xs tracking-wide shadow-lg shadow-white/5 transition-all duration-150 transform active:scale-[0.99] flex items-center justify-center gap-2 mt-2">
                    <span>Enter Gateway Console</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </form>

            <!-- Quick Start Helper Pill -->
            <div class="mt-6 pt-5 border-t border-white/[0.06] flex items-center justify-between text-[11px] text-zinc-500">
                <div class="flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>Default: <code class="text-zinc-300 bg-zinc-900 px-1 py-0.5 rounded border border-white/5">admin@omniroute.local</code> / <code class="text-zinc-300 bg-zinc-900 px-1 py-0.5 rounded border border-white/5">password</code></span>
                </div>
            </div>
        </div>

        <p class="text-center text-[11px] text-zinc-600 mt-6 font-mono">
            OmniRoute Lite • Zero Build • Shared Hosting Optimized
        </p>
    </div>
</body>
</html>
