@extends('layouts.frontend')

@section('title', 'Katalog & Tarif Layanan — LaundryGue')

@section('content')
<div class="py-12 sm:py-16 md:py-20 px-4 sm:px-6 max-w-7xl mx-auto">
    <!-- Header & Search Bar -->
    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 pointer-events-auto">
        <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 sm:mb-3">Transparansi Finansial</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-3 sm:mb-4 tracking-tight">Katalog Layanan & Struktur Harga</h1>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6 sm:mb-8">Cari dan pilih jenis perawatan pakaian yang Anda butuhkan secara transparan.</p>

        <!-- Input Pencarian (Search Bar) -->
        <div class="relative max-w-lg mx-auto mb-6">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
            </span>
            <input type="text" id="searchService" placeholder="Cari jenis layanan..."
                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 sm:py-4 text-base sm:text-sm text-slate-900 placeholder-slate-400 font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm transition">
        </div>

        <!-- Tombol Kategori Dinamis dari Database -->
        @php
            $categories = isset($services) ? $services->pluck('category')->unique()->filter() : collect();
        @endphp

        <div class="flex flex-wrap justify-center gap-2" id="categoryButtons">
            <button type="button" onclick="window.filterCategory('all', this)" class="cat-btn bg-slate-900 text-white px-4 sm:px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                Semua Layanan
            </button>
            @foreach($categories as $cat)
            <button type="button" onclick="window.filterCategory('{{ strtolower($cat) }}', this)" class="cat-btn bg-white border border-slate-200 text-slate-600 hover:border-slate-400 px-4 sm:px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                {{ ucfirst($cat) }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- SECTION KALKULATOR SIMULASI BIAYA LAUNDRY TERANG -->
    <div id="calculatorSection" class="mb-14 bg-gradient-to-br from-sky-50/90 via-white to-blue-50/80 rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-10 text-slate-900 shadow-xl relative overflow-hidden border border-sky-100" data-aos="fade-up">
        <!-- Background Foto Kalkulator dengan Efek Terang & Blur Halus -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="{{ asset($settings['services_calc_bg'] ?? 'img/backgrounds/calculator-bg.jpg') }}" alt="Laundry calculation" class="w-full h-full object-cover filter blur-[2px] opacity-25 scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-white/85 via-sky-50/80 to-white/90"></div>
        </div>
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-200/80">
                <div>
                    <span class="inline-flex items-center gap-1.5 bg-sky-100 text-sky-700 text-[11px] font-bold uppercase px-3 py-1 rounded-full tracking-wider mb-2">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Fitur Interaktif
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">Kalkulator Estimasi Biaya Laundry</h2>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1">Hitung taksiran harga sebelum memesan dan dapatkan penawaran diskon promo.</p>
                </div>
                <div class="hidden sm:block text-right">
                    <span class="text-xs text-slate-500 block">Konsultasi Admin CS</span>
                    <span class="text-sm font-bold text-sky-600 font-mono">+{{ $settings['whatsapp'] ?? '6281220295876' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                <!-- Kolom Input Form (md:col-span-7) -->
                <div class="md:col-span-7 space-y-4">
                    <!-- Pilih Layanan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pilih Jenis Layanan</label>
                        <select id="calcServiceSelect" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium shadow-sm">
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}"
                                        data-price="{{ $srv->price }}"
                                        data-unit="{{ $srv->unit ?? 'Kg' }}"
                                        data-name="{{ $srv->name }}"
                                        data-duration="{{ $srv->duration ?? 'Sesuai Antrean' }}">
                                    [{{ $srv->category ?? 'Umum' }}] {{ $srv->name }} — Rp{{ number_format($srv->price, 0, ',', '.') }}/{{ $srv->unit ?? 'Kg' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Berat / Jumlah -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Berat / Jumlah (<span id="calcUnitLabel" class="text-sky-600 font-bold">Kg</span>)
                            </label>
                            <input type="number" id="calcQtyInput" step="0.1" min="0.1" value="1"
                                   class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm">
                        </div>

                        <!-- Pilih Voucher Promo -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kupon / Promo Diskon</label>
                            <select id="calcPromoSelect" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium shadow-sm">
                                <option value="" data-type="none" data-value="0">Tanpa Promo</option>
                                @if(isset($promos))
                                    @foreach($promos as $p)
                                        <option value="{{ $p->code }}" data-type="{{ $p->type }}" data-value="{{ $p->value }}">
                                            {{ $p->code }} ({{ $p->type == 'percentage' ? $p->value.'%' : 'Rp'.number_format($p->value, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Kolom Hasil Taksiran (md:col-span-5) -->
                <div class="md:col-span-5 bg-white border border-sky-100 rounded-2xl p-5 sm:p-6 flex flex-col justify-between shadow-md">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Rincian Perhitungan</span>
                        <div class="space-y-2 text-xs py-3 border-b border-slate-100">
                            <div class="flex justify-between text-slate-600">
                                <span>Harga Satuan:</span>
                                <span id="calcUnitPriceText" class="font-bold text-slate-900">Rp0</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal:</span>
                                <span id="calcSubtotalText" class="font-bold text-slate-900">Rp0</span>
                            </div>
                            <div class="flex justify-between text-emerald-600">
                                <span>Diskon Promo:</span>
                                <span id="calcDiscountText" class="font-bold">-Rp0</span>
                            </div>
                            <div class="flex justify-between text-sky-600">
                                <span>Estimasi Selesai:</span>
                                <span id="calcDurationText" class="font-bold">-</span>
                            </div>
                        </div>

                        <div class="pt-4 mb-4">
                            <span class="text-xs text-slate-500 uppercase tracking-wider font-bold block mb-1">Estimasi Total Biaya</span>
                            <div id="calcFinalPriceText" class="text-2xl sm:text-3xl font-black text-sky-600">Rp0</div>
                        </div>
                    </div>

                    <button type="button" id="calcWhatsAppBtn" onclick="openModalFromCalculator()"
                       class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-xl text-center text-xs sm:text-sm transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Pesan Cucian Ini via WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Kartu Layanan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" id="serviceGrid" data-aos="fade-up">
        @forelse($services as $service)
        @php
            $nameLower = strtolower($service->name);
            $serviceCat = strtolower($service->category ?? 'umum');
        @endphp
        <div class="service-card bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 border border-slate-200/70 shadow-sm hover:shadow-2xl transition duration-300 flex flex-col justify-between"
             data-name="{{ $nameLower }}" data-category="{{ $serviceCat }}">
            <div>
                <div class="flex items-center justify-between mb-5 sm:mb-6">
                    <span class="w-11 h-11 sm:w-12 sm:h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center font-bold">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                    <span class="bg-emerald-50 text-emerald-600 text-[11px] sm:text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $service->category ?? 'Umum' }}</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mb-2 sm:mb-3">{{ $service->name }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 sm:mb-8 leading-relaxed">{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.' }}</p>
            </div>
            <div class="border-t border-slate-100 pt-5 sm:pt-6 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <span class="text-xl sm:text-2xl font-black text-sky-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    <span class="text-xs text-slate-400 font-semibold"> / {{ $service->unit ?? 'Kg' }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="selectForCalculator('{{ $service->id }}')"
                        class="bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1"
                        title="Hitung taksiran biaya">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Hitung</span>
                    </button>
                    <button onclick="openModal('{{ addslashes($service->name) }}', 'Rp {{ number_format($service->price, 0, ',', '.') }}', '{{ $service->unit ?? 'Kg' }}', '{{ addslashes($service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.') }}', '{{ $service->category ?? 'Umum' }}', '{{ $service->duration ?? 'Sesuai Antrean' }}', {{ $service->price }}, '{{ $service->id }}')"
                        class="bg-slate-900 hover:bg-sky-600 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-md cursor-pointer">
                        Detail
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div id="emptyMessage" class="col-span-full text-center py-16 sm:py-20 bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm">
            Belum ada data layanan yang dimasukkan ke dalam sistem.
        </div>
        @endforelse
    </div>

    <!-- Pesan jika pencarian tidak ditemukan -->
    <div id="noResult" class="hidden text-center py-16 sm:py-20 bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm mt-8">
        Layanan yang Anda cari tidak ditemukan.
    </div>
</div>

<!-- MODAL POP-UP DETAIL LAYANAN & FORMULIR LENGKAP ORDER WHATSAPP -->
<div id="serviceModal" 
     onclick="closeModalOnBackdrop(event)"
     class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-950/70 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-3 sm:p-6"
     style="display: none;">
    <div class="w-full max-w-xl bg-white rounded-3xl p-5 sm:p-8 text-left shadow-2xl transform scale-95 transition-all duration-300 relative my-auto border border-slate-100 max-h-[90vh] overflow-y-auto" id="modalContainer" onclick="event.stopPropagation()">
        
        <!-- Tombol Tutup Silang -->
        <button type="button" 
                onclick="closeModal()" 
                class="absolute top-4 right-4 sm:top-5 sm:right-5 w-9 h-9 sm:w-10 sm:h-10 bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 rounded-full flex items-center justify-center font-bold transition cursor-pointer z-10" 
                aria-label="Tutup Detail">
            ✕
        </button>

        <!-- Header Modal: Info Layanan Terpilih -->
        <div class="mb-5 pr-8 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                <span id="modalCategoryBadge" class="bg-sky-50 text-sky-700 text-[10px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider border border-sky-100">Layanan</span>
                <span id="modalDurationBadge" class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-1 rounded-full tracking-wider">Durasi</span>
            </div>
            <h2 id="modalTitle" class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">Nama Layanan</h2>
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

                    <!-- Notifikasi Live Status Jarak -->
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
                        @if(isset($promos))
                            @foreach($promos as $p)
                                <option value="{{ $p->code }}" data-type="{{ $p->type }}" data-value="{{ $p->value }}">
                                    Kupon: {{ $p->code }} ({{ $p->type === 'percentage' ? rtrim(rtrim(number_format((float)$p->value, 2, '.', ''), '0'), '.').'%' : 'Rp '.number_format($p->value, 0, ',', '.') }})
                                </option>
                            @endforeach
                        @endif
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

        <div class="flex flex-col sm:flex-row gap-2.5">
            <button type="button" onclick="closeModal()" class="w-full sm:w-1/4 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-xl font-bold text-xs transition text-center cursor-pointer">
                Tutup
            </button>
            <button type="button" id="modalCalcBtn" onclick="sendModalToCalculator()" class="w-full sm:w-1/4 bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 py-3 rounded-xl font-bold text-xs transition text-center cursor-pointer">
                Simulasi
            </button>
            <button type="button" id="modalSubmitOrderBtn" onclick="submitOrderToWhatsApp()" class="w-full sm:w-2/4 bg-emerald-600 hover:bg-emerald-500 text-white py-3.5 rounded-xl font-bold text-xs sm:text-sm text-center transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Pesan ke WhatsApp</span>
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    // Outlet Location: Jl. Somawinata cidahu No.139, Tanimulya, Ngamprah, Kab. Bandung Barat
    const OUTLET_LAT = -6.8679;
    const OUTLET_LNG = 107.5273;
    const MAX_PICKUP_KM = 5.0;
    const WA_DESTINATION = "{{ $settings['whatsapp'] ?? '6281220295876' }}";

    let currentCategory = 'all';
    let currentModalServiceId = '';
    let currentModalServiceName = '';
    let currentModalServiceCategory = 'Umum';
    let currentModalServiceDuration = 'Sesuai Antrean';
    let currentModalUnitPrice = 0;
    let currentModalUnit = 'Kg';
    let detectedGpsCoords = null;

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
    // 1. FILTER KATEGORI & PENCARIAN LAYANAN
    // ==========================================
    window.filterCategory = function(category, element) {
        currentCategory = (category || 'all').trim().toLowerCase();

        const searchInput = document.getElementById('searchService');
        if (searchInput && searchInput.value) {
            searchInput.value = '';
        }

        const catButtons = document.querySelectorAll('.cat-btn');
        catButtons.forEach(btn => {
            btn.classList.remove('bg-slate-900', 'text-white');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });

        if (element) {
            element.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            element.classList.add('bg-slate-900', 'text-white');
        }

        window.applyServiceFilters();

        if (window.AOS) {
            setTimeout(() => { try { window.AOS.refresh(); } catch(e){} }, 50);
        }
    };

    window.applyServiceFilters = function() {
        const searchInput = document.getElementById('searchService');
        const serviceCards = document.querySelectorAll('.service-card');
        const noResultDiv = document.getElementById('noResult');
        const term = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let matchCount = 0;

        serviceCards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').trim().toLowerCase();
            const category = (card.getAttribute('data-category') || '').trim().toLowerCase();

            const matchesSearch = !term || name.includes(term);
            const matchesCategory = (currentCategory === 'all' || category === currentCategory);

            if (matchesSearch && matchesCategory) {
                card.style.display = 'flex';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResultDiv) {
            if (matchCount === 0) {
                noResultDiv.classList.remove('hidden');
            } else {
                noResultDiv.classList.add('hidden');
            }
        }
    };

    function initSearchListener() {
        const searchInput = document.getElementById('searchService');
        if (searchInput) {
            searchInput.oninput = function() {
                window.applyServiceFilters();
            };
        }
    }
    initSearchListener();

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

    let addressDebounceTimer = null;

    // ==========================================
    // 2. TOGGLE ALAMAT & DETEKSI OTOMATIS JARAK ALAMAT (MAX 5 KM)
    // ==========================================
    window.toggleOrderAddressGroup = function() {
        const methodElem = document.getElementById('orderCustMethod');
        const addrContainer = document.getElementById('orderAddressContainer');
        const submitBtn = document.getElementById('modalSubmitOrderBtn') || document.getElementById('modalWhatsAppBtn');
        if (!methodElem || !addrContainer) return;

        const isPickup = methodElem.value.includes('Antar-Jemput');
        if (isPickup) {
            addrContainer.classList.remove('hidden');
            window.validateOrderDistance();
        } else {
            addrContainer.classList.add('hidden');
            // Jika antar sendiri ke outlet, jarak tidak membatasi
            const statusElem = document.getElementById('orderDistanceStatus');
            if (statusElem) statusElem.classList.add('hidden');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                const btnText = submitBtn.querySelector('span');
                if (btnText) btnText.textContent = 'Kirim Pesanan ke WhatsApp (Antar Sendiri)';
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
        const submitBtn = document.getElementById('modalSubmitOrderBtn') || document.getElementById('modalWhatsAppBtn');
        const isPickup = methodElem ? methodElem.value.includes('Antar-Jemput') : false;

        if (!isPickup) {
            if (statusElem) statusElem.classList.add('hidden');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                const btnText = submitBtn.querySelector('span');
                if (btnText) btnText.textContent = 'Kirim Pesanan ke WhatsApp (Antar Sendiri)';
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
                const btnText = submitBtn.querySelector('span');
                if (btnText) btnText.textContent = '⚠️ Masukkan Alamat & Cek Jarak Terlebih Dahulu';
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
                const btnText = submitBtn.querySelector('span');
                if (btnText) btnText.textContent = `❌ Di Luar Jangkauan (${distVal} KM > 5 KM) — Pilih Antar Sendiri`;
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
                const btnText = submitBtn.querySelector('span');
                if (btnText) btnText.textContent = `Kirim Pesanan ke WhatsApp (Jarak ${distVal} KM ✓)`;
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

    // ==========================================
    // 3. MODAL POP-UP DETAIL & FORM PEMESANAN
    // ==========================================
    window.openModal = function(name, formattedPrice, unit, desc, category, duration, rawPrice, serviceId) {
        currentModalServiceName = name;
        currentModalUnitPrice = rawPrice || 0;
        currentModalUnit = unit || 'Kg';
        currentModalServiceId = serviceId || '';
        currentModalServiceCategory = category || 'Layanan';
        currentModalServiceDuration = duration || 'Sesuai Antrean';

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
        if (modalCategoryBadge) modalCategoryBadge.innerText = currentModalServiceCategory;
        if (modalDurationBadge) modalDurationBadge.innerText = currentModalServiceDuration ? `Durasi: ${currentModalServiceDuration}` : 'Sesuai Antrean';
        if (modalDesc) modalDesc.innerText = desc || 'Layanan terstandarisasi dengan pembersihan menyeluruh.';
        if (modalUnitPrice) modalUnitPrice.innerText = `${formattedPrice} / ${currentModalUnit}`;
        if (modalUnitLabel) modalUnitLabel.innerText = currentModalUnit;
        if (modalQtyInput) modalQtyInput.value = 1;
        if (modalValidationAlert) modalValidationAlert.classList.add('hidden');

        if (modalOrderPromo) modalOrderPromo.selectedIndex = 0;
        if (orderCustMethod) orderCustMethod.selectedIndex = 0;
        if (distInput) distInput.value = '';
        detectedGpsCoords = null;

        window.toggleOrderAddressGroup();
        window.calculateModalTotal();

        // Kunci scrolling latar (hanya body, hindari html jumping)
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

        // Kembalikan scrolling halaman
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
        const subtotal = Math.round(qty * currentModalUnitPrice);

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

    // ==========================================
    // 4. SUBMIT PESANAN KE WHATSAPP 081220295876
    // ==========================================
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
            + `• *Layanan:* ${currentModalServiceName}\n`
            + `• *Kategori:* ${currentModalServiceCategory}\n`
            + `• *Durasi:* ${currentModalServiceDuration}\n`
            + `• *Jumlah/Estimasi:* ${qty} ${currentModalUnit}\n`
            + `• *Harga Satuan:* Rp ${currentModalUnitPrice.toLocaleString('id-ID')} / ${currentModalUnit}\n`;

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

        msg += `Halo Admin LaundryGue, saya ingin memesan layanan laundry dengan rincian formulir di atas. Mohon konfirmasi jadwal dan penjemputannya ya. Terima kasih!`;

        const waUrl = `https://wa.me/${targetWa}?text=${encodeURIComponent(msg)}`;
        window.open(waUrl, '_blank');
        window.closeModal();
    };

    window.openModalFromCalculator = function() {
        const calcServiceSelect = document.getElementById('calcServiceSelect');
        const calcQtyInput = document.getElementById('calcQtyInput');
        const calcPromoSelect = document.getElementById('calcPromoSelect');

        if (!calcServiceSelect || !calcServiceSelect.value) {
            alert('Silakan pilih jenis layanan di kalkulator terlebih dahulu!');
            calcServiceSelect?.focus();
            return;
        }

        const opt = calcServiceSelect.options[calcServiceSelect.selectedIndex];
        const name = opt.getAttribute('data-name');
        const price = parseFloat(opt.getAttribute('data-price')) || 0;
        const unit = opt.getAttribute('data-unit') || 'Kg';
        const duration = opt.getAttribute('data-duration') || 'Sesuai antrean';
        const qty = parseFloat(calcQtyInput ? calcQtyInput.value : 1) || 1;
        const promoCode = calcPromoSelect ? calcPromoSelect.value : '';

        window.openModal(name, 'Rp ' + price.toLocaleString('id-ID'), unit, 'Pemesanan melalui fitur kalkulator estimasi.', 'Kalkulator', duration, price, calcServiceSelect.value);

        const modalQtyInput = document.getElementById('modalQtyInput');
        const modalOrderPromo = document.getElementById('modalOrderPromo');
        if (modalQtyInput) modalQtyInput.value = qty;
        if (modalOrderPromo && promoCode) {
            modalOrderPromo.value = promoCode;
        }
        window.calculateModalTotal();
    };

    window.sendModalToCalculator = function() {
        window.closeModal();
        if (currentModalServiceId) {
            window.selectForCalculator(currentModalServiceId);
        }
        document.getElementById('calculatorSection')?.scrollIntoView({ behavior: 'smooth' });
    };

    // Re-bind Escape keydown listener dengan proteksi listener ganda SPA
    if (window.__handleModalKeydown) {
        window.removeEventListener('keydown', window.__handleModalKeydown);
    }
    window.__handleModalKeydown = function(e) {
        if (e.key === 'Escape') {
            window.closeModal();
        }
    };
    window.addEventListener('keydown', window.__handleModalKeydown);

    // ==========================================
    // 5. KALKULATOR ESTIMASI BIAYA
    // ==========================================
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(Math.round(amount));
    }

    window.calculateEstimate = function() {
        const calcServiceSelect = document.getElementById('calcServiceSelect');
        const calcQtyInput = document.getElementById('calcQtyInput');
        const calcPromoSelect = document.getElementById('calcPromoSelect');
        const calcUnitPriceText = document.getElementById('calcUnitPriceText');
        const calcSubtotalText = document.getElementById('calcSubtotalText');
        const calcDiscountText = document.getElementById('calcDiscountText');
        const calcDurationText = document.getElementById('calcDurationText');
        const calcFinalPriceText = document.getElementById('calcFinalPriceText');
        const calcUnitLabel = document.getElementById('calcUnitLabel');

        if (!calcServiceSelect) return;
        const selectedOpt = calcServiceSelect.options[calcServiceSelect.selectedIndex];

        if (!selectedOpt || !selectedOpt.value) {
            if (calcUnitPriceText) calcUnitPriceText.innerText = 'Rp0';
            if (calcSubtotalText) calcSubtotalText.innerText = 'Rp0';
            if (calcDiscountText) calcDiscountText.innerText = '-Rp0';
            if (calcDurationText) calcDurationText.innerText = '-';
            if (calcFinalPriceText) calcFinalPriceText.innerText = 'Rp0';
            if (calcUnitLabel) calcUnitLabel.innerText = 'Kg';
            return;
        }

        const price = parseFloat(selectedOpt.getAttribute('data-price')) || 0;
        const unit = selectedOpt.getAttribute('data-unit') || 'Kg';
        const duration = selectedOpt.getAttribute('data-duration') || 'Sesuai antrean';
        if (calcUnitLabel) calcUnitLabel.innerText = unit;

        let qty = parseFloat(calcQtyInput ? calcQtyInput.value : 1);
        if (isNaN(qty) || qty <= 0) qty = 1;

        const subtotal = price * qty;

        let discount = 0;
        if (calcPromoSelect) {
            const promoOpt = calcPromoSelect.options[calcPromoSelect.selectedIndex];
            if (promoOpt && promoOpt.value) {
                const pType = promoOpt.getAttribute('data-type');
                const pVal = parseFloat(promoOpt.getAttribute('data-value')) || 0;
                if (pType === 'percentage') {
                    discount = (subtotal * pVal) / 100;
                } else {
                    discount = pVal;
                }
            }
        }

        const finalPrice = Math.max(0, subtotal - discount);

        if (calcUnitPriceText) calcUnitPriceText.innerText = `Rp${formatRupiah(price)} / ${unit}`;
        if (calcSubtotalText) calcSubtotalText.innerText = `Rp${formatRupiah(subtotal)}`;
        if (calcDiscountText) calcDiscountText.innerText = discount > 0 ? `-Rp${formatRupiah(discount)}` : '-Rp0';
        if (calcDurationText) calcDurationText.innerText = duration;
        if (calcFinalPriceText) calcFinalPriceText.innerText = `Rp${formatRupiah(finalPrice)}`;
    };

    function initCalcListeners() {
        const calcServiceSelect = document.getElementById('calcServiceSelect');
        const calcQtyInput = document.getElementById('calcQtyInput');
        const calcPromoSelect = document.getElementById('calcPromoSelect');

        if (calcServiceSelect) calcServiceSelect.onchange = window.calculateEstimate;
        if (calcQtyInput) {
            calcQtyInput.oninput = window.calculateEstimate;
            calcQtyInput.onchange = window.calculateEstimate;
        }
        if (calcPromoSelect) calcPromoSelect.onchange = window.calculateEstimate;
    }
    initCalcListeners();

    window.selectForCalculator = function(serviceId) {
        const calcServiceSelect = document.getElementById('calcServiceSelect');
        if (!calcServiceSelect) return;
        calcServiceSelect.value = serviceId;
        window.calculateEstimate();
        const calcElem = document.getElementById('calculatorSection');
        if (calcElem) {
            calcElem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };

    // Jalankan kalkulasi awal
    window.calculateEstimate();

    // Re-bind listeners jika di-load melalui event navigasi SPA (hindari duplikasi listener)
    if (window.__servicesSpaNavigated) {
        window.removeEventListener('spa:navigated', window.__servicesSpaNavigated);
    }
    window.__servicesSpaNavigated = function() {
        initSearchListener();
        initCalcListeners();
        initAddressInputAutoDetect();
        window.calculateEstimate();
    };
    window.addEventListener('spa:navigated', window.__servicesSpaNavigated);
})();
</script>
@endsection
