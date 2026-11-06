@extends('layouts.frontend')

@section('title', ($title ?? 'Status Tautan Ulasan') . ' — LaundryGue')

@section('content')
<div class="relative py-16 md:py-24 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[80vh] flex items-center justify-center">
    <!-- Ambient Blur Background -->
    <div class="absolute top-1/4 right-1/4 w-80 sm:w-96 h-80 sm:h-96 bg-sky-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-72 sm:w-80 h-72 sm:h-80 bg-blue-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="max-w-lg w-full mx-auto text-center" data-aos="zoom-in">
        <!-- Logo -->
        <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-white shadow-xl shadow-slate-100 border border-slate-100 mb-6 group hover:scale-105 transition duration-300">
            <img src="{{ asset('img/logo.png') }}" alt="LaundryGue Logo" class="w-14 h-14 sm:w-16 sm:h-16 object-contain">
        </div>

        <div class="bg-white/95 backdrop-blur-xl border border-slate-200/80 rounded-3xl shadow-[0_20px_50px_rgba(8,112,184,0.06)] p-6 sm:p-10">
            @if(isset($status) && $status === 'success')
                <!-- Sukses Terbit -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-emerald-100 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-500/20">
                    <i data-lucide="check-circle-2" class="w-10 h-10 sm:w-12 sm:h-12"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2.5">
                    {{ $title ?? 'Ulasan Berhasil Terbit!' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    {{ $message ?? 'Terima kasih atas ulasan dan rating kepuasan yang telah Anda berikan!' }}
                </p>

                @if(isset($testimonial))
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5 text-left mb-6">
                        <div class="flex items-center gap-1 text-amber-400 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                                @else
                                    <i data-lucide="star" class="w-4 h-4 text-slate-200 fill-slate-200"></i>
                                @endif
                            @endfor
                            <span class="text-xs font-bold text-amber-600 ml-1">({{ $testimonial->rating }}.0 / 5)</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 italic mb-3">"{{ $testimonial->message }}"</p>
                        <div class="text-xs font-bold text-slate-900">{{ $testimonial->name }}</div>
                        <div class="text-[11px] text-slate-400">{{ $testimonial->role }}</div>
                    </div>
                @endif

                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-[11px] font-semibold flex items-center justify-center gap-2 mb-6">
                    <i data-lucide="lock" class="w-3.5 h-3.5 shrink-0 text-amber-600"></i>
                    <span>Tautan ini sekarang telah kedaluwarsa (sekali pakai).</span>
                </div>

                <a href="{{ url('/') }}#testimoni" class="inline-flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-sky-600 text-white py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold shadow-lg transition">
                    <span>Lihat Ulasan di Beranda</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>

            @elseif(isset($status) && $status === 'already_used')
                <!-- Link Sudah Digunakan / Expired -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-slate-100 text-slate-500 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-inner">
                    <i data-lucide="lock" class="w-8 h-8 sm:w-10 sm:h-10 text-slate-600"></i>
                </div>
                <div class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                    <span>Tautan Kedaluwarsa (Expired)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2.5">
                    {{ $title ?? 'Tautan Telah Digunakan' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    {{ $message ?? 'Ulasan melalui tautan ini sudah pernah dikirimkan sebelumnya. Setiap tautan hanya berlaku satu kali untuk menjamin transparansi ulasan.' }}
                </p>

                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-500 leading-relaxed mb-6">
                    Jika Anda memiliki masukan tambahan atau kendala operasional, jangan ragu untuk menghubungi layanan bantuan kami.
                </div>

                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 w-full bg-sky-600 hover:bg-sky-500 text-white py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold shadow-lg shadow-sky-600/20 transition">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>

            @elseif(isset($status) && $status === 'expired')
                <!-- Masa Berlaku Berakhir -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-amber-100 text-amber-600 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-inner">
                    <i data-lucide="clock" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2.5">
                    {{ $title ?? 'Masa Berlaku Berakhir' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    {{ $message ?? 'Masa aktif pengisian ulasan untuk tautan ini telah melewati batas waktu.' }}
                </p>

                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-sky-600 text-white py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold shadow-lg transition">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>

            @else
                <!-- Token Required / Not Found -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-sky-100 text-sky-600 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-inner">
                    <i data-lucide="key" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2.5">
                    {{ $title ?? 'Tautan Khusus Diperlukan' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    {{ $message ?? 'Halaman pengisian ulasan ini memerlukan tautan undangan khusus sekali pakai dari kasir atau admin setelah cucian Anda selesai.' }}
                </p>

                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-sky-600 text-white py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold shadow-lg transition">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
