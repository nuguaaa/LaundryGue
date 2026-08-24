@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Tambah Promo Baru</h1>
        <p class="text-gray-600 text-sm mb-6">Buat kupon atau penawaran diskon untuk pelanggan laundry.</p>

        <form action="{{ route('admin.promos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promo:</label>
                <input type="text" name="title" placeholder="Contoh: Diskon Merdeka Cuci Baju" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kupon:</label>
                <input type="text" name="code" placeholder="Contoh: MERDEKA" class="w-full px-3 py-2 border rounded-lg uppercase focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Diskon:</label>
                    <select name="type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rp)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Besar Nilai:</label>
                    <input type="number" step="0.01" name="value" placeholder="Contoh: 10 atau 5000" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi / Ketentuan:</label>
                <textarea name="description" rows="3" placeholder="Jelaskan syarat dan ketentuan promo..." class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Berlaku Sampai Tanggal:</label>
                <input type="date" name="expired_date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.promos.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">Batal</a>
                <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition">Simpan Promo</button>
            </div>
        </form>
    </div>
@endsection
