@extends('layouts.admin')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
                {{ __('Kelola Gambar & Tampilan Beranda') }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kustomisasi gambar latar, galeri foto, logo, dan konten teks penting di halaman utama (index) website.
            </p>
        </div>
        <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-xs shrink-0 self-start sm:self-center">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Pratinjau Landing Page</span>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Notifikasi Alert AJAX / Flash -->
    <div id="mediaAlertBox" class="hidden px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between animate-fade-in-up">
        <div class="flex items-center gap-2.5">
            <svg id="mediaAlertIcon" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span id="mediaAlertText">Pesan pemberitahuan</span>
        </div>
        <button type="button" onclick="document.getElementById('mediaAlertBox').classList.add('hidden')" class="font-bold ml-2 text-lg leading-none cursor-pointer">&times;</button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
        </div>
    @endif

    <!-- TAB NAVIGASI KONTROL -->
    <div class="bg-white p-2 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm flex flex-wrap gap-1.5 sm:gap-2">
        <button type="button" onclick="switchMediaTab('slots', this)" class="media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-sky-600 text-white shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>Slot Gambar Utama ({{ count($slots) }})</span>
        </button>
        <button type="button" onclick="switchMediaTab('library', this)" class="media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-slate-100 text-slate-600 hover:bg-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>Pustaka Media ({{ $mediaList->count() }})</span>
        </button>
        <button type="button" onclick="switchMediaTab('texts', this)" class="media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-slate-100 text-slate-600 hover:bg-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span>Kustomisasi Teks Halaman</span>
        </button>
        <button type="button" onclick="switchMediaTab('preview', this)" class="media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-slate-100 text-slate-600 hover:bg-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span>Pratinjau Live Web</span>
        </button>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 1: KONTROL SLOT GAMBAR BERANDA UTAMA -->
    <!-- ============================================================== -->
    <div id="tab-slots" class="tab-content space-y-6">
        <div class="bg-gradient-to-r from-sky-50 via-white to-blue-50 border border-sky-100 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-black text-slate-800">Manajemen Posisi Gambar di Halaman Depan</h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Anda dapat mengganti foto di setiap bagian penting beranda dengan memilih foto yang sudah ada di pustaka media atau mengunggah foto baru. Jika ingin kembali ke tampilan semula, cukup klik tombol <strong>"Reset Bawaan"</strong>. Gambar lama tetap tersimpan dan dapat dipakai ulang kapan saja.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($slots as $slotKey => $slot)
                @php
                    $isCustom = isset($settings[$slotKey]) && !empty($settings[$slotKey]);
                    $activePath = $isCustom ? $settings[$slotKey] : $slot['default'];
                @endphp
                <div id="slot-card-{{ $slotKey }}" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                    <div>
                        <!-- Header Slot -->
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-100 block mb-1">
                                    {{ $slot['section'] }}
                                </span>
                                <h4 class="font-extrabold text-sm sm:text-base text-slate-900 leading-snug">
                                    {{ $slot['label'] }}
                                </h4>
                            </div>
                            <span id="slot-badge-{{ $slotKey }}" class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md shrink-0 {{ $isCustom ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $isCustom ? 'Kustom' : 'Bawaan' }}
                            </span>
                        </div>

                        <p class="text-[11px] sm:text-xs text-slate-500 mb-4 line-clamp-2">
                            {{ $slot['description'] }}
                        </p>

                        <!-- Box Pratinjau Gambar Aktif -->
                        <div class="relative w-full h-40 sm:h-44 bg-slate-100 rounded-xl overflow-hidden border border-slate-200/80 mb-4 group">
                            <img id="slot-img-{{ $slotKey }}" src="{{ asset($activePath) }}" alt="{{ $slot['label'] }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                <a id="slot-view-{{ $slotKey }}" href="{{ asset($activePath) }}" target="_blank" class="px-3 py-1.5 bg-white/90 hover:bg-white text-slate-900 rounded-lg text-[11px] font-bold shadow-md transition">
                                    Perbesar
                                </a>
                            </div>
                        </div>

                        <div class="text-[10px] font-mono text-slate-400 truncate mb-4" id="slot-path-text-{{ $slotKey }}">
                            File: {{ $activePath }}
                        </div>
                    </div>

                    <!-- Tombol Aksi Slot -->
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                        <button type="button" onclick="openMediaPickerModal('{{ $slotKey }}', '{{ addslashes($slot['label']) }}')" class="flex-1 bg-sky-600 hover:bg-sky-500 text-white font-bold py-2 px-3 rounded-xl text-xs transition shadow-sm text-center cursor-pointer flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Ganti Gambar</span>
                        </button>

                        <button type="button" 
                                id="slot-reset-btn-{{ $slotKey }}"
                                onclick="resetSlotAjax('{{ $slotKey }}')" 
                                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition cursor-pointer {{ $isCustom ? '' : 'hidden' }}"
                                title="Kembalikan ke gambar default">
                            Reset
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 2: PUSTAKA MEDIA LENGKAP & FORM UPLOAD -->
    <!-- ============================================================== -->
    <div id="tab-library" class="tab-content hidden space-y-6">
        <!-- FORM UPLOAD MEDIA BARU -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-5 sm:p-7 shadow-sm">
            <div class="mb-5 pb-4 border-b border-slate-100">
                <h3 class="text-base sm:text-lg font-black text-slate-900">Upload Gambar Baru ke Pustaka</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Semua gambar yang diunggah akan tersimpan di server dan siap dipasang ke slot mana pun.</p>
            </div>

            <form id="mediaUploadForm" action="{{ route('admin.landing-media.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="border-2 border-dashed border-sky-200 hover:border-sky-400 bg-sky-50/50 rounded-2xl p-6 sm:p-8 text-center transition cursor-pointer" onclick="document.getElementById('libraryFileInput').click()">
                    <input type="file" name="image" id="libraryFileInput" accept="image/jpeg,image/png,image/webp,image/svg+xml" class="hidden" onchange="previewUploadFile(event)">
                    <div id="uploadPlaceholder">
                        <div class="w-14 h-14 bg-white rounded-2xl text-sky-600 flex items-center justify-center mx-auto mb-3 shadow-md">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Klik di sini atau seret foto untuk mengunggah</p>
                        <p class="text-xs text-slate-400 mt-1">Mendukung format JPG, PNG, WEBP, SVG (Maks. 5 MB)</p>
                    </div>

                    <!-- Pratinjau Gambar yang dipilih -->
                    <div id="uploadPreviewContainer" class="hidden flex flex-col items-center">
                        <img id="uploadPreviewImage" src="#" alt="Pratinjau" class="max-h-48 rounded-xl shadow-md mb-2 object-contain">
                        <span id="uploadPreviewFilename" class="text-xs font-bold text-slate-700"></span>
                        <span id="uploadPreviewFilesize" class="text-[11px] text-slate-400"></span>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-2">
                    <span class="text-xs text-slate-500">Foto akan tersimpan aman langsung di folder hosting (tanpa risiko symlink mati).</span>
                    <button type="submit" id="submitUploadBtn" class="bg-sky-600 hover:bg-sky-500 text-white font-bold py-2.5 px-6 rounded-xl text-xs sm:text-sm transition shadow-md shadow-sky-600/25 flex items-center gap-2 cursor-pointer shrink-0">
                        <span id="uploadSpinner" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        </span>
                        <span id="uploadBtnText">Unggah ke Galeri</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- DAFTAR PUSTAKA FOTO DI SERVER -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-5 sm:p-7 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900">Koleksi Pustaka Media Tersimpan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Seluruh arsip foto yang siap digunakan kembali atau dihapus jika tidak diperlukan.</p>
                </div>
                <span class="text-xs font-bold text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-100 self-start sm:self-center">
                    Total: <strong id="totalMediaCount">{{ $mediaList->count() }}</strong> Gambar
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="mediaLibraryGrid">
                @forelse($mediaList as $media)
                    @php
                        $isUsed = isset($usageMap[$media->path]) && count($usageMap[$media->path]) > 0;
                        $usedSlots = $isUsed ? $usageMap[$media->path] : [];
                    @endphp
                    <div id="media-card-{{ $media->id }}" class="group bg-slate-50 border border-slate-200/80 rounded-2xl p-3 flex flex-col justify-between hover:shadow-lg hover:border-sky-300 transition duration-300">
                        <div>
                            <div class="relative w-full h-32 rounded-xl overflow-hidden bg-white border border-slate-200/60 mb-2.5">
                                <img src="{{ asset($media->path) }}" alt="{{ $media->original_name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @if($isUsed)
                                    <span class="absolute top-1.5 left-1.5 bg-emerald-600 text-white text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-md shadow-sm">
                                        Aktif
                                    </span>
                                @endif
                                <a href="{{ asset($media->path) }}" target="_blank" class="absolute bottom-1.5 right-1.5 bg-slate-900/80 hover:bg-slate-900 text-white p-1 rounded-md text-[10px] opacity-0 group-hover:opacity-100 transition shadow">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>

                            <p class="text-[11px] font-bold text-slate-800 truncate mb-0.5" title="{{ $media->original_name }}">
                                {{ $media->original_name }}
                            </p>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 mb-2">
                                <span>{{ $media->formatted_size }}</span>
                                <span>{{ $media->created_at ? $media->created_at->format('d/m/y') : '' }}</span>
                            </div>

                            @if($isUsed)
                                <div class="mb-2 text-[10px] text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100 line-clamp-1" title="{{ implode(', ', $usedSlots) }}">
                                    Dipakai: {{ $usedSlots[0] }}
                                </div>
                            @endif
                        </div>

                        <!-- Aksi Item Media -->
                        <div class="pt-2 border-t border-slate-200/60 flex items-center gap-1.5 mt-1">
                            <button type="button" onclick="openApplyToSlotModal({{ $media->id }}, '{{ addslashes($media->original_name) }}', '{{ asset($media->path) }}')" class="flex-1 bg-sky-50 hover:bg-sky-600 hover:text-white text-sky-700 border border-sky-200 py-1.5 px-2 rounded-lg text-[11px] font-bold transition text-center cursor-pointer">
                                Terapkan
                            </button>

                            <button type="button" onclick="confirmDeleteMedia({{ $media->id }}, '{{ addslashes($media->original_name) }}', {{ $isUsed ? 'true' : 'false' }})" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus gambar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div id="mediaEmptyNotice" class="col-span-full py-12 text-center text-slate-400 text-sm">
                        Belum ada gambar tersimpan di pustaka. Unggah gambar pertama Anda di atas.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 3: KUSTOMISASI TEKS BAGIAN PENTING LANDING PAGE -->
    <!-- ============================================================== -->
    <div id="tab-texts" class="tab-content hidden space-y-6">
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-5 sm:p-8 shadow-sm">
            <div class="mb-6 pb-4 border-b border-slate-100">
                <h3 class="text-base sm:text-lg font-black text-slate-900">Ubah Teks & Informasi Utama Landing Page</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ubah judul, slogan, badge penghargaan, dan butir-butir keunggulan layanan tanpa perlu mengubah kode sumber.</p>
            </div>

            <form id="textsForm" action="{{ route('admin.landing-media.texts') }}" method="POST" class="space-y-6">
                @csrf

                <!-- SEKTOR 1: HERO UTAMA -->
                <div class="space-y-4 bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                    <span class="text-xs font-black text-sky-700 uppercase tracking-widest block">Bagian 1: Hero Banner Utama</span>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Badge Atas Hero</label>
                        <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? 'Standar Layanan Publik Terakreditasi A' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Utama Hero (Baris 1)</label>
                            <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Infrastruktur Perawatan Pakaian' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Teks Warna Gradien Highlight</label>
                            <input type="text" name="hero_subtitle_highlight" value="{{ $settings['hero_subtitle_highlight'] ?? 'Profesional & Presisi' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Deskripsi Paragraf Hero</label>
                        <textarea name="hero_description" rows="2" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">{{ $settings['hero_description'] ?? 'Platform otomatisasi pengolahan tekstil dengan sterilisasi medis, pewarnaan terlindung, dan sistem pelacakan invoice digital secara instan.' }}</textarea>
                    </div>
                </div>

                <!-- SEKTOR 2: KEUNGGULAN KORPORAT -->
                <div class="space-y-4 bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                    <span class="text-xs font-black text-sky-700 uppercase tracking-widest block">Bagian 2: Section Mengapa Mempercayakan Pakaian</span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Badge Keunggulan</label>
                            <input type="text" name="why_badge" value="{{ $settings['why_badge'] ?? 'Keunggulan Korporat' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Section Keunggulan</label>
                            <input type="text" name="why_title" value="{{ $settings['why_title'] ?? 'Mengapa Mempercayakan Pakaian Anda Kepada Kami?' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Paragraf Pembuka Keunggulan</label>
                        <textarea name="why_description" rows="2" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">{{ $settings['why_description'] ?? 'Kami mengintegrasikan teknologi pembersihan modern bersuhu tinggi dengan perlakuan khusus demi menjaga serat kain tetap awet, steril, dan harum tahan lama.' }}</textarea>
                    </div>

                    <!-- 3 Poin Keunggulan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                            <span class="text-[11px] font-bold text-sky-600 uppercase block mb-1">Poin 1</span>
                            <input type="text" name="why_1_title" value="{{ $settings['why_1_title'] ?? 'Sterilisasi Anti-Bakteri 99.9%' }}" placeholder="Judul Poin 1" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-bold mb-2">
                            <textarea name="why_1_desc" rows="2" placeholder="Deskripsi Poin 1" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-medium">{{ $settings['why_1_desc'] ?? 'Setiap helai kain melalui proses uap panas bertekanan tinggi untuk membunuh kuman dan jamur secara tuntas.' }}</textarea>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                            <span class="text-[11px] font-bold text-sky-600 uppercase block mb-1">Poin 2</span>
                            <input type="text" name="why_2_title" value="{{ $settings['why_2_title'] ?? 'Pengerjaan Cepat & Tepat Waktu' }}" placeholder="Judul Poin 2" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-bold mb-2">
                            <textarea name="why_2_desc" rows="2" placeholder="Deskripsi Poin 2" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-medium">{{ $settings['why_2_desc'] ?? 'Didukung sistem manajemen operasional digital otomatis yang memantau progres laundry secara real-time.' }}</textarea>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                            <span class="text-[11px] font-bold text-sky-600 uppercase block mb-1">Poin 3</span>
                            <input type="text" name="why_3_title" value="{{ $settings['why_3_title'] ?? 'Garansi Kepuasan 100%' }}" placeholder="Judul Poin 3" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-bold mb-2">
                            <textarea name="why_3_desc" rows="2" placeholder="Deskripsi Poin 3" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-medium">{{ $settings['why_3_desc'] ?? 'Jika ada noda yang belum bersih atau hasil kurang memuaskan, kami cuci ulang tanpa biaya tambahan.' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" id="saveTextsBtn" class="bg-sky-600 hover:bg-sky-500 text-white font-bold py-3 px-8 rounded-xl text-sm transition shadow-lg shadow-sky-600/25 cursor-pointer">
                        Simpan Perubahan Teks
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 4: PRATINJAU LIVE WEBSITE UTAMA (LIVE WEB PREVIEW) -->
    <!-- ============================================================== -->
    <div id="tab-preview" class="tab-content hidden space-y-4">
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-4 sm:p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 flex items-center gap-2">
                        <span>Pratinjau Langsung Website Utama</span>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Lihat hasil perubahan foto latar, galeri, logo, dan konten teks langsung tanpa harus keluar dari dashboard.
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" onclick="refreshLiveWebPreview()" class="inline-flex items-center gap-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Muat Ulang (Refresh)</span>
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-2xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Tab Baru</span>
                    </a>
                </div>
            </div>

            <!-- Toolbar Pengatur Ukuran Layar Preview -->
            <div class="flex items-center justify-between gap-2 mb-3 bg-slate-50 p-2 rounded-xl border border-slate-200/80 text-xs font-bold text-slate-600">
                <span class="text-slate-400 text-[11px] font-medium hidden sm:inline">Simulasi Tampilan Layar:</span>
                <div class="flex items-center gap-1.5 mx-auto sm:mx-0">
                    <button type="button" onclick="setPreviewDevice('100%', this)" class="preview-device-btn px-3 py-1 rounded-lg bg-white text-slate-900 shadow-2xs border border-slate-200 text-xs font-bold cursor-pointer">
                        Desktop (100%)
                    </button>
                    <button type="button" onclick="setPreviewDevice('768px', this)" class="preview-device-btn px-3 py-1 rounded-lg hover:bg-white text-slate-600 border border-transparent text-xs font-bold cursor-pointer">
                        Tablet (768px)
                    </button>
                    <button type="button" onclick="setPreviewDevice('390px', this)" class="preview-device-btn px-3 py-1 rounded-lg hover:bg-white text-slate-600 border border-transparent text-xs font-bold cursor-pointer">
                        Mobile (390px)
                    </button>
                </div>
                <div class="text-[11px] text-slate-400 font-mono hidden md:block">
                    URL: {{ url('/') }}
                </div>
            </div>

            <!-- Iframe Container -->
            <div class="w-full flex justify-center bg-slate-100/80 p-2 sm:p-4 rounded-2xl border border-slate-200 overflow-hidden">
                <div id="previewIframeWrapper" class="w-full transition-all duration-300 rounded-xl overflow-hidden shadow-md bg-white" style="height: 750px;">
                    <iframe id="liveWebPreviewIframe" src="{{ url('/') }}" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: PEMILIH GAMBAR UNTUK SLOT (MEDIA PICKER MODAL) -->
<!-- ============================================================== -->
<div id="mediaPickerModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white rounded-3xl p-6 sm:p-8 text-left shadow-2xl relative my-auto border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base sm:text-lg font-black text-slate-900">Pilih Gambar untuk Slot</h3>
                <p id="pickerModalSlotLabel" class="text-xs text-sky-600 font-bold mt-0.5">Nama Slot</p>
            </div>
            <button type="button" onclick="closeMediaPickerModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center font-bold transition cursor-pointer">&times;</button>
        </div>

        <input type="hidden" id="activePickerSlotKey" value="">

        <!-- Pilihan Opsi Tab Modal: Dari Pustaka ATAU Langsung Upload Baru -->
        <div class="py-4 border-b border-slate-100 flex items-center justify-between gap-3">
            <span class="text-xs text-slate-500">Klik salah satu gambar di bawah untuk langsung menerapkannya:</span>
            <label class="bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 px-3.5 py-1.5 rounded-xl text-xs font-bold cursor-pointer transition flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Upload Foto Baru</span>
                <input type="file" id="modalDirectUploadInput" accept="image/*" class="hidden" onchange="uploadDirectToSlot(event)">
            </label>
        </div>

        <!-- Grid Gambar di dalam Modal -->
        <div class="overflow-y-auto py-4 flex-1">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3.5" id="modalPickerGrid">
                @foreach($mediaList as $m)
                    <div onclick="selectMediaForSlot({{ $m->id }}, '{{ $m->path }}', '{{ asset($m->path) }}')"
                         class="cursor-pointer group relative bg-slate-50 rounded-xl overflow-hidden border-2 border-slate-200 hover:border-sky-500 transition p-1.5 flex flex-col justify-between">
                        <div class="w-full h-28 rounded-lg overflow-hidden bg-white mb-1.5">
                            <img src="{{ asset($m->path) }}" alt="{{ $m->original_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                        </div>
                        <p class="text-[10px] font-bold text-slate-800 truncate" title="{{ $m->original_name }}">{{ $m->original_name }}</p>
                        <span class="text-[9px] text-slate-400 font-mono">{{ $m->formatted_size }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeMediaPickerModal()" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-600 transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: TERAPKAN MEDIA KE SLOT TERTENTU (DARI TAB PUSTAKA) -->
<!-- ============================================================== -->
<div id="applySlotModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl p-6 sm:p-7 text-left shadow-2xl relative my-auto border border-slate-100">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-black text-slate-900">Terapkan Foto ke Bagian Beranda</h3>
            <button type="button" onclick="closeApplySlotModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center font-bold transition cursor-pointer">&times;</button>
        </div>

        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl mb-4 border border-slate-200/80">
            <img id="applyModalThumb" src="#" alt="Thumb" class="w-14 h-14 object-cover rounded-xl border border-slate-200 shrink-0">
            <div class="min-w-0">
                <p id="applyModalTitle" class="text-xs font-bold text-slate-800 truncate"></p>
                <span class="text-[11px] text-slate-400">Pilih slot tampilan di bawah:</span>
            </div>
        </div>

        <input type="hidden" id="applyModalMediaId" value="">

        <div class="space-y-3 mb-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Pilih Slot Landing Page:</label>
            <select id="applyModalSlotSelect" class="w-full px-3.5 py-3 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                @foreach($slots as $k => $s)
                    <option value="{{ $k }}">{{ $s['label'] }} ({{ $s['section'] }})</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" onclick="closeApplySlotModal()" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-600 transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="executeApplySlot()" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold bg-sky-600 hover:bg-sky-500 text-white transition shadow-md shadow-sky-600/25 cursor-pointer">
                Terapkan Sekarang
            </button>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: KONFIRMASI HAPUS GAMBAR -->
<!-- ============================================================== -->
<div id="deleteConfirmModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="w-full max-w-sm bg-white rounded-3xl p-6 text-center shadow-2xl relative my-auto border border-slate-100">
        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h4 class="text-base font-black text-slate-900 mb-1">Hapus Gambar Ini?</h4>
        <p id="deleteConfirmText" class="text-xs text-slate-500 mb-4 leading-relaxed"></p>
        <div id="deleteWarningActive" class="hidden mb-4 bg-amber-50 border border-amber-200 text-amber-800 p-2.5 rounded-xl text-[11px] font-semibold text-left">
            Perhatian: Gambar ini sedang aktif digunakan di salah satu slot beranda. Jika dihapus, slot tersebut akan otomatis kembali ke foto default bawaan.
        </div>

        <input type="hidden" id="deleteTargetMediaId" value="">

        <div class="flex items-center gap-2">
            <button type="button" onclick="closeDeleteConfirmModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition cursor-pointer">
                Batal
            </button>
            <button type="button" id="executeDeleteBtn" onclick="executeDeleteMedia()" class="flex-1 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold transition shadow-md shadow-red-600/25 cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // ==========================================
    // 1. SWITCH TAB KONTROL
    // ==========================================
    function switchMediaTab(tabKey, btn) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.media-tab-btn').forEach(b => {
            b.className = 'media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer';
        });

        const activeTab = document.getElementById(`tab-${tabKey}`);
        if (activeTab) activeTab.classList.remove('hidden');

        btn.className = 'media-tab-btn flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition bg-sky-600 text-white shadow-sm cursor-pointer';

        if (tabKey === 'preview' && typeof refreshLiveWebPreview === 'function') {
            refreshLiveWebPreview();
        }
    }

    // ==========================================
    // 2. TOAST NOTIFIKASI AJAX
    // ==========================================
    function showMediaAlert(msg, isSuccess = true) {
        const box = document.getElementById('mediaAlertBox');
        const txt = document.getElementById('mediaAlertText');
        if (!box || !txt) return;

        txt.textContent = msg;
        box.className = `${isSuccess ? 'bg-emerald-50 border-emerald-300 text-emerald-800' : 'bg-red-50 border-red-300 text-red-800'} border px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between animate-fade-in-up mb-4`;
        box.classList.remove('hidden');

        setTimeout(() => {
            box.classList.add('hidden');
        }, 4500);
    }

    // ==========================================
    // 3. PRATINJAU UPLOAD FILE DI FORM PUSTAKA
    // ==========================================
    function previewUploadFile(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(evt) {
            document.getElementById('uploadPlaceholder')?.classList.add('hidden');
            const previewContainer = document.getElementById('uploadPreviewContainer');
            const previewImg = document.getElementById('uploadPreviewImage');
            const filenameText = document.getElementById('uploadPreviewFilename');
            const filesizeText = document.getElementById('uploadPreviewFilesize');

            if (previewContainer) previewContainer.classList.remove('hidden');
            if (previewImg) previewImg.src = evt.target.result;
            if (filenameText) filenameText.textContent = file.name;
            if (filesizeText) filesizeText.textContent = (file.size / 1024).toFixed(0) + ' KB';
        };
        reader.readAsDataURL(file);
    }

    // ==========================================
    // 4. MODAL PEMILIH GAMBAR UNTUK SLOT
    // ==========================================
    const mediaPickerModal = document.getElementById('mediaPickerModal');
    const activePickerSlotKey = document.getElementById('activePickerSlotKey');
    const pickerModalSlotLabel = document.getElementById('pickerModalSlotLabel');

    function openMediaPickerModal(slotKey, slotLabel) {
        if (activePickerSlotKey) activePickerSlotKey.value = slotKey;
        if (pickerModalSlotLabel) pickerModalSlotLabel.textContent = slotLabel;
        if (mediaPickerModal) {
            mediaPickerModal.classList.remove('hidden');
            mediaPickerModal.classList.add('flex');
        }
    }

    function closeMediaPickerModal() {
        if (mediaPickerModal) {
            mediaPickerModal.classList.add('hidden');
            mediaPickerModal.classList.remove('flex');
        }
    }

    async function selectMediaForSlot(mediaId, path, url) {
        const slotKey = activePickerSlotKey.value;
        if (!slotKey) return;

        try {
            const res = await fetch("{{ route('admin.landing-media.set-slot') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    slot_key: slotKey,
                    media_id: mediaId
                })
            });

            const data = await res.json();
            if (data.success) {
                // Update tampilan kartu slot secara langsung
                updateSlotCardUI(slotKey, data.url, data.path, true);
                closeMediaPickerModal();
                showMediaAlert(data.message, true);
                refreshLiveWebPreview();
            } else {
                showMediaAlert(data.message || 'Gagal menerapkan gambar.', false);
            }
        } catch (err) {
            showMediaAlert('Terjadi kesalahan jaringan.', false);
        }
    }

    // Direct Upload dari dalam modal pemilih
    async function uploadDirectToSlot(e) {
        const file = e.target.files[0];
        const slotKey = activePickerSlotKey.value;
        if (!file || !slotKey) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('slot_key', slotKey);

        try {
            const res = await fetch("{{ route('admin.landing-media.upload') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();
            if (data.success && data.media) {
                updateSlotCardUI(slotKey, data.media.url, data.media.path, true);
                closeMediaPickerModal();
                showMediaAlert(data.message, true);
                setTimeout(() => window.location.reload(), 800);
            } else {
                showMediaAlert(data.message || 'Gagal mengunggah foto.', false);
            }
        } catch (err) {
            showMediaAlert('Gagal mengunggah gambar ke server.', false);
        }
    }

    // ==========================================
    // 5. RESET SLOT KE BAWAAN
    // ==========================================
    async function resetSlotAjax(slotKey) {
        if (!confirm('Kembalikan slot ini ke foto default bawaan?')) return;

        try {
            const res = await fetch("{{ route('admin.landing-media.reset-slot') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ slot_key: slotKey })
            });

            const data = await res.json();
            if (data.success) {
                updateSlotCardUI(slotKey, data.url, data.default_path, false);
                showMediaAlert(data.message, true);
                refreshLiveWebPreview();
            } else {
                showMediaAlert(data.message || 'Gagal mereset slot.', false);
            }
        } catch (err) {
            showMediaAlert('Terjadi kesalahan jaringan.', false);
        }
    }

    function updateSlotCardUI(slotKey, url, path, isCustom) {
        const img = document.getElementById(`slot-img-${slotKey}`);
        const viewLink = document.getElementById(`slot-view-${slotKey}`);
        const badge = document.getElementById(`slot-badge-${slotKey}`);
        const resetBtn = document.getElementById(`slot-reset-btn-${slotKey}`);
        const pathTxt = document.getElementById(`slot-path-text-${slotKey}`);

        if (img) img.src = url;
        if (viewLink) viewLink.href = url;
        if (pathTxt) pathTxt.textContent = `File: ${path}`;
        if (badge) {
            badge.textContent = isCustom ? 'Kustom' : 'Bawaan';
            badge.className = `text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md shrink-0 ${isCustom ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600'}`;
        }
        if (resetBtn) {
            if (isCustom) {
                resetBtn.classList.remove('hidden');
            } else {
                resetBtn.classList.add('hidden');
            }
        }
    }

    // ==========================================
    // 6. MODAL TERAPKAN KE SLOT (DARI TAB PUSTAKA)
    // ==========================================
    const applySlotModal = document.getElementById('applySlotModal');
    const applyModalMediaId = document.getElementById('applyModalMediaId');
    const applyModalTitle = document.getElementById('applyModalTitle');
    const applyModalThumb = document.getElementById('applyModalThumb');
    const applyModalSlotSelect = document.getElementById('applyModalSlotSelect');

    function openApplyToSlotModal(mediaId, title, url) {
        if (applyModalMediaId) applyModalMediaId.value = mediaId;
        if (applyModalTitle) applyModalTitle.textContent = title;
        if (applyModalThumb) applyModalThumb.src = url;

        if (applySlotModal) {
            applySlotModal.classList.remove('hidden');
            applySlotModal.classList.add('flex');
        }
    }

    function closeApplySlotModal() {
        if (applySlotModal) {
            applySlotModal.classList.add('hidden');
            applySlotModal.classList.remove('flex');
        }
    }

    async function executeApplySlot() {
        const mediaId = applyModalMediaId.value;
        const slotKey = applyModalSlotSelect.value;
        if (!mediaId || !slotKey) return;

        try {
            const res = await fetch("{{ route('admin.landing-media.set-slot') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    slot_key: slotKey,
                    media_id: mediaId
                })
            });

            const data = await res.json();
            if (data.success) {
                closeApplySlotModal();
                showMediaAlert(data.message, true);
                setTimeout(() => window.location.reload(), 800);
            } else {
                showMediaAlert(data.message || 'Gagal menerapkan gambar.', false);
            }
        } catch (err) {
            showMediaAlert('Terjadi kendala jaringan.', false);
        }
    }

    // ==========================================
    // 7. MODAL HAPUS GAMBAR
    // ==========================================
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const deleteConfirmText = document.getElementById('deleteConfirmText');
    const deleteWarningActive = document.getElementById('deleteWarningActive');
    const deleteTargetMediaId = document.getElementById('deleteTargetMediaId');

    function confirmDeleteMedia(mediaId, title, isUsed) {
        if (deleteTargetMediaId) deleteTargetMediaId.value = mediaId;
        if (deleteConfirmText) deleteConfirmText.textContent = `Hapus "${title}" dari pustaka media? File akan dihapus permanen dari server.`;

        if (deleteWarningActive) {
            if (isUsed) {
                deleteWarningActive.classList.remove('hidden');
            } else {
                deleteWarningActive.classList.add('hidden');
            }
        }

        if (deleteConfirmModal) {
            deleteConfirmModal.classList.remove('hidden');
            deleteConfirmModal.classList.add('flex');
        }
    }

    function closeDeleteConfirmModal() {
        if (deleteConfirmModal) {
            deleteConfirmModal.classList.add('hidden');
            deleteConfirmModal.classList.remove('flex');
        }
    }

    async function executeDeleteMedia() {
        const mediaId = deleteTargetMediaId.value;
        if (!mediaId) return;

        try {
            const res = await fetch(`{{ url('admin/landing-media') }}/${mediaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                closeDeleteConfirmModal();
                const card = document.getElementById(`media-card-${mediaId}`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => card.remove(), 300);
                }
                showMediaAlert(data.message, true);
            } else {
                showMediaAlert(data.message || 'Gagal menghapus gambar.', false);
            }
        } catch (err) {
            showMediaAlert('Gagal menghubungi server.', false);
        }
    }

    // ==========================================
    // 8. FORM SUBMIT TEKS AJAX
    // ==========================================
    const textsForm = document.getElementById('textsForm');
    textsForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('saveTextsBtn');
        if (btn) btn.disabled = true;

        try {
            const res = await fetch(textsForm.action, {
                method: 'POST',
                body: new FormData(textsForm),
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                showMediaAlert(data.message, true);
                refreshLiveWebPreview();
            } else {
                showMediaAlert('Gagal menyimpan teks.', false);
            }
        } catch (err) {
            textsForm.submit();
        } finally {
            if (btn) btn.disabled = false;
        }
    });

    // ==========================================
    // 9. KONTROL PRATINJAU LIVE WEBSITE UTAMA
    // ==========================================
    function refreshLiveWebPreview() {
        const iframe = document.getElementById('liveWebPreviewIframe');
        if (iframe) {
            iframe.src = "{{ url('/') }}?preview=" + new Date().getTime();
        }
    }

    function setPreviewDevice(width, btn) {
        const wrapper = document.getElementById('previewIframeWrapper');
        if (wrapper) {
            wrapper.style.width = width;
        }
        document.querySelectorAll('.preview-device-btn').forEach(b => {
            b.className = 'preview-device-btn px-3 py-1 rounded-lg hover:bg-white text-slate-600 border border-transparent text-xs font-bold cursor-pointer';
        });
        if (btn) {
            btn.className = 'preview-device-btn px-3 py-1 rounded-lg bg-white text-slate-900 shadow-2xs border border-slate-200 text-xs font-bold cursor-pointer';
        }
    }
</script>
@endsection
