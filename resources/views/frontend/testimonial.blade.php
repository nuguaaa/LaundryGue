@extends('layouts.frontend')

@section('title', 'Kirim Ulasan & Testimoni Pelanggan — LaundryGue')

@section('content')
<div class="relative py-12 md:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[85vh] flex items-center justify-center">
    <!-- Ambient Blur Background -->
    <div class="absolute top-1/4 right-1/4 w-80 sm:w-96 h-80 sm:h-96 bg-sky-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-72 sm:w-80 h-72 sm:h-80 bg-blue-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="max-w-xl w-full mx-auto" data-aos="zoom-in" data-aos-duration="600">
        <!-- Logo & Header -->
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

        <!-- Personal Greeting (Jika ada nama pelanggan dari data pesanan) -->
        @if(!empty($tokenModel->customer_name))
            <div class="bg-gradient-to-br from-sky-50/90 via-white to-blue-50/70 border border-sky-100 rounded-3xl p-5 sm:p-6 mb-6 shadow-sm relative overflow-hidden" data-aos="fade-up">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-sky-200/30 rounded-full blur-xl pointer-events-none"></div>
                <div class="flex items-start gap-3.5 sm:gap-4 relative z-10">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-sky-500/25 text-xl font-bold">
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
            <form action="{{ route('testimonial.store', ['token' => $tokenModel->token ?? request('token')]) }}" method="POST" class="space-y-6" id="testiForm">
                @csrf
                <input type="hidden" name="token" value="{{ $tokenModel->token ?? request('token') }}">

                <!-- Rating Bintang Interaktif (1 sampai 5) -->
                <div class="text-center pb-6 border-b border-slate-100">
                    <label class="block text-slate-800 text-xs sm:text-sm font-black uppercase tracking-wider mb-1.5">
                        Rating Kepuasan Layanan <span class="text-red-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-400 mb-4">Klik bintang sesuai tingkat kepuasan hasil cucian Anda</p>
                    
                    <div class="flex items-center justify-center gap-1.5 sm:gap-2.5 mb-3" id="starContainer">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    data-rating="{{ $i }}" 
                                    class="star-btn p-1.5 rounded-2xl transition-all duration-200 hover:scale-125 focus:outline-none cursor-pointer" 
                                    title="Pilih {{ $i }} Bintang">
                                <svg class="w-9 h-9 sm:w-11 sm:h-11 transition-colors drop-shadow-sm" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                    <div>
                        <span id="ratingLabel" class="inline-block text-xs sm:text-sm font-bold text-amber-800 bg-amber-50 px-4 py-1.5 rounded-full border border-amber-200/70 shadow-sm transition-all duration-200">
                            ⭐⭐⭐⭐⭐ (Sangat Memuaskan)
                        </span>
                    </div>
                    @error('rating')
                        <p class="text-xs text-red-500 mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian Nama Pelanggan: Otomatis jika sudah ada data nama saat generate link -->
                @if(!empty($tokenModel->customer_name))
                    <input type="hidden" name="name" value="{{ $tokenModel->customer_name }}">
                    <div class="flex items-center justify-between p-3.5 sm:p-4 bg-slate-50 border border-slate-200/80 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center font-black text-sm uppercase shadow-sm">
                                {{ substr($tokenModel->customer_name, 0, 2) }}
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Ulasan Dari Pelanggan</span>
                                <span class="text-sm font-bold text-slate-900">{{ $tokenModel->customer_name }}</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Terverifikasi</span>
                        </span>
                    </div>
                @else
                    <!-- Fallback Input Nama (Jika token dibuat tanpa nama) -->
                    <div>
                        <label class="block text-slate-800 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">
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
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-slate-800 text-xs sm:text-sm font-bold uppercase tracking-wider">
                            Ulasan & Pengalaman Cuci Anda <span class="text-red-500">*</span>
                        </label>
                        <span id="charCounter" class="text-[11px] text-slate-400 font-medium">Min 5 karakter</span>
                    </div>
                    <textarea name="message" id="messageInput" rows="4" placeholder="Ceritakan bagaimana kebersihan pakaian, aroma wangi cucian, ketepatan waktu, dan keramahan pelayanan kami..." required
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition leading-relaxed resize-none">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notice Sekali Pakai -->
                <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-slate-500 text-xs flex items-start gap-2.5 leading-relaxed">
                    <i data-lucide="shield-check" class="w-4 h-4 shrink-0 text-sky-500 mt-0.5"></i>
                    <span>Setelah menekan tombol di bawah, ulasan Anda akan langsung tampil di beranda dan tautan ini akan otomatis kedaluwarsa demi menjaga keaslian ulasan.</span>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-1">
                    <button type="submit" id="submitBtn" class="w-full bg-slate-900 hover:bg-sky-600 text-white py-3.5 sm:py-4 px-6 rounded-2xl font-bold text-sm shadow-xl shadow-slate-900/10 hover:shadow-sky-600/25 transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        <i data-lucide="sparkles" class="w-4 h-4 text-amber-400"></i>
                        <span>Kirim Ulasan Sekarang</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tombol Kembali ke Beranda -->
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-slate-700 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Beranda Utama</span>
            </a>
        </div>
    </div>
</div>

<script>
    (function() {
        function initTestimonialRating() {
            const starBtns = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingLabel = document.getElementById('ratingLabel');
            const messageInput = document.getElementById('messageInput');
            const charCounter = document.getElementById('charCounter');
            const form = document.getElementById('testiForm');
            const submitBtn = document.getElementById('submitBtn');

            if (!ratingInput) return;

            const ratingTexts = {
                1: '⭐ (Sangat Kecewa)',
                2: '⭐⭐ (Kurang Puas)',
                3: '⭐⭐⭐ (Cukup)',
                4: '⭐⭐⭐⭐ (Puas & Rekomended)',
                5: '⭐⭐⭐⭐⭐ (Sangat Memuaskan)'
            };

            let currentSelectedRating = parseInt(ratingInput.value || 5);

            function updateStarVisuals(val) {
                starBtns.forEach(btn => {
                    const r = parseInt(btn.getAttribute('data-rating'));
                    const svg = btn.querySelector('svg');
                    if (svg) {
                        if (r <= val) {
                            svg.classList.remove('text-slate-200', 'fill-slate-200');
                            svg.classList.add('text-amber-400', 'fill-amber-400');
                        } else {
                            svg.classList.remove('text-amber-400', 'fill-amber-400');
                            svg.classList.add('text-slate-200', 'fill-slate-200');
                        }
                    }
                });

                if (ratingLabel) {
                    ratingLabel.textContent = ratingTexts[val] || (val + ' Bintang');
                }
            }

            function setRating(val) {
                currentSelectedRating = val;
                ratingInput.value = val;
                updateStarVisuals(val);
            }

            starBtns.forEach(btn => {
                const val = parseInt(btn.getAttribute('data-rating'));

                // Click to choose
                btn.addEventListener('click', function() {
                    setRating(val);
                });

                // Hover to preview
                btn.addEventListener('mouseenter', function() {
                    updateStarVisuals(val);
                });

                // Keyboard accessible
                btn.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        setRating(val);
                    }
                });
            });

            // Restore selected rating when mouse leaves the star container
            const container = document.getElementById('starContainer');
            if (container) {
                container.addEventListener('mouseleave', function() {
                    updateStarVisuals(currentSelectedRating);
                });
            }

            // Inisialisasi awal
            setRating(currentSelectedRating);

            // Character counter for message textarea
            if (messageInput && charCounter) {
                function updateCount() {
                    const len = messageInput.value.length;
                    if (len === 0) {
                        charCounter.textContent = 'Min 5 karakter';
                        charCounter.className = 'text-[11px] text-slate-400 font-medium';
                    } else if (len < 5) {
                        charCounter.textContent = len + ' / min 5 karakter';
                        charCounter.className = 'text-[11px] text-amber-600 font-bold';
                    } else {
                        charCounter.textContent = len + ' karakter';
                        charCounter.className = 'text-[11px] text-emerald-600 font-medium';
                    }
                }
                messageInput.addEventListener('input', updateCount);
                updateCount();
            }

            // Prevent double submission
            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTestimonialRating);
        } else {
            initTestimonialRating();
        }
    })();
</script>
@endsection
