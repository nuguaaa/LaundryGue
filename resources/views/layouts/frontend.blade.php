<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaundryGue — Enterprise Laundry Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased selection:bg-sky-500 selection:text-white flex flex-col min-h-screen">

    <!-- NAVBAR PREMIUM -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-200 group-hover:scale-105 transition duration-300">
                    <i data-lucide="waves" class="w-6 h-6 text-sky-400"></i>
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-slate-900 block leading-none">LaundryGue</span>
                    <span class="text-[10px] font-bold tracking-widest text-sky-600 uppercase">Enterprise Solution</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/60 text-sm font-semibold text-slate-600">
                <a href="{{ url('/') }}" class="px-5 py-2 rounded-full transition {{ request()->is('/') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('frontend.services') }}" class="px-5 py-2 rounded-full transition {{ request()->routeIs('frontend.services') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Layanan & Harga</a>
                <a href="{{ route('frontend.contact') }}" class="px-5 py-2 rounded-full transition {{ request()->routeIs('frontend.contact') ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900' }}">Pusat Kontak</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}#tracking" class="hidden sm:inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl text-sm font-bold shadow-xl shadow-slate-200 transition-all duration-300 transform hover:-translate-y-0.5">
                    <i data-lucide="search" class="w-4 h-4 text-sky-400"></i>
                    Lacak Resi
                </a>
            </div>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER KELAS ENTERPRISE -->
    <footer class="bg-slate-950 text-white pt-20 pb-12 border-t border-slate-900 mt-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-sky-500 text-slate-950 flex items-center justify-center font-black">LG</div>
                    <span class="text-xl font-bold tracking-tight">LaundryGue System</span>
                </div>
                <p class="text-slate-400 text-sm max-w-sm leading-relaxed mb-6">
                    Sistem manajemen dan layanan operasional pembersihan pakaian berstandar tinggi dengan teknologi pelacakan otomatis real-time.
                </p>
                <div class="flex space-x-4 text-slate-400">
                    <span class="text-xs uppercase tracking-widest font-bold bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800 text-sky-400">ISO 9001 Standard</span>
                    <span class="text-xs uppercase tracking-widest font-bold bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800 text-sky-400">Secure Protocol</span>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-6">Navigasi Utama</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition">Beranda Utama</a></li>
                    <li><a href="{{ route('frontend.services') }}" class="hover:text-white transition">Katalog & Tarif Layanan</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="hover:text-white transition">Informasi Lokasi & Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-6">Infrastruktur Outlet</h4>
                <p class="text-sm text-slate-400 leading-relaxed mb-4">
                    {{ $settings['address'] ?? 'Alamat belum diatur di dashboard admin.' }}
                </p>
                <p class="text-xs text-sky-400 font-semibold">
                    {{ $settings['operational_hours'] ?? 'Operasional Terpusat' }}
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} LaundryGue Enterprise. Seluruh hak cipta dilindungi undang-undang.</p>
            <p class="mt-4 md:mt-0 font-medium">Arsitektur Web Kelas Korporat</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
