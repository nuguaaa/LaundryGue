<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LaundryGue') }} - Admin Panel</title>

    <!-- Google Fonts: Plus Jakarta Sans (Keseragaman Font Seluruh Halaman) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Scripts & Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Brand Color Custom & Global Font -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .bg-brand {
            background-color: #0ea5e9;
        }
        .text-brand {
            color: #0ea5e9;
        }
        @keyframes spaLoadingPulse {
            0% { transform: scaleX(0.08); transform-origin: left; opacity: 0.9; }
            50% { transform: scaleX(0.68); transform-origin: left; opacity: 1; }
            100% { transform: scaleX(1); transform-origin: left; opacity: 0.9; }
        }
        #spa-progress.spa-active {
            opacity: 1 !important;
            animation: spaLoadingPulse 0.75s infinite alternate ease-in-out;
        }
        .spa-row-removing {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
            opacity: 0 !important;
            transform: translateX(30px) scale(0.96) !important;
        }
    </style>
</head>

<body class="h-full bg-slate-100 text-slate-800 antialiased overflow-x-hidden">
    <!-- Top Progress Bar SPA Navigation (YouTube / GitHub style) -->
    <div id="spa-progress" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-400 via-indigo-500 to-sky-400 z-[99999] opacity-0 transition-opacity duration-300 pointer-events-none"></div>

    <!-- Floating Toast Notification Container (Real-time SPA Alerts) -->
    <div id="spa-toast-container" class="fixed bottom-5 right-5 z-[99998] flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0"></div>

    <!-- Splash Screen Page Transition (Admin & Kasir) -->
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
                <span class="text-xs font-bold tracking-widest text-slate-300 uppercase">Memuat Dashboard...</span>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- ============================================================== -->
        <!-- MOBILE / TABLET DRAWER OVERLAY & SIDEBAR (< lg screens) -->
        <!-- ============================================================== -->
        <div id="mobileDrawerBackdrop" class="fixed inset-0 bg-slate-950/60 z-40 backdrop-blur-sm hidden lg:hidden transition-opacity duration-300"></div>

        <aside id="mobileDrawer" class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl flex flex-col justify-between transform -translate-x-full lg:hidden transition-transform duration-300 ease-in-out">
            <div>
                <!-- Header Drawer -->
                <div class="h-16 flex items-center justify-between px-6 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black shadow-sm">
                            <span class="text-sky-400 text-sm">LG</span>
                        </div>
                        <div>
                            <span class="text-lg font-black text-slate-900 block leading-tight">LaundryGue</span>
                            <span class="text-[10px] font-bold text-sky-600 uppercase tracking-wider">{{ ucfirst(auth()->user()->role ?? 'Staff') }} Panel</span>
                        </div>
                    </div>
                    <!-- Tombol Tutup Drawer -->
                    <button type="button" id="closeDrawerBtn" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Navigation Links Mobile -->
                <nav class="p-4 space-y-1 text-sm overflow-y-auto max-h-[calc(100vh-140px)]">
                    @if(auth()->user()->role == 'admin')
                        <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Master Data</div>
                        <a href="{{ route('admin.services.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.services.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Kelola Harga Layanan
                        </a>
                        <a href="{{ route('admin.promos.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.promos.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Kelola Promo & Diskon
                        </a>
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pengaturan Website
                        </a>
                    @endif

                    <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Operasional</div>
                    <a href="{{ route('admin.transactions.create') }}"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.create') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Kasir (Input Pesanan)
                    </a>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.index') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Pesanan Aktif
                    </a>

                    @if(auth()->user()->role == 'admin')
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Keuangan & Akses</div>
                        <a href="{{ route('admin.transactions.history') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.history') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Laporan & History
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Kelola Pengguna
                        </a>
                    @else
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Pengeluaran</div>
                        <a href="{{ route('admin.transactions.history') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.history') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Input Pengeluaran
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Tombol Logout di Bawah Drawer -->
            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout Akun
                    </button>
                </form>
            </div>
        </aside>

        <!-- ============================================================== -->
        <!-- DESKTOP SIDEBAR (Persistent >= lg screens) -->
        <!-- ============================================================== -->
        <aside class="hidden lg:flex lg:flex-col w-64 bg-white border-r border-slate-200 justify-between shadow-sm shrink-0 sticky top-0 h-screen overflow-y-auto">
            <div>
                <!-- Logo / Brand -->
                <div class="h-16 flex items-center px-6 border-b border-slate-200 gap-3">
                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black shadow-sm">
                        <span class="text-sky-400 text-sm">LG</span>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">LaundryGue</span>
                        <span class="text-[10px] font-bold text-sky-600 uppercase tracking-wider">{{ ucfirst(auth()->user()->role ?? 'Staff') }} Panel</span>
                    </div>
                </div>

                <!-- Menu Link -->
                <nav class="p-4 space-y-1 text-sm">
                    @if(auth()->user()->role == 'admin')
                        <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Master Data</div>
                        <a href="{{ route('admin.services.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.services.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Kelola Harga Layanan
                        </a>
                        <a href="{{ route('admin.promos.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.promos.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Kelola Promo & Diskon
                        </a>
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pengaturan Website
                        </a>
                    @endif

                    <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Operasional Outlet</div>
                    <a href="{{ route('admin.transactions.create') }}"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.create') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Kasir (Input Pesanan)
                    </a>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.index') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Pesanan Aktif
                    </a>

                    @if(auth()->user()->role == 'admin')
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Keuangan & Akses</div>
                        <a href="{{ route('admin.transactions.history') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.history') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Laporan & History
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Kelola Pengguna
                        </a>
                    @else
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Pengeluaran</div>
                        <a href="{{ route('admin.transactions.history') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.transactions.history') ? 'bg-sky-50 text-sky-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Input Pengeluaran
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Tombol Logout di Bawah Sidebar Desktop -->
            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout Akun
                    </button>
                </form>
            </div>
        </aside>

        <!-- ============================================================== -->
        <!-- KONTEN UTAMA (Fluid & Responsive across Mobile, Tablet, Desktop) -->
        <!-- ============================================================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">

            <!-- Top Header Bar Modern Responsive -->
            <header class="bg-white border-b border-slate-200 h-16 sm:h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm sticky top-0 z-30">
                <!-- Sisi Kiri: Hamburger Menu Mobile + Judul & Badge -->
                <div class="flex items-center gap-2.5 sm:gap-4 min-w-0">
                    <!-- Hamburger Button (< lg) -->
                    <button type="button" id="openDrawerBtn" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition focus:outline-none" aria-label="Buka Menu Navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Brand Mini untuk Mobile -->
                    <div class="flex items-center gap-2 lg:hidden">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-black text-xs">
                            <span class="text-sky-400">LG</span>
                        </div>
                    </div>

                    <!-- Judul Panel & Role Badge -->
                    <div class="flex items-center gap-2 truncate">
                        <span class="text-xs sm:text-sm font-bold text-slate-800 truncate">
                            Dashboard {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                        </span>
                        <span class="hidden xs:inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-[11px] font-extrabold uppercase {{ auth()->user()->role == 'admin' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                            {{ auth()->user()->role ?? 'KASIR' }}
                        </span>
                    </div>
                </div>

                <!-- Sisi Kanan: Link Website, User Info, & Tombol Logout -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ url('/') }}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-xs text-sky-600 font-bold bg-sky-50 hover:bg-sky-100 border border-sky-200 px-2.5 sm:px-3 py-1.5 rounded-xl transition shadow-xs"
                        title="Lihat Website Publik">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden md:inline">Lihat Website</span>
                    </a>

                    <!-- User Info Avatar Chip -->
                    <div class="hidden sm:flex items-center gap-2 pl-1 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-slate-900 text-sky-400 font-bold flex items-center justify-center text-xs shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left max-w-[120px] truncate">
                            <div class="text-xs font-bold text-slate-800 truncate leading-tight">{{ Auth::user()->name ?? 'User Laundry' }}</div>
                            <div class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role ?? 'Staff' }}</div>
                        </div>
                    </div>

                    <!-- TOMBOL LOGOUT PROMINENT (Accessible on all devices) -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-3 sm:px-3.5 py-1.5 rounded-xl text-xs font-bold transition duration-200 shadow-sm cursor-pointer"
                            title="Keluar dari akun">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content Area with Fluid Responsive Padding (SPA Dynamic Container) -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col" id="spa-main-container">
                <div id="spa-header">
                    @if (isset($header))
                        <div class="mb-5 sm:mb-6">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                <!-- Flash Message Sukses & Error -->
                <div id="spa-alerts">
                    @if (session('success'))
                        <div class="mb-5 sm:mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold text-lg leading-none">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 sm:mb-6 bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 font-bold text-lg leading-none">&times;</button>
                        </div>
                    @endif
                </div>

                <div id="spa-content" class="animate-fade-in-up transition-opacity duration-150">
                    @yield('content')
                </div>
            </main>

            <!-- Footer Panel Admin & Kasir -->
            <footer class="mt-auto px-4 sm:px-6 lg:px-8 py-4 border-t border-slate-200 bg-white text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <span>&copy; {{ date('Y') }} LaundryGue System. Hak cipta dilindungi undang-undang.</span>
                <span>Dibuat oleh <strong class="text-sky-600 font-bold">nugua</strong></span>
            </footer>
        </div>

    </div>

    <!-- Script SPA Router Engine & Drawer Navigasi Mobile -->
    <script>
        // Splash Screen Transition Handlers
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

        // Drawer Mobile Navigation Handlers
        const drawer = document.getElementById('mobileDrawer');
        const backdrop = document.getElementById('mobileDrawerBackdrop');

        function openDrawer() {
            if (!drawer || !backdrop) return;
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('-translate-x-full');
            }, 10);
        }

        function closeDrawer() {
            if (!drawer || !backdrop) return;
            drawer.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }

        window.openDrawer = openDrawer;
        window.closeDrawer = closeDrawer;

        document.getElementById('openDrawerBtn')?.addEventListener('click', openDrawer);
        document.getElementById('closeDrawerBtn')?.addEventListener('click', closeDrawer);
        backdrop?.addEventListener('click', closeDrawer);

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeDrawer();
            }
        });

        // ==========================================
        // SPA ROUTER & AJAX ENGINE UNTUK ADMIN PANEL
        // ==========================================
        let isSpaNavigating = false;
        const spaProgress = document.getElementById('spa-progress');

        function startSpaProgress() {
            if (spaProgress) spaProgress.classList.add('spa-active');
        }

        function stopSpaProgress() {
            if (spaProgress) spaProgress.classList.remove('spa-active');
        }

        window.showSpaToast = function(message, type = 'success') {
            const container = document.getElementById('spa-toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto flex items-center justify-between gap-3 px-4 py-3 rounded-2xl shadow-xl text-xs sm:text-sm font-bold border transition-all duration-300 transform translate-x-full ${
                type === 'error'
                    ? 'bg-red-900/90 text-white border-red-700 backdrop-blur-md'
                    : 'bg-slate-900/95 text-white border-slate-700 backdrop-blur-md shadow-sky-500/10'
            }`;

            const iconSvg = type === 'error'
                ? `<svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
                : `<svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            toast.innerHTML = `
                <div class="flex items-center gap-2.5">
                    ${iconSvg}
                    <span>${message}</span>
                </div>
                <button type="button" class="text-slate-400 hover:text-white font-bold text-base leading-none ml-2">&times;</button>
            `;

            toast.querySelector('button').onclick = () => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            };

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full');
            });

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 3500);
        };

        function executeSpaScripts(container) {
            if (!container) return;
            const scripts = container.querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => {
                    newScript.setAttribute(attr.name, attr.value);
                });
                newScript.textContent = oldScript.textContent;
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        }

        function updateSpaActiveMenu(url) {
            const currentPath = new URL(url, window.location.origin).pathname;
            document.querySelectorAll('aside nav a').forEach(link => {
                const linkHref = link.getAttribute('href');
                if (!linkHref) return;
                const linkPath = new URL(linkHref, window.location.origin).pathname;

                const isActive = (linkPath === currentPath) ||
                    (linkPath !== '/admin/transactions' && linkPath !== '/admin/transactions-history' && currentPath.startsWith(linkPath) && linkPath.length > 6);

                if (isActive) {
                    link.classList.remove('text-slate-600', 'hover:bg-slate-50', 'hover:text-slate-900');
                    link.classList.add('bg-sky-50', 'text-sky-600', 'shadow-sm');
                } else {
                    link.classList.remove('bg-sky-50', 'text-sky-600', 'shadow-sm');
                    link.classList.add('text-slate-600', 'hover:bg-slate-50', 'hover:text-slate-900');
                }
            });
        }

        window.spaNavigate = async function(url, push = true) {
            if (isSpaNavigating) return;
            isSpaNavigating = true;
            startSpaProgress();

            try {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-SPA-Request': '1'
                    }
                });

                if (!res.ok) {
                    window.location.href = url;
                    return;
                }

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newHeader = doc.getElementById('spa-header');
                const newAlerts = doc.getElementById('spa-alerts');
                const newContent = doc.getElementById('spa-content');

                if (!newContent) {
                    window.location.href = url;
                    return;
                }

                if (doc.title) {
                    document.title = doc.title;
                }

                if (push) {
                    window.history.pushState({ spa: true, url }, '', url);
                }

                const contentEl = document.getElementById('spa-content');
                if (contentEl) contentEl.style.opacity = '0';

                setTimeout(() => {
                    const headerEl = document.getElementById('spa-header');
                    if (headerEl && newHeader) headerEl.innerHTML = newHeader.innerHTML;

                    const alertsEl = document.getElementById('spa-alerts');
                    if (alertsEl && newAlerts) alertsEl.innerHTML = newAlerts.innerHTML;

                    if (contentEl && newContent) {
                        contentEl.innerHTML = newContent.innerHTML;
                        contentEl.style.opacity = '1';
                        contentEl.classList.remove('animate-fade-in-up');
                        void contentEl.offsetWidth;
                        contentEl.classList.add('animate-fade-in-up');
                    }

                    updateSpaActiveMenu(url);
                    executeSpaScripts(document.getElementById('spa-content'));

                    if (window.lucide) {
                        window.lucide.createIcons();
                    }

                    closeDrawer();
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    window.dispatchEvent(new CustomEvent('app:spa-navigated', { detail: { url } }));

                    stopSpaProgress();
                    isSpaNavigating = false;
                }, 100);

            } catch (err) {
                console.error('SPA Navigation Error:', err);
                stopSpaProgress();
                isSpaNavigating = false;
                window.location.href = url;
            }
        };

        window.addEventListener('popstate', function() {
            window.spaNavigate(window.location.href, false);
        });

        // Intercept link clicks untuk SPA Navigation
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href');
            const target = link.getAttribute('target');

            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || target === '_blank' || link.getAttribute('download') !== null) {
                return;
            }

            const urlObj = new URL(href, window.location.origin);
            if (urlObj.origin === window.location.origin && (urlObj.pathname.startsWith('/admin') || urlObj.pathname.startsWith('/profile') || urlObj.pathname.startsWith('/dashboard'))) {
                // Abaikan tombol cetak struk atau cetak laporan
                if (urlObj.pathname.includes('/receipt') || urlObj.pathname.includes('/laporan/cetak')) {
                    return;
                }
                e.preventDefault();
                window.spaNavigate(urlObj.href, true);
            }
        });

        // Intercept Status Dropdown Change via AJAX
        document.addEventListener('change', async function(e) {
            const select = e.target.closest('select[name="status"]');
            if (!select) return;

            const form = select.closest('form');
            if (!form || !form.action) return;

            e.preventDefault();
            const row = select.closest('tr');
            startSpaProgress();

            const formData = new FormData(form);
            const actionUrl = form.action;

            try {
                const res = await fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json().catch(() => null);
                stopSpaProgress();

                if (res.ok && data && data.success) {
                    window.showSpaToast(data.message || 'Status pesanan berhasil diperbarui!', 'success');

                    const newStatus = data.status || select.value;

                    // Jika di Pesanan Aktif dan diubah ke Diambil: hilangkan baris secara mulus
                    if (newStatus === 'Diambil' && window.location.pathname.endsWith('/transactions')) {
                        if (row) {
                            row.classList.add('spa-row-removing');
                            setTimeout(() => {
                                row.remove();
                                const tbody = document.querySelector('tbody');
                                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                    tbody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-slate-400 italic">Tidak ada pesanan aktif saat ini. Semuanya sudah diambil!</td></tr>`;
                                }
                            }, 360);
                        }
                    } else if (newStatus !== 'Diambil' && window.location.pathname.includes('transactions-history')) {
                        // Jika di History dan dikembalikan ke Proses / Selesai / Baru: hilangkan dari history
                        if (row) {
                            row.classList.add('spa-row-removing');
                            setTimeout(() => {
                                row.remove();
                            }, 360);
                        }
                    } else {
                        // Update warna dropdown
                        select.className = 'text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 ' +
                            (newStatus === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : (newStatus === 'Proses' ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-amber-50 text-amber-700 border-amber-300'));
                    }
                } else {
                    window.spaNavigate(window.location.href, false);
                }
            } catch (err) {
                stopSpaProgress();
                form.submit();
            }
        });

        // Intercept Delete Forms via AJAX
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            const methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput || methodInput.value.toUpperCase() !== 'DELETE') return;

            e.preventDefault();
            const row = form.closest('tr') || form.closest('.delete-container');
            startSpaProgress();

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json().catch(() => null);
                stopSpaProgress();

                if (res.ok && data && data.success) {
                    window.showSpaToast(data.message || 'Data berhasil dihapus!', 'success');
                    if (row) {
                        row.classList.add('spa-row-removing');
                        setTimeout(() => row.remove(), 360);
                    } else {
                        window.spaNavigate(window.location.href, false);
                    }
                } else {
                    window.spaNavigate(window.location.href, false);
                }
            } catch (err) {
                stopSpaProgress();
                form.submit();
            }
        });
    </script>
</body>

</html>

