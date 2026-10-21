@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Tambah Layanan Baru') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200">
        <div class="mb-6 pb-4 border-b border-slate-100">
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Form Layanan Baru</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Masukkan detail paket layanan laundry dan harga tarif baru.</p>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Kategori Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="category" placeholder="Contoh: Kiloan / Satuan / Bedcover" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Nama Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="name" placeholder="Contoh: Cuci Kering Setrika Premium" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Estimasi Durasi Pengerjaan <span class="text-red-500">*</span></label>
                <input type="text" name="duration" placeholder="Contoh: 2 Hari / 1 Hari / 6 Jam" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Harga Tarif (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" placeholder="Contoh: 8000" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm font-bold" required min="0">
                </div>

                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Satuan Unit <span class="text-red-500">*</span></label>
                    <input type="text" name="unit" placeholder="Contoh: Kg / Pcs / Psg" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-2.5 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.services.index') }}" class="w-full sm:w-auto text-center bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="w-full sm:w-auto bg-sky-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sky-500 transition shadow-md shadow-sky-600/20">Simpan Layanan</button>
            </div>
        </form>
    </div>
@endsection
