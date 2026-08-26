@extends('layouts.frontend')

@section('title', 'Pusat Kontak & Lokasi — LaundryHub')

@section('content')
<div class="py-20 px-6 max-w-7xl mx-auto">
    <div class="max-w-4xl mx-auto bg-slate-900 text-white rounded-[3rem] p-8 md:p-16 shadow-2xl relative overflow-hidden">
        <div class="absolute right-0 bottom-0 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-sky-400 text-xs font-extrabold uppercase tracking-widest block mb-3">Saluran Komunikasi</span>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Hubungi Pusat Bantuan</h1>
                <p class="text-slate-400 text-sm leading-relaxed mb-8">
                    Tim manajemen operasional kami siap melayani pertanyaan seputar korporasi, kemitraan, atau kendala layanan Anda.
                </p>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Jam Operasional: {{ $settings['operational_hours'] ?? 'Selasa - Minggu (10.00 - 18.00 WIB)' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        <span>Outlet Utama: {{ $settings['address'] ?? 'Alamat belum diatur' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/80 p-8 rounded-3xl border border-slate-700/60 backdrop-blur-md">
                <h3 class="text-lg font-bold mb-4">Layanan Cepat WhatsApp</h3>
                <p class="text-xs text-slate-400 mb-6 leading-relaxed">Terhubung langsung dengan admin operasional untuk permintaan antar-jemput pakaian langsung ke lokasi Anda[cite: 14].</p>

                {{-- Tombol WhatsApp aktif dengan pesan otomatis --}}
                <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin LaundryHub, saya ingin bertanya seputar layanan dan konsultasi antar-jemput pakaian.') }}" target="_blank" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-4 rounded-2xl text-sm flex items-center justify-center gap-3 transition shadow-lg shadow-sky-600/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>Buka Saluran WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
