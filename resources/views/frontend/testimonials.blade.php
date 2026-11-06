@extends('layouts.frontend')

@section('title', 'Seluruh Testimoni & Ulasan Pelanggan — LaundryGue')

@section('content')
<div class="py-12 sm:py-16 md:py-20 px-4 sm:px-6 max-w-7xl mx-auto">
    <!-- Header Page -->
    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14" data-aos="fade-up">
        <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-2 sm:mb-3">Transparansi Reputasi</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-3 sm:mb-4 tracking-tight">
            Ulasan Asli Pelanggan Kami
        </h1>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Seluruh testimoni di bawah ini diberikan langsung oleh pelanggan resmi kami melalui tautan verifikasi sekali pakai setelah cucian selesai.
        </p>
    </div>

    <!-- Rating Summary Dashboard Card Terang -->
    <div class="bg-gradient-to-br from-sky-50/90 via-white to-blue-50/80 text-slate-900 rounded-3xl p-6 sm:p-10 mb-10 sm:mb-14 shadow-xl border border-sky-100 relative overflow-hidden" data-aos="zoom-in">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center relative z-10">
            <!-- Nilai Rata-rata -->
            <div class="text-center md:text-left md:border-r md:border-slate-200/80 md:pr-8">
                <span class="text-xs font-bold text-sky-700 uppercase tracking-widest block mb-1">Skor Kepuasan Rata-Rata</span>
                <div class="flex items-baseline justify-center md:justify-start gap-2">
                    <span class="text-5xl sm:text-6xl font-black text-slate-900 tracking-tight">{{ $avgRating }}</span>
                    <span class="text-xl sm:text-2xl font-bold text-slate-400">/ 5.0</span>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-1 my-3 text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i>
                        @else
                            <i data-lucide="star" class="w-5 h-5 text-slate-200 fill-slate-200"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-xs text-slate-500 font-medium">Berdasarkan total {{ $totalTestimonials }} ulasan terverifikasi</p>
            </div>

            <!-- Breakdown Bintang -->
            <div class="space-y-2 col-span-1 md:col-span-2">
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $count = $ratingCounts[$star] ?? 0;
                        $percent = $totalTestimonials > 0 ? round(($count / $totalTestimonials) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-3 text-xs">
                        <span class="w-16 font-bold text-slate-700 flex items-center gap-1">
                            <span>{{ $star }} Bintang</span>
                        </span>
                        <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden border border-slate-200/60">
                            <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="w-12 text-right font-mono text-slate-500 text-[11px] font-semibold">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Filter Bintang Tab -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10" data-aos="fade-up">
        <a href="{{ route('frontend.testimonials') }}" 
           class="px-4 sm:px-5 py-2.5 rounded-2xl text-xs font-bold transition shadow-sm {{ !request('rating') ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Semua ({{ $totalTestimonials }})
        </a>
        @for($s = 5; $s >= 1; $s--)
            <a href="{{ route('frontend.testimonials', ['rating' => $s]) }}" 
               class="px-4 sm:px-5 py-2.5 rounded-2xl text-xs font-bold transition shadow-sm flex items-center gap-1.5 {{ request('rating') == $s ? 'bg-sky-600 text-white shadow-sky-600/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span class="text-amber-400">★</span>
                <span>{{ $s }} Bintang ({{ $ratingCounts[$s] ?? 0 }})</span>
            </a>
        @endfor
    </div>

    <!-- Grid Seluruh Testimoni -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
        @forelse($testimonials as $testi)
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 50 }}">
            <div>
                <!-- Stars -->
                <div class="flex items-center gap-1.5 mb-4">
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testi->rating)
                                <svg class="w-5 h-5 text-amber-400 fill-amber-400 shrink-0" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-slate-200 fill-slate-200 shrink-0" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60">{{ $testi->rating }}.0</span>
                </div>

                <!-- Review Text -->
                <p class="text-slate-700 text-xs sm:text-sm leading-relaxed mb-6 font-medium">
                    "{{ $testi->message }}"
                </p>
            </div>

            <!-- Author & Info -->
            <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center font-black text-xs uppercase shadow-md shadow-sky-500/20">
                        {{ substr($testi->name, 0, 2) }}
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">{{ $testi->name }}</h4>
                        <span class="text-[11px] text-slate-400 font-medium">{{ $testi->role }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-slate-400 font-medium">
                    {{ $testi->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm">
            <i data-lucide="message-square" class="w-12 h-12 mx-auto text-slate-300 mb-3"></i>
            <p>Belum ada ulasan untuk kategori rating ini.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($testimonials->hasPages())
        <div class="flex justify-center" data-aos="fade-up">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>
@endsection
