@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Laporan Keuangan & History') }}
    </h2>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Pesan -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg print:hidden">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan Laundry</h1>
            <p class="text-gray-600 text-sm">Rekapitulasi pendapatan bersih dan pengeluaran operasional.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 print:hidden">
            <!-- Filter Laporan -->
            <form method="GET" action="{{ route('admin.transactions.history') }}" class="flex items-center space-x-2">
                <select name="filter" onchange="this.form.submit()" class="px-3 py-2 border rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand">
                    <option value="">-- Semua Waktu --</option>
                    <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </form>

<a href="{{ route('laporan.cetak', ['filter' => request('filter', 'all')]) }}" target="_blank" class="btn btn-primary">
    Cetak Laporan
</a>

            <a href="{{ route('admin.transactions.index') }}" class="bg-sky-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-sky-600 transition">
                &larr; Pesanan Aktif
            </a>
        </div>
    </div>

    <!-- Kotak Ringkasan Keuangan (Kotor, Pengeluaran, Bersih) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="text-xs text-gray-500 font-semibold uppercase">Total Pendapatan Kotor</div>
            <div class="text-2xl font-extrabold text-green-600 mt-1">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="text-xs text-gray-500 font-semibold uppercase">Total Pengeluaran</div>
            <div class="text-2xl font-extrabold text-red-600 mt-1">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="text-xs text-gray-500 font-semibold uppercase">Total Pendapatan Bersih (Profit)</div>
            <div class="text-2xl font-extrabold text-blue-600 mt-1">Rp{{ number_format($pendapatanBersih, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- TABEL 1: PENGELUARAN OPERASIONAL -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base font-bold text-gray-800">Catat Pengeluaran Operasional (Sabun, Listrik, dll)</h3>
        </div>

        <!-- Form Input Pengeluaran (Sembunyi saat dicetak) -->
        <div class="p-5 print:hidden">
            <form action="{{ route('admin.expenses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Barang / Keperluan</label>
                    <input type="text" name="item_name" placeholder="Contoh: Sabun Rinso / Pewangi" class="w-full px-3 py-2 border rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah (Qty)</label>
                    <input type="number" name="quantity" placeholder="3" class="w-full px-3 py-2 border rounded-lg text-sm" required min="1">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga Satuan (Rp)</label>
                    <input type="number" name="unit_price" placeholder="15000" class="w-full px-3 py-2 border rounded-lg text-sm" required min="0">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                        + Tambah Pengeluaran
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Pengeluaran -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase">
                        <th class="py-2.5 px-4">Nama Barang</th>
                        <th class="py-2.5 px-4">Qty</th>
                        <th class="py-2.5 px-4">Harga Satuan</th>
                        <th class="py-2.5 px-4">Total Harga</th>
                        <th class="py-2.5 px-4 text-center print:hidden">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($expenses as $exp)
                    <tr>
                        <td class="py-2.5 px-4 font-medium text-gray-800">{{ $exp->item_name }}</td>
                        <td class="py-2.5 px-4 text-gray-600">{{ $exp->quantity }}</td>
                        <td class="py-2.5 px-4 text-gray-600">Rp{{ number_format($exp->unit_price, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-4 font-bold text-red-600">Rp{{ number_format($exp->total_price, 0, ',', '.') }}</td>
                        <td class="py-2.5 px-4 text-center print:hidden">
                            <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-400 italic">Belum ada catatan pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Tabel Pengeluaran (Hanya muncul jika bukan mode cetak) -->
        @if(!request('print') && method_exists($expenses, 'hasPages'))
        <div class="p-4 border-t border-gray-200 print:hidden flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="text-xs text-gray-500">
                Menampilkan <b>{{ $expenses->firstItem() ?? 0 }}</b> sampai <b>{{ $expenses->lastItem() ?? 0 }}</b> dari <b>{{ $expenses->total() }}</b> pengeluaran
            </div>
            <div>
                {{ $expenses->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- TABEL 2: RIWAYAT TRANSAKSI / PENDAPATAN -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base font-bold text-gray-800">Riwayat Transaksi Masuk (Selesai & Diambil)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white text-xs uppercase">
                        <th class="py-3 px-4">Invoice</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4">Detail Layanan</th>
                        <th class="py-3 px-4">Total Pendapatan</th>
                        <th class="py-3 px-4">Diproses Oleh</th>
                        <th class="py-3 px-4">Tanggal Diambil</th>
                        <th class="py-3 px-4 text-center print:hidden">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-mono font-bold text-gray-700 text-xs">{{ $trx->invoice_code }}</td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-800">{{ $trx->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $trx->customer_phone }}</div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                @foreach($trx->details as $detail)
                                    <div>{{ $detail->service->name ?? 'Layanan' }} ({{ $detail->quantity }} {{ $detail->service->unit ?? '' }})</div>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 font-bold text-green-600">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-sm">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    {{ $trx->user->name ?? 'Sistem' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-xs text-gray-600">{{ $trx->updated_at->format('d M Y, H:i') }}</td>
                            <td class="py-3 px-4 text-center print:hidden">
                                <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus arsip riwayat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-600 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 italic">Belum ada riwayat transaksi pada filter waktu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Tabel Transaksi (Hanya muncul jika bukan mode cetak) -->
        @if(!request('print') && method_exists($transactions, 'hasPages'))
        <div class="p-4 border-t border-gray-200 print:hidden flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="text-xs text-gray-500">
                Menampilkan <b>{{ $transactions->firstItem() ?? 0 }}</b> sampai <b>{{ $transactions->lastItem() ?? 0 }}</b> dari <b>{{ $transactions->total() }}</b> transaksi
            </div>
            <div>
                {{ $transactions->links() }}
            </div>
        </div>
        @endif
    </div>

</div>

<!-- Script untuk Cetak Laporan Otomatis Tanpa Pagination -->
<!-- Script untuk Cetak Laporan Otomatis Tanpa Pagination -->
<script>
function printReport() {
    const url = new URL(window.location.href);
    // Jika parameter print belum ada, tambahkan lalu reload halaman
    if (!url.searchParams.has('print')) {
        url.searchParams.set('print', '1');
        window.location.href = url.toString();
    } else {
        window.print();
    }
}

// Otomatis langsung memunculkan dialog cetak jika parameter print=1 sudah aktif
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('print')) {
        window.print();
    }
};
</script>

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
