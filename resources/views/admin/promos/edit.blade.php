@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Ubah Promo</h1>
        <p class="text-gray-600 text-sm mb-6">Perbarui informasi diskon atau kupon.</p>

        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promo:</label>
                <input type="text" name="title" value="{{ $promo->title }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kupon:</label>
                <input type="text" name="code" value="{{ $promo->code }}" class="w-full px-3 py-2 border rounded-lg uppercase focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Besaran Diskon:</label>
                <input type="text" name="discount" value="{{ $promo->discount }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi / Ketentuan:</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>{{ $promo->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Berlaku Sampai Tanggal:</label>
                <input type="date" name="expired_date" value="{{ $promo->expired_date }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.promos.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">Batal</a>
                <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
