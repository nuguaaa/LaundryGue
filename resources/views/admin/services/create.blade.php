@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Tambah Layanan Baru</h1>
        <p class="text-gray-600 text-sm mb-6">Masukkan detail layanan laundry baru yang ingin ditambahkan.</p>

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <input type="text" name="category" placeholder="Contoh: Kiloan / Satuan / Sepatu" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Layanan:</label>
                <input type="text" name="name" placeholder="Contoh: Cuci Setrika Wangi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Durasi:</label>
                <input type="text" name="duration" placeholder="Contoh: 2 Hari" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp):</label>
                <input type="number" name="price" placeholder="Contoh: 6000" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Satuan:</label>
                <input type="text" name="unit" placeholder="Contoh: Kg / Psg / Pcs" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.services.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">Batal</a>
                <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition">Simpan Layanan</button>
            </div>
        </form>
    </div>
@endsection
