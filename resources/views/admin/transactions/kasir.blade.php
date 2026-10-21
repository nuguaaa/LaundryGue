@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Halaman Kasir (Input Pesanan)') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-slate-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 sm:pb-5 border-b border-slate-100">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Input Transaksi Kasir</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pilih layanan laundry dan terapkan promo diskon otomatis.</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3.5 py-2 rounded-xl text-xs font-bold hover:bg-slate-200 transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Pesanan Aktif</span>
            </a>
        </div>

        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admin.transactions.store') }}" method="POST" target="_blank" class="space-y-4 sm:space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Contoh: Siska Dewi" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">No. WhatsApp / Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="081234567890" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Pilih Layanan Laundry <span class="text-red-500">*</span></label>
                <select name="service_id" id="service_select" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-medium" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                            [{{ $service->category }}] {{ $service->name }} - Rp{{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Jumlah / Berat <span class="text-red-500">*</span></label>
                    <input type="number" step="0.1" name="quantity" id="qty_input" value="{{ old('quantity', 1) }}" placeholder="1" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none font-bold" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Pilih / Ketik Kode Promo</label>
                    <select id="promo_select" class="w-full px-3 py-2.5 sm:py-2 border border-slate-300 rounded-xl text-xs sm:text-sm bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none mb-2 font-medium">
                        <option value="">-- Pilih dari Promo Tersedia --</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->code }}">
                                {{ $promo->code }} ({{ $promo->type == 'percentage' ? $promo->value.'%' : 'Rp'.number_format($promo->value, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="promo_code" id="promo_code_input" value="{{ old('promo_code') }}" placeholder="Atau ketik kupon manual" class="w-full px-3.5 py-2.5 sm:py-2 border border-slate-300 rounded-xl text-xs sm:text-sm uppercase font-mono focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <!-- Kotak Kalkulator Total & Diskon Otomatis -->
            <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-2.5">
                <div class="flex justify-between text-xs sm:text-sm text-slate-500 font-medium">
                    <span>Subtotal Harga:</span>
                    <span id="subtotal_text" class="font-bold text-slate-700">Rp0</span>
                </div>
                <div class="flex justify-between text-xs sm:text-sm text-red-600 font-medium">
                    <span>Potongan Diskon Promo:</span>
                    <span id="discount_text" class="font-bold">-Rp0</span>
                </div>
                <div class="border-t border-slate-200 pt-3 flex justify-between items-center">
                    <span class="text-xs sm:text-sm font-extrabold text-slate-800 uppercase tracking-wider">Total Akhir Bayar:</span>
                    <span id="estimated_total" class="text-2xl sm:text-3xl lg:text-4xl font-black text-sky-600">Rp0</span>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-3.5 sm:py-4 rounded-2xl font-bold transition shadow-lg shadow-sky-600/20 text-sm sm:text-base flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Proses Transaksi & Cetak Nota
                </button>
            </div>
        </form>
    </div>

    <!-- Script Kalkulator & Daftar Promo (SPA Compatible) -->
    <script>
        function initKasirCalculator() {
            const serviceSelect = document.getElementById('service_select');
            const qtyInput = document.getElementById('qty_input');
            const promoSelect = document.getElementById('promo_select');
            const promoCodeInput = document.getElementById('promo_code_input');

            const subtotalText = document.getElementById('subtotal_text');
            const discountText = document.getElementById('discount_text');
            const estimatedTotal = document.getElementById('estimated_total');

            const promosList = [
                @foreach($promos as $promo)
                    {
                        code: "{{ strtolower($promo->code) }}",
                        type: "{{ $promo->type }}",
                        value: parseFloat("{{ $promo->value }}") || 0
                    },
                @endforeach
            ];

            function calculateTotal() {
                if (!serviceSelect || serviceSelect.selectedIndex < 0) return;
                const selectedServiceOption = serviceSelect.options[serviceSelect.selectedIndex];
                const price = parseFloat(selectedServiceOption?.getAttribute('data-price')) || 0;
                const qty = parseFloat(qtyInput?.value) || 0;
                const subtotal = price * qty;

                let discount = 0;
                const enteredCode = promoCodeInput?.value.trim().toLowerCase() || '';

                if (enteredCode !== '') {
                    const matchedPromo = promosList.find(p => p.code === enteredCode);
                    if (matchedPromo) {
                        if (matchedPromo.type === 'percentage') {
                            discount = (subtotal * matchedPromo.value) / 100;
                        } else {
                            discount = matchedPromo.value;
                        }
                    }
                }

                if (discount > subtotal) discount = subtotal;
                const finalTotal = subtotal - discount;

                if (subtotalText) subtotalText.innerText = 'Rp' + subtotal.toLocaleString('id-ID');
                if (discountText) discountText.innerText = '-Rp' + discount.toLocaleString('id-ID');
                if (estimatedTotal) estimatedTotal.innerText = 'Rp' + finalTotal.toLocaleString('id-ID');
            }

            promoSelect?.addEventListener('change', function() {
                if (promoCodeInput) {
                    promoCodeInput.value = this.value;
                }
                calculateTotal();
            });

            serviceSelect?.addEventListener('change', calculateTotal);
            qtyInput?.addEventListener('input', calculateTotal);
            promoCodeInput?.addEventListener('input', calculateTotal);

            calculateTotal();
        }

        initKasirCalculator();
        document.addEventListener('DOMContentLoaded', initKasirCalculator);
        window.addEventListener('app:spa-navigated', initKasirCalculator);
    </script>
@endsection
