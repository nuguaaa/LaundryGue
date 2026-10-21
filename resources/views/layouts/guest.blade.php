<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaundryGue') }} - Masuk Akun</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-100">
        <!-- Splash Screen Page Transition -->
        <div id="splashScreen" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-900/95 backdrop-blur-md transition-all duration-300 pointer-events-auto">
            <div class="flex flex-col items-center text-center p-6">
                <div class="relative flex items-center justify-center mb-5">
                    <div class="absolute w-20 h-20 rounded-2xl bg-sky-500/20 animate-ping"></div>
                    <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-slate-700 text-sky-400 flex items-center justify-center font-black text-2xl shadow-2xl shadow-sky-500/20">
                        <span>LG</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <svg class="animate-spin h-4 w-4 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span class="text-xs font-bold tracking-widest text-slate-300 uppercase">Memuat...</span>
                </div>
            </div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 p-4">
            <div class="mb-6 text-center animate-fade-in-up">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-sky-400 flex items-center justify-center font-black text-xl shadow-lg group-hover:scale-105 transition duration-300">
                        LG
                    </div>
                    <div class="text-left">
                        <span class="text-xl font-black text-slate-900 block leading-tight">LaundryGue</span>
                        <span class="text-[10px] font-bold text-sky-600 uppercase tracking-widest">Portal Kasir & Admin</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white p-5 sm:p-8 shadow-xl shadow-slate-200/50 rounded-2xl sm:rounded-3xl border border-slate-200/80 animate-fade-in-up">
                {{ $slot }}
            </div>

            <div class="mt-6 sm:mt-8 text-center text-xs text-slate-400 font-medium space-y-1">
                <div><a href="{{ url('/') }}" class="hover:text-sky-600 transition">&larr; Kembali ke Beranda Website</a></div>
                <div>Dibuat oleh <strong class="text-sky-600 font-bold">nugua</strong></div>
            </div>
        </div>

        <script>
            function hideSplashScreen() {
                const splash = document.getElementById('splashScreen');
                if (splash) {
                    splash.classList.add('opacity-0', 'pointer-events-none');
                    setTimeout(() => { splash.style.display = 'none'; }, 300);
                }
            }
            window.addEventListener('load', hideSplashScreen);
            setTimeout(hideSplashScreen, 800);
            window.addEventListener('pageshow', hideSplashScreen);
        </script>
    </body>
</html>
