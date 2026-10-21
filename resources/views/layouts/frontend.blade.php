<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('title', 'LaundryGue — Modern Laundry & Care Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased selection:bg-sky-500 selection:text-white flex flex-col min-h-screen overflow-x-hidden">

    <!-- Splash Screen Page Transition -->
    <div id="splashScreen" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-950/95 backdrop-blur-md transition-all duration-300 pointer-events-auto">
        <div class="flex flex-col items-center text-center p-6">
            <div class="relative flex items-center justify-center mb-5">
                <div class="absolute w-20 h-20 rounded-2xl bg-sky-500/20 animate-ping"></div>
                <div class="w-16 h-16 rounded-2xl bg-slate-900 border border-slate-700 text-sky-400 flex items-center justify-center font-black text-2xl shadow-2xl shadow-sky-500/20">
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

    <!-- NAVBAR PREMIUM RESPONSIVE -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 md:h-24 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2.5 sm:space-x-3 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-200 group-hover:scale-105 transition duration-300 shrink-0">
                    <i data-lucide="waves" class="w-5 h-5 sm:w-6 sm:h-6 text-sky-400"></i>
                </div>
                <div>
                    <span class="text-base sm:text-lg font-black tracking-tight text-slate-900 block leading-tight">LaundryGue</span>
                    <span class="text-[9px] sm:text-[10px] font-bold tracking-widest text-sky-600 uppercase">Enterprise Care</span>
                </div>
            </a>

            <!-- Navigasi Desktop / Tablet Lebar (>= md) -->
            <nav class="hidden md:flex items-center space-x-1 bg-slate-100/90 p-1.5 rounded-full border border-slate-200/60 text-xs sm:text-sm font-bold text-slate-600">
                <a href="{{ url('/') }}" class="px-4 lg:px-5 py-2 rounded-full transition {{ request()->is('/') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('frontend.services') }}" class="px-4 lg:px-5 py-2 rounded-full transition {{ request()->routeIs('frontend.services') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Layanan & Harga</a>
                <a href="{{ route('frontend.contact') }}" class="px-4 lg:px-5 py-2 rounded-full transition {{ request()->routeIs('frontend.contact') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Pusat Kontak</a>
            </nav>

            <!-- Aksi Kanan & Hamburger Menu Mobile -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                @auth
                    <a href="{{ route('admin.transactions.create') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 px-3.5 py-2 rounded-2xl text-xs font-bold transition shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-sky-600"></i>
                        <span>Panel {{ ucfirst(Auth::user()->role) }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-3 py-2 rounded-2xl text-xs font-bold transition shadow-sm" title="Logout dari akun">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth

                <!-- Hamburger Button Mobile (< md) -->
                <button type="button" id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition focus:outline-none" aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- MOBILE NAV DROPDOWN (Smooth toggle on mobile/tablet) -->
        <div id="mobileMenuDropdown" class="hidden md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-2xl px-4 py-4 space-y-2 shadow-xl">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->is('/') ? 'bg-sky-50 text-sky-600' : 'text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="home" class="w-4 h-4 text-sky-500"></i>
                <span>Beranda Utama</span>
            </a>
            <a href="{{ route('frontend.services') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('frontend.services') ? 'bg-sky-50 text-sky-600' : 'text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="layers" class="w-4 h-4 text-sky-500"></i>
                <span>Katalog & Tarif Layanan</span>
            </a>
            <a href="{{ route('frontend.contact') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('frontend.contact') ? 'bg-sky-50 text-sky-600' : 'text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="phone-call" class="w-4 h-4 text-sky-500"></i>
                <span>Pusat Kontak & Lokasi</span>
            </a>

            @auth
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="{{ route('admin.transactions.create') }}" class="flex-1 flex items-center justify-center gap-2 bg-sky-50 text-sky-700 border border-sky-200 py-2.5 rounded-xl text-xs font-bold shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-sky-600"></i>
                        <span>Panel {{ ucfirst(Auth::user()->role) }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow animate-fade-in-up">
        @yield('content')
    </main>

    <!-- FOOTER KELAS ENTERPRISE -->
    <footer class="bg-slate-950 text-white pt-16 sm:pt-20 pb-12 border-t border-slate-900 mt-16 sm:mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 mb-12 sm:mb-16">
            <div class="sm:col-span-2">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-sky-500 text-slate-950 flex items-center justify-center font-black">LG</div>
                    <span class="text-xl font-bold tracking-tight">LaundryGue System</span>
                </div>
                <p class="text-slate-400 text-xs sm:text-sm max-w-sm leading-relaxed mb-6">
                    Sistem manajemen dan layanan operasional pembersihan pakaian berstandar tinggi dengan teknologi pelacakan otomatis real-time.
                </p>
                <div class="flex flex-wrap gap-2 text-slate-400">
                    <span class="text-[10px] sm:text-xs uppercase tracking-widest font-bold bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800 text-sky-400">ISO 9001 Standard</span>
                    <span class="text-[10px] sm:text-xs uppercase tracking-widest font-bold bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800 text-sky-400">Secure Protocol</span>
                </div>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-300 mb-4 sm:mb-6">Navigasi Utama</h4>
                <ul class="space-y-2.5 sm:space-y-3 text-xs sm:text-sm text-slate-400 font-medium">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition">Beranda Utama</a></li>
                    <li><a href="{{ route('frontend.services') }}" class="hover:text-white transition">Katalog & Tarif Layanan</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="hover:text-white transition">Informasi Lokasi & Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-300 mb-4 sm:mb-6">Infrastruktur Outlet</h4>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-3">
                    {{ $settings['address'] ?? 'Alamat belum diatur di dashboard admin.' }}
                </p>
                <p class="text-xs text-sky-400 font-bold">
                    {{ $settings['operational_hours'] ?? 'Operasional Terpusat' }}
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
            <p>&copy; {{ date('Y') }} LaundryGue Enterprise. Seluruh hak cipta dilindungi undang-undang.</p>
            <p class="font-medium text-slate-400">Dibuat oleh <span class="text-sky-400 font-bold">nugua</span></p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Splash Screen Transition Handlers
        function hideSplashScreen() {
            const splash = document.getElementById('splashScreen');
            if (splash) {
                splash.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => { splash.style.display = 'none'; }, 300);
            }
        }

        function showSplashScreen() {
            const splash = document.getElementById('splashScreen');
            if (splash) {
                splash.style.display = 'flex';
                splash.classList.remove('opacity-0', 'pointer-events-none');
            }
        }

        window.addEventListener('load', hideSplashScreen);
        setTimeout(hideSplashScreen, 800);
        window.addEventListener('pageshow', hideSplashScreen);

        document.addEventListener('DOMContentLoaded', function() {
            // Intercept internal link navigation to show splash screen
            document.querySelectorAll('a[href]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || href.startsWith('https://wa.me') || target === '_blank') {
                        return;
                    }
                    showSplashScreen();
                });
            });

            // Toggle Hamburger Menu Mobile
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenuDropdown');

            btn?.addEventListener('click', function() {
                menu?.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
