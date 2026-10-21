@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Ubah Promo') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200">
        <div class="mb-6 pb-4 border-b border-slate-100">
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Ubah Data Promo</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Perbarui informasi diskon atau kupon promosi.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-600 text-xs sm:text-sm p-4 rounded-xl font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Judul Promo <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $promo->title) }}" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
                @error('title')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Kode Kupon <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $promo->code) }}" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl uppercase font-mono font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
                @error('code')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Tipe Diskon <span class="text-red-500">*</span></label>
                    <select name="type" id="promoTypeSelect" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm bg-white font-medium" required>
                        <option value="percentage" {{ old('type', $promo->type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('type', $promo->type) == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Besar Nilai <span class="text-red-500">*</span></label>
                    <input type="number" step="any" name="value" id="promoValueInput" value="{{ old('value', $promo->value) }}" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm font-bold" required min="1">
                    <p id="promoValueHelp" class="text-[11px] text-slate-500 mt-1 font-medium">Batas persentase diskon: 1% s/d 100%.</p>
                    @error('value')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Deskripsi / Ketentuan <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>{{ old('description', $promo->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Berlaku Sampai Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="expired_date" value="{{ old('expired_date', $promo->expired_date) }}" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
                @error('expired_date')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-2.5 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.promos.index') }}" class="w-full sm:w-auto text-center bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="w-full sm:w-auto bg-sky-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sky-500 transition shadow-md shadow-sky-600/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('promoTypeSelect');
            const valueInput = document.getElementById('promoValueInput');
            const valueHelp = document.getElementById('promoValueHelp');

            function updateValueRules() {
                if (!typeSelect || !valueInput) return;
                
                if (typeSelect.value === 'percentage') {
                    valueInput.min = '1';
                    valueInput.max = '100';
                    valueInput.placeholder = 'Contoh: 10 (1 - 100)';
                    if (valueHelp) {
                        valueHelp.textContent = 'Batas nilai persentase diskon: 1% s/d 100%.';
                    }
                    if (parseFloat(valueInput.value) > 100) {
                        valueInput.value = 100;
                    }
                } else {
                    valueInput.min = '1';
                    valueInput.removeAttribute('max');
                    valueInput.placeholder = 'Bebas, contoh: 5000, 15000, 50000';
                    if (valueHelp) {
                        valueHelp.textContent = 'Nominal rupiah bebas tanpa batas (contoh: 15.000).';
                    }
                }
            }

            typeSelect?.addEventListener('change', updateValueRules);

            valueInput?.addEventListener('input', function() {
                if (typeSelect?.value === 'percentage') {
                    const num = parseFloat(this.value);
                    if (num > 100) {
                        this.value = 100;
                    }
                }
            });

            // Jalankan saat pertama dimuat
            updateValueRules();
        });
    </script>
@endsection

