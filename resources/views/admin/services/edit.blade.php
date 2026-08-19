@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Ubah Layanan</h1>
        <p class="text-gray-600 text-sm mb-6">Perbarui informasi layanan laundry.</p>

        <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <input type="text" name="category" value="{{ $service->category }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Layanan:</label>
                <input type="text" name="name" value="{{ $service->name }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Durasi:</label>
                <input type="text" name="duration" value="{{ $service->duration }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp):</label>
                <input type="number" name="price" value="{{ $service->price }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Satuan:</label>
                <input type="text" name="unit" value="{{ $service->unit }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.services.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">Batal</a>
                <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
