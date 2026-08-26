<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Brand Color Custom -->
    <style>
        .bg-brand {
            background-color: #0ea5e9;
        }

        .text-brand {
            color: #0ea5e9;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">

        <!-- Sidebar Navigasi Kiri -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shadow-sm">
            <div>
                <!-- Logo / Brand -->
                <div class="h-16 flex items-center px-6 border-b border-gray-200">
                    <span class="text-xl font-bold text-brand">Laundry Gue</span>
                </div>

                <!-- Menu Link -->
                <nav class="p-4 space-y-1">
                    @if(auth()->user()->role == 'admin')
                        <!-- Menu Khusus Admin -->
                        <a href="{{ route('admin.services.index') }}"
                            class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.services.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                            Kelola Harga Layanan
                        </a>
                        <a href="{{ route('admin.promos.index') }}"
                            class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.promos.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                            Kelola Promo & Diskon
                        </a>
                        <a href="{{ route('admin.settings.index') }}"
                            class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                            Pengaturan Website
                        </a>
                    @endif

                    <!-- Menu Kasir & Admin (Bisa diakses keduanya) -->
                    <a href="{{ route('admin.transactions.create') }}"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transactions.create') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                        Halaman Kasir (Input Pesanan)
                    </a>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transactions.index') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                        Pesanan Aktif (Status Cucian)
                    </a>

                    @if(auth()->user()->role == 'admin')
                        <!-- Menu Khusus Admin (Laporan & User) -->
                        <a href="{{ route('admin.transactions.history') }}"
                            class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transactions.history') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                            Laporan & History Transaksi
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-sky-50 text-brand' : 'text-gray-600 hover:bg-gray-50' }}">
                            Kelola User
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Tombol Logout di Bawah Sidebar -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2.5 rounded-lg text-sm font-medium transition text-center">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten Utama Kanan -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top Header Bar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shadow-sm">
                <div class="text-sm font-medium text-gray-700">
                    Dashboard {{ ucfirst(auth()->user()->role ?? 'Admin') }} Laundry
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" target="_blank"
                        class="text-sm text-brand font-medium hover:underline">
                        Lihat Website &rarr;
                    </a>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ Auth::user()->name ?? 'Admin Laundry' }} ({{ ucfirst(Auth::user()->role ?? 'Admin') }})
                    </span>
                </div>
            </header>

            <!-- Page Content Area -->
            <main class="flex-1 p-8">
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                <!-- Flash Message Sukses -->
                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>
</body>

</html>
