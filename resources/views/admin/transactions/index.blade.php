@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Daftar Pesanan Aktif') }}
    </h2>
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Sedang Berjalan</h1>
            <p class="text-gray-600 text-sm">Kelola status cucian pelanggan. Jika status diubah ke "Diambil", otomatis masuk ke laporan.</p>
        </div>
        <div class="space-x-3">
            <a href="{{ route('admin.transactions.history') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition shadow-sm">
                Lihat History Laporan &rarr;
            </a>
            <a href="{{ route('admin.transactions.create') }}" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition shadow-sm">
                + Input Kasir Baru
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-brand text-white">
                    <th class="py-3 px-4">Invoice</th>
                    <th class="py-3 px-4">Pelanggan</th>
                    <th class="py-3 px-4">Layanan</th>
                    <th class="py-3 px-4">Total Biaya</th>
                    <th class="py-3 px-4">Diproses Oleh</th> <!-- Kolom Baru: Nama Kasir/Admin -->
                    <th class="py-3 px-4">Status Cucian</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono font-bold text-brand text-sm">{{ $trx->invoice_code }}</td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">{{ $trx->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $trx->customer_phone }}</div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">
                            @foreach($trx->details as $detail)
                                <div>{{ $detail->service->name ?? 'Layanan' }} ({{ $detail->quantity }} {{ $detail->service->unit ?? '' }})</div>
                            @endforeach
                        </td>
                        <td class="py-3 px-4 font-bold text-gray-800">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>

                        <!-- Menampilkan Nama Kasir/Admin yang bertugas -->
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                {{ $trx->user->name ?? 'Sistem / Tidak Diketahui' }}
                            </span>
                        </td>

                        <td class="py-3 px-4">
                            <form action="{{ route('admin.transactions.status', $trx->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs font-semibold px-2.5 py-1.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-brand
                                    {{ $trx->status == 'Selesai' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                                    <option value="Baru" {{ $trx->status == 'Baru' ? 'selected' : '' }}>Baru / Diterima</option>
                                    <option value="Proses" {{ $trx->status == 'Proses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Selesai" {{ $trx->status == 'Selesai' ? 'selected' : '' }}>Selesai (Siap Ambil)</option>
                                    <option value="Diambil" {{ $trx->status == 'Diambil' ? 'selected' : '' }}>Sudah Diambil (Selesai)</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-red-600 transition shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500 italic">Tidak ada pesanan aktif saat ini. Semuanya sudah diambil!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
