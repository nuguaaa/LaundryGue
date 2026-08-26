@extends('layouts.frontend')

@section('title', 'Katalog & Tarif Layanan — LaundryHub')

@section('content')
<div class="py-20 px-6 max-w-7xl mx-auto">
    <!-- Header & Search Bar -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-sky-600 text-xs font-extrabold uppercase tracking-widest block mb-3">Transparansi Finansial</span>
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">Katalog Layanan & Struktur Harga</h1>
        <p class="text-slate-600 text-base leading-relaxed mb-8">Cari dan pilih jenis perawatan pakaian yang Anda butuhkan secara transparan.</p>

        <!-- Input Pencarian (Search Bar) -->
        <div class="relative max-w-lg mx-auto mb-6">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
            </span>
            <input type="text" id="searchService" placeholder="Cari jenis layanan..."
                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-4 text-sm text-slate-900 placeholder-slate-400 font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm transition">
        </div>

        <!-- Tombol Kategori Dinamis dari Database -->
        @php
            $categories = isset($services) ? $services->pluck('category')->unique()->filter() : collect();
        @endphp

        <div class="flex flex-wrap justify-center gap-2" id="categoryButtons">
            <button onclick="filterCategory('all', this)" class="cat-btn bg-slate-900 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                Semua Layanan
            </button>
            @foreach($categories as $cat)
            <button onclick="filterCategory('{{ strtolower($cat) }}', this)" class="cat-btn bg-white border border-slate-200 text-slate-600 hover:border-slate-400 px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                {{ ucfirst($cat) }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Grid Kartu Layanan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="serviceGrid">
        @forelse($services as $service)
        @php
            $nameLower = strtolower($service->name);
            $serviceCat = strtolower($service->category ?? 'umum');
        @endphp
        <div class="service-card bg-white rounded-3xl p-8 border border-slate-200/70 shadow-sm hover:shadow-2xl transition duration-300 flex flex-col justify-between"
             data-name="{{ $nameLower }}" data-category="{{ $serviceCat }}">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                    <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $service->category ?? 'Umum' }}</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3">{{ $service->name }}</h3>
                <p class="text-sm text-slate-500 mb-8 leading-relaxed">{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.' }}</p>
            </div>
            <div class="border-t border-slate-100 pt-6 flex items-center justify-between">
                <div>
                    <span class="text-2xl font-black text-sky-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    <span class="text-xs text-slate-400 font-semibold"> / {{ $service->unit ?? 'Kg' }}</span>
                </div>
                <button onclick="openModal('{{ $service->name }}', 'Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit ?? 'Kg' }}', '{{ $service->description ?? 'Layanan terstandarisasi dengan pembersihan menyeluruh.' }}')"
                    class="bg-slate-900 hover:bg-sky-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-md">
                    Pilih Layanan
                </button>
            </div>
        </div>
        @empty
        <div id="emptyMessage" class="col-span-3 text-center py-20 bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm">
            Belum ada data layanan yang dimasukkan ke dalam sistem.
        </div>
        @endforelse
    </div>

    <!-- Pesan jika pencarian tidak ditemukan -->
    <div id="noResult" class="hidden text-center py-20 bg-white rounded-3xl border border-slate-200 text-slate-400 text-sm mt-8">
        Layanan yang Anda cari tidak ditemukan.
    </div>
</div>

<!-- MODAL POP-UP DETAIL LAYANAN -->
<div id="serviceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
    <div class="bg-white rounded-[2.5rem] p-8 max-w-lg w-full mx-auto shadow-2xl transform scale-95 transition-transform duration-300 relative" id="modalContainer">
        <button onclick="closeModal()" class="absolute top-6 right-6 w-10 h-10 bg-slate-100 text-slate-500 hover:bg-slate-200 rounded-full flex items-center justify-center font-bold transition">
            ✕
        </button>

        <div class="mb-6">
            <span class="bg-sky-50 text-sky-600 text-xs font-extrabold uppercase px-3 py-1.5 rounded-lg tracking-wider">Detail Pilihan Anda</span>
            <h2 id="modalTitle" class="text-2xl font-black text-slate-900 mt-3">Nama Layanan</h2>
        </div>

        <p id="modalDesc" class="text-sm text-slate-600 leading-relaxed mb-6">Deskripsi layanan akan muncul di sini.</p>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center justify-between mb-8">
            <span class="text-xs text-slate-500 font-bold uppercase">Estimasi Tarif:</span>
            <span id="modalPrice" class="text-xl font-black text-sky-600">Rp 0</span>
        </div>

        <div class="flex gap-3">
            <button onclick="closeModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3.5 rounded-2xl font-bold text-sm transition">
                Tutup
            </button>
            <a id="modalWhatsAppBtn" href="#" target="_blank" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white py-3.5 rounded-2xl font-bold text-sm text-center transition shadow-lg shadow-emerald-600/20">
                Pesan via WhatsApp
            </a>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchService');
    const serviceCards = document.querySelectorAll('.service-card');
    const noResultDiv = document.getElementById('noResult');
    const catButtons = document.querySelectorAll('.cat-btn');

    let currentCategory = 'all';

    function filterCategory(category, element) {
        currentCategory = category;

        catButtons.forEach(btn => {
            btn.classList.remove('bg-slate-900', 'text-white');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });
        element.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        element.classList.add('bg-slate-900', 'text-white');

        applyFilters();
    }

    if(searchInput) {
        searchInput.addEventListener('input', function() {
            applyFilters();
        });
    }

    function applyFilters() {
        const term = searchInput ? searchInput.value.toLowerCase() : '';
        let matchCount = 0;

        serviceCards.forEach(card => {
            const name = card.getAttribute('data-name');
            const category = card.getAttribute('data-category');

            const matchesSearch = name.includes(term);
            const matchesCategory = (currentCategory === 'all' || category === currentCategory);

            if(matchesSearch && matchesCategory) {
                card.style.display = 'flex';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if(matchCount === 0 && noResultDiv) {
            noResultDiv.classList.remove('hidden');
        } else if(noResultDiv) {
            noResultDiv.classList.add('hidden');
        }
    }

    const modal = document.getElementById('serviceModal');
    const modalContainer = document.getElementById('modalContainer');
    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalPrice = document.getElementById('modalPrice');
    const modalWhatsAppBtn = document.getElementById('modalWhatsAppBtn');
    const waNumber = "{{ $settings['whatsapp'] ?? '6281220295876' }}";

    function openModal(name, price, desc) {
        modalTitle.innerText = name;
        modalPrice.innerText = price;
        modalDesc.innerText = desc;

        const waMessage = encodeURIComponent(`Halo Admin, saya tertarik untuk memesan layanan ${name} (${price}). Mohon info lebih lanjut.`);
        modalWhatsAppBtn.href = `https://wa.me/${waNumber}?text=${waMessage}`;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalContainer.classList.remove('scale-95');
        modalContainer.classList.add('scale-100');
    }

    function closeModal() {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modalContainer.classList.remove('scale-100');
        modalContainer.classList.add('scale-95');
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endsection
