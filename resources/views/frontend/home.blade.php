@extends('layouts.frontend')

@section('content')
    <!-- HERO SECTION & TRACKING MANDIRI -->
    <section class="relative overflow-hidden pt-12 md:pt-20 pb-20 md:pb-32 px-4 md:px-6">
        <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-sky-100/60 rounded-full blur-[100px] md:blur-[140px] -z-10 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-indigo-100/50 rounded-full blur-[100px] md:blur-[140px] -z-10 pointer-events-none"></div>

        <div class="max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-sky-50 border border-sky-100 text-sky-700 text-[11px] md:text-xs font-bold uppercase px-3.5 py-2 rounded-full tracking-wider mb-6 md:mb-8 shadow-sm">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>Standar Layanan Publik Terakreditasi A</span>
            </div>

            <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-6 md:mb-8 leading-[1.15]">
                Infrastruktur Perawatan Pakaian <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-blue-700">Profesional & Presisi</span>
            </h1>

            <p class="text-base sm:text-lg md:text-xl text-slate-600 mb-8 md:mb-12 max-w-3xl mx-auto font-normal leading-relaxed px-2">
                Platform otomatisasi pengolahan tekstil dengan sterilisasi medis, pewarnaan terlindung, dan sistem pelacakan invoice digital secara instan.
            </p>

            <!-- KOTAK CEK RESI / INVOICE MANDIRI -->
            <div id="tracking" class="bg-white p-6 sm:p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_20px_50px_rgba(8,112,184,0.07)] border border-slate-100 max-w-2xl mx-auto text-left relative">
                <div class="flex items-center space-x-3.5 md:space-x-4 mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shadow-inner shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-bold text-slate-900">Konsol Pelacakan Resi Mandiri</h3>
                        <p class="text-[11px] md:text-xs text-slate-400">Verifikasi status pengerjaan secara real-time</p>
                    </div>
                </div>

                <p class="text-xs text-slate-500 mb-5">Masukkan nomor invoice unik transaksi Anda untuk menampilkan log tahapan pencucian.</p>

                @if(session('error'))
                    <div class="mb-5 bg-red-50 border border-red-100 text-red-600 text-xs p-3.5 md:p-4 rounded-xl md:rounded-2xl font-semibold flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('track.order') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="invoice_code" placeholder="CONTOH: INV-2026-001" required
                            class="w-full bg-slate-50 border border-slate-200/80 rounded-xl md:rounded-2xl pl-12 pr-4 py-3.5 md:py-4 text-xs md:text-sm font-mono uppercase text-slate-900 placeholder-slate-400 font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-6 md:px-8 py-3.5 md:py-4 rounded-xl md:rounded-2xl font-bold text-xs md:text-sm shadow-lg shadow-sky-600/30 transition-all duration-300 flex items-center justify-center gap-2 shrink-0">
                        <span>Cek Status</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- SECTION PROMO AKTIF -->
    @php
        $activePromos = isset($promos) ? $promos : collect();
    @endphp

    @if($activePromos->count() > 0)
    <section class="py-12 md:py-20 bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-72 md:w-96 h-72 md:h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 md:w-96 h-72 md:h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 md:mb-14">
                <div>
                    <span class="inline-flex items-center gap-2 bg-sky-500/20 text-sky-400 text-[11px] md:text-xs font-bold uppercase px-3.5 py-1.5 rounded-full tracking-wider mb-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Penawaran Terbatas
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight">Promo & Diskon Aktif Bulan Ini</h2>
                </div>
                <p class="text-slate-400 text-xs md:text-sm mt-3 md:mt-0 max-w-md">
                    Nikmati penawaran spesial hemat biaya perawatan pakaian berkala khusus untuk pelanggan setia maupun korporasi.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-6 md:gap-8">
                @foreach($activePromos as $promo)
                <div class="w-full sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.34rem)] max-w-md bg-slate-800/80 border border-slate-700/80 rounded-2xl md:rounded-3xl p-6 md:p-8 flex flex-col justify-between backdrop-blur-sm relative overflow-hidden group hover:border-sky-500 transition duration-300">
                    <div class="absolute top-0 right-0 bg-sky-600 text-white text-[10px] md:text-xs font-extrabold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider">
                        Diskon {{ $promo->value ?? 'Spesial' }}
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-sky-500/20 text-sky-400 rounded-2xl flex items-center justify-center font-bold mb-5 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold mb-2 text-white">{{ $promo->title ?? 'Promo Laundry' }}</h3>
                        <p class="text-xs md:text-sm text-slate-400 mb-4 leading-relaxed">{{ $promo->description ?? 'Manfaatkan diskon menarik untuk layanan cuci pakaian Anda.' }}</p>

                        @if(isset($promo->expired_date))
                        <div class="text-[11px] text-sky-300/80 font-medium mb-6 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Berlaku s/d: {{ $promo->expired_date }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-700/60 pt-4 flex items-center justify-between mt-auto">
                        <span class="text-xs font-bold text-sky-400 font-mono tracking-wider">KODE: {{ $promo->code ?? 'PROMO' }}</span>
                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin, saya ingin klaim promo ' . ($promo->title ?? '') . ' dengan Kode Kupon: ' . ($promo->code ?? '')) }}" target="_blank" class="bg-sky-600 hover:bg-sky-500 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-md shadow-sky-600/30">Klaim</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION: KENAPA MEMILIH KAMI -->
    <section class="py-16 md:py-24 bg-white border-t border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="text-left">
                    <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Keunggulan Korporat</span>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-4 md:mb-6 tracking-tight leading-tight">
                        Mengapa Mempercayakan Pakaian Anda Kepada Kami?
                    </h2>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8">
                        Kami mengintegrasikan teknologi pembersihan modern bersuhu tinggi dengan perlakuan khusus demi menjaga serat kain tetap awet, steril, dan harum tahan lama.
                    </p>

                    <div class="space-y-5 md:space-y-6">
                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">Sterilisasi Anti-Bakteri 99.9%</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Setiap helai kain melalui proses uap panas bertekanan tinggi untuk membunuh kuman dan jamur secara tuntas.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">Pengerjaan Cepat & Tepat Waktu</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Didukung sistem manajemen operasional digital otomatis yang memantau progres laundry secara real-time.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">Garansi Kepuasan 100%</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Jika ada noda yang belum bersih atau hasil kurang memuaskan, kami cuci ulang tanpa biaya tambahan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3.5 md:gap-4 relative mt-4 lg:mt-0">
                    <div class="absolute -top-10 -right-10 w-48 md:w-72 h-48 md:h-72 bg-sky-100 rounded-full blur-3xl -z-10"></div>
                    <div class="space-y-3.5 md:space-y-4">
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-48 sm:h-56 md:h-64">
                            <img src="https://images.unsplash.com/photo-1545173190-9f5ce75e7f59?auto=format&fit=crop&w=600&q=80" alt="Mesin Cuci" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-36 sm:h-40 md:h-44">
                            <img src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?auto=format&fit=crop&w=600&q=80" alt="Setrika" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                    </div>
                    <div class="space-y-3.5 md:space-y-4 pt-6 sm:pt-8">
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-36 sm:h-40 md:h-44">
                            <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&w=600&q=80" alt="Pakaian Rapi" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-48 sm:h-56 md:h-64">
                            <img src="https://images.unsplash.com/photo-1595349022551-6ebf5a8e1b6f?auto=format&fit=crop&w=600&q=80" alt="Tekstil" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3 CARD LAYANAN UTAMA -->
    <section class="py-16 md:py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
                <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Katalog Unggulan</span>
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-3 md:mb-4 tracking-tight">Pilihan Kategori Layanan</h2>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8 px-2">Berikut adalah representasi layanan terbaik dari database kami.</p>

                <a href="{{ route('frontend.services') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-sky-600 text-white px-6 md:px-8 py-3.5 md:py-4 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold shadow-xl shadow-slate-200 transition-all duration-300 transform hover:-translate-y-0.5">
                    <span>Lihat Semua Jenis Layanan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            @php
                $featuredServices = isset($services) ? $services->take(3) : collect();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse($featuredServices as $service)
                <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 border border-slate-200/70 shadow-sm hover:shadow-2xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5 md:mb-6">
                            <span class="w-10 h-10 md:w-12 md:h-12 bg-sky-50 text-sky-600 rounded-xl md:rounded-2xl flex items-center justify-center font-bold">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span class="bg-emerald-50 text-emerald-600 text-[10px] md:text-xs font-bold px-2.5 md:px-3 py-1 md:py-1.5 rounded-full uppercase tracking-wider">{{ $service->category ?? 'Umum' }}</span>
                        </div>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 mb-2 md:mb-3">{{ $service->name }}</h3>
                        <p class="text-xs md:text-sm text-slate-500 mb-6 md:mb-8 leading-relaxed">{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.' }}</p>
                    </div>
                    <div class="border-t border-slate-100 pt-5 md:pt-6 flex items-center justify-between">
                        <div>
                            <span class="text-base md:text-xl font-black text-sky-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            <span class="text-[11px] md:text-xs text-slate-400 font-semibold"> / {{ $service->unit ?? 'Kg' }}</span>
                        </div>
                        <button onclick="openModal('{{ $service->name }}', 'Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit ?? 'Kg' }}', '{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.' }}')"
                            class="bg-slate-900 hover:bg-sky-600 text-white px-3.5 md:px-4 py-2 rounded-xl text-xs font-bold transition shadow-md">
                            Pilih
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm">
                    Belum ada data layanan di database.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION TESTIMONI PELANGGAN (DINAMIS DARI DATABASE) -->
    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="py-16 md:py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
                <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Ulasan Pengguna</span>
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-3 md:mb-4 tracking-tight">Apa Kata Pelanggan Setia Kami?</h2>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed">Kepuasan Anda adalah prioritas utama standar kualitas layanan kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($testimonials as $testi)
                <div class="bg-slate-50 border border-slate-200/70 p-6 md:p-8 rounded-2xl md:rounded-3xl shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-1 mb-4 text-yellow-400">
                            @for($i = 0; $i < $testi->rating; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 text-xs md:text-sm leading-relaxed mb-6">"{{ $testi->message }}"</p>
                    </div>
                    <div class="border-t border-slate-200/60 pt-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm md:text-base">{{ $testi->name }}</h4>
                            <span class="text-[11px] md:text-xs text-slate-400 font-medium">{{ $testi->role }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs uppercase">
                            {{ substr($testi->name, 0, 2) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION KONTAK & LOKASI (MENGGUNAKAN DATA SETTINGS) -->
    <section id="contact" class="py-16 md:py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="max-w-4xl mx-auto bg-slate-900 text-white rounded-[2rem] md:rounded-[3rem] p-6 sm:p-10 md:p-16 shadow-2xl relative overflow-hidden">
                <div class="absolute right-0 bottom-0 w-72 md:w-96 h-72 md:h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div>
                        <span class="text-sky-400 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Saluran Komunikasi</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-3 md:mb-4 tracking-tight">Hubungi Pusat Bantuan</h2>
                        <p class="text-slate-400 text-xs md:text-sm leading-relaxed mb-6 md:mb-8">
                            Tim manajemen operasional kami siap melayani pertanyaan seputar korporasi, kemitraan, atau kendala layanan Anda.
                        </p>

                        <div class="space-y-3.5 md:space-y-4 text-xs md:text-sm">
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

                    <div class="bg-slate-800/80 p-6 md:p-8 rounded-2xl md:rounded-3xl border border-slate-700/60 backdrop-blur-md">
                        <h3 class="text-base md:text-lg font-bold mb-3 md:mb-4">Layanan Cepat WhatsApp</h3>
                        <p class="text-xs text-slate-400 mb-5 md:mb-6 leading-relaxed">Terhubung langsung dengan admin operasional untuk permintaan antar-jemput pakaian langsung ke lokasi Anda.</p>

                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin LaundryHub, saya ingin bertanya seputar layanan dan konsultasi antar-jemput pakaian.') }}" target="_blank" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-3.5 md:py-4 rounded-xl md:rounded-2xl text-xs md:text-sm flex items-center justify-center gap-3 transition shadow-lg shadow-sky-600/30">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>Buka Saluran WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL POP-UP DETAIL LAYANAN -->
    <div id="serviceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-8 max-w-lg w-full mx-auto shadow-2xl transform scale-95 transition-transform duration-300 relative" id="modalContainer">
            <button onclick="closeModal()" class="absolute top-5 right-5 w-9 h-9 md:w-10 md:h-10 bg-slate-100 text-slate-500 hover:bg-slate-200 rounded-full flex items-center justify-center font-bold transition">
                ✕
            </button>

            <div class="mb-5 md:mb-6">
                <span class="bg-sky-50 text-sky-600 text-[10px] md:text-xs font-extrabold uppercase px-3 py-1.5 rounded-lg tracking-wider">Detail Pilihan Anda</span>
                <h3 id="modalTitle" class="text-xl md:text-2xl font-black text-slate-900 mt-2.5 md:mt-3">Nama Layanan</h3>
            </div>

            <p id="modalDesc" class="text-xs md:text-sm text-slate-600 leading-relaxed mb-5 md:mb-6">Deskripsi layanan akan muncul di sini.</p>

            <div class="bg-slate-50 p-3.5 md:p-4 rounded-xl md:rounded-2xl border border-slate-100 flex items-center justify-between mb-6 md:mb-8">
                <span class="text-[11px] md:text-xs text-slate-500 font-bold uppercase">Estimasi Tarif:</span>
                <span id="modalPrice" class="text-lg md:text-xl font-black text-sky-600">Rp 0</span>
            </div>

            <div class="flex gap-3">
                <button onclick="closeModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 md:py-3.5 rounded-xl md:rounded-2xl font-bold text-xs md:text-sm transition">
                    Tutup
                </button>
                <a id="modalWhatsAppBtn" href="#" target="_blank" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white py-3 md:py-3.5 rounded-xl md:rounded-2xl font-bold text-xs md:text-sm text-center transition shadow-lg shadow-emerald-600/20">
                    Pesan via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('serviceModal');
        const modalContainer = document.getElementById('modalContainer');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalPrice = document.getElementById('modalPrice');
        const modalWhatsAppBtn = document.getElementById('modalWhatsAppBtn');
        const waNumber = "{{ $settings['whatsapp'] ?? '6281220295876' }}";

        function openModal(name, price, desc) {
            modalTitle.innerText = name;
            modalPrice.innerText = price;
            modalDesc.innerText = desc;

            const waMessage = encodeURIComponent(`Halo Admin, saya tertarik untuk memesan layanan ${name} (${price}). Mohon info lebih lanjut.`);
            modalWhatsAppBtn.href = `https://wa.me/${waNumber}?text=${waMessage}`;

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContainer.classList.remove('scale-95');
            modalContainer.classList.add('scale-100');
        }

        function closeModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
        }

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection
