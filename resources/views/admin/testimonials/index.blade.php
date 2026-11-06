@extends('layouts.admin')

@section('title', 'Kelola Testimoni & Link Undangan — LaundryGue')

@section('content')
<div class="space-y-8">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelola Testimoni & Link Undangan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                Cari data pesanan pelanggan untuk generate link ulasan sekali pakai secara instan, kelola link, dan hapus testimoni jika diperlukan.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 border border-sky-200/80 px-3.5 py-1.5 rounded-2xl text-xs font-bold shadow-sm">
                <i data-lucide="shield-check" class="w-4 h-4 text-sky-600"></i>
                <span>One-Time Token Secured</span>
            </span>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses / Link Baru Dibuat -->
    @if(session('new_link'))
        <div class="p-5 sm:p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-3xl shadow-xl shadow-emerald-500/20 animate-fade-in-up">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider text-emerald-100 mb-1">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span>Link Testimoni Berhasil Dibuat!</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold">Bagikan tautan ini ke pelanggan:</h3>
                    @if(data_get(session('new_token'), 'customer_name'))
                        <p class="text-xs sm:text-sm text-emerald-100">Untuk Pelanggan: <strong class="text-white">{{ data_get(session('new_token'), 'customer_name') }}</strong></p>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <div class="bg-slate-900/60 backdrop-blur-md border border-white/20 px-3.5 py-2.5 rounded-2xl flex items-center justify-between gap-3 text-xs font-mono max-w-md overflow-x-auto text-white">
                        <span class="truncate" id="generatedLinkInput">{{ session('new_link') }}</span>
                    </div>
                    <button type="button" onclick="copyGeneratedLink('{{ session('new_link') }}')" 
                            class="bg-white hover:bg-emerald-50 text-emerald-800 font-bold px-4 py-2.5 rounded-2xl text-xs shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                        <span id="copySuccessBtnText">Salin Tautan</span>
                    </button>
                    @if(data_get(session('new_token'), 'customer_phone'))
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', (string) data_get(session('new_token'), 'customer_phone'));
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $cName = data_get(session('new_token'), 'customer_name') ?? 'Pelanggan';
                            $waMsg = urlencode("Halo {$cName}, terima kasih telah mencuci di LaundryGue! Mohon kesediaan Anda memberikan ulasan singkat melalui tautan ulasan khusus berikut:\n\n" . session('new_link') . "\n\nNama Anda sudah otomatis terisi di sistem. Masukan Anda sangat berarti bagi kami!");
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank"
                           class="bg-emerald-800 hover:bg-emerald-900 text-white font-bold px-4 py-2.5 rounded-2xl text-xs shadow-md transition flex items-center justify-center gap-1.5">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Kirim ke WhatsApp</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @elseif(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm rounded-2xl font-bold flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card 1: Cari Data Pelanggan & 1-Klik Generate Link (Tanpa Ribet Isi Form) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center font-bold shadow-md shadow-sky-500/20">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900">Cari Data Pelanggan & Generate Link</h2>
                    <p class="text-xs text-slate-500">Ketik nama atau resi pesanan, lalu klik tombol Generate Link untuk membuat link otomatis atas nama pelanggan tersebut.</p>
                </div>
            </div>

            <!-- Tombol Toggle Form Manual Fallback -->
            <button type="button" onclick="document.getElementById('manualFormCollapse').classList.toggle('hidden')" 
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition cursor-pointer self-start md:self-auto">
                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                <span>Atau Input Manual</span>
            </button>
        </div>

        <!-- Live Search Box -->
        <div class="relative mb-5">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-5 h-5"></i>
            </span>
            <input type="text" id="searchCustomerInput" placeholder="Ketik nama pelanggan, nomor WhatsApp, atau nomor resi..."
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-xs sm:text-sm text-slate-900 font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition shadow-inner">
        </div>

        <!-- Tabel Hasil Pencarian Pesanan / Pelanggan -->
        <div class="border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
            <div class="max-h-72 overflow-y-auto">
                <table class="w-full text-left text-xs sm:text-sm" id="customerTable">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] sm:text-xs sticky top-0 z-10 border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 sm:px-6">Resi / Invoice</th>
                            <th class="py-3 px-4 sm:px-6">Nama Pelanggan</th>
                            <th class="py-3 px-4 sm:px-6">No WhatsApp</th>
                            <th class="py-3 px-4 sm:px-6">Status Cucian</th>
                            <th class="py-3 px-4 sm:px-6 text-right">Aksi Generate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="customerTableBody">
                        @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-sky-50/50 transition customer-row" 
                            data-search="{{ strtolower($trx->customer_name . ' ' . $trx->invoice_code . ' ' . $trx->customer_phone) }}">
                            <td class="py-3 px-4 sm:px-6 font-mono font-bold text-sky-700">
                                #{{ $trx->invoice_code }}
                            </td>
                            <td class="py-3 px-4 sm:px-6 font-bold text-slate-900">
                                {{ $trx->customer_name }}
                            </td>
                            <td class="py-3 px-4 sm:px-6 text-slate-500 font-mono text-xs">
                                {{ $trx->customer_phone ?: '-' }}
                            </td>
                            <td class="py-3 px-4 sm:px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold
                                    @if($trx->status == 'Selesai' || $trx->status == 'Diambil') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($trx->status == 'Proses') bg-sky-50 text-sky-700 border border-sky-200
                                    @else bg-amber-50 text-amber-700 border border-amber-200 @endif">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 sm:px-6 text-right">
                                <form action="{{ route('admin.testimonials.tokens.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="transaction_id" value="{{ $trx->id }}">
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-500 hover:to-blue-600 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                                        <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-300"></i>
                                        <span>Generate Link</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400 text-xs">
                                Belum ada riwayat pesanan untuk digenerate ulasannya.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Manual Fallback (Collapsible) -->
        <div id="manualFormCollapse" class="hidden mt-6 pt-6 border-t border-slate-100">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Input Data Manual (Jika Tanpa No Resi)</h4>
            <form action="{{ route('admin.testimonials.tokens.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pelanggan</label>
                    <input type="text" name="customer_name" placeholder="Contoh: Ibu Rina"
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No WhatsApp</label>
                    <input type="text" name="customer_phone" placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-sky-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Generate Link Manual</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card 2: Tabel Riwayat Link Undangan Testimoni (One-time Links) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Daftar Link Undangan Ulasan</h3>
                <p class="text-xs text-slate-500">Status tautan sekali pakai: Aktif (belum diisi) atau Expired (sudah diisi / kedaluwarsa).</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Total {{ $tokens->total() }} Link
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[10px] sm:text-xs border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Pelanggan & Info</th>
                        <th class="py-3.5 px-4 sm:px-6">Tautan Ulasan (URL)</th>
                        <th class="py-3.5 px-4 sm:px-6">Status Link</th>
                        <th class="py-3.5 px-4 sm:px-6">Dibuat Pada</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tokens as $tok)
                    @php
                        $targetUrl = route('testimonial.create', ['token' => $tok->token]);
                        $isExpired = $tok->is_used || ($tok->expires_at && $tok->expires_at->isPast());
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-4 px-4 sm:px-6">
                            <div class="font-bold text-slate-900">{{ $tok->customer_name ?: 'Pelanggan Umum' }}</div>
                            @if($tok->customer_phone)
                                <div class="text-[11px] text-slate-400 font-mono">{{ $tok->customer_phone }}</div>
                            @endif
                            @if($tok->notes)
                                <div class="text-[11px] text-sky-600 font-medium mt-0.5">{{ $tok->notes }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-4 sm:px-6 max-w-xs sm:max-w-md">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs text-slate-600 truncate bg-slate-100 px-2 py-1 rounded-lg select-all">
                                    {{ $targetUrl }}
                                </span>
                                @if(!$isExpired)
                                    <button type="button" onclick="copyGeneratedLink('{{ $targetUrl }}')" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Salin Tautan">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 sm:px-6">
                            @if($tok->is_used)
                                <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-full text-[11px] font-bold">
                                    <i data-lucide="lock" class="w-3 h-3 text-slate-500"></i>
                                    <span>Sudah Diisi (Expired)</span>
                                </span>
                                @if($tok->testimonial)
                                    <div class="text-[11px] text-amber-600 font-bold mt-1 flex items-center gap-1">
                                        <span>Rating: {{ str_repeat('⭐', $tok->testimonial->rating) }}</span>
                                    </div>
                                @endif
                            @elseif($tok->expires_at && $tok->expires_at->isPast())
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-200 px-2.5 py-1 rounded-full text-[11px] font-bold">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    <span>Waktu Habis</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Aktif / Menunggu Diisi</span>
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 sm:px-6 text-xs text-slate-500">
                            {{ $tok->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-4 sm:px-6 text-right">
                            <form action="{{ route('admin.testimonials.tokens.destroy', $tok->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus link undangan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" title="Hapus Link">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs sm:text-sm">
                            Belum ada link undangan testimoni yang dibuat. Silakan pilih pelanggan di atas untuk generate link!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tokens->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $tokens->links() }}
            </div>
        @endif
    </div>

    <!-- Card 3: Tabel Ulasan Pelanggan yang Telah Masuk di Beranda Utama -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Ulasan & Testimoni yang Tampil di Beranda</h3>
                <p class="text-xs text-slate-500">Daftar seluruh ulasan yang telah dikirimkan pelanggan. Admin dapat menghapus ulasan yang tidak sesuai.</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Total {{ $testimonials->total() }} Ulasan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[10px] sm:text-xs border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Rating Bintang</th>
                        <th class="py-3.5 px-4 sm:px-6">Nama & Kategori</th>
                        <th class="py-3.5 px-4 sm:px-6">Isi Ulasan Testimoni</th>
                        <th class="py-3.5 px-4 sm:px-6">Tanggal Masuk</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($testimonials as $testi)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testi->rating)
                                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                                    @else
                                        <i data-lucide="star" class="w-4 h-4 text-slate-200 fill-slate-200"></i>
                                    @endif
                                @endfor
                                <span class="font-bold text-amber-600 ml-1">{{ $testi->rating }}.0</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 sm:px-6">
                            <div class="font-bold text-slate-900">{{ $testi->name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $testi->role }}</div>
                        </td>
                        <td class="py-4 px-4 sm:px-6 max-w-sm sm:max-w-md">
                            <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed">
                                "{{ $testi->message }}"
                            </p>
                        </td>
                        <td class="py-4 px-4 sm:px-6 text-xs text-slate-500 whitespace-nowrap">
                            {{ $testi->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                            <form action="{{ route('admin.testimonials.destroy', $testi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni dari {{ $testi->name }} ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 text-xs font-bold transition shadow-sm cursor-pointer" 
                                        title="Hapus Ulasan dari Beranda">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Hapus Testimoni</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs sm:text-sm">
                            Belum ada ulasan yang masuk dari pelanggan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function copyGeneratedLink(url) {
        if (!url) return;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.getElementById('copySuccessBtnText');
            if (btn) {
                btn.textContent = 'Tersalin!';
                setTimeout(() => { btn.textContent = 'Salin Tautan'; }, 2000);
            }
            alert('Tautan ulasan berhasil disalin ke clipboard!');
        }).catch(() => {
            prompt('Salin tautan ini secara manual:', url);
        });
    }

    // Client-side instant filter untuk pencarian pelanggan
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchCustomerInput');
        const rows = document.querySelectorAll('.customer-row');

        searchInput?.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
