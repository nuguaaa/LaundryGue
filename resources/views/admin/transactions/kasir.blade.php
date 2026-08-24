@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Halaman Kasir Laundry') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-xl p-8 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Input Transaksi Kasir</h1>
                <p class="text-gray-600 text-sm">Pilih layanan dan terapkan promo diskon secara langsung.</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-gray-600 transition">
                &larr; Pesanan Aktif
            </a>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.transactions.store') }}" method="POST" target="_blank">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan:</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Contoh: Siska" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. WhatsApp / Telepon:</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="Contoh: 0812..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Layanan Laundry:</label>
                <select name="service_id" id="service_select" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                            [{{ $service->category }}] {{ $service->name }} - Rp{{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah / Berat:</label>
                    <input type="number" step="0.1" name="quantity" id="qty_input" value="{{ old('quantity', 1) }}" placeholder="1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pilih / Ketik Kode Promo:</label>
                    <select id="promo_select" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none mb-2">
                        <option value="">-- Pilih dari Daftar Promo --</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->code }}">
                                {{ $promo->code }} ({{ $promo->type == 'percentage' ? $promo->value.'%' : 'Rp'.number_format($promo->value, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="promo_code" id="promo_code_input" value="{{ old('promo_code') }}" placeholder="Atau ketik manual di sini" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand focus:outline-none">
                </div>
            </div>

            <!-- Kotak Kalkulator Total & Diskon Otomatis -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal:</span>
                    <span id="subtotal_text">Rp0</span>
                </div>
                <div class="flex justify-between text-sm text-red-600">
                    <span>Potongan Diskon:</span>
                    <span id="discount_text">-Rp0</span>
                </div>
                <div class="border-t pt-2 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-700 uppercase">Total Akhir Bayar:</span>
                    <span id="estimated_total" class="text-2xl font-black text-brand">Rp0</span>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="w-full bg-brand text-white py-3 rounded-lg font-bold hover:bg-sky-600 transition shadow-sm">
                    Proses & Simpan Pesanan Kasir
                </button>
            </div>
        </form>
    </div>

    <!-- Script Kalkulator & Daftar Promo -->
    <script>
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
            const selectedServiceOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = parseFloat(selectedServiceOption.getAttribute('data-price')) || 0;
            const qty = parseFloat(qtyInput.value) || 0;
            const subtotal = price * qty;

            let discount = 0;
            const enteredCode = promoCodeInput.value.trim().toLowerCase();

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

            subtotalText.innerText = 'Rp' + subtotal.toLocaleString('id-ID');
            discountText.innerText = '-Rp' + discount.toLocaleString('id-ID');
            estimatedTotal.innerText = 'Rp' + finalTotal.toLocaleString('id-ID');
        }

        promoSelect.addEventListener('change', function() {
            promoCodeInput.value = this.value;
            calculateTotal();
        });

        serviceSelect.addEventListener('change', calculateTotal);
        qtyInput.addEventListener('input', calculateTotal);
        promoCodeInput.addEventListener('input', calculateTotal);

        calculateTotal();
    </script>
@endsection
