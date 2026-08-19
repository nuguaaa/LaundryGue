<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Laundry Gue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#019FE8'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR (Menu Samping) -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col justify-between">
            <div>
                <!-- Logo / Brand -->
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <span class="text-xl font-bold text-brand">Laundry Gue</span>
                </div>

                <!-- Menu Navigasi Admin -->
                <div class="px-4 py-6 space-y-1">
                    <a href="{{ route('admin.services.index') }}"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.services.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                        Kelola Harga Layanan
                    </a>
                    <a href="{{ route('admin.promos.index') }}"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.promos.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                        Kelola Promo & Diskon
                    </a>
                </div>
            </div>

            <!-- Tombol Logout di Bawah Sidebar -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition text-center">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- NAVBAR ATAS -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <div class="text-gray-700 font-medium">
                    Dashboard Kasir & Admin
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" target="_blank" class="text-sm text-brand font-medium hover:underline">Lihat
                        Website &rarr;</a>
                    <span class="text-sm text-gray-500 font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </header>

            <!-- ISI KONTEN DINAMIS -->
            <main class="flex-1 p-6">
                @if (session('success'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>
