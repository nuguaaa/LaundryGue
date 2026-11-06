@extends('layouts.frontend')

@section('title', 'Pusat Kontak & Lokasi — LaundryGue')

@section('content')
<div class="py-12 sm:py-16 md:py-20 px-4 sm:px-6 max-w-7xl mx-auto space-y-10 sm:space-y-12">
    <div class="max-w-4xl mx-auto bg-gradient-to-br from-sky-50/90 via-white to-blue-50/80 text-slate-900 rounded-2xl sm:rounded-3xl md:rounded-[3rem] p-6 sm:p-10 md:p-16 shadow-xl border border-sky-100 relative overflow-hidden" data-aos="zoom-in">
        <!-- Background Foto Kontak dengan Efek Terang & Blur Halus -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="{{ asset('img/backgrounds/contact-bg.jpg') }}" alt="Customer Service Background" class="w-full h-full object-cover opacity-25 filter blur-[2px] scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-white/85 via-sky-50/80 to-white/90"></div>
        </div>

        <div class="absolute right-0 bottom-0 w-72 md:w-96 h-72 md:h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div>
                <span class="text-sky-700 text-xs font-extrabold uppercase tracking-widest block mb-2 sm:mb-3">Saluran Komunikasi</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 sm:mb-4 tracking-tight">Hubungi Pusat Bantuan</h1>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6 sm:mb-8">
                    Tim manajemen operasional LaundryGue siap melayani pertanyaan seputar pesanan, kemitraan, atau penjemputan pakaian Anda.
                </p>

                <div class="space-y-3.5 sm:space-y-4 text-xs sm:text-sm text-slate-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Jam Operasional: {{ $settings['operational_hours'] ?? 'Selasa - Minggu (10.00 - 18.00 WIB)' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        <span>Outlet Utama: {{ $settings['address'] ?? 'Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah, Kab. Bandung Barat' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl border border-sky-100 shadow-md text-slate-900">
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3">Layanan Cepat WhatsApp</h3>
                <p class="text-xs text-slate-600 mb-5 sm:mb-6 leading-relaxed">Terhubung langsung dengan admin operasional untuk permintaan antar-jemput pakaian langsung ke lokasi Anda.</p>

                {{-- Tombol WhatsApp aktif dengan pesan otomatis --}}
                <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin LaundryGue, saya ingin bertanya seputar layanan dan konsultasi antar-jemput pakaian.') }}" target="_blank" rel="noopener noreferrer" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-3.5 sm:py-4 rounded-xl sm:rounded-2xl text-xs sm:text-sm flex items-center justify-center gap-2.5 sm:gap-3 transition shadow-lg shadow-sky-600/30">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>Buka Saluran WhatsApp (0812-2029-5876)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- PETA LOKASI OUTLET INTERAKTIF -->
    <div class="max-w-4xl mx-auto bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-lg border border-slate-200" data-aos="fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div>
                <span class="text-sky-600 text-[11px] font-extrabold uppercase tracking-widest block mb-1">Titik Lokasi Outlet</span>
                <h2 class="text-lg sm:text-xl font-black text-slate-900">Peta & Rute Menuju Outlet LaundryGue</h2>
                <p class="text-xs text-slate-500">Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah, Bandung Barat (Radius Jemput Maksimal 5 KM)</p>
            </div>
            <a href="https://www.google.com/maps/search/?api=1&query=-6.8679,107.5273" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shrink-0">
                <span>Buka di Google Maps</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
        <div class="relative w-full h-72 sm:h-96 rounded-2xl overflow-hidden border border-slate-200 shadow-inner bg-slate-100">
            <iframe 
                src="https://www.google.com/maps?q=-6.8679,107.5273&hl=id&z=16&output=embed"
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta Lokasi LaundryGue Somawinata Cidahu #139">
            </iframe>
        </div>
    </div>
</div>
@endsection

