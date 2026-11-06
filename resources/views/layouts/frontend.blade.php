<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('title', 'LaundryGue — Modern Laundry & Care Management System')</title>
    <link rel="icon" type="image/png" href="{{ asset($settings['site_logo'] ?? 'img/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        @keyframes pageFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-page-enter {
            animation: pageFadeIn 0.25s ease-out;
        }
        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee-infinite {
            display: flex;
            width: max-content;
            animation: marqueeScroll 45s linear infinite;
        }
        .animate-marquee-infinite:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased selection:bg-sky-500 selection:text-white flex flex-col min-h-screen overflow-x-hidden">

    <!-- SPA Top Progress Bar (Indikator Pemuatan Halaman Instan) -->
    <div id="spaProgressBar" class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-sky-400 via-sky-500 to-blue-600 z-[99999] transition-all duration-300 pointer-events-none opacity-0 w-0"></div>

    @php
        $splashEnabled = ($settings['enable_splash_screen'] ?? '0') === '1';
    @endphp

    @if($splashEnabled)
    <!-- Splash Screen Transition -->
    <div id="splashScreen" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-950/90 backdrop-blur-md transition-all duration-300 pointer-events-auto">
        <div class="flex flex-col items-center text-center p-6">
            <div class="relative flex items-center justify-center mb-5">
                <div class="absolute w-20 h-20 rounded-2xl bg-sky-500/20 animate-ping"></div>
                <div class="w-16 h-16 rounded-2xl bg-slate-900 border border-slate-700 flex items-center justify-center p-2.5 shadow-2xl shadow-sky-500/20">
                    <img src="{{ asset($settings['site_logo'] ?? 'img/logo.png') }}" alt="LaundryGue Logo" class="w-full h-full object-contain">
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
    @endif

    <!-- NAVBAR PREMIUM RESPONSIVE (TERPUSAT DI TENGAH & INTERAKTIF) -->
    <header id="mainNavbar" class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between relative">
            <!-- Brand Logo (Sisi Kiri) -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2.5 sm:space-x-3 group z-20 focus:outline-none">
                <img src="{{ asset($settings['site_logo'] ?? 'img/logo.png') }}" alt="LaundryGue Logo" class="w-10 h-10 sm:w-11 sm:h-11 object-contain rounded-2xl shadow-sm group-hover:scale-105 group-hover:rotate-1 transition duration-300 shrink-0">
                <div>
                    <span class="text-base sm:text-lg font-black tracking-tight text-slate-900 block leading-tight">LaundryGue</span>
                    <span class="text-[9px] sm:text-[10px] font-bold tracking-widest text-sky-600 uppercase">Enterprise Care</span>
                </div>
            </a>

            <!-- Navigasi Desktop Terpusat Tepat di Tengah (True Absolute Center) -->
            <nav class="hidden md:flex items-center absolute left-1/2 -translate-x-1/2 space-x-1 bg-slate-100/90 backdrop-blur-md p-1.5 rounded-full border border-slate-200/80 text-xs sm:text-sm font-bold text-slate-600 shadow-sm transition-all duration-300 z-10">
                <a href="{{ url('/') }}" class="px-4 lg:px-5 py-2 rounded-full transition-all duration-200 {{ request()->is('/') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/60' : 'hover:text-slate-900 hover:bg-white/60' }}">
                    Beranda
                </a>
                <a href="{{ route('frontend.services') }}" class="px-4 lg:px-5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('frontend.services') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/60' : 'hover:text-slate-900 hover:bg-white/60' }}">
                    Layanan & Harga
                </a>
                <a href="{{ route('frontend.testimonials') }}" class="px-4 lg:px-5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('frontend.testimonials') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/60' : 'hover:text-slate-900 hover:bg-white/60' }}">
                    Testimoni
                </a>
                <a href="{{ route('frontend.contact') }}" class="px-4 lg:px-5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('frontend.contact') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/60' : 'hover:text-slate-900 hover:bg-white/60' }}">
                    Pusat Kontak
                </a>
            </nav>

            <!-- Aksi Kanan & Hamburger Menu Mobile (Sisi Kanan) -->
            <div class="flex items-center space-x-2 sm:space-x-3 z-20">
                @auth
                    <a href="{{ route('admin.transactions.create') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 px-4 py-2 rounded-full text-xs font-bold transition shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-sky-600"></i>
                        <span>Panel {{ ucfirst(Auth::user()->role) }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-3.5 py-2 rounded-full text-xs font-bold transition shadow-sm cursor-pointer" title="Logout dari akun">
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
            <a href="{{ route('frontend.testimonials') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('frontend.testimonials') ? 'bg-sky-50 text-sky-600' : 'text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="star" class="w-4 h-4 text-amber-500 fill-amber-500"></i>
                <span>Testimoni Pelanggan</span>
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

    <!-- KONTEN UTAMA (SPA CONTAINER RINGAN & CEPAT) -->
    <main id="spaMainContainer" class="flex-grow animate-page-enter transition-opacity duration-150">
        @yield('content')
    </main>

    <!-- FOOTER KELAS ENTERPRISE -->
    <footer class="bg-slate-950 text-white pt-16 sm:pt-20 pb-12 border-t border-slate-900 mt-16 sm:mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 mb-12 sm:mb-16">
            <div class="sm:col-span-2">
                <div class="flex items-center space-x-3 mb-5">
                    <img src="{{ asset($settings['site_logo'] ?? 'img/logo.png') }}" alt="LaundryGue Logo" class="w-10 h-10 object-contain rounded-xl shadow-inner">
                    <span class="text-xl font-bold tracking-tight">LaundryGue</span>
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
                    <li><a href="{{ route('frontend.testimonials') }}" class="hover:text-white transition">Testimoni Pelanggan</a></li>
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

    <!-- AOS (Animate On Scroll) Library Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        lucide.createIcons();

        // Inisialisasi AOS (Animate On Scroll) untuk seluruh halaman publik
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 750,
                once: false,
                mirror: true,
                offset: 50,
                easing: 'ease-out-cubic'
            });
        }

        // ==========================================
        // SINGLE PAGE APPLICATION (SPA) ROUTER ENGINE
        // ==========================================
        const spaCache = new Map();
        const spaProgressBar = document.getElementById('spaProgressBar');
        const spaContainer = document.getElementById('spaMainContainer') || document.querySelector('main');
        let isSpaLoading = false;

        function isSpaLink(link) {
            if (!link || !link.href) return false;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || 
                href.startsWith('mailto:') || href.startsWith('tel:') || 
                href.startsWith('https://wa.me') || link.getAttribute('target') === '_blank' || 
                link.hasAttribute('download')) {
                return false;
            }
            try {
                const targetUrl = new URL(link.href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) return false;
                
                // Jangan intersep route auth, admin, logout, cetak nota, cek pesanan mandiri
                const p = targetUrl.pathname;
                if (p.startsWith('/admin') || p.startsWith('/login') || p.startsWith('/logout') || 
                    p.startsWith('/cek-pesanan') || p.includes('/cetak') || p.includes('/nota') || 
                    p.startsWith('/img') || p.startsWith('/build') || p.startsWith('/uploads')) {
                    return false;
                }
                return true;
            } catch (e) {
                return false;
            }
        }

        async function spaPrefetch(url) {
            if (spaCache.has(url) || isSpaLoading) return;
            try {
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-SPA-Request': 'true' } });
                if (res.ok) {
                    const text = await res.text();
                    spaCache.set(url, text);
                }
            } catch (e) {}
        }

        async function spaNavigate(url, pushState = true) {
            if (isSpaLoading) return;

            const currentUrl = new URL(window.location.href);
            const targetUrl = new URL(url, window.location.origin);

            // Jika hanya berpindah anchor hash di halaman yang sama
            if (currentUrl.pathname === targetUrl.pathname && targetUrl.hash) {
                if (pushState) history.pushState({ url }, '', url);
                const el = document.querySelector(targetUrl.hash);
                if (el) el.scrollIntoView({ behavior: 'smooth' });
                return;
            }

            // Mulai animasi loading bar di bagian atas layar
            isSpaLoading = true;
            if (spaProgressBar) {
                spaProgressBar.style.opacity = '1';
                spaProgressBar.style.width = '35%';
            }

            try {
                let html = spaCache.get(url);
                if (!html) {
                    if (spaProgressBar) spaProgressBar.style.width = '65%';
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-SPA-Request': 'true'
                        }
                    });

                    if (!res.ok) {
                        window.location.href = url;
                        return;
                    }
                    html = await res.text();
                    spaCache.set(url, html);
                }

                if (spaProgressBar) spaProgressBar.style.width = '90%';

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMain = doc.getElementById('spaMainContainer') || doc.querySelector('main');

                if (!newMain || !spaContainer) {
                    window.location.href = url;
                    return;
                }

                // Transisi Halus (Smooth Fade Out)
                spaContainer.style.opacity = '0';
                
                setTimeout(() => {
                    // Update Title Halaman
                    document.title = doc.title;

                    // Update History URL Browser
                    if (pushState) {
                        history.pushState({ url }, '', url);
                    }

                    // Bersihkan timer rotasi promo jika ada sebelum berganti halaman
                    if (window.__autoRotateTimer) {
                        clearInterval(window.__autoRotateTimer);
                        window.__autoRotateTimer = null;
                    }
                    if (typeof autoRotateTimer !== 'undefined' && autoRotateTimer) {
                        clearInterval(autoRotateTimer);
                        autoRotateTimer = null;
                    }

                    // Pastikan scroll body pulih jika sebelumnya ada modal terbuka
                    document.body.classList.remove('overflow-hidden');
                    document.body.style.overflow = '';
                    if (window.closeModal && typeof window.closeModal === 'function') {
                        try { window.closeModal(); } catch (e) {}
                    }

                    // Swap Konten Utama
                    spaContainer.innerHTML = newMain.innerHTML;
                    spaContainer.style.opacity = '1';

                    // Sinkronisasi Active State pada Navbar
                    syncActiveNavLinks(targetUrl.pathname);

                    // Eksekusi ulang script inline yang dimuat dari halaman baru
                    const scripts = spaContainer.querySelectorAll('script');
                    scripts.forEach(oldScript => {
                        const newScript = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                        newScript.textContent = oldScript.textContent;
                        oldScript.parentNode.replaceChild(newScript, oldScript);
                    });

                    // Inisialisasi ulang icon Lucide & animasi AOS
                    if (window.lucide) window.lucide.createIcons();
                    if (typeof AOS !== 'undefined') {
                        if (typeof AOS.refreshHard === 'function') {
                            AOS.refreshHard();
                        } else {
                            AOS.refresh();
                        }
                    }

                    // Scroll ke target hash atau bagian atas halaman
                    if (targetUrl.hash) {
                        const targetElem = document.querySelector(targetUrl.hash);
                        if (targetElem) {
                            setTimeout(() => targetElem.scrollIntoView({ behavior: 'smooth' }), 50);
                        } else {
                            window.scrollTo({ top: 0, behavior: 'instant' });
                        }
                    } else {
                        window.scrollTo({ top: 0, behavior: 'instant' });
                    }

                    // Tutup menu mobile jika sedang terbuka
                    const mobileMenu = document.getElementById('mobileMenuDropdown');
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }

                    // Selesaikan Loading Progress Bar
                    if (spaProgressBar) {
                        spaProgressBar.style.width = '100%';
                        setTimeout(() => {
                            spaProgressBar.style.opacity = '0';
                            spaProgressBar.style.width = '0';
                            isSpaLoading = false;
                        }, 200);
                    } else {
                        isSpaLoading = false;
                    }

                    window.dispatchEvent(new CustomEvent('spa:navigated', { detail: { url } }));
                }, 120);

            } catch (err) {
                console.error('SPA Navigation error, fallback ke full reload:', err);
                window.location.href = url;
            }
        }

        // Sinkronisasi kelas aktif pada tombol navigasi desktop dan mobile
        function syncActiveNavLinks(currentPath) {
            const normalizedPath = (currentPath === '' || currentPath === '/') ? '/' : currentPath;

            // 1. Desktop Nav Links
            const desktopLinks = document.querySelectorAll('#mainNavbar nav a');
            desktopLinks.forEach(link => {
                const linkPath = new URL(link.href, window.location.origin).pathname;
                const isMatch = (linkPath === '/' && (normalizedPath === '/' || normalizedPath === '')) ||
                                (linkPath !== '/' && normalizedPath.startsWith(linkPath));

                if (isMatch) {
                    link.className = 'px-4 lg:px-5 py-2 rounded-full transition-all duration-200 bg-white text-slate-900 shadow-md ring-1 ring-slate-200/60';
                } else {
                    link.className = 'px-4 lg:px-5 py-2 rounded-full transition-all duration-200 hover:text-slate-900 hover:bg-white/60 text-slate-600';
                }
            });

            // 2. Mobile Nav Links
            const mobileLinks = document.querySelectorAll('#mobileMenuDropdown a');
            mobileLinks.forEach(link => {
                const linkPath = new URL(link.href, window.location.origin).pathname;
                const isMatch = (linkPath === '/' && (normalizedPath === '/' || normalizedPath === '')) ||
                                (linkPath !== '/' && normalizedPath.startsWith(linkPath));

                if (isMatch) {
                    link.classList.add('bg-sky-50', 'text-sky-600');
                    link.classList.remove('text-slate-700', 'hover:bg-slate-50');
                } else {
                    link.classList.remove('bg-sky-50', 'text-sky-600');
                    link.classList.add('text-slate-700', 'hover:bg-slate-50');
                }
            });
        }

        // Intersepsi klik tautan internal agar bertindak sebagai SPA
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && isSpaLink(link)) {
                e.preventDefault();
                spaNavigate(link.href);
            }
        });

        // Prefetch otomatis saat cursor hover di link untuk respon instan
        document.addEventListener('mouseover', function(e) {
            const link = e.target.closest('a');
            if (link && isSpaLink(link)) {
                spaPrefetch(link.href);
            }
        }, { passive: true });

        // Dukungan Back / Forward Browser History
        window.addEventListener('popstate', function() {
            spaNavigate(window.location.href, false);
        });

        @if($splashEnabled)
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
        @endif

        document.addEventListener('DOMContentLoaded', function() {
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
