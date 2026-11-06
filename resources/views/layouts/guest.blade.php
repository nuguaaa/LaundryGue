<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaundryGue') }} - Masuk Akun Portal Kasir & Admin</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            @keyframes floatSlow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            .animate-float-slow {
                animation: floatSlow 6s ease-in-out infinite;
            }
            @keyframes pulseGlow {
                0%, 100% { opacity: 0.4; transform: scale(1); }
                50% { opacity: 0.7; transform: scale(1.05); }
            }
            .animate-pulse-glow {
                animation: pulseGlow 8s ease-in-out infinite;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-sky-500 selection:text-white relative overflow-x-hidden flex flex-col justify-between">
        
        <!-- Background Ambient Lighting Mesh & Glowing Orbs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
            <div class="absolute -top-40 -left-40 w-96 sm:w-[520px] h-96 sm:h-[520px] bg-sky-500/15 rounded-full blur-[120px] animate-pulse-glow"></div>
            <div class="absolute -bottom-40 -right-40 w-96 sm:w-[520px] h-96 sm:h-[520px] bg-blue-600/15 rounded-full blur-[140px] animate-pulse-glow" style="animation-delay: 3s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
            
            <!-- Subtle Grid Pattern Overlay -->
            <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:32px_32px] opacity-[0.04]"></div>
        </div>

        <!-- Top Header Navigation -->
        <header class="w-full max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-6 flex items-center justify-between z-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-sky-500 rounded-2xl p-1">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl blur-sm opacity-50 group-hover:opacity-100 transition duration-300"></div>
                    <img src="{{ asset('img/logo.png') }}" alt="LaundryGue Logo" class="relative w-10 h-10 sm:w-11 sm:h-11 object-contain rounded-2xl bg-slate-900 border border-slate-800 p-1.5 shadow-lg group-hover:scale-105 transition duration-300">
                </div>
                <div class="text-left">
                    <span class="text-base sm:text-lg font-black text-white block leading-tight tracking-tight">LaundryGue</span>
                    <span class="text-[9px] sm:text-[10px] font-bold text-sky-400 uppercase tracking-widest block">Enterprise Care</span>
                </div>
            </a>

            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-white bg-slate-900/80 hover:bg-slate-800 border border-slate-800/80 hover:border-slate-700 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition duration-200 shadow-sm">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 text-sky-400"></i>
                <span class="hidden sm:inline">Kembali ke</span> Beranda
            </a>
        </header>

        <!-- Main Form Container -->
        <main class="flex-grow flex items-center justify-center px-4 py-6 sm:py-10 z-10">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-6 text-center z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500 border-t border-slate-900 pt-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-sky-400"></i>
                    <span>Enkripsi 256-Bit SSL &bull; Hak Akses Berbasis Peran</span>
                </div>
                <div>
                    &copy; {{ date('Y') }} LaundryGue Enterprise &bull; Dibuat oleh <span class="text-sky-400 font-bold">nugua</span>
                </div>
            </div>
        </footer>

        <script>
            if (window.lucide) {
                window.lucide.createIcons();
            }
        </script>
    </body>
</html>
