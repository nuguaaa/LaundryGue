@extends('layouts.frontend')

@section('content')
    <style>
        /* Animasi Slide Left saat buka web & Slide Right saat tutup */
        @keyframes promoSlideLeftIn {
            0% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes promoSlideRightOut {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(120%); opacity: 0; }
        }
        .anim-slide-left-in {
            animation: promoSlideLeftIn 0.55s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .anim-slide-right-out {
            animation: promoSlideRightOut 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Animasi Transisi Fade-In Otomatis untuk Seluruh Kartu Promo */
        .card-fade-out {
            opacity: 0 !important;
            transform: scale(0.96) !important;
            transition: opacity 0.35s ease-out, transform 0.35s ease-out !important;
        }
        .card-fade-in {
            opacity: 1 !important;
            transform: scale(1) !important;
            transition: opacity 0.45s ease-in, transform 0.45s ease-in !important;
        }
    </style>

    <!-- ======================================================== -->
    <!-- HERO SECTION DENGAN FOTO BACKGROUND TERANG, JERNIH & BERSIH -->
    <!-- ======================================================== -->
    <section class="relative overflow-hidden pt-12 md:pt-20 pb-20 md:pb-28 px-4 md:px-6 bg-gradient-to-b from-sky-50/70 via-white to-slate-50 text-slate-900 border-b border-sky-100/70" data-aos="fade-up">
        <!-- Layer Background Foto Laundry Asli yang Jelas Terlihat dengan Pencahayaan Terang -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ asset($settings['landing_hero_bg'] ?? 'img/hero/hero-bg.jpg') }}" alt="Infrastruktur Mesin Cuci Laundry Modern" 
                 class="w-full h-full object-cover object-center filter blur-[0.5px] scale-100 opacity-40 transition duration-700">
            <!-- Overlay Gradien Lembut Terang (Putih & Sky Blue Cerah) Menjaga Keterbacaan dan Kesan Higienis -->
            <div class="absolute inset-0 bg-gradient-to-b from-white/75 via-sky-50/60 to-white/95 backdrop-blur-[0.5px]"></div>
            <!-- Ambient Lighting Glow Terang -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-sky-200/50 rounded-full blur-[110px] pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-[450px] h-[350px] bg-blue-100/60 rounded-full blur-[100px] pointer-events-none"></div>
        </div>

        <div class="max-w-5xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/95 border border-sky-200 text-sky-700 text-[11px] md:text-xs font-bold uppercase px-4 py-2 rounded-full tracking-wider mb-6 md:mb-8 shadow-sm backdrop-blur-sm">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>{{ $settings['hero_badge'] ?? 'Standar Layanan Publik Terakreditasi A' }}</span>
            </div>

            <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-6 md:mb-8 leading-[1.15]">
                {{ $settings['hero_title'] ?? 'Infrastruktur Perawatan Pakaian' }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 via-blue-600 to-sky-700">{{ $settings['hero_subtitle_highlight'] ?? 'Profesional & Presisi' }}</span>
            </h1>

            <p class="text-base sm:text-lg md:text-xl text-slate-600 mb-8 md:mb-12 max-w-3xl mx-auto font-medium leading-relaxed px-2">
                {{ $settings['hero_description'] ?? 'Platform otomatisasi pengolahan tekstil dengan sterilisasi medis, pewarnaan terlindung, dan sistem pelacakan invoice digital secara instan.' }}
            </p>

            <!-- KOTAK CEK RESI / INVOICE MANDIRI (AJAX AKTIF) -->
            <div id="tracking" class="bg-white/95 backdrop-blur-xl p-6 sm:p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_20px_50px_rgba(14,165,233,0.12)] border border-sky-100 max-w-2xl mx-auto text-left relative transition duration-300 text-slate-900">
                <div class="flex items-center space-x-3.5 md:space-x-4 mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shadow-inner shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base md:text-lg font-bold text-slate-900">Konsol Pelacakan Resi Mandiri</h3>
                            <span class="bg-sky-100 text-sky-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Live AJAX</span>
                        </div>
                        <p class="text-[11px] md:text-xs text-slate-400">Verifikasi status pengerjaan secara real-time tanpa refresh</p>
                    </div>
                </div>

                <p class="text-xs text-slate-500 mb-5">Masukkan nomor invoice unik atau nomor WhatsApp yang Anda daftarkan saat mencuci.</p>

                <!-- Box Notifikasi Error AJAX -->
                <div id="trackOrderAjaxError" class="hidden mb-5 bg-red-50 border border-red-200 text-red-600 text-xs p-3.5 md:p-4 rounded-xl md:rounded-2xl font-semibold flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span id="trackOrderAjaxErrorText"></span>
                </div>

                @if(session('error'))
                    <div class="mb-5 bg-red-50 border border-red-100 text-red-600 text-xs p-3.5 md:p-4 rounded-xl md:rounded-2xl font-semibold flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form id="trackOrderForm" action="{{ route('track.order') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="invoice_code" id="trackInvoiceInput" placeholder="INV-2026-001 ATAU NO. WHATSAPP" required
                            class="w-full bg-slate-50 border border-slate-200/80 rounded-xl md:rounded-2xl pl-12 pr-4 py-3.5 md:py-4 text-base sm:text-sm font-mono uppercase text-slate-900 placeholder-slate-400 font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                    <button type="submit" id="trackSubmitBtn" class="bg-sky-600 hover:bg-sky-700 text-white px-6 md:px-8 py-3.5 md:py-4 rounded-xl md:rounded-2xl font-bold text-sm shadow-lg shadow-sky-600/30 transition-all duration-300 flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                        <span id="trackBtnText">Cek Status</span>
                        <svg id="trackBtnArrow" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <!-- CARD HASIL PELACAKAN AJAX SECARA INSTAN TANPA RELOAD -->
                <div id="ajaxTrackingResultCard" class="hidden mt-6 pt-6 border-t border-slate-100 animate-fade-in-up">
                    <div class="bg-gradient-to-br from-slate-50 via-white to-sky-50/40 text-slate-900 p-5 sm:p-6 rounded-2xl md:rounded-3xl shadow-lg border border-sky-100 relative overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-slate-200/80">
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-0.5" id="ajaxResInvoice">INV-0000</span>
                                <h4 class="text-base sm:text-lg font-black text-slate-900" id="ajaxResCustomer">Nama Pelanggan</h4>
                            </div>
                            <span id="ajaxResBadge" class="self-start sm:self-center px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider border">
                                Status Pesanan
                            </span>
                        </div>

                        <!-- Progress Steps Diagram -->
                        <div class="grid grid-cols-4 gap-2 my-5 text-center text-[10px] sm:text-xs font-bold" id="ajaxStepsContainer">
                            <div class="step-item p-2 rounded-xl bg-white border border-slate-200 text-slate-500 shadow-sm" id="step-diterima">
                                <div class="step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-slate-200 text-slate-700">1</div>
                                <span>Diterima</span>
                            </div>
                            <div class="step-item p-2 rounded-xl bg-white border border-slate-200 text-slate-500 shadow-sm" id="step-proses">
                                <div class="step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-slate-200 text-slate-700">2</div>
                                <span>Diproses</span>
                            </div>
                            <div class="step-item p-2 rounded-xl bg-white border border-slate-200 text-slate-500 shadow-sm" id="step-selesai">
                                <div class="step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-slate-200 text-slate-700">3</div>
                                <span>Siap Ambil</span>
                            </div>
                            <div class="step-item p-2 rounded-xl bg-white border border-slate-200 text-slate-500 shadow-sm" id="step-diambil">
                                <div class="step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-slate-200 text-slate-700">4</div>
                                <span>Selesai</span>
                            </div>
                        </div>

                        <!-- Rincian Biaya & Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-slate-200/80">
                            <div>
                                <span class="text-[10px] text-slate-500 uppercase font-bold tracking-wider block">Total Tagihan</span>
                                <span class="text-lg sm:text-xl font-black text-sky-600" id="ajaxResTotal">Rp 0</span>
                                <span class="text-[11px] text-slate-500 ml-1 font-semibold" id="ajaxResPaymentStatus">(Status Bayar)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="clearAjaxTracking()" class="px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                                    Tutup
                                </button>
                                <a id="ajaxResDetailBtn" href="#" class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-sky-600/25">
                                    <span>Lihat Detail Nota & QR</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- SECTION PROMO AKTIF (DENGAN BACKGROUND FOTO TEXTURE GELAP) -->
    <!-- ======================================================== -->
    @php
        $activePromos = isset($promos) ? $promos : collect();
        $promoList = $activePromos->values()->all();
    @endphp

    @if($activePromos->count() > 0)
    <section class="py-12 md:py-20 bg-gradient-to-b from-slate-50 via-sky-50/40 to-white text-slate-900 relative overflow-hidden border-t border-slate-200/70" data-aos="fade-up">
        <!-- Background Foto Promo Terang -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ asset($settings['landing_promo_bg'] ?? 'img/backgrounds/promo-bg.jpg') }}" alt="Promo Background" class="w-full h-full object-cover filter blur-[2px] opacity-25">
            <div class="absolute inset-0 bg-gradient-to-br from-white/85 via-sky-50/80 to-white/90"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 md:mb-14">
                <div>
                    <span class="inline-flex items-center gap-2 bg-sky-100 text-sky-700 text-[11px] md:text-xs font-bold uppercase px-3.5 py-1.5 rounded-full tracking-wider mb-3">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Penawaran Terbatas
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-900">Promo & Diskon Aktif Bulan Ini</h2>
                </div>
                <p class="text-slate-600 text-xs md:text-sm mt-3 md:mt-0 max-w-md">
                    Nikmati penawaran spesial hemat biaya perawatan pakaian berkala khusus untuk pelanggan setia maupun korporasi.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($activePromos as $promo)
                @php
                    $val = $promo->value;
                    $formattedVal = $promo->type === 'percentage' 
                        ? (is_numeric($val) ? rtrim(rtrim(number_format((float)$val, 2, '.', ''), '0'), '.') . '%' : $val . '%')
                        : (is_numeric($val) ? 'Rp ' . number_format((float)$val, 0, ',', '.') : 'Rp ' . $val);
                @endphp
                <div class="w-full bg-white border border-slate-200/90 rounded-2xl md:rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-sm hover:shadow-xl hover:border-sky-300 transition duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 bg-sky-600 text-white text-[10px] md:text-xs font-extrabold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider">
                        Diskon {{ $formattedVal }}
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center font-bold mb-5 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold mb-2 text-slate-900">{{ $promo->title ?? 'Promo Laundry' }}</h3>
                        <p class="text-xs md:text-sm text-slate-600 mb-4 leading-relaxed">{{ $promo->description ?? 'Manfaatkan diskon menarik untuk layanan cuci pakaian Anda.' }}</p>

                        @if(isset($promo->expired_date))
                        <div class="text-[11px] text-sky-700 font-medium mb-6 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Berlaku s/d: {{ \Carbon\Carbon::parse($promo->expired_date)->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex items-center justify-between mt-auto">
                        <span class="text-xs font-bold text-sky-700 font-mono tracking-wider bg-sky-50 px-2.5 py-1 rounded-lg border border-sky-200">KODE: {{ $promo->code ?? 'PROMO' }}</span>
                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin, saya ingin klaim promo ' . ($promo->title ?? '') . ' dengan Kode Kupon: ' . ($promo->code ?? '')) }}" target="_blank" class="bg-sky-600 hover:bg-sky-500 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-md shadow-sky-600/25">Klaim</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ======================================================== -->
    <!-- SECTION: KENAPA MEMILIH KAMI (DENGAN GAMBAR FOLDER GALLERY) -->
    <!-- ======================================================== -->
    <section class="py-16 md:py-24 bg-white border-t border-slate-100 overflow-hidden" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="text-left">
                    <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">{{ $settings['why_badge'] ?? 'Keunggulan Korporat' }}</span>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-4 md:mb-6 tracking-tight leading-tight">
                        {{ $settings['why_title'] ?? 'Mengapa Mempercayakan Pakaian Anda Kepada Kami?' }}
                    </h2>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8">
                        {{ $settings['why_description'] ?? 'Kami mengintegrasikan teknologi pembersihan modern bersuhu tinggi dengan perlakuan khusus demi menjaga serat kain tetap awet, steril, dan harum tahan lama.' }}
                    </p>

                    <div class="space-y-5 md:space-y-6">
                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">{{ $settings['why_1_title'] ?? 'Sterilisasi Anti-Bakteri 99.9%' }}</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">{{ $settings['why_1_desc'] ?? 'Setiap helai kain melalui proses uap panas bertekanan tinggi untuk membunuh kuman dan jamur secara tuntas.' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">{{ $settings['why_2_title'] ?? 'Pengerjaan Cepat & Tepat Waktu' }}</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">{{ $settings['why_2_desc'] ?? 'Didukung sistem manajemen operasional digital otomatis yang memantau progres laundry secara real-time.' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-slate-900 mb-1">{{ $settings['why_3_title'] ?? 'Garansi Kepuasan 100%' }}</h4>
                                <p class="text-xs md:text-sm text-slate-500 leading-relaxed">{{ $settings['why_3_desc'] ?? 'Jika ada noda yang belum bersih atau hasil kurang memuaskan, kami cuci ulang tanpa biaya tambahan.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GALERI FOTO FOLDER GALLERY (LOKAL & TERORGANISIR) -->
                <div class="grid grid-cols-2 gap-3.5 md:gap-4 relative mt-4 lg:mt-0">
                    <div class="absolute -top-10 -right-10 w-48 md:w-72 h-48 md:h-72 bg-sky-100 rounded-full blur-3xl -z-10"></div>
                    <div class="space-y-3.5 md:space-y-4">
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-48 sm:h-56 md:h-64 group">
                            <img src="{{ asset($settings['landing_why_1'] ?? 'img/gallery/mesin-cuci.jpg') }}" alt="Mesin Cuci Modern Industri LaundryGue" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-36 sm:h-40 md:h-44 group">
                            <img src="{{ asset($settings['landing_why_2'] ?? 'img/gallery/setrika.jpg') }}" alt="Setrika Uap Presisi Kain" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                    </div>
                    <div class="space-y-3.5 md:space-y-4 pt-6 sm:pt-8">
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-36 sm:h-40 md:h-44 group">
                            <img src="{{ asset($settings['landing_why_3'] ?? 'img/gallery/pakaian-rapi.jpg') }}" alt="Pakaian Rapi Lipatan Higienis" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded-2xl md:rounded-3xl shadow-lg border border-slate-100 h-48 sm:h-56 md:h-64 group">
                            <img src="{{ asset($settings['landing_why_4'] ?? 'img/gallery/tekstil.jpg') }}" alt="Perawatan Serat Tekstil Bersih" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3 CARD LAYANAN UTAMA -->
    <section class="py-16 md:py-24 bg-slate-50 border-t border-slate-100" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
                <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Katalog Unggulan</span>
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-3 md:mb-4 tracking-tight">Pilihan Kategori Layanan</h2>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8 px-2">Berikut adalah representasi layanan terbaik dari database kami.</p>

                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('frontend.services') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-sky-600 text-white px-6 md:px-8 py-3.5 md:py-4 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold shadow-xl shadow-slate-200 transition-all duration-300 transform hover:-translate-y-0.5">
                        <span>Lihat Semua Katalog Layanan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('frontend.services') }}#calculatorSection" class="inline-flex items-center gap-2 bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 px-5 md:px-7 py-3.5 md:py-4 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold transition-all duration-300">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Simulasi / Kalkulator Biaya</span>
                    </a>
                </div>
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
                        <p class="text-xs md:text-sm text-slate-500 mb-6 md:mb-8 leading-relaxed">{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh serat pakaian.' }}</p>
                    </div>
                    <div class="border-t border-slate-100 pt-5 md:pt-6 flex items-center justify-between">
                        <div>
                            <span class="text-base md:text-xl font-black text-sky-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            <span class="text-[11px] md:text-xs text-slate-400 font-semibold"> / {{ $service->unit ?? 'Kg' }}</span>
                        </div>
                        <button onclick="openModal('{{ addslashes($service->name) }}', 'Rp {{ number_format($service->price, 0, ',', '.') }}', '{{ $service->unit ?? 'Kg' }}', '{{ addslashes($service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.') }}', '{{ $service->category ?? 'Umum' }}', '{{ $service->duration ?? 'Sesuai Antrean' }}', {{ $service->price }})"
                            class="bg-slate-900 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md cursor-pointer flex items-center gap-1.5">
                            <span>Pilih</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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

    <!-- SECTION TESTIMONI PELANGGAN (10 TESTI TERATAS BERGERAK KE SAMPING) -->
    @if(isset($testimonials) && $testimonials->count() > 0)
    <section id="testimoni" class="py-16 md:py-24 bg-white border-t border-slate-100 overflow-hidden" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 md:px-6 mb-8 md:mb-10 text-center">
            <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Ulasan Pengguna Terverifikasi</span>
            <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-3 md:mb-4 tracking-tight">Apa Kata Pelanggan Setia Kami?</h2>
            <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-2xl mx-auto">Kepuasan dan aroma pakaian bersih Anda adalah prioritas utama standar kualitas layanan kami.</p>
        </div>

        <!-- Marquee Infinite Horizontal Track -->
        <div class="relative w-full overflow-hidden py-4 group">
            <div class="absolute left-0 top-0 bottom-0 w-12 sm:w-28 bg-gradient-to-r from-white via-white/80 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-12 sm:w-28 bg-gradient-to-l from-white via-white/80 to-transparent z-10 pointer-events-none"></div>

            <div class="flex gap-5 sm:gap-6 animate-marquee-infinite">
                @foreach($testimonials as $testi)
                <div class="w-80 sm:w-96 shrink-0 bg-slate-50 border border-slate-200/80 p-6 md:p-7 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:scale-[1.02]">
                    <div>
                        <div class="flex items-center gap-1.5 mb-4">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testi->rating)
                                        <svg class="w-4 h-4 text-amber-400 fill-amber-400 shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-slate-200 fill-slate-200 shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60">{{ $testi->rating }}.0</span>
                        </div>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6 font-medium line-clamp-3">"{{ $testi->message }}"</p>
                    </div>
                    <div class="border-t border-slate-200/60 pt-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm">{{ $testi->name }}</h4>
                            <span class="text-[11px] text-slate-400 font-medium">{{ $testi->role }}</span>
                        </div>
                        <div class="w-9 h-9 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs uppercase">
                            {{ substr($testi->name, 0, 2) }}
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Loop Duplikat (Infinite Marquee) -->
                @foreach($testimonials as $testi)
                <div class="w-80 sm:w-96 shrink-0 bg-slate-50 border border-slate-200/80 p-6 md:p-7 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:scale-[1.02]" aria-hidden="true">
                    <div>
                        <div class="flex items-center gap-1.5 mb-4">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testi->rating)
                                        <svg class="w-4 h-4 text-amber-400 fill-amber-400 shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-slate-200 fill-slate-200 shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60">{{ $testi->rating }}.0</span>
                        </div>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6 font-medium line-clamp-3">"{{ $testi->message }}"</p>
                    </div>
                    <div class="border-t border-slate-200/60 pt-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm">{{ $testi->name }}</h4>
                            <span class="text-[11px] text-slate-400 font-medium">{{ $testi->role }}</span>
                        </div>
                        <div class="w-9 h-9 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs uppercase">
                            {{ substr($testi->name, 0, 2) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-8 sm:mt-10" data-aos="fade-up">
            <a href="{{ route('frontend.testimonials') }}" 
               class="inline-flex items-center gap-2.5 bg-slate-900 hover:bg-sky-600 text-white px-7 sm:px-9 py-3.5 sm:py-4 rounded-2xl text-xs sm:text-sm font-bold shadow-xl shadow-slate-200 transition-all duration-300 transform hover:-translate-y-0.5 group">
                <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                <span>Lihat Seluruh Testimoni ({{ $totalTestimonials ?? $testimonials->count() }} Ulasan)</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>
    @endif

    <!-- ======================================================== -->
    <!-- SECTION KONTAK & LOKASI (DENGAN BACKGROUND FOTO TERANG) -->
    <!-- ======================================================== -->
    <section id="contact" class="py-16 md:py-24 bg-slate-50 border-t border-slate-200/80" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-sky-50/90 via-white to-blue-50/80 text-slate-900 rounded-[2rem] md:rounded-[3rem] p-6 sm:p-10 md:p-16 shadow-xl border border-sky-100 relative overflow-hidden">
                <!-- Background Foto Kontak & Layanan Terang -->
                <div class="absolute inset-0 -z-10 overflow-hidden">
                    <img src="{{ asset($settings['landing_contact_bg'] ?? 'img/backgrounds/contact-bg.jpg') }}" alt="Customer Service Laundry Background" class="w-full h-full object-cover filter blur-[2px] opacity-25">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/85 via-sky-50/80 to-white/90"></div>
                </div>

                <div class="absolute right-0 bottom-0 w-72 md:w-96 h-72 md:h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div>
                        <span class="text-sky-700 text-xs font-extrabold uppercase tracking-widest block mb-2 md:mb-3">Saluran Komunikasi</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 md:mb-4 tracking-tight">Hubungi Pusat Bantuan</h2>
                        <p class="text-slate-600 text-xs md:text-sm leading-relaxed mb-6 md:mb-8">
                            Tim manajemen operasional kami siap melayani pertanyaan seputar korporasi, kemitraan, atau kendala layanan Anda.
                        </p>

                        <div class="space-y-3.5 md:space-y-4 text-xs md:text-sm text-slate-700">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Jam Operasional: {{ $settings['operational_hours'] ?? 'Selasa - Minggu: 10.00 - 17.00 WIB' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span>Outlet Utama: {{ $settings['address'] ?? 'Alamat belum diatur' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 md:p-8 rounded-2xl md:rounded-3xl border border-sky-100 shadow-md">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 mb-3 md:mb-4">Layanan Cepat WhatsApp</h3>
                        <p class="text-xs text-slate-600 mb-5 md:mb-6 leading-relaxed">Terhubung langsung dengan admin operasional untuk permintaan antar-jemput pakaian langsung ke lokasi Anda.</p>

                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin LaundryGue, saya ingin bertanya seputar layanan dan konsultasi antar-jemput pakaian.') }}" target="_blank" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-3.5 md:py-4 rounded-xl md:rounded-2xl text-xs md:text-sm flex items-center justify-center gap-3 transition shadow-lg shadow-sky-600/30">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>Buka Saluran WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- MODAL POP-UP DETAIL LAYANAN & FORMULIR LENGKAP ORDER WHATSAPP -->
    <!-- ======================================================== -->
    <div id="serviceModal" 
         onclick="closeModalOnBackdrop(event)"
         class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-950/70 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-3 sm:p-6"
         style="display: none;">
        
        <div id="modalContainer" 
             onclick="event.stopPropagation()"
             class="w-full max-w-xl bg-white rounded-3xl p-5 sm:p-8 text-left shadow-2xl transform scale-95 transition-all duration-300 relative my-auto border border-slate-100 max-h-[90vh] overflow-y-auto">
            
            <!-- Tombol Tutup Silang -->
            <button type="button" 
                    onclick="closeModal()" 
                    class="absolute top-4 right-4 sm:top-5 sm:right-5 w-9 h-9 bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 rounded-full flex items-center justify-center font-bold transition cursor-pointer z-10"
                    aria-label="Tutup Formulir Pesanan">
                ✕
            </button>

            <!-- Header Modal: Info Layanan Terpilih -->
            <div class="mb-5 pr-8 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                    <span id="modalCategoryBadge" class="bg-sky-50 text-sky-700 text-[10px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider border border-sky-100">Layanan</span>
                    <span id="modalDurationBadge" class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-1 rounded-full tracking-wider">Durasi</span>
                </div>
                <h3 id="modalTitle" class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">Nama Layanan</h3>
                <p id="modalDesc" class="text-xs text-slate-500 leading-relaxed mt-1">Deskripsi layanan akan muncul di sini.</p>
            </div>

            <!-- FORMULIR INPUT DATA PEMESAN LENGKAP -->
            <div class="space-y-4 mb-5">
                <div class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    <span>1. Data Pemesan & Pengantaran</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="orderCustName" placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-base sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor WhatsApp Anda <span class="text-red-500">*</span></label>
                        <input type="tel" id="orderCustPhone" placeholder="Contoh: 08123456789" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-base sm:text-sm font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Metode Penyerahan Cucian <span class="text-red-500">*</span></label>
                    <select id="orderCustMethod" onchange="toggleOrderAddressGroup()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-base sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                        <option value="Antar-Jemput ke Alamat (Pickup & Delivery)">Antar-Jemput ke Alamat Saya (Kurir Jemput)</option>
                        <option value="Antar Sendiri ke Outlet">Antar Sendiri ke Outlet Laundry</option>
                    </select>
                </div>

                <div id="orderAddressContainer">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700">Alamat Penjemputan & Patokan <span class="text-red-500">*</span></label>
                        <span class="text-[10px] text-sky-600 font-semibold flex items-center gap-1">
                            <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Deteksi Jarak Otomatis Aktif</span>
                        </span>
                    </div>
                    <textarea id="orderCustAddress" rows="2" placeholder="Tuliskan nama jalan, perumahan, kelurahan, atau patokan (contoh: Jl. Haji Gofur, Tanimulya, Cilame)..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-base sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition mb-2"></textarea>

                    <!-- Tombol Deteksi Cepat: Cek Alamat & GPS -->
                    <div class="flex items-center gap-2 mb-3">
                        <button type="button" id="orderCheckAddressBtn" onclick="autoDetectDistanceByAddress()" class="flex-1 inline-flex items-center justify-center gap-1.5 bg-sky-600 hover:bg-sky-500 text-white text-[11px] font-bold px-3 py-2 rounded-xl shadow-xs transition cursor-pointer">
                            <span id="orderCheckAddressIcon">🔍</span>
                            <span id="orderCheckAddressText">Cek Jarak Alamat Otomatis</span>
                        </button>
                        <button type="button" id="orderGpsBtn" onclick="detectOrderDistanceGps()" class="inline-flex items-center justify-center gap-1 bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-300 text-[11px] font-bold px-3 py-2 rounded-xl shadow-xs transition cursor-pointer">
                            <span id="orderGpsIcon">📍</span>
                            <span id="orderGpsText">Gunakan GPS</span>
                        </button>
                    </div>

                    <!-- Box Pengecekan Jarak Maksimal 5 KM -->
                    <div class="bg-gradient-to-r from-sky-50/80 via-white to-blue-50/60 border border-sky-200/80 rounded-2xl p-3.5 space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Radius Penjemputan (Maks. 5 KM)
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">Somawinata Cidahu #139</span>
                        </div>

                        <p class="text-[10px] text-slate-500 leading-relaxed">
                            Outlet kami beralamat di <strong>Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah</strong>. Layanan jemput pakaian melayani radius maksimal <strong>5 kilometer</strong>.
                        </p>

                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <input type="number" id="orderCustDistance" min="0.1" max="100" step="0.1" placeholder="Jarak terhitung otomatis..." oninput="validateOrderDistance()" class="w-full bg-white border border-slate-200 rounded-xl pl-3 pr-10 py-2 text-base sm:text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-2xs">
                                <span class="absolute right-3 top-2 text-xs font-bold text-slate-400">KM</span>
                            </div>
                        </div>

                        <!-- Notifikasi Live Status Jarak & Eksekusi -->
                        <div id="orderDistanceStatus" class="text-[11px] font-bold p-3 rounded-xl hidden transition-all duration-300"></div>
                    </div>
                </div>

                <div class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2 pt-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    <span>2. Rincian Cucian & Penawaran Diskon</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Jumlah / Berat Cucian -->
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80 flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-bold text-slate-700 uppercase">Perkiraan (<span id="modalUnitLabel">Kg</span>)</span>
                            <span id="modalUnitPrice" class="text-xs font-black text-sky-600">Rp 0</span>
                        </div>
                        <div class="inline-flex items-center bg-white border border-slate-300 rounded-lg overflow-hidden shadow-xs">
                            <button type="button" onclick="adjustModalQty(-1)" class="w-7 h-7 flex items-center justify-center font-black text-slate-600 hover:bg-slate-100 transition cursor-pointer">-</button>
                            <input type="number" id="modalQtyInput" value="1" min="0.5" step="0.5" oninput="calculateModalTotal()" class="w-12 text-center font-mono font-bold text-base sm:text-xs text-slate-900 border-x border-slate-200 focus:outline-none py-1">
                            <button type="button" onclick="adjustModalQty(1)" class="w-7 h-7 flex items-center justify-center font-black text-slate-600 hover:bg-slate-100 transition cursor-pointer">+</button>
                        </div>
                    </div>

                    <!-- Kupon Diskon Promo -->
                    <div>
                        <select id="modalOrderPromo" onchange="calculateModalTotal()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-3 text-base sm:text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                            <option value="" data-type="none" data-value="0">Tanpa Kupon Promo</option>
                            @foreach($activePromos as $p)
                                <option value="{{ $p->code }}" data-type="{{ $p->type }}" data-value="{{ $p->value }}">
                                    Kupon: {{ $p->code }} ({{ $p->type === 'percentage' ? rtrim(rtrim(number_format((float)$p->value, 2, '.', ''), '0'), '.').'%' : 'Rp '.number_format($p->value, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Catatan Khusus (Opsional)</label>
                    <input type="text" id="orderCustNotes" placeholder="Contoh: Baju putih dipisahkan, ekstra pewangi..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-base sm:text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                </div>
            </div>

            <!-- RINGKASAN BIAYA ESTIMASI -->
            <div class="bg-gradient-to-br from-sky-50/90 to-blue-50/70 p-4 rounded-2xl border border-sky-100 mb-5 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal Estimasi:</span>
                    <span id="modalSubtotalPrice" class="font-bold text-slate-900">Rp 0</span>
                </div>
                <div class="flex items-center justify-between text-emerald-600" id="modalDiscountRow">
                    <span>Potongan Diskon Promo:</span>
                    <span id="modalDiscountPrice" class="font-bold">-Rp 0</span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-sky-200 text-slate-900 font-extrabold text-sm sm:text-base">
                    <span>Total Perkiraan Biaya:</span>
                    <span id="modalTotalPrice" class="text-sky-600 text-lg sm:text-xl font-black">Rp 0</span>
                </div>
            </div>

            <!-- Pesan Validasi Error Merah -->
            <div id="modalOrderValidationAlert" class="hidden mb-4 bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded-xl font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span id="modalOrderValidationText">Mohon lengkapi formulir terlebih dahulu!</span>
            </div>

            <!-- Tombol Aksi Modal -->
            <div class="flex flex-col sm:flex-row gap-2.5">
                <button type="button" onclick="closeModal()" class="w-full sm:w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-xl font-bold text-xs transition text-center cursor-pointer">
                    Batal
                </button>
                <button type="button" id="modalSubmitOrderBtn" onclick="submitOrderToWhatsApp()" class="w-full sm:w-2/3 bg-emerald-600 hover:bg-emerald-500 text-white py-3.5 rounded-xl font-bold text-xs sm:text-sm text-center transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Kirim Pesanan ke WhatsApp</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- FLOATING PROMO POP-UP TERBARU (SLIDE LEFT BUKA, SLIDE RIGHT TUTUP, AUTO FADE-IN) -->
    <!-- ======================================================== -->
    @php
        $latestPromo = $activePromos->where('expired_date', '>=', now()->toDateString())->sortByDesc('id')->first() 
                       ?? $activePromos->sortByDesc('id')->first();
        if ($latestPromo) {
            $promoVal = $latestPromo->value;
            $formattedDiscount = $latestPromo->type === 'percentage'
                ? (is_numeric($promoVal) ? rtrim(rtrim(number_format((float)$promoVal, 2, '.', ''), '0'), '.') . '%' : $promoVal . '%')
                : (is_numeric($promoVal) ? 'Rp ' . number_format((float)$promoVal, 0, ',', '.') : 'Rp ' . $promoVal);
        }
    @endphp

    @if($latestPromo && count($promoList) > 0)
        <!-- Pop Up Dialog Promo Interaktif Terang: Bergerak sebagai Satu Kartu Utuh -->
        <div id="latestPromoNotification" 
             data-promo-id="{{ $latestPromo->id }}"
             onmouseenter="pausePromoRotation()"
             onmouseleave="resumePromoRotation()"
             class="fixed top-20 sm:top-24 right-4 left-4 sm:left-auto sm:right-6 z-40 sm:max-w-sm sm:w-96 bg-white/95 text-slate-900 backdrop-blur-2xl border border-sky-200 rounded-3xl shadow-[0_20px_60px_-15px_rgba(14,165,233,0.25)] ring-1 ring-slate-100 p-5 transition-all duration-300 transform opacity-0 translate-x-full pointer-events-none">
            
            <!-- Ambient Lighting Glow Orb Terang -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-sky-200/50 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Header Notifikasi: Badge & Tombol Tutup (Slide Right) -->
            <div class="flex items-center justify-between gap-2 mb-3.5 relative z-10">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-black uppercase tracking-wider shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>Promo Terbaru!</span>
                </div>

                <div class="flex items-center gap-2">
                    <span id="promoCurrentCounter" class="text-[10px] text-slate-400 font-mono font-bold tracking-wider">1/{{ count($promoList) }}</span>
                    <!-- Tombol Tutup Meluncur ke Kanan (Slide Right) -->
                    <button type="button" 
                            id="closePromoNotifBtn"
                            onclick="minimizePromoPopup()" 
                            class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition focus:outline-none cursor-pointer" 
                            title="Tutup & Geser ke Kanan"
                            aria-label="Tutup Notifikasi Promo">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Seluruh Tubuh Kartu Promo (Animasi Fade-In Otomatis) -->
            <div id="promoSlideCard" class="space-y-3 relative z-10 card-fade-in">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <img src="{{ asset($settings['site_logo'] ?? 'img/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain shrink-0">
                        <h4 id="promoTitleText" class="text-sm sm:text-base font-extrabold text-slate-900 leading-snug tracking-tight truncate">
                            {{ $latestPromo->title }}
                        </h4>
                    </div>
                    <span id="promoBadgeText" class="shrink-0 bg-gradient-to-r from-sky-600 to-blue-600 text-white text-[10px] sm:text-[11px] font-black px-2.5 py-0.5 rounded-lg uppercase tracking-wide shadow-md shadow-sky-600/20">
                        {{ $formattedDiscount ?? 'Promo' }}
                    </span>
                </div>

                <p id="promoDescText" class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                    {{ $latestPromo->description }}
                </p>

                <!-- Voucher Kode Kupon Box Interaktif -->
                <div class="bg-sky-50/80 border border-dashed border-sky-300 rounded-2xl p-2.5 flex items-center justify-between gap-2 mt-2 group hover:border-sky-500 transition">
                    <div class="min-w-0">
                        <span class="text-[9px] uppercase font-bold text-slate-500 block tracking-wider">Kupon Voucher</span>
                        <span class="font-mono font-black text-sky-700 text-xs sm:text-sm tracking-widest truncate block" id="promoCodeDisplay">{{ $latestPromo->code }}</span>
                    </div>
                    <button type="button" 
                            id="copyPromoBtn"
                            onclick="copyCurrentPromoCode()" 
                            class="shrink-0 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-500 hover:to-blue-500 text-white text-[11px] font-bold px-3 py-1.5 rounded-xl transition shadow-md shadow-sky-600/20 cursor-pointer flex items-center gap-1">
                        <i data-lucide="copy" class="w-3 h-3"></i>
                        <span id="copyPromoBtnLabel">Salin</span>
                    </button>
                </div>

                <!-- Footer Promo: Tanggal Expired & Tombol Klaim -->
                <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[11px] mt-1">
                    <span id="promoExpiryText" class="text-slate-500 flex items-center gap-1 text-[10px] sm:text-[11px]">
                        @if(isset($latestPromo->expired_date))
                            <i data-lucide="calendar" class="w-3 h-3 text-sky-600"></i>
                            <span>s/d {{ \Carbon\Carbon::parse($latestPromo->expired_date)->format('d M Y') }}</span>
                        @else
                            <i data-lucide="sparkles" class="w-3 h-3 text-amber-500"></i>
                            <span>Penawaran Terbatas</span>
                        @endif
                    </span>

                    <a id="promoClaimBtn" 
                       href="https://wa.me/{{ $settings['whatsapp'] ?? '6281220295876' }}?text={{ urlencode('Halo Admin, saya ingin klaim promo ' . $latestPromo->title . ' dengan Kode Kupon: ' . $latestPromo->code) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-600 hover:text-sky-700 transition group ml-auto">
                        <span>Klaim Sekarang</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

                <!-- Indikator Slide Dots Otomatis -->
                @if(count($promoList) > 1)
                <div class="flex items-center justify-center gap-1.5 pt-1" id="promoDotsContainer">
                    @foreach($promoList as $idx => $p)
                        <span class="promo-dot w-2 h-2 rounded-full transition-all duration-300 {{ $idx === 0 ? 'bg-sky-500 w-5' : 'bg-slate-200' }}"></span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Tombol Mengambang (Floating Reopen Badge) Ketika Pop Up Ditutup -->
        <button type="button" 
                id="floatingPromoBadge"
                onclick="restorePromoPopup()" 
                class="hidden fixed bottom-5 right-5 z-40 bg-gradient-to-r from-sky-600 via-sky-500 to-blue-600 hover:from-sky-500 hover:to-blue-500 text-white font-bold py-2.5 px-4 rounded-full shadow-2xl shadow-sky-600/50 flex items-center gap-2 text-xs border border-sky-300/40 transition-all duration-300 transform hover:scale-105 cursor-pointer animate-float-slow">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-300 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-400"></span>
            </span>
            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-300"></i>
            <span>Promo Aktif ({{ count($promoList) }})</span>
        </button>
    @endif

    <script>
    (function() {
        // Outlet Location: Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah, Kab. Bandung Barat
        const OUTLET_LAT = -6.8679;
        const OUTLET_LNG = 107.5273;
        const MAX_PICKUP_KM = 5.0;
        const WA_DESTINATION = "{{ $settings['whatsapp'] ?? '6281220295876' }}";

        // Database wilayah lokal sekitar outlet (Jl. Somawinata Cidahu #139, Tanimulya, Ngamprah)
        const LOCAL_AREAS = [
            { keys: ['somawinata', 'cidahu'], lat: -6.8679, lng: 107.5273, name: 'Jl. Somawinata / Cidahu (Sekitar Outlet)' },
            { keys: ['tanimulya', 'tani mulya'], lat: -6.8622, lng: 107.5295, name: 'Tanimulya, Ngamprah' },
            { keys: ['gadobangkong', 'gado bangkong'], lat: -6.8685, lng: 107.5180, name: 'Gadobangkong, Ngamprah' },
            { keys: ['cilame', 'haji gofur', 'h. gofur', 'h.gofur'], lat: -6.8580, lng: 107.5150, name: 'Cilame / Jl. H. Gofur, Ngamprah' },
            { keys: ['permata', 'permata cimahi'], lat: -6.8550, lng: 107.5300, name: 'Komplek Permata Cimahi' },
            { keys: ['puri cipageran', 'cipageran'], lat: -6.8520, lng: 107.5400, name: 'Cipageran, Cimahi Utara' },
            { keys: ['pakuhaji', 'paku haji'], lat: -6.8450, lng: 107.5250, name: 'Pakuhaji, Ngamprah' },
            { keys: ['ngamprah', 'mekarsari ngamprah'], lat: -6.8480, lng: 107.5020, name: 'Pusat Kec. Ngamprah' },
            { keys: ['alun-alun cimahi', 'alun alun cimahi', 'cimahi tengah', 'tagog'], lat: -6.8725, lng: 107.5420, name: 'Cimahi Tengah / Alun-alun' },
            { keys: ['cimahi', 'cibeber', 'padasuka'], lat: -6.8800, lng: 107.5400, name: 'Kota Cimahi' },
            { keys: ['cihanjuang'], lat: -6.8600, lng: 107.5650, name: 'Cihanjuang, Parongpong' },
            { keys: ['padalarang', 'kbp', 'kota baru parahyangan'], lat: -6.8390, lng: 107.4850, name: 'Padalarang' },
            { keys: ['batujajar'], lat: -6.9050, lng: 107.4950, name: 'Batujajar, Bandung Barat' },
            { keys: ['parongpong'], lat: -6.8250, lng: 107.5750, name: 'Parongpong, Bandung Barat' },
            { keys: ['lembang'], lat: -6.8150, lng: 107.6180, name: 'Lembang, Bandung Barat' },
            { keys: ['bandung', 'dago', 'sukajadi', 'buahbatu', 'kopo', 'soreang', 'cileunyi', 'antapani'], lat: -6.9175, lng: 107.6191, name: 'Kota Bandung / Sekitar' }
        ];

        let currentServiceUnitPrice = 0;
        let currentServiceName = '';
        let currentServiceCategory = 'Umum';
        let currentServiceDuration = 'Sesuai Antrean';
        let currentServiceUnit = 'Kg';
        let detectedGpsCoords = null;
        let addressDebounceTimer = null;

        // Hitung jarak Haversine (KM) antar 2 koordinat
        function calculateHaversineKm(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius bumi dalam KM
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // ==========================================
        // 1. DETAIL LAYANAN & FORMULIR ORDER WHATSAPP LENGKAP
        // ==========================================
        window.toggleOrderAddressGroup = function() {
            const methodElem = document.getElementById('orderCustMethod');
            const addrContainer = document.getElementById('orderAddressContainer');
            const submitBtn = document.getElementById('modalSubmitOrderBtn');
            if (!methodElem || !addrContainer) return;

            const isPickup = methodElem.value.includes('Antar-Jemput');
            if (isPickup) {
                addrContainer.classList.remove('hidden');
                window.validateOrderDistance();
            } else {
                addrContainer.classList.add('hidden');
                const statusElem = document.getElementById('orderDistanceStatus');
                if (statusElem) statusElem.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) btnSpan.textContent = 'Kirim Pesanan ke WhatsApp (Antar Sendiri)';
                }
            }
        };

        window.autoDetectDistanceByAddress = async function() {
            const addressInput = document.getElementById('orderCustAddress');
            const distInput = document.getElementById('orderCustDistance');
            const statusElem = document.getElementById('orderDistanceStatus');
            const btnText = document.getElementById('orderCheckAddressText');
            const btnIcon = document.getElementById('orderCheckAddressIcon');

            const rawAddr = (addressInput ? addressInput.value : '').trim();
            if (!rawAddr || rawAddr.length < 3) {
                if (statusElem) {
                    statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 block';
                    statusElem.innerHTML = '⚠️ Silakan ketik nama jalan, perumahan, atau kelurahan Anda pada kolom alamat di atas.';
                }
                addressInput?.focus();
                window.validateOrderDistance();
                return;
            }

            if (statusElem) {
                statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-sky-50 text-sky-700 border border-sky-200 flex items-center gap-2 block animate-pulse';
                statusElem.innerHTML = '<svg class="w-4 h-4 animate-spin text-sky-600 inline shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> <span>Menganalisis alamat & menghitung jarak ke outlet Somawinata...</span>';
            }
            if (btnText) btnText.textContent = 'Menganalisis...';
            if (btnIcon) btnIcon.textContent = '⏳';

            const lowerAddr = rawAddr.toLowerCase();

            // 1. Cek pencocokan lokal instan (Fast Local Resolution)
            let matchedLocation = null;
            for (const loc of LOCAL_AREAS) {
                if (loc.keys.some(k => lowerAddr.includes(k))) {
                    matchedLocation = loc;
                    break;
                }
            }

            let targetLat = null;
            let targetLng = null;
            let locationName = '';

            if (matchedLocation) {
                targetLat = matchedLocation.lat;
                targetLng = matchedLocation.lng;
                locationName = matchedLocation.name;
            } else {
                // 2. Query Nominatim geocoder jika belum cocok di database lokal
                try {
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 3500);

                    let query = encodeURIComponent(rawAddr + ', Bandung Barat, Jawa Barat');
                    let res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1&countrycodes=id`, {
                        signal: controller.signal
                    });
                    clearTimeout(timeoutId);

                    let results = await res.json().catch(() => []);
                    if (!results || results.length === 0) {
                        query = encodeURIComponent(rawAddr);
                        res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1&countrycodes=id`);
                        results = await res.json().catch(() => []);
                    }

                    if (results && results.length > 0) {
                        targetLat = parseFloat(results[0].lat);
                        targetLng = parseFloat(results[0].lon);
                        locationName = results[0].display_name;
                    }
                } catch (e) {
                    // Ignore network timeout
                }
            }

            if (btnText) btnText.textContent = 'Cek Jarak Alamat Otomatis';
            if (btnIcon) btnIcon.textContent = '🔍';

            if (targetLat && targetLng) {
                detectedGpsCoords = { lat: targetLat, lng: targetLng, name: locationName };
                const dist = calculateHaversineKm(OUTLET_LAT, OUTLET_LNG, targetLat, targetLng);
                const roundedDist = Math.round(dist * 10) / 10;
                if (distInput) {
                    distInput.value = roundedDist;
                }
                window.validateOrderDistance(locationName);
            } else {
                // Geocoder tidak menemukan titik spesifik
                if (statusElem) {
                    statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 block';
                    statusElem.innerHTML = `📍 <strong>Alamat dicatat:</strong> "${rawAddr}"<br>`
                        + `Peta digital belum mengenali titik spesifik. Klik <strong>"Gunakan GPS"</strong> untuk akurasi instan atau masukkan perkiraan KM manual.`;
                }
                window.validateOrderDistance();
            }
        };

        window.detectOrderDistanceGps = function() {
            const gpsBtn = document.getElementById('orderGpsBtn');
            const gpsText = document.getElementById('orderGpsText');
            const distInput = document.getElementById('orderCustDistance');

            if (!navigator.geolocation) {
                alert('Perangkat atau browser Anda tidak mendukung deteksi lokasi GPS. Silakan gunakan tombol Cek Jarak Alamat Otomatis.');
                return;
            }

            if (gpsText) gpsText.textContent = 'Mencari...';
            if (gpsBtn) gpsBtn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    if (gpsText) gpsText.textContent = 'GPS Terdeteksi';
                    if (gpsBtn) gpsBtn.disabled = false;

                    const userLat = pos.coords.latitude;
                    const userLng = pos.coords.longitude;
                    detectedGpsCoords = { lat: userLat, lng: userLng, name: 'Titik GPS Akurat Perangkat' };

                    const dist = calculateHaversineKm(OUTLET_LAT, OUTLET_LNG, userLat, userLng);
                    const rounded = Math.round(dist * 10) / 10;
                    if (distInput) {
                        distInput.value = rounded;
                    }
                    window.validateOrderDistance('Titik GPS Akurat Perangkat');
                },
                function(err) {
                    if (gpsText) gpsText.textContent = 'Gunakan GPS';
                    if (gpsBtn) gpsBtn.disabled = false;
                    alert('Gagal mendeteksi lokasi GPS: ' + (err.message || 'Izin akses lokasi ditolak') + '. Silakan gunakan tombol Cek Jarak Alamat Otomatis.');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        };

        window.validateOrderDistance = function(locationName) {
            const methodElem = document.getElementById('orderCustMethod');
            const distInput = document.getElementById('orderCustDistance');
            const statusElem = document.getElementById('orderDistanceStatus');
            const submitBtn = document.getElementById('modalSubmitOrderBtn');
            const isPickup = methodElem ? methodElem.value.includes('Antar-Jemput') : false;

            if (!isPickup) {
                if (statusElem) statusElem.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) btnSpan.textContent = 'Kirim Pesanan ke WhatsApp (Antar Sendiri)';
                }
                return true;
            }

            const rawVal = distInput ? distInput.value.trim() : '';
            const distVal = parseFloat(rawVal);

            if (!rawVal || isNaN(distVal) || distVal <= 0) {
                if (statusElem && !statusElem.classList.contains('bg-amber-50')) {
                    statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 block';
                    statusElem.innerHTML = '⚠️ Masukkan alamat dan klik <strong>"Cek Jarak Alamat Otomatis"</strong> atau <strong>"Gunakan GPS"</strong> (Batas radius penjemputan: 5 KM).';
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) btnSpan.textContent = '⚠️ Masukkan Alamat & Cek Jarak Terlebih Dahulu';
                }
                return false;
            }

            if (distVal > MAX_PICKUP_KM) {
                if (statusElem) {
                    statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-red-50 text-red-600 border border-red-200 block';
                    statusElem.innerHTML = `❌ <strong>Jarak Anda: ${distVal} KM (Melebihi Radius > 5 KM)</strong><br>`
                        + (locationName ? `<span class="text-[10px] text-slate-500 block mb-1">Lokasi terdeteksi: ${locationName}</span>` : '')
                        + `Maaf, penjemputan pakaian hanya melayani radius maksimal 5 km dari outlet kami (Jl. Somawinata Cidahu #139). Silakan ganti metode ke <strong>"Antar Sendiri ke Outlet"</strong> jika ingin mencuci di LaundryGue.`;
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) btnSpan.textContent = `❌ Di Luar Jangkauan (${distVal} KM > 5 KM) — Pilih Antar Sendiri`;
                }
                return false;
            } else {
                if (statusElem) {
                    statusElem.className = 'text-[11px] font-bold p-3 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 block';
                    statusElem.innerHTML = `✅ <strong>Jarak: ${distVal} KM (Dalam Jangkauan Penjemputan ✓)</strong><br>`
                        + (locationName ? `<span class="text-[10px] text-emerald-600 block mb-1">Lokasi: ${locationName}</span>` : '')
                        + `Alamat dalam jangkauan! Tombol eksekusi pemesanan di bawah siap dikirim.`;
                }
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) btnSpan.textContent = `Kirim Pesanan ke WhatsApp (Jarak ${distVal} KM ✓)`;
                }
                return true;
            }
        };

        function initAddressInputAutoDetect() {
            const addressInput = document.getElementById('orderCustAddress');
            if (addressInput) {
                addressInput.oninput = function() {
                    if (addressDebounceTimer) clearTimeout(addressDebounceTimer);
                    addressDebounceTimer = setTimeout(() => {
                        if (addressInput.value.trim().length >= 4) {
                            window.autoDetectDistanceByAddress();
                        }
                    }, 800);
                };
            }
        }
        initAddressInputAutoDetect();

        window.openModal = function(name, formattedPrice, unit, desc, category, duration, rawPrice) {
            currentServiceName = name;
            currentServiceUnitPrice = rawPrice || 0;
            currentServiceUnit = unit || 'Kg';
            currentServiceCategory = category || 'Layanan';
            currentServiceDuration = duration || 'Sesuai Antrean';

            const modal = document.getElementById('serviceModal');
            const modalContainer = document.getElementById('modalContainer');
            const modalTitle = document.getElementById('modalTitle');
            const modalCategoryBadge = document.getElementById('modalCategoryBadge');
            const modalDurationBadge = document.getElementById('modalDurationBadge');
            const modalDesc = document.getElementById('modalDesc');
            const modalUnitPrice = document.getElementById('modalUnitPrice');
            const modalUnitLabel = document.getElementById('modalUnitLabel');
            const modalQtyInput = document.getElementById('modalQtyInput');
            const modalValidationAlert = document.getElementById('modalOrderValidationAlert');
            const modalOrderPromo = document.getElementById('modalOrderPromo');
            const orderCustMethod = document.getElementById('orderCustMethod');
            const distInput = document.getElementById('orderCustDistance');

            if (modalTitle) modalTitle.innerText = name;
            if (modalCategoryBadge) modalCategoryBadge.innerText = currentServiceCategory;
            if (modalDurationBadge) modalDurationBadge.innerText = currentServiceDuration ? `Durasi: ${currentServiceDuration}` : 'Sesuai Antrean';
            if (modalDesc) modalDesc.innerText = desc || 'Layanan terstandarisasi dengan pembersihan menyeluruh.';
            if (modalUnitPrice) modalUnitPrice.innerText = `${formattedPrice} / ${currentServiceUnit}`;
            if (modalUnitLabel) modalUnitLabel.innerText = currentServiceUnit;
            if (modalQtyInput) modalQtyInput.value = 1;
            if (modalValidationAlert) modalValidationAlert.classList.add('hidden');

            if (modalOrderPromo) modalOrderPromo.selectedIndex = 0;
            if (orderCustMethod) orderCustMethod.selectedIndex = 0;
            if (distInput) distInput.value = '';
            detectedGpsCoords = null;

            window.toggleOrderAddressGroup();
            window.calculateModalTotal();

            // Kunci scroll halaman belakang
            document.body.style.overflow = 'hidden';

            if (modal) {
                modal.style.display = 'flex';
                setTimeout(() => {
                    modal.classList.remove('opacity-0', 'pointer-events-none');
                    if (modalContainer) {
                        modalContainer.classList.remove('scale-95');
                        modalContainer.classList.add('scale-100');
                    }
                }, 10);
            }
        };

        window.closeModal = function() {
            const modal = document.getElementById('serviceModal');
            const modalContainer = document.getElementById('modalContainer');

            if (modalContainer) {
                modalContainer.classList.remove('scale-100');
                modalContainer.classList.add('scale-95');
            }
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 250);
            }

            // Pulihkan scroll halaman utama
            document.body.style.overflow = '';
        };

        window.closeModalOnBackdrop = function(e) {
            const modal = document.getElementById('serviceModal');
            if (e.target === modal) {
                window.closeModal();
            }
        };

        window.adjustModalQty = function(delta) {
            const modalQtyInput = document.getElementById('modalQtyInput');
            if (!modalQtyInput) return;
            let val = parseFloat(modalQtyInput.value) || 1;
            val = Math.max(0.5, val + delta);
            modalQtyInput.value = val;
            window.calculateModalTotal();
        };

        window.calculateModalTotal = function() {
            const modalQtyInput = document.getElementById('modalQtyInput');
            const modalSubtotalPrice = document.getElementById('modalSubtotalPrice');
            const modalDiscountRow = document.getElementById('modalDiscountRow');
            const modalDiscountPrice = document.getElementById('modalDiscountPrice');
            const modalTotalPrice = document.getElementById('modalTotalPrice');
            const modalOrderPromo = document.getElementById('modalOrderPromo');

            const qty = Math.max(0.1, parseFloat(modalQtyInput ? modalQtyInput.value : 1) || 1);
            const subtotal = Math.round(qty * currentServiceUnitPrice);

            let discount = 0;
            let promoCode = '';
            if (modalOrderPromo && modalOrderPromo.selectedIndex > 0) {
                const opt = modalOrderPromo.options[modalOrderPromo.selectedIndex];
                promoCode = opt.value;
                const pType = opt.getAttribute('data-type');
                const pVal = parseFloat(opt.getAttribute('data-value')) || 0;
                if (pType === 'percentage') {
                    discount = Math.round((subtotal * pVal) / 100);
                } else {
                    discount = Math.round(pVal);
                }
            }

            const finalTotal = Math.max(0, subtotal - discount);

            if (modalSubtotalPrice) modalSubtotalPrice.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            if (modalDiscountPrice) modalDiscountPrice.innerText = '-Rp ' + discount.toLocaleString('id-ID');
            if (modalDiscountRow) {
                if (discount > 0) {
                    modalDiscountRow.classList.remove('hidden');
                } else {
                    modalDiscountRow.classList.add('hidden');
                }
            }
            if (modalTotalPrice) modalTotalPrice.innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');

            return { qty, subtotal, discount, promoCode, finalTotal };
        };

        window.submitOrderToWhatsApp = function() {
            const orderCustName = document.getElementById('orderCustName');
            const orderCustPhone = document.getElementById('orderCustPhone');
            const orderCustMethod = document.getElementById('orderCustMethod');
            const orderCustAddress = document.getElementById('orderCustAddress');
            const orderCustDistance = document.getElementById('orderCustDistance');
            const orderCustNotes = document.getElementById('orderCustNotes');
            const modalValidationAlert = document.getElementById('modalOrderValidationAlert');
            const modalValidationText = document.getElementById('modalOrderValidationText');

            const custName = (orderCustName ? orderCustName.value : '').trim();
            const custPhone = (orderCustPhone ? orderCustPhone.value : '').trim();
            const method = orderCustMethod ? orderCustMethod.value : 'Antar-Jemput ke Alamat';
            const isPickup = method.includes('Antar-Jemput');
            const address = (orderCustAddress ? orderCustAddress.value : '').trim();
            const notes = (orderCustNotes ? orderCustNotes.value : '').trim();
            const distVal = parseFloat(orderCustDistance ? orderCustDistance.value : 0);

            if (!custName) {
                if (modalValidationAlert && modalValidationText) {
                    modalValidationText.textContent = 'Silakan isi Nama Lengkap Anda terlebih dahulu!';
                    modalValidationAlert.classList.remove('hidden');
                }
                orderCustName?.focus();
                return;
            }

            if (isPickup) {
                if (!address) {
                    if (modalValidationAlert && modalValidationText) {
                        modalValidationText.textContent = 'Silakan masukkan alamat lengkap penjemputan cucian Anda!';
                        modalValidationAlert.classList.remove('hidden');
                    }
                    orderCustAddress?.focus();
                    return;
                }

                if (isNaN(distVal) || distVal <= 0) {
                    if (modalValidationAlert && modalValidationText) {
                        modalValidationText.textContent = 'Silakan masukkan estimasi jarak ke outlet atau gunakan tombol Deteksi GPS!';
                        modalValidationAlert.classList.remove('hidden');
                    }
                    orderCustDistance?.focus();
                    return;
                }

                if (distVal > MAX_PICKUP_KM) {
                    if (modalValidationAlert && modalValidationText) {
                        modalValidationText.textContent = `Maaf, jarak penjemputan Anda (${distVal} KM) melebihi batas maksimal 5 KM dari outlet!`;
                        modalValidationAlert.classList.remove('hidden');
                    }
                    return;
                }
            }

            if (modalValidationAlert) modalValidationAlert.classList.add('hidden');

            const { qty, subtotal, discount, promoCode, finalTotal } = window.calculateModalTotal();

            // Normalisasi nomor tujuan WhatsApp ke 6281220295876
            let targetWa = (WA_DESTINATION || '6281220295876').replace(/[^0-9]/g, '');
            if (targetWa.startsWith('0')) {
                targetWa = '62' + targetWa.slice(1);
            } else if (targetWa.startsWith('8')) {
                targetWa = '62' + targetWa;
            }
            if (!targetWa) targetWa = '6281220295876';

            // Susun teks pesan WhatsApp lengkap dan rapi
            let msg = `🧺 *PESANAN LAUNDRY BARU — LAUNDRYGUE*\n`
                + `=================================\n`
                + `👤 *DATA PEMESAN:*\n`
                + `• *Nama:* ${custName}\n`
                + `• *No. WhatsApp:* ${custPhone || '-'}\n`
                + `• *Metode:* ${method}\n`;

            if (isPickup) {
                msg += `• *Alamat Penjemputan:* ${address}\n`
                    + `• *Jarak ke Outlet:* ${distVal} KM (Maks. 5 KM)\n`;
                if (detectedGpsCoords) {
                    msg += `• *Titik GPS:* https://maps.google.com/?q=${detectedGpsCoords.lat},${detectedGpsCoords.lng}\n`;
                }
            } else {
                msg += `• *Lokasi Outlet Tujuan:* Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah\n`;
            }

            msg += `\n📋 *RINCIAN LAYANAN:*\n`
                + `• *Layanan:* ${currentServiceName}\n`
                + `• *Kategori:* ${currentServiceCategory}\n`
                + `• *Durasi:* ${currentServiceDuration}\n`
                + `• *Jumlah/Estimasi:* ${qty} ${currentServiceUnit}\n`
                + `• *Harga Satuan:* Rp ${currentServiceUnitPrice.toLocaleString('id-ID')} / ${currentServiceUnit}\n`;

            if (discount > 0 && promoCode) {
                msg += `• *Kupon Promo:* ${promoCode} (-Rp ${discount.toLocaleString('id-ID')})\n`;
            }

            msg += `---------------------------------\n`
                + `💰 *ESTIMASI TOTAL: Rp ${finalTotal.toLocaleString('id-ID')}*\n`
                + `---------------------------------\n`;

            if (notes) {
                msg += `📝 *Catatan Khusus:*\n${notes}\n\n`;
            } else {
                msg += `\n`;
            }

            msg += `Halo Admin LaundryGue, saya ingin memesan layanan laundry dengan rincian di atas. Mohon konfirmasi jadwal dan penjemputannya ya. Terima kasih!`;

            const waUrl = `https://wa.me/${targetWa}?text=${encodeURIComponent(msg)}`;
            window.open(waUrl, '_blank');
            window.closeModal();
        };

        // Tutup modal dengan tombol Escape keyboard (bersihkan listener lama agar tidak menumpuk di SPA)
        if (window.__handleModalKeydown) {
            window.removeEventListener('keydown', window.__handleModalKeydown);
        }
        window.__handleModalKeydown = function(e) {
            if (e.key === 'Escape') {
                window.closeModal();
                if (typeof window.minimizePromoPopup === 'function') {
                    window.minimizePromoPopup();
                }
            }
        };
        window.addEventListener('keydown', window.__handleModalKeydown);


        // ==========================================
        // 2. AJAX LIVE ORDER TRACKING HANDLER
        // ==========================================
        const trackForm = document.getElementById('trackOrderForm');
        const trackErrBox = document.getElementById('trackOrderAjaxError');
        const trackErrText = document.getElementById('trackOrderAjaxErrorText');
        const trackBtn = document.getElementById('trackSubmitBtn');
        const trackBtnText = document.getElementById('trackBtnText');
        const trackBtnArrow = document.getElementById('trackBtnArrow');
        const trackInput = document.getElementById('trackInvoiceInput');
        const ajaxResultCard = document.getElementById('ajaxTrackingResultCard');

        if (trackForm) {
            trackForm.onsubmit = async function(e) {
                e.preventDefault();
                if (trackErrBox) trackErrBox.classList.add('hidden');
                if (trackBtn) trackBtn.disabled = true;
                if (trackBtnText) trackBtnText.textContent = 'Memeriksa...';
                if (trackBtnArrow) trackBtnArrow.classList.add('animate-spin');

                try {
                    const res = await fetch(trackForm.action, {
                        method: 'POST',
                        body: new FormData(trackForm),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json().catch(() => null);

                    if (res.ok && data && data.success && data.order) {
                        if (trackBtnText) trackBtnText.textContent = 'Mengarahkan...';
                        const targetUrl = data.redirect || (data.order && data.order.check_url) || ('/cek-pesanan/' + encodeURIComponent(data.order.invoice_code));
                        window.location.href = targetUrl;
                        return;
                    } else {
                        const msg = (data && data.message) ? data.message : 'Nomor nota / nomor WhatsApp tidak ditemukan. Periksa kembali ketikan Anda!';
                        if (trackErrText) trackErrText.textContent = msg;
                        if (trackErrBox) trackErrBox.classList.remove('hidden');
                        if (ajaxResultCard) ajaxResultCard.classList.add('hidden');
                        if (trackInput) {
                            trackInput.classList.add('border-red-400', 'ring-2', 'ring-red-200');
                            setTimeout(() => trackInput.classList.remove('border-red-400', 'ring-2', 'ring-red-200'), 3000);
                        }
                    }
                } catch (err) {
                    trackForm.submit();
                } finally {
                    if (trackBtn) trackBtn.disabled = false;
                    if (trackBtnText) trackBtnText.textContent = 'Cek Status';
                    if (trackBtnArrow) trackBtnArrow.classList.remove('animate-spin');
                }
            };
        }

        window.renderAjaxTrackingResult = function(order) {
            const invoiceElem = document.getElementById('ajaxResInvoice');
            const custElem = document.getElementById('ajaxResCustomer');
            const badgeElem = document.getElementById('ajaxResBadge');
            const totalElem = document.getElementById('ajaxResTotal');
            const payStatusElem = document.getElementById('ajaxResPaymentStatus');
            const detailBtn = document.getElementById('ajaxResDetailBtn');

            if (trackErrBox) trackErrBox.classList.add('hidden');
            if (invoiceElem) invoiceElem.innerText = order.invoice_code;
            if (custElem) custElem.innerText = order.customer_name;
            if (badgeElem) {
                badgeElem.innerText = order.status_label;
                badgeElem.className = `self-start sm:self-center px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider border ${order.status_badge}`;
            }
            if (totalElem) totalElem.innerText = order.formatted_total;
            if (payStatusElem) {
                payStatusElem.innerText = `(${order.payment_status})`;
                if (order.payment_status === 'Lunas') {
                    payStatusElem.className = 'text-[11px] text-emerald-600 ml-1 font-bold';
                } else {
                    payStatusElem.className = 'text-[11px] text-amber-600 ml-1 font-semibold';
                }
            }
            if (detailBtn) detailBtn.href = order.check_url;

            // Highlight Step Tracker
            const steps = ['step-diterima', 'step-proses', 'step-selesai', 'step-diambil'];
            const statusMap = {
                'Baru': 0,
                'Proses': 1,
                'Selesai': 2,
                'Diambil': 3
            };
            const currentStepIdx = statusMap[order.status] ?? 0;

            steps.forEach((stepId, idx) => {
                const stepElem = document.getElementById(stepId);
                if (!stepElem) return;
                const circle = stepElem.querySelector('.step-circle');
                if (idx <= currentStepIdx) {
                    stepElem.className = 'step-item p-2 rounded-xl bg-sky-50 text-sky-700 font-bold border border-sky-300 shadow-sm';
                    if (circle) circle.className = 'step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-sky-600 text-white font-bold';
                } else {
                    stepElem.className = 'step-item p-2 rounded-xl bg-white border border-slate-200 text-slate-500 shadow-sm';
                    if (circle) circle.className = 'step-circle w-6 h-6 mx-auto mb-1 rounded-full flex items-center justify-center text-[10px] bg-slate-200 text-slate-700';
                }
            });

            if (ajaxResultCard) {
                ajaxResultCard.classList.remove('hidden');
                ajaxResultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        };

        window.clearAjaxTracking = function() {
            const ajaxResultCard = document.getElementById('ajaxTrackingResultCard');
            const trackErrBox = document.getElementById('trackOrderAjaxError');
            const trackInput = document.getElementById('trackInvoiceInput');
            if (ajaxResultCard) ajaxResultCard.classList.add('hidden');
            if (trackErrBox) trackErrBox.classList.add('hidden');
            if (trackInput) {
                trackInput.value = '';
                trackInput.focus();
            }
        };

        if (window.location.hash === '#tracking' && trackInput) {
            setTimeout(() => {
                trackInput.focus();
            }, 300);
        }


        // ==========================================
        // 3. PROMO POP-UP (SLIDE LEFT BUKA, SLIDE RIGHT TUTUP, AUTO FADE-IN SELURUH KARTU)
        // ==========================================
        @if(count($promoList) > 0)
        const promosData = @json($promoList);
        let currentPromoIndex = 0;
        let isPromoHovered = false;
        if (window.__autoRotateTimer) {
            clearInterval(window.__autoRotateTimer);
            window.__autoRotateTimer = null;
        }

        function formatPromoDiscount(promo) {
            if (!promo) return 'Promo';
            const val = promo.value;
            if (promo.type === 'percentage') {
                return (parseFloat(val) % 1 === 0 ? parseInt(val) : parseFloat(val)) + '%';
            }
            return 'Rp ' + parseInt(val || 0).toLocaleString('id-ID');
        }

        function renderPromoContent(idx) {
            const p = promosData[idx];
            if (!p) return;

            const promoTitleText = document.getElementById('promoTitleText');
            const promoBadgeText = document.getElementById('promoBadgeText');
            const promoDescText = document.getElementById('promoDescText');
            const promoCodeDisplay = document.getElementById('promoCodeDisplay');
            const promoCurrentCounter = document.getElementById('promoCurrentCounter');
            const promoExpiryText = document.getElementById('promoExpiryText');
            const promoClaimBtn = document.getElementById('promoClaimBtn');

            if (promoTitleText) promoTitleText.textContent = p.title || 'Promo Menarik';
            if (promoBadgeText) promoBadgeText.textContent = 'Diskon ' + formatPromoDiscount(p);
            if (promoDescText) promoDescText.textContent = p.description || 'Gunakan kode kupon ini untuk memesan laundry hemat.';
            if (promoCodeDisplay) promoCodeDisplay.textContent = p.code || 'PROMO';
            if (promoCurrentCounter) promoCurrentCounter.textContent = `${idx + 1}/${promosData.length}`;

            if (promoExpiryText) {
                if (p.expired_date) {
                    const d = new Date(p.expired_date);
                    const formattedDate = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                    promoExpiryText.innerHTML = `<i data-lucide="calendar" class="w-3 h-3 text-sky-400"></i><span>s/d ${formattedDate}</span>`;
                } else {
                    promoExpiryText.innerHTML = `<i data-lucide="sparkles" class="w-3 h-3 text-amber-400"></i><span>Penawaran Terbatas</span>`;
                }
            }

            if (promoClaimBtn) {
                const claimMsg = encodeURIComponent(`Halo Admin LaundryGue, saya ingin klaim promo "${p.title}" dengan kode kupon: ${p.code}`);
                promoClaimBtn.href = `https://wa.me/${WA_DESTINATION}?text=${claimMsg}`;
            }

            // Update Dots
            const dots = document.querySelectorAll('.promo-dot');
            dots.forEach((dot, dotIdx) => {
                if (dotIdx === idx) {
                    dot.className = 'promo-dot w-5 h-2 rounded-full transition-all duration-300 bg-sky-500';
                } else {
                    dot.className = 'promo-dot w-2 h-2 rounded-full transition-all duration-300 bg-slate-200';
                }
            });

            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        function autoRotateNextPromo() {
            const promoSlideCard = document.getElementById('promoSlideCard');
            if (isPromoHovered || promosData.length <= 1 || !promoSlideCard) return;

            promoSlideCard.classList.remove('card-fade-in');
            promoSlideCard.classList.add('card-fade-out');

            setTimeout(() => {
                currentPromoIndex = (currentPromoIndex + 1) % promosData.length;
                renderPromoContent(currentPromoIndex);

                promoSlideCard.classList.remove('card-fade-out');
                promoSlideCard.classList.add('card-fade-in');
            }, 350);
        }

        function startAutoRotation() {
            if (promosData.length > 1 && !window.__autoRotateTimer) {
                window.__autoRotateTimer = setInterval(autoRotateNextPromo, 5000);
            }
        }

        window.pausePromoRotation = function() {
            isPromoHovered = true;
        };

        window.resumePromoRotation = function() {
            isPromoHovered = false;
        };

        window.showPromoPopupSlideLeft = function() {
            const promoPopup = document.getElementById('latestPromoNotification');
            if (!promoPopup) return;
            promoPopup.classList.remove('hidden', 'opacity-0', 'translate-x-full', 'pointer-events-none', 'anim-slide-right-out');
            promoPopup.classList.add('anim-slide-left-in', 'pointer-events-auto');
            startAutoRotation();
        };

        window.minimizePromoPopup = function() {
            const promoPopup = document.getElementById('latestPromoNotification');
            const promoFloatingBadge = document.getElementById('floatingPromoBadge');
            if (!promoPopup) return;
            promoPopup.classList.remove('anim-slide-left-in');
            promoPopup.classList.add('anim-slide-right-out', 'pointer-events-none');

            setTimeout(() => {
                promoPopup.classList.add('hidden', 'opacity-0', 'translate-x-full');
                promoPopup.classList.remove('anim-slide-right-out');
                if (promoFloatingBadge) {
                    promoFloatingBadge.classList.remove('hidden');
                }
            }, 450);
        };

        window.restorePromoPopup = function() {
            const promoFloatingBadge = document.getElementById('floatingPromoBadge');
            if (promoFloatingBadge) {
                promoFloatingBadge.classList.add('hidden');
            }
            window.showPromoPopupSlideLeft();
        };

        window.copyCurrentPromoCode = async function() {
            const p = promosData[currentPromoIndex];
            const copyPromoBtnLabel = document.getElementById('copyPromoBtnLabel');
            if (!p || !p.code) return;

            try {
                await navigator.clipboard.writeText(p.code);
                if (copyPromoBtnLabel) {
                    copyPromoBtnLabel.textContent = 'Tersalin!';
                    setTimeout(() => {
                        copyPromoBtnLabel.textContent = 'Salin';
                    }, 2000);
                }
            } catch (err) {
                if (copyPromoBtnLabel) copyPromoBtnLabel.textContent = p.code;
            }
        };

        function initHomePromo() {
            renderPromoContent(0);
            setTimeout(() => {
                window.showPromoPopupSlideLeft();
            }, 800);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHomePromo);
        } else {
            initHomePromo();
        }
        @endif
    })();
    </script>
@endsection
