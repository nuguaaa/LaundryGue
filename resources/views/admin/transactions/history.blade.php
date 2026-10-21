@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl text-slate-800 leading-tight">
        @if(auth()->user()->role === 'admin')
            {{ __('Laporan Keuangan & History Transaksi') }}
        @else
            {{ __('Pencatatan Pengeluaran Operasional') }}
        @endif
    </h2>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Pesan Sukses & Error -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl print:hidden flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-xl print:hidden shadow-sm">
            <div class="font-bold text-xs uppercase tracking-wider text-red-700 mb-1 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Perhatian:
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->user()->role === 'admin')
        <!-- ============================================================== -->
        <!-- AREA KHUSUS ADMIN: LAPORAN LENGKAP, FILTER, SUMMARY & TRANSAKSI -->
        <!-- ============================================================== -->

        <!-- Header & Filter Bar -->
        <div class="space-y-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Laporan Keuangan & History</h1>
                    <p class="text-slate-500 text-sm">Rekapitulasi omzet kotor, pengeluaran operasional, dan profit bersih.</p>
                    <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Periode Aktif: <strong class="ml-1 text-indigo-900">{{ $filterData['label'] ?? 'Semua Waktu' }}</strong>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 print:hidden">
                    <a href="{{ route('laporan.cetak', request()->all()) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan
                    </a>

                    <a href="{{ route('admin.transactions.index') }}" class="bg-sky-500 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-sky-600 transition shadow-sm">
                        &larr; Pesanan Aktif
                    </a>
                </div>
            </div>

            <!-- Filter Bar Modern (Preset & Custom Kategori) -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 print:hidden">
                <form method="GET" action="{{ route('admin.transactions.history') }}" id="filterForm" class="flex flex-wrap items-end gap-3">
                    <div class="min-w-[200px]">
                        <label class="block text-xs font-bold text-slate-600 mb-1">Kategori Filter Waktu</label>
                        <select name="filter" id="filterSelect" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all" {{ ($filterData['filter'] ?? 'all') == 'all' ? 'selected' : '' }}>-- Semua Waktu --</option>
                            <option value="today" {{ ($filterData['filter'] ?? '') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ ($filterData['filter'] ?? '') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ ($filterData['filter'] ?? '') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ ($filterData['filter'] ?? '') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom_month" {{ ($filterData['filter'] ?? '') == 'custom_month' ? 'selected' : '' }}>📅 Pilih Bulan (Custom Bulan)</option>
                            <option value="custom_day" {{ ($filterData['filter'] ?? '') == 'custom_day' ? 'selected' : '' }}>📆 Pilih Hari (Custom Tanggal)</option>
                        </select>
                    </div>

                    <!-- Opsi Custom Bulan & Tahun -->
                    <div id="customMonthWrapper" class="{{ ($filterData['filter'] ?? '') == 'custom_month' ? 'flex' : 'hidden' }} items-center gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Pilih Bulan</label>
                            <select name="month" class="px-3 py-2 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @php
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $selectedMonth = $filterData['month'] ?? (int)date('n');
                                @endphp
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Pilih Tahun</label>
                            <select name="year" class="px-3 py-2 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @php
                                    $selectedYear = $filterData['year'] ?? (int)date('Y');
                                    $currentYear = (int)date('Y');
                                @endphp
                                @for($y = $currentYear - 4; $y <= $currentYear + 1; $y++)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Opsi Custom Hari/Tanggal -->
                    <div id="customDayWrapper" class="{{ ($filterData['filter'] ?? '') == 'custom_day' ? 'block' : 'hidden' }}">
                        <label class="block text-xs font-bold text-slate-600 mb-1">Pilih Tanggal</label>
                        <input type="date" name="date" value="{{ $filterData['date'] ?? date('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-800 transition flex items-center gap-1.5 shadow-sm">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Tampilkan Data
                        </button>
                        @if(request()->has('filter') && request('filter') != 'all')
                            <a href="{{ route('admin.transactions.history') }}" class="bg-slate-100 text-slate-600 px-3.5 py-2 rounded-xl text-sm font-bold hover:bg-slate-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Kotak Ringkasan Keuangan (Kotor, Pengeluaran, Bersih) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Pendapatan Kotor</div>
                <div class="text-2xl font-black text-emerald-600 mt-1">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="text-[11px] text-slate-400 mt-1">Berdasarkan periode filter aktif</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Pengeluaran</div>
                <div class="text-2xl font-black text-red-600 mt-1">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                <div class="text-[11px] text-slate-400 mt-1">Operasional & belanja laundry</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Pendapatan Bersih (Profit)</div>
                <div class="text-2xl font-black text-sky-600 mt-1">Rp{{ number_format($pendapatanBersih, 0, ',', '.') }}</div>
                <div class="text-[11px] text-slate-400 mt-1">Pendapatan Kotor - Pengeluaran</div>
            </div>
        </div>

        <!-- FORM INPUT RIWAYAT TRANSAKSI MANUAL (BANYAK TRANSAKSI PER TANGGAL) -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200 print:hidden">
            <div class="p-5 border-b border-slate-200 bg-emerald-50/60 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        Input Riwayat Transaksi Manual (Banyak Transaksi Per Tanggal)
                    </h3>
                    <p class="text-xs text-slate-600 mt-0.5">Pilih tanggal tertentu, lalu masukkan daftar transaksi pada tanggal tersebut sekaligus untuk rekap pembukuan lalu.</p>
                </div>
                <div id="batchSummaryBadge" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                    Total: 0 Baris - Rp0
                </div>
            </div>

            <div class="p-5">
                <form action="{{ route('admin.transactions.manual.store') }}" method="POST" id="manualTrxForm" class="space-y-4">
                    @csrf

                    <!-- Pilih Tanggal Utama Transaksi -->
                    <div class="bg-emerald-50/40 p-4 rounded-xl border border-emerald-100 flex flex-col md:flex-row items-start md:items-center gap-3">
                        <label class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5 shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Pilih Tanggal Transaksi:
                        </label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm font-bold text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500 shadow-sm" required>
                        <span class="text-xs text-slate-500">
                            *Semua baris transaksi di bawah akan otomatis disimpan pada tanggal ini.
                        </span>
                    </div>

                    <!-- Tabel Input Baris Transaksi -->
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left border-collapse text-xs" id="manualTrxTable">
                            <thead>
                                <tr class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider">
                                    <th class="py-2.5 px-3 w-10 text-center">#</th>
                                    <th class="py-2.5 px-3 min-w-[160px]">Nama Pelanggan <span class="text-red-500">*</span></th>
                                    <th class="py-2.5 px-3 min-w-[120px]">No. HP / WA</th>
                                    <th class="py-2.5 px-3 min-w-[200px]">Layanan <span class="text-red-500">*</span></th>
                                    <th class="py-2.5 px-3 w-24">Jumlah / Qty <span class="text-red-500">*</span></th>
                                    <th class="py-2.5 px-3 min-w-[140px]">Total Harga (Rp)</th>
                                    <th class="py-2.5 px-3 min-w-[130px]">No. Nota (Opsional)</th>
                                    <th class="py-2.5 px-3 w-12 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="manualTrxBody" class="divide-y divide-slate-200">
                                <!-- Baris transaksi akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Bar Bawah (Tambah Baris, Info & Tombol Simpan) -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-3 pt-2">
                        <button type="button" id="btnAddRow" class="bg-emerald-50 text-emerald-700 border border-emerald-300 hover:bg-emerald-100 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            + Tambah Baris Transaksi
                        </button>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                            <div class="text-xs text-slate-500 hidden md:block">
                                *Total harga terhitung otomatis berdasarkan harga layanan dan quantity.
                            </div>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span id="btnSubmitText">Simpan Semua Transaksi</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @else
        <!-- ============================================================== -->
        <!-- AREA KHUSUS KASIR: HANYA INPUT & LIHAT PENGELUARAN OPERASIONAL -->
        <!-- ============================================================== -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Pencatatan Pengeluaran Operasional</h1>
                <p class="text-slate-500 text-sm mt-1">Catat belanja perlengkapan harian outlet seperti sabun, pewangi, listrik, plastik, dan kebutuhan lainnya.</p>
                <div class="mt-2 inline-flex items-center gap-2 text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                    <span>Kasir: <strong>{{ Auth::user()->name }}</strong></span>
                </div>
            </div>
            <div class="bg-red-50 border border-red-200 px-4 py-3 rounded-2xl text-right">
                <div class="text-[11px] font-bold uppercase tracking-wider text-red-600">Total Pengeluaran Tercatat</div>
                <div class="text-xl font-black text-red-700">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
        </div>
    @endif

    <!-- ============================================================== -->
    <!-- BAGIAN PENGELUARAN OPERASIONAL (BISA DIINPUT ADMIN & KASIR) -->
    <!-- ============================================================== -->
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
        <div class="p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                Form Catat Pengeluaran Operasional
            </h3>
        </div>

        <!-- Form Input Pengeluaran -->
        <div class="p-4 sm:p-5 print:hidden">
            <form action="{{ route('admin.expenses.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Pengeluaran</label>
                    <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Barang / Keperluan</label>
                    <input type="text" name="item_name" placeholder="Contoh: Sabun / Pewangi / Listrik" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Jumlah (Qty)</label>
                    <input type="number" name="quantity" placeholder="1" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500" required min="1">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Harga Satuan (Rp)</label>
                    <input type="number" name="unit_price" placeholder="15000" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500" required min="0">
                </div>
                <div class="flex items-end sm:col-span-2 lg:col-span-1">
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-red-700 transition shadow-sm">
                        + Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Pengeluaran -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-3 px-4 min-w-[110px]">Tanggal</th>
                        <th class="py-3 px-4 min-w-[180px]">Nama Barang / Kebutuhan</th>
                        <th class="py-3 px-4 min-w-[70px]">Qty</th>
                        <th class="py-3 px-4 min-w-[120px]">Harga Satuan</th>
                        <th class="py-3 px-4 min-w-[130px]">Total Biaya</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="py-3 px-4 min-w-[100px] text-center print:hidden">Aksi (Admin)</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($expenses as $exp)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 text-xs text-slate-600">{{ $exp->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-800">{{ $exp->item_name }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $exp->quantity }}</td>
                        <td class="py-3 px-4 text-slate-600">Rp{{ number_format($exp->unit_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-bold text-red-600">Rp{{ number_format($exp->total_price, 0, ',', '.') }}</td>
                        @if(auth()->user()->role === 'admin')
                            <td class="py-3 px-4 text-center print:hidden">
                                <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus data pengeluaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-2.5 py-1 rounded-lg text-xs font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="py-8 text-center text-slate-400 italic">Belum ada catatan pengeluaran pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Tabel Pengeluaran -->
        @if(!request('print') && method_exists($expenses, 'hasPages'))
        <div class="p-4 border-t border-slate-200 print:hidden flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="text-xs text-slate-500">
                Menampilkan <b>{{ $expenses->firstItem() ?? 0 }}</b> sampai <b>{{ $expenses->lastItem() ?? 0 }}</b> dari <b>{{ $expenses->total() }}</b> pengeluaran
            </div>
            <div>
                {{ $expenses->links() }}
            </div>
        </div>
        @endif
    </div>

    @if(auth()->user()->role === 'admin')
        <!-- ============================================================== -->
        <!-- TABEL 2: RIWAYAT TRANSAKSI / PENDAPATAN (KHUSUS ADMIN) -->
        <!-- ============================================================== -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
            <div class="p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        Riwayat Transaksi Masuk (Selesai & Diambil)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Seluruh pesanan selesai tersimpan di sini. Admin dapat menghapus data jika diperlukan.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                            <th class="py-3 px-4 min-w-[130px]">Invoice</th>
                            <th class="py-3 px-4 min-w-[150px]">Pelanggan</th>
                            <th class="py-3 px-4 min-w-[180px]">Detail Layanan</th>
                            <th class="py-3 px-4 min-w-[130px]">Total Pendapatan</th>
                            <th class="py-3 px-4 min-w-[110px]">Diproses Oleh</th>
                            <th class="py-3 px-4 min-w-[140px]">Tanggal Transaksi</th>
                            <th class="py-3 px-4 min-w-[100px] text-center print:hidden">Aksi (Admin)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-sm">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-mono font-bold text-sky-600 text-xs">{{ $trx->invoice_code }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800">{{ $trx->customer_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $trx->customer_phone }}</div>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-700">
                                    @foreach($trx->details as $detail)
                                        <div>{{ $detail->service->name ?? 'Layanan' }} <span class="text-xs text-slate-500">({{ $detail->quantity }} {{ $detail->service->unit ?? '' }})</span></div>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4 font-bold text-emerald-600">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                        {{ $trx->user->name ?? 'Sistem' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-xs text-slate-600">{{ $trx->updated_at->format('d M Y, H:i') }}</td>
                                <td class="py-3 px-4 text-center print:hidden space-x-1.5 whitespace-nowrap">
                                    <form action="{{ route('admin.transactions.status', $trx->id) }}" method="POST" class="inline-block">
                                        @csrf @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold px-2 py-1 rounded-lg border border-slate-300 focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white text-slate-700 shadow-sm" title="Ubah Status Pesanan">
                                            <option value="Diambil" selected>Diambil</option>
                                            <option value="Proses">Kembalikan ke Proses</option>
                                            <option value="Selesai">Kembalikan ke Selesai</option>
                                            <option value="Baru">Kembalikan ke Baru</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus arsip riwayat transaksi {{ $trx->invoice_code }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-3 py-1 rounded-lg text-xs font-bold transition shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 italic">Belum ada riwayat transaksi pada periode: {{ $filterData['label'] ?? 'Semua Waktu' }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Tabel Transaksi -->
            @if(!request('print') && method_exists($transactions, 'hasPages'))
            <div class="p-4 border-t border-slate-200 print:hidden flex flex-col md:flex-row justify-between items-center gap-2">
                <div class="text-xs text-slate-500">
                    Menampilkan <b>{{ $transactions->firstItem() ?? 0 }}</b> sampai <b>{{ $transactions->lastItem() ?? 0 }}</b> dari <b>{{ $transactions->total() }}</b> transaksi
                </div>
                <div>
                    {{ $transactions->links() }}
                </div>
            </div>
            @endif
        </div>
    @endif

</div>

@if(auth()->user()->role === 'admin')
<!-- Script khusus Admin untuk Filter Dinamis & Multi-Baris Input Riwayat Transaksi (SPA Compatible) -->
<script>
function initHistoryLogic() {
    // 1. Logika Tampilan Filter Custom
    const filterSelect = document.getElementById('filterSelect');
    const customMonthWrapper = document.getElementById('customMonthWrapper');
    const customDayWrapper = document.getElementById('customDayWrapper');

    function updateFilterUI() {
        if (!filterSelect) return;
        const val = filterSelect.value;
        if (val === 'custom_month') {
            customMonthWrapper.classList.remove('hidden');
            customMonthWrapper.classList.add('flex');
            customDayWrapper.classList.add('hidden');
        } else if (val === 'custom_day') {
            customDayWrapper.classList.remove('hidden');
            customDayWrapper.classList.add('block');
            customMonthWrapper.classList.add('hidden');
            customMonthWrapper.classList.remove('flex');
        } else {
            customMonthWrapper.classList.add('hidden');
            customMonthWrapper.classList.remove('flex');
            customDayWrapper.classList.add('hidden');
            if (val === 'today' || val === 'week' || val === 'month' || val === 'year' || val === 'all') {
                const form = document.getElementById('filterForm');
                if (form) {
                    const url = new URL(form.action, window.location.origin);
                    url.searchParams.set('filter', val);
                    if (window.spaNavigate) {
                        window.spaNavigate(url.href, true);
                    } else {
                        form.submit();
                    }
                }
            }
        }
    }

    filterSelect?.addEventListener('change', updateFilterUI);

    const filterForm = document.getElementById('filterForm');
    filterForm?.addEventListener('submit', function(e) {
        if (window.spaNavigate) {
            e.preventDefault();
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            window.spaNavigate(filterForm.action + '?' + params.toString(), true);
        }
    });

    // 2. Logika Multi-Baris Input Riwayat Transaksi Manual
    const services = @json($services);
    const tbody = document.getElementById('manualTrxBody');
    const btnAddRow = document.getElementById('btnAddRow');
    const summaryBadge = document.getElementById('batchSummaryBadge');
    const btnSubmitText = document.getElementById('btnSubmitText');
    let rowCounter = 0;

    function createRowHtml(idx) {
        const serviceOptions = services.map(s => {
            return `<option value="${s.id}" data-price="${s.price}" data-unit="${s.unit}">${s.name} (Rp${new Intl.NumberFormat('id-ID').format(s.price)}/${s.unit})</option>`;
        }).join('');

        return `
            <tr class="trx-row hover:bg-slate-50">
                <td class="py-2.5 px-3 text-center text-slate-400 font-bold row-number text-xs"></td>
                <td class="py-2.5 px-3">
                    <input type="text" name="items[${idx}][customer_name]" placeholder="Nama pelanggan" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-emerald-500" required>
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="items[${idx}][customer_phone]" placeholder="08..." class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-emerald-500">
                </td>
                <td class="py-2.5 px-3">
                    <select name="items[${idx}][service_id]" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs bg-white row-service focus:ring-1 focus:ring-emerald-500" required>
                        <option value="">-- Pilih Layanan --</option>
                        ${serviceOptions}
                    </select>
                </td>
                <td class="py-2.5 px-3">
                    <input type="number" step="any" min="0.01" name="items[${idx}][quantity]" placeholder="Qty" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs row-qty focus:ring-1 focus:ring-emerald-500" required>
                </td>
                <td class="py-2.5 px-3">
                    <input type="number" min="0" name="items[${idx}][total_price]" placeholder="Otomatis / Manual" class="w-full px-2.5 py-1.5 border border-emerald-200 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50/60 row-total focus:ring-1 focus:ring-emerald-500">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="items[${idx}][invoice_code]" placeholder="Otomatis" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-emerald-500">
                </td>
                <td class="py-2.5 px-3 text-center">
                    <button type="button" class="text-slate-400 hover:text-red-600 font-bold p-1 rounded-lg hover:bg-red-50 transition btn-remove-row" title="Hapus baris ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            </tr>
        `;
    }

    function addRow() {
        if (!tbody) return;
        const currentIdx = rowCounter++;
        tbody.insertAdjacentHTML('beforeend', createRowHtml(currentIdx));
        reindexRows();
    }

    function reindexRows() {
        if (!tbody) return;
        const rows = tbody.querySelectorAll('.trx-row');
        let totalNominal = 0;
        let filledCount = 0;

        rows.forEach((row, i) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) numCell.textContent = i + 1;

            const nameInput = row.querySelector('input[name*="[customer_name]"]');
            const totalInput = row.querySelector('.row-total');
            const val = parseFloat(totalInput?.value) || 0;
            totalNominal += val;
            if (nameInput && nameInput.value.trim() !== '') {
                filledCount++;
            }
        });

        const formatted = new Intl.NumberFormat('id-ID').format(totalNominal);
        if (summaryBadge) {
            summaryBadge.textContent = `Total: ${rows.length} Baris (${filledCount} Terisi) - Rp${formatted}`;
        }
        if (btnSubmitText) {
            btnSubmitText.textContent = rows.length > 0 ? `Simpan Semua Transaksi (${rows.length} Baris)` : `Simpan Semua Transaksi`;
        }
    }

    function handleRowCalculation(row) {
        const serviceSelect = row.querySelector('.row-service');
        const qtyInput = row.querySelector('.row-qty');
        const totalInput = row.querySelector('.row-total');

        const opt = serviceSelect?.options[serviceSelect.selectedIndex];
        const price = parseFloat(opt?.getAttribute('data-price')) || 0;
        const qty = parseFloat(qtyInput?.value) || 0;

        if (price > 0 && qty > 0) {
            totalInput.value = Math.round(price * qty);
        }
        reindexRows();
    }

    tbody?.addEventListener('input', function(e) {
        const row = e.target.closest('.trx-row');
        if (!row) return;
        if (e.target.classList.contains('row-qty')) {
            handleRowCalculation(row);
        } else {
            reindexRows();
        }
    });

    tbody?.addEventListener('change', function(e) {
        const row = e.target.closest('.trx-row');
        if (!row) return;
        if (e.target.classList.contains('row-service')) {
            handleRowCalculation(row);
        }
    });

    tbody?.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-remove-row');
        if (!btn) return;
        const row = btn.closest('.trx-row');
        const totalRows = tbody.querySelectorAll('.trx-row').length;
        if (totalRows <= 1) {
            row.querySelectorAll('input').forEach(inp => inp.value = '');
            row.querySelectorAll('select').forEach(sel => sel.selectedIndex = 0);
        } else {
            row.remove();
        }
        reindexRows();
    });

    btnAddRow?.addEventListener('click', function() {
        addRow();
    });

    if (tbody && tbody.children.length === 0) {
        for (let i = 0; i < 3; i++) {
            addRow();
        }
    }
}

initHistoryLogic();
document.addEventListener('DOMContentLoaded', initHistoryLogic);
window.addEventListener('app:spa-navigated', initHistoryLogic);
</script>
@endif

<!-- Style Khusus Untuk Cetak / PDF -->
<style>
@media print {
    .print\:hidden, nav, header, footer {
        display: none !important;
    }
    body {
        background-color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    table {
        width: 100% !important;
        font-size: 12px !important;
    }
}
</style>
@endsection
