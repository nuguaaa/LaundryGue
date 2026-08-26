@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pengaturan Informasi Website') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Informasi Halaman Depan</h1>
                <p class="text-gray-600 text-sm">Kelola jam operasional, alamat outlet, dan nomor WhatsApp yang tampil di website.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Jam Operasional -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Operasional:</label>
                <input type="text" name="operational_hours" value="{{ $settings['operational_hours'] ?? '' }}" placeholder="Contoh: Senin - Sabtu (08.00 - 20.00 WIB)" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>
                <p class="text-xs text-gray-400 mt-1">Teks bebas yang akan tampil di bagian kontak dan footer.</p>
            </div>

            <!-- Alamat Outlet -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Outlet Utama:</label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap outlet..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>{{ $settings['address'] ?? '' }}</textarea>
            </div>

            <!-- Nomor WhatsApp -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp Admin (Format: 62812...):</label>
                <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="6281220295876" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none font-mono" required>
                <p class="text-xs text-gray-400 mt-1">Tanpa awalan 0 atau +, langsung gunakan kode negara (contoh: 628123456789).</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="w-full bg-brand text-white py-3 rounded-lg font-bold hover:bg-sky-600 transition shadow-sm">
                    Simpan Perubahan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
