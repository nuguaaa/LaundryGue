@extends('layouts.frontend')

@section('title', 'Kirim Ulasan & Testimoni Pelanggan — LaundryGue')

@section('content')
<div class="relative py-12 md:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[85vh] flex items-center justify-center">
    <!-- Ambient Blur Background -->
    <div class="absolute top-1/4 right-1/4 w-80 sm:w-96 h-80 sm:h-96 bg-sky-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-72 sm:w-80 h-72 sm:h-80 bg-blue-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="max-w-xl w-full mx-auto" data-aos="zoom-in" data-aos-duration="600">
        <!-- Logo & Header Card -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-white shadow-xl shadow-slate-100 border border-slate-100 mb-4 group hover:scale-105 transition duration-300">
                <img src="{{ asset('img/logo.png') }}" alt="LaundryGue Logo" class="w-14 h-14 sm:w-16 sm:h-16 object-contain">
            </div>
            
            <div class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 text-[11px] font-bold px-3 py-1 rounded-full border border-sky-200 mb-3">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-sky-600"></i>
                <span>Tautan Khusus Pelanggan (Sekali Pakai)</span>
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                Kirim Ulasan & Testimoni
            </h1>
        </div>

        <!-- Basa-Basi Ramah Personal (Jika ada nama pelanggan dari data pesanan) -->
        @if(!empty($tokenModel->customer_name))
            <div class="bg-gradient-to-br from-sky-50 via-white to-blue-50 border border-sky-200/80 rounded-3xl p-5 sm:p-6 mb-6 shadow-sm relative overflow-hidden" data-aos="fade-up">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-sky-200/30 rounded-full blur-xl pointer-events-none"></div>
                <div class="flex items-start gap-3.5 sm:gap-4 relative z-10">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-sky-500/25 text-xl font-bold">
                        👋
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-base sm:text-lg font-black text-slate-900">
                            Hai, <span class="text-sky-600">{{ $tokenModel->customer_name }}</span>!
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Gimana hasil cucian kamu di <strong>LaundryGue</strong>? Pakaiannya bersih, wangi segar, dan rapi sesuai harapanmu kan?
                        </p>
                        <p class="text-xs text-slate-500 leading-relaxed pt-1">
                            Bantu kami dengan memilih bintang kepuasan dan tulis ulasan singkat pengalamanmu di bawah ini ya. Nama kamu sudah otomatis tercatat, jadi kamu <strong>tidak perlu mengetik nama lagi</strong>!
                        </p>
                    </div>
                </div>
            </div>
        @else
            <p class="text-xs sm:text-sm text-slate-600 text-center max-w-md mx-auto leading-relaxed mb-6">
                Pengalaman dan masukan berharga Anda membantu kami menjaga kualitas perawatan pakaian tetap prima dan berstandar tinggi.
            </p>
        @endif

        <!-- Alert Error Validasi -->
        @if($errors->any())
            <div class="mb-6 p-4 sm:p-5 bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm rounded-2xl font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Kartu Testimoni -->
        <div class="bg-white/95 backdrop-blur-xl border border-slate-200/80 rounded-3xl shadow-[0_20px_50px_rgba(8,112,184,0.06)] p-6 sm:p-8 md:p-10">
            <form action="{{ route('testimonial.store', ['token' => $tokenModel->token ?? request('token')]) }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $tokenModel->token ?? request('token') }}">

                <!-- Rating Bintang Interaktif (1 sampai 5) -->
                <div class="text-center pb-5 border-b border-slate-100">
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">
                        Rating Kepuasan Layanan <span class="text-red-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-400 mb-3">Klik bintang sesuai tingkat kepuasan hasil cucian Anda (1 s/d 5 bintang)</p>
                    
                    <div class="flex items-center justify-center gap-2 mb-2" id="starContainer">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    data-rating="{{ $i }}" 
                                    class="star-btn text-amber-400 hover:scale-125 transition-all p-1 focus:outline-none cursor-pointer" 
                                    title="Pilih {{ $i }} Bintang">
                                <svg class="w-9 h-9 sm:w-11 sm:h-11 fill-current transition-colors drop-shadow-sm" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                    <span id="ratingLabel" class="inline-block text-xs sm:text-sm font-bold text-amber-700 bg-amber-50 px-4 py-1.5 rounded-full border border-amber-200/60 shadow-sm mt-1">
                        ⭐⭐⭐⭐⭐ (Sangat Memuaskan)
                    </span>
                    @error('rating')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian Nama Pelanggan: Otomatis jika sudah ada data nama saat generate link -->
                @if(!empty($tokenModel->customer_name))
                    <input type="hidden" name="name" value="{{ $tokenModel->customer_name }}">
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200/80 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-black text-sm uppercase">
                                {{ substr($tokenModel->customer_name, 0, 2) }}
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Ulasan Dari Pelanggan</span>
                                <span class="text-sm font-bold text-slate-900">{{ $tokenModel->customer_name }}</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                            <span>Terverifikasi</span>
                        </span>
                    </div>
                @else
                    <!-- Fallback Input Nama (Jika token dibuat tanpa nama) -->
                    <div>
                        <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Rian Pratama" required
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Input Ulasan / Pesan Testimoni -->
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">
                        Ulasan & Testimoni Pengalaman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" rows="4" placeholder="Ceritakan bagaimana hasil cucian, aroma, ketepatan waktu, dan pelayanan kami..." required
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notice Sekali Pakai -->
                <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl text-slate-500 text-[11px] flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 shrink-0 text-sky-500"></i>
                    <span>Setelah menekan tombol kirim, ulasan Anda akan langsung terbit dan tautan ini akan otomatis kedaluwarsa.</span>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-500 hover:to-blue-600 text-white py-3.5 sm:py-4 px-6 rounded-2xl font-bold text-sm shadow-xl shadow-sky-600/25 transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>Kirim Ulasan Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        function initTestimonialRating() {
            const starBtns = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingLabel = document.getElementById('ratingLabel');

            if (!ratingInput) return;

            const ratingTexts = {
                1: '⭐ (Sangat Kecewa)',
                2: '⭐⭐ (Kurang Puas)',
                3: '⭐⭐⭐ (Cukup)',
                4: '⭐⭐⭐⭐ (Puas & Rekomended)',
                5: '⭐⭐⭐⭐⭐ (Sangat Memuaskan)'
            };

            function setRating(val) {
                ratingInput.value = val;
                if (ratingLabel) {
                    ratingLabel.textContent = ratingTexts[val] || (val + ' Bintang');
                }

                starBtns.forEach(btn => {
                    const r = parseInt(btn.getAttribute('data-rating'));
                    const svg = btn.querySelector('svg');
                    if (svg) {
                        if (r <= val) {
                            svg.classList.remove('text-slate-200', 'fill-slate-200');
                            svg.classList.add('text-amber-400', 'fill-current');
                        } else {
                            svg.classList.remove('text-amber-400', 'fill-current');
                            svg.classList.add('text-slate-200', 'fill-slate-200');
                        }
                    }
                });
            }

            starBtns.forEach(btn => {
                btn.onclick = function() {
                    const val = parseInt(this.getAttribute('data-rating'));
                    setRating(val);
                };
            });

            // Inisialisasi awal
            setRating(parseInt(ratingInput.value || 5));
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTestimonialRating);
        } else {
            initTestimonialRating();
        }
    })();
</script>
@endsection
