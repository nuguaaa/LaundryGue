@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Pengaturan Informasi Website') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200">
        <div class="mb-6 pb-5 border-b border-slate-100">
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Informasi Halaman Depan</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola jam operasional, alamat outlet utama, dan nomor kontak WhatsApp yang tampil di landing page website.</p>
        </div>

        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Jam Operasional -->
            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Jam Operasional <span class="text-red-500">*</span></label>
                <input type="text" name="operational_hours" value="{{ $settings['operational_hours'] ?? '' }}" placeholder="Contoh: Senin - Sabtu (08.00 - 20.00 WIB)" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-base sm:text-sm" required>
                <p class="text-[11px] text-slate-400 mt-1">Jadwal buka outlet yang ditampilkan di informasi kontak dan footer website.</p>
            </div>

            <!-- Alamat Outlet -->
            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Alamat Outlet Utama <span class="text-red-500">*</span></label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap outlet..." class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-base sm:text-sm" required>{{ $settings['address'] ?? '' }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Alamat fisik toko yang membantu pelanggan menemukan lokasi laundry.</p>
            </div>

            <!-- Nomor WhatsApp -->
            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Nomor WhatsApp Admin / CS <span class="text-red-500">*</span></label>
                <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="6281220295876" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none font-mono text-base sm:text-sm" required>
                <p class="text-[11px] text-slate-400 mt-1">Gunakan format internasional tanpa awalan + atau 0 (contoh: 6281234567890).</p>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white py-3.5 rounded-xl sm:rounded-2xl font-bold transition shadow-lg shadow-sky-600/20 text-sm">
                    Simpan Perubahan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection

