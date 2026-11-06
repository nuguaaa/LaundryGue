@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Ringkasan Eksekutif') }}
    </h2>
@endsection

@section('content')
<div class="space-y-6 sm:space-y-8">

    <!-- BANNER SAMBUTAN & QUICK ACTIONS -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 text-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-sky-500/20 text-sky-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Operasional Online
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Halo, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-xl">
                    @if($isAdmin)
                        Pantau seluruh performa keuangan, operasional kasir, dan produktivitas outlet laundry secara real-time hari ini.
                    @else
                        Selamat bertugas! Kelola alur cucian pelanggan dengan teliti dan pastikan setiap cucian selesai tepat waktu.
                    @endif
                </p>
                <div class="mt-3 text-xs text-sky-300 font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>

            <!-- Tombol Pintasan Cepat -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('admin.transactions.create') }}" class="bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition shadow-lg shadow-sky-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>+ Kasir Baru</span>
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Pesanan Aktif ({{ $totalActiveOrders }})</span>
                </a>
                @if($isAdmin)
                    <a href="{{ route('admin.transactions.history') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition flex items-center gap-2 border border-slate-700">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Laporan Keuangan</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- KARTU STATISTIK METRIK UTAMA (KPI) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @if($isAdmin)
            <!-- Omzet Hari Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Omzet Hari Ini</span>
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 tracking-tight">Rp{{ number_format($todayRevenue, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                        <span class="font-bold text-emerald-600">{{ $todayCompletedOrders }} transaksi selesai</span> diambil hari ini
                    </div>
                </div>
            </div>

            <!-- Omzet Bulan Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Omzet Bulan Ini</span>
                    <span class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl font-black text-sky-700 tracking-tight">Rp{{ number_format($monthRevenue, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        Total pesanan masuk: <strong class="text-slate-800">{{ $monthTotalOrders }} order</strong>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Bulan Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Biaya Operasional</span>
                    <span class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl font-black text-red-600 tracking-tight">Rp{{ number_format($monthExpenses, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        Biaya belanja kebutuhan detergen & utilitas
                    </div>
                </div>
            </div>

            <!-- Laba Bersih Bulan Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laba Bersih (Profit)</span>
                    <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl font-black {{ $monthNetProfit >= 0 ? 'text-indigo-700' : 'text-red-600' }} tracking-tight">
                        Rp{{ number_format($monthNetProfit, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        Margin bersih setelah dipotong beban operasional
                    </div>
                </div>
            </div>
        @else
            <!-- METRIK KHUSUS KASIR -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Order Masuk Hari Ini</span>
                    <span class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-black">
                        {{ $todayNewOrders }}
                    </span>
                </div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ $todayNewOrders }} Transaksi</div>
                <div class="text-[11px] text-slate-500 mt-1">Pelanggan yang menyerahkan cucian hari ini</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cucian Diserahkan</span>
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black">
                        {{ $todayCompletedOrders }}
                    </span>
                </div>
                <div class="text-2xl font-black text-emerald-700 tracking-tight">{{ $todayCompletedOrders }} Transaksi</div>
                <div class="text-[11px] text-slate-500 mt-1">Cucian yang telah diambil oleh pelanggan hari ini</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Dikerjakan</span>
                    <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black">
                        {{ $countProses }}
                    </span>
                </div>
                <div class="text-2xl font-black text-blue-700 tracking-tight">{{ $countProses }} Order</div>
                <div class="text-[11px] text-slate-500 mt-1">Cucian sedang di mesin cuci / pengering / setrika</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Siap Diambil</span>
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black">
                        {{ $countSelesai }}
                    </span>
                </div>
                <div class="text-2xl font-black text-emerald-700 tracking-tight">{{ $countSelesai }} Order</div>
                <div class="text-[11px] text-slate-500 mt-1">Cucian sudah rapi di rak dan siap diserahkan</div>
            </div>
        @endif
    </div>

    <!-- STATUS ANTREAN CUCIAN REAL-TIME -->
    <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Status Pengerjaan Outlet</h2>
                <p class="text-slate-500 text-xs">Pantauan tahapan cucian yang saat ini berada di dalam outlet.</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1">
                <span>Kelola Semua Pesanan</span> &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- 1. Antrean Baru -->
            <a href="{{ route('admin.transactions.index') }}" class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/70 hover:bg-amber-50 transition group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">1. Baru / Antrean</span>
                    <span class="w-7 h-7 rounded-lg bg-amber-500 text-white text-xs font-black flex items-center justify-center shadow-xs">
                        {{ $countBaru }}
                    </span>
                </div>
                <p class="text-xs text-amber-900/70 leading-relaxed">Cucian baru diterima di kasir dan menunggu dimasukkan ke mesin.</p>
                <div class="mt-3 text-[11px] font-bold text-amber-700 group-hover:underline flex items-center gap-1">
                    <span>Lihat Cucian Baru</span> &rarr;
                </div>
            </a>

            <!-- 2. Sedang Diproses -->
            <a href="{{ route('admin.transactions.index') }}" class="p-4 rounded-2xl bg-sky-50/70 border border-sky-200/70 hover:bg-sky-50 transition group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-sky-800 uppercase tracking-wider">2. Sedang Diproses</span>
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-black flex items-center justify-center shadow-xs">
                        {{ $countProses }}
                    </span>
                </div>
                <p class="text-xs text-sky-900/70 leading-relaxed">Tahap pencucian, pengeringan, atau setrika uap rapi oleh tim.</p>
                <div class="mt-3 text-[11px] font-bold text-sky-700 group-hover:underline flex items-center gap-1">
                    <span>Lihat Proses Cucian</span> &rarr;
                </div>
            </a>

            <!-- 3. Selesai Siap Ambil -->
            <a href="{{ route('admin.transactions.index') }}" class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/70 hover:bg-emerald-50 transition group">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">3. Selesai (Siap Ambil)</span>
                    <span class="w-7 h-7 rounded-lg bg-emerald-500 text-white text-xs font-black flex items-center justify-center shadow-xs">
                        {{ $countSelesai }}
                    </span>
                </div>
                <p class="text-xs text-emerald-900/70 leading-relaxed">Pakaian sudah wangi, dipacking rapi, dan menunggu diambil pelanggan.</p>
                <div class="mt-3 text-[11px] font-bold text-emerald-700 group-hover:underline flex items-center gap-1">
                    <span>Lihat Siap Ambil</span> &rarr;
                </div>
            </a>
        </div>
    </div>

    <!-- SMART ALERT: Cucian Selesai yang Belum Diambil (> 2 hari) -->
    @if($unclaimedOrders->count() > 0)
        <div class="bg-amber-50 border border-amber-300/80 rounded-2xl p-5 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-2.5">
                    <span class="p-2 bg-amber-500 text-white rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-amber-900">Perhatian: Cucian Selesai Belum Diambil (> 2 Hari)</h3>
                        <p class="text-xs text-amber-700">Terdapat {{ $unclaimedOrders->count() }} pesanan yang sudah selesai dikerjakan namun belum diambil pemiliknya. Kirim pengingat WhatsApp agar rak penyimpanan tidak penuh.</p>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-amber-200/60 bg-white/70 rounded-xl border border-amber-200 overflow-hidden">
                @foreach($unclaimedOrders as $order)
                    @php
                        $daysWaiting = $order->updated_at ? round($order->updated_at->diffInDays(now())) : 2;
                        $waReminderText = "Halo kak " . $order->customer_name . ", cucian Anda dengan nomor nota *" . $order->invoice_code . "* sudah selesai sejak " . $daysWaiting . " hari lalu dan telah rapi tersimpan di outlet LaundryGue. Mohon untuk segera diambil ya kak. Terima kasih! 🙏";
                    @endphp
                    <div class="p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div>
                            <span class="font-mono font-bold text-amber-800">{{ $order->invoice_code }}</span>
                            <span class="mx-1 text-slate-300">•</span>
                            <strong class="text-slate-800">{{ $order->customer_name }}</strong>
                            <span class="text-slate-500">({{ $order->customer_phone }})</span>
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                Sudah {{ $daysWaiting }} hari di rak
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}?text={{ urlencode($waReminderText) }}"
                               target="_blank"
                               class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-lg transition shadow-xs flex items-center gap-1.5">
                                💬 Ingatkan via WA
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- GRAFIK TREN 7 HARI TERAKHIR & TOP LAYANAN (Dua Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom Kiri: Visualisasi Omzet 7 Hari Terakhir -->
        <div class="lg:col-span-2 bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Tren Pendapatan 7 Hari Terakhir</h2>
                        <p class="text-slate-500 text-xs">Grafik pendapatan dari cucian yang telah diambil dan dibayar.</p>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg">Real-Time Data</span>
                </div>

                <!-- Bar Chart Ringan & Responsif -->
                <div class="pt-6 pb-2">
                    <div class="h-44 sm:h-52 flex items-end justify-between gap-2 sm:gap-4 px-2 border-b border-slate-200 pb-2">
                        @foreach($weeklyChart as $bar)
                            @php
                                $percent = $maxDailyRevenue > 0 ? min(100, max(6, round(($bar['revenue'] / $maxDailyRevenue) * 100))) : 6;
                            @endphp
                            <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
                                <!-- Tooltip Hover -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none absolute -top-10 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded-md shadow-lg whitespace-nowrap z-20">
                                    Rp{{ number_format($bar['revenue'], 0, ',', '.') }} ({{ $bar['orders'] }} order)
                                </div>

                                <!-- Batang Bar -->
                                <div class="w-full max-w-[42px] bg-gradient-to-t from-sky-600 to-sky-400 group-hover:from-indigo-600 group-hover:to-sky-500 rounded-t-lg transition-all duration-300 shadow-sm"
                                     style="height: {{ $percent }}%;"></div>

                                <!-- Label Tanggal & Hari -->
                                <div class="text-center mt-2.5">
                                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 block">{{ $bar['dayName'] }}</span>
                                    <span class="text-[9px] text-slate-400 block">{{ $bar['displayDate'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Rata-rata pendapatan harian seminggu terakhir</span>
                <strong class="text-slate-800">
                    Rp{{ number_format(array_sum(array_column($weeklyChart, 'revenue')) / 7, 0, ',', '.') }} / hari
                </strong>
            </div>
        </div>

        <!-- Kolom Kanan: Layanan Terlaris (Top Services) -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Layanan Terlaris</h2>
                    <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Terpopuler</span>
                </div>
                <p class="text-slate-500 text-xs mb-5">Jenis cucian dengan volume pengerjaan terbanyak.</p>

                <div class="space-y-4">
                    @forelse($topServices as $srv)
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1">
                                <span class="font-bold text-slate-800 truncate max-w-[150px]">{{ $srv->name }}</span>
                                <span class="font-bold text-sky-600">
                                    {{ $srv->transaction_details_sum_quantity ? round($srv->transaction_details_sum_quantity, 1) : 0 }} {{ $srv->unit }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-sky-500 h-2 rounded-full" style="width: {{ min(100, max(15, ($srv->transaction_details_sum_quantity ?? 1) * 3)) }}%"></div>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                Tarif: Rp{{ number_format($srv->price, 0, ',', '.') }} / {{ $srv->unit }}
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-slate-400 text-xs italic">
                            Belum ada data pengerjaan layanan.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.services.index') }}" class="block text-center text-xs font-bold text-sky-600 hover:text-sky-700">
                    Kelola Katalog Layanan &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- TABEL 5 PESANAN AKTIF TERBARU (AKSI CEPAT) -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100">
            <div>
                <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Antrean Pesanan Terkini</h2>
                <p class="text-slate-500 text-xs">Ubah status tahapan pengerjaan cucian langsung secara cepat.</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white px-3.5 py-2 rounded-xl transition shadow-xs self-start sm:self-auto">
                Buka Semua Pesanan Aktif &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                        <th class="py-3 px-4">Invoice</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4">Layanan</th>
                        <th class="py-3 px-4">Total Biaya</th>
                        <th class="py-3 px-4">Status & Ubah Cepat</th>
                        <th class="py-3 px-4 text-center">Struk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentActiveOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-sky-600">{{ $order->invoice_code }}</td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $order->customer_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                @foreach($order->details as $d)
                                    <div>{{ $d->service->name ?? 'Layanan' }} <span class="text-slate-400">({{ $d->quantity }} {{ $d->service->unit ?? '' }})</span></div>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('admin.transactions.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold px-2.5 py-1 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500
                                        {{ $order->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : ($order->status == 'Proses' ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-amber-50 text-amber-700 border-amber-300') }}">
                                        <option value="Baru" {{ $order->status == 'Baru' ? 'selected' : '' }}>Baru / Antrean</option>
                                        <option value="Proses" {{ $order->status == 'Proses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai (Siap Ambil)</option>
                                        <option value="Diambil" {{ $order->status == 'Diambil' ? 'selected' : '' }}>Sudah Diambil (Selesai)</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.transactions.receipt', $order->id) }}" target="_blank"
                                   class="inline-flex items-center gap-1 text-slate-600 hover:text-sky-600 bg-slate-100 hover:bg-sky-50 px-2.5 py-1 rounded-lg font-bold transition text-[11px]"
                                   title="Cetak Struk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    <span>Cetak</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400 italic">
                                Belum ada pesanan aktif saat ini. Outlet sedang santai!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
