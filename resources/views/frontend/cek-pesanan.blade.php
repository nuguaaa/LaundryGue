<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Resi #{{ $transaction->invoice_code }} — LaundryGue</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @media print {
            body { display: none !important; }
        }
    </style>
</head>
<body class="bg-gradient-to-b from-sky-50/50 via-slate-50 to-white text-slate-800 min-h-screen flex flex-col justify-between selection:bg-sky-500 selection:text-white relative overflow-x-hidden">

    @php
        $splashEnabled = ($settings['enable_splash_screen'] ?? '0') === '1';
    @endphp

    @if($splashEnabled)
    <!-- Splash Screen Page Transition -->
    <div id="splashScreen" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white/95 backdrop-blur-md transition-all duration-300 pointer-events-auto">
        <div class="flex flex-col items-center text-center p-6">
            <div class="relative flex items-center justify-center mb-5">
                <div class="absolute w-20 h-20 rounded-2xl bg-sky-500/20 animate-ping"></div>
                <div class="w-16 h-16 rounded-2xl bg-white border border-sky-100 text-sky-600 flex items-center justify-center font-black text-2xl shadow-xl shadow-sky-500/10">
                    <img src="{{ asset('img/logo.png') }}" alt="LaundryGue Logo" class="w-full h-full object-contain">
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <svg class="animate-spin h-4 w-4 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span class="text-xs font-bold tracking-widest text-slate-600 uppercase">Memuat Status Pesanan...</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Background Subtle Accent -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-sky-200/40 blur-[120px] rounded-full pointer-events-none"></div>

    <!-- Header Sederhana -->
    <header class="w-full py-4 sm:py-6 px-4 sm:px-6 max-w-3xl mx-auto flex justify-between items-center z-10 gap-3">
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 sm:space-x-3 group">
            <img src="{{ asset('img/logo.png') }}" alt="LaundryGue Logo" class="w-9 h-9 sm:w-10 sm:h-10 object-contain rounded-xl shadow-md group-hover:scale-105 transition duration-300">
            <div>
                <span class="text-sm sm:text-base font-extrabold tracking-tight text-slate-900 block leading-none">LaundryGue</span>
                <span class="text-[9px] font-bold tracking-widest text-sky-600 uppercase">Live Tracking System</span>
            </div>
        </a>
        <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-700 hover:text-slate-900 transition flex items-center gap-1.5 bg-white border border-slate-200/90 shadow-sm px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> <span>Kembali</span><span class="hidden sm:inline">ke Beranda</span>
        </a>
    </header>

    <!-- Konten Utama -->
    <main class="w-full max-w-xl mx-auto px-4 py-4 sm:py-6 z-10 flex-grow flex items-center">
        <div class="w-full bg-white border border-slate-200/90 rounded-2xl sm:rounded-3xl shadow-xl shadow-slate-200/60 p-5 sm:p-8 relative overflow-hidden animate-fade-in-up" data-aos="zoom-in">

            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-500 via-blue-500 to-indigo-500"></div>

            @if(isset($isExpired) && $isExpired)
                <!-- KONDISI KEDALUWARSA: SUDAH LEWAT 1 HARI SEJAK SELESAI / DIAMBIL -->
                <div class="text-center py-6">
                    <div class="w-20 h-20 bg-amber-50 border border-amber-200 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md shadow-amber-500/10">
                        <i data-lucide="lock" class="w-10 h-10"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-700 bg-amber-50 px-3.5 py-1 rounded-full border border-amber-200">Akses Ditutup</span>
                    <h1 class="text-2xl font-black text-slate-900 mt-4 mb-1">Masa Akses Pelacakan Berakhir</h1>
                    <p class="text-xs font-mono text-slate-500 mb-6 bg-slate-100 py-1.5 px-3 rounded-lg inline-block border border-slate-200">{{ $transaction->invoice_code }}</p>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-sm text-slate-700 mb-8 text-left space-y-3">
                        <div class="flex items-start gap-3">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                            <p class="text-xs leading-relaxed text-slate-600">
                                Pesanan dengan nomor resi ini telah diselesaikan pada <span class="text-slate-900 font-semibold">{{ $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '' }}</span>.
                                Sesuai kebijakan privasi dan keamanan sistem LaundryGue, pelacakan otomatis ditutup dan <strong>tidak dapat diakses setelah 1 hari (24 jam)</strong> sejak cucian selesai.
                            </p>
                        </div>
                        <div class="border-t border-slate-200 pt-3 text-[11px] text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                            Jika membutuhkan informasi lebih lanjut mengenai arsip transaksi ini, silakan hubungi admin outlet kami.
                        </div>
                    </div>

                    <a href="{{ url('/') }}" class="w-full block bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg text-sm text-center">
                        Kembali ke Beranda
                    </a>
                </div>

            @else
                <!-- STATUS AKTIF: MENGIKUTI PERUBAHAN DARI PESANAN AKTIF -->
                <div class="text-center py-4 sm:py-6" id="heroSection">
                    <!-- Hero Big Icon Container -->
                    <div id="heroIconContainer" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-5 shadow-md transition-all duration-300
                        @if($transaction->status == 'Proses') bg-sky-50 border border-sky-200 text-sky-600 shadow-sky-100
                        @elseif($transaction->status == 'Selesai' || $transaction->status == 'Diambil') bg-emerald-50 border border-emerald-200 text-emerald-600 shadow-emerald-100
                        @else bg-amber-50 border border-amber-200 text-amber-600 shadow-amber-100 @endif">
                        <span id="heroIconWrapper">
                            @if($transaction->status == 'Baru')
                                <i data-lucide="package-plus" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                            @elseif($transaction->status == 'Proses')
                                <i data-lucide="loader-2" class="w-8 h-8 sm:w-10 sm:h-10 animate-spin"></i>
                            @elseif($transaction->status == 'Selesai')
                                <i data-lucide="check-check" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                            @elseif($transaction->status == 'Diambil')
                                <i data-lucide="check-circle-2" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                            @else
                                <i data-lucide="clock" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                            @endif
                        </span>
                    </div>

                    <!-- Badge Status Mengikuti Status Pesanan Aktif -->
                    <span id="heroBadge" class="text-xs font-bold uppercase tracking-widest px-3.5 py-1 rounded-full border transition-all duration-300
                        @if($transaction->status == 'Proses') text-sky-700 bg-sky-50 border-sky-200
                        @elseif($transaction->status == 'Selesai' || $transaction->status == 'Diambil') text-emerald-700 bg-emerald-50 border-emerald-200
                        @else text-amber-700 bg-amber-50 border-amber-200 @endif">
                        @if($transaction->status == 'Baru')
                            PESANAN BARU / DITERIMA
                        @elseif($transaction->status == 'Proses')
                            SEDANG DIPROSES
                        @elseif($transaction->status == 'Selesai')
                            SELESAI (SIAP AMBIL!)
                        @elseif($transaction->status == 'Diambil')
                            PESANAN DIAMBIL
                        @else
                            {{ strtoupper($transaction->status) }}
                        @endif
                    </span>

                    <!-- Heading Dinamis Mengikuti Status -->
                    <h1 id="heroTitle" class="text-2xl sm:text-3xl font-black text-slate-900 mt-3.5 mb-1 tracking-tight transition-all duration-300">
                        @if($transaction->status == 'Baru')
                            Cucian Baru Diterima
                        @elseif($transaction->status == 'Proses')
                            Cucian Sedang Diproses
                        @elseif($transaction->status == 'Selesai')
                            Cucian Selesai dan Siap Diambil!
                        @elseif($transaction->status == 'Diambil')
                            Cucian Telah Diserahkan
                        @else
                            Status Pengerjaan Laundry
                        @endif
                    </h1>

                    <p class="text-xs font-mono text-slate-500 mb-5 bg-slate-100 py-1.5 px-3 rounded-lg inline-block border border-slate-200/80">
                        Resi: <span class="text-slate-800 font-bold">{{ $transaction->invoice_code }}</span>
                    </p>

                    <!-- Info Box Deskripsi -->
                    <div id="heroNoticeBox" class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5 text-sm text-slate-700 mb-6 text-left space-y-3">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-sky-600 shrink-0 mt-0.5"></i>
                            <p id="heroDescription" class="text-xs leading-relaxed text-slate-600">
                                @if($transaction->status == 'Baru')
                                    Pesanan Anda telah diterima di outlet dan masuk antrean pengerjaan mesin cuci.
                                @elseif($transaction->status == 'Proses')
                                    Cucian sedang dalam tahap proses pencucian / pengeringan / setrika rapi oleh tim kami. Harap menunggu pemberitahuan selanjutnya.
                                @elseif($transaction->status == 'Selesai')
                                    Cucian sudah selesai dicuci, dikeringkan, dan disetrika rapi! Silakan ambil ke outlet dengan membawa nomor resi ini.
                                @elseif($transaction->status == 'Diambil')
                                    Cucian dengan nomor resi ini telah diserahkan dan diambil oleh pemilik pada <span class="text-slate-900 font-semibold">{{ $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '' }}</span>.
                                @else
                                    Pesanan Anda sedang diproses oleh staf LaundryGue.
                                @endif
                            </p>
                        </div>

                        <!-- Info Batas Akses 24 Jam jika Selesai / Diambil -->
                        <div id="expireCountdownBox" class="border-t border-slate-200 pt-3 flex items-center justify-between text-[11px] text-amber-700 font-medium {{ in_array($transaction->status, ['Selesai', 'Diambil']) ? '' : 'hidden' }}">
                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i> Akses pelacakan aktif sampai:</span>
                            <span id="expireTimeText" class="font-bold font-mono text-slate-800">{{ $transaction->updated_at ? Carbon\Carbon::parse($transaction->updated_at)->addDay()->format('d M Y, H:i') : '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelanggan & Petugas Kasir -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 space-y-3 mb-6 text-sm text-slate-700">
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 text-slate-500 font-medium"><i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Nama Pelanggan</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $transaction->customer_name }}</span>
                    </div>
                    <div class="border-t border-slate-200/80 pt-3 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 text-slate-500 font-medium"><i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i> Waktu Masuk</span>
                        <span class="font-semibold text-slate-800">{{ $transaction->created_at ? $transaction->created_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <div class="border-t border-slate-200/80 pt-3 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 text-slate-500 font-medium"><i data-lucide="shield-check" class="w-4 h-4 text-slate-400"></i> Petugas Kasir</span>
                        <span class="font-semibold text-slate-800">{{ $transaction->user->name ?? 'System Admin' }}</span>
                    </div>
                </div>

                <!-- Rincian Layanan & Tarif Cucian -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i data-lucide="receipt" class="w-4 h-4 text-sky-600"></i> Rincian Tarif & Layanan
                    </h2>
                    <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 space-y-3">
                        @forelse($transaction->details as $detail)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-800 font-medium">{{ $detail->service->name ?? 'Layanan' }} <span class="text-xs text-slate-500">({{ $detail->quantity }} {{ $detail->service->unit ?? 'Kg' }})</span></span>
                            <span class="font-mono font-bold text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @empty
                        <div class="text-xs text-slate-400 italic">Paket Layanan Laundry</div>
                        @endforelse
                        <div class="border-t border-slate-200 pt-3 flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-600">Total Biaya:</span>
                            <span class="text-sky-600 text-base font-mono font-black">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Resi & Validasi Mandiri -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 sm:p-5 text-center mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-2.5">QR Code Pelacakan & Validasi Resi</span>
                    <div class="inline-block p-2.5 bg-white rounded-xl shadow-md border border-slate-200/80">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode(url('/cek-pesanan/' . $transaction->invoice_code)) }}" 
                             alt="QR Cek Pesanan {{ $transaction->invoice_code }}" 
                             class="w-28 h-28 sm:w-32 sm:h-32 object-contain mx-auto"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] font-mono text-slate-500 mt-2.5">Scan kode QR di atas untuk membuka status nota langsung di ponsel</p>
                </div>

                @php
                    $rawWa = $settings['whatsapp'] ?? '6281220295876';
                    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
                    if (str_starts_with($cleanWa, '0')) {
                        $cleanWa = '62' . substr($cleanWa, 1);
                    }
                @endphp

                <div class="mt-6">
                    <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20LaundryGue,%20saya%20ingin%20menanyakan%20status%20pesanan%20dengan%20nomor%20resi%20*{{ $transaction->invoice_code }}*" target="_blank" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg shadow-emerald-600/20 text-sm">
                        <i data-lucide="message-circle" class="w-5 h-5"></i> Hubungi Outlet via WhatsApp
                    </a>
                </div>
            @endif

        </div>
    </main>

    <footer class="w-full py-6 text-center text-xs text-slate-500 z-10 border-t border-slate-200 bg-white/50 mt-10">
        <p>&copy; {{ date('Y') }} LaundryGue Enterprise System. All rights reserved.</p>
        @if(isset($settings['address']))
        <p class="text-slate-600 mt-1 max-w-md mx-auto">{{ $settings['address'] }}</p>
        @endif
        <p class="text-slate-400 mt-2 font-medium">Dibuat oleh <span class="text-sky-600 font-bold">nugua</span></p>
    </footer>

    <script>
        lucide.createIcons();

        @if($splashEnabled)
        // Splash Screen Handler
        function hideSplashScreen() {
            const splash = document.getElementById('splashScreen');
            if (splash) {
                splash.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => { splash.style.display = 'none'; }, 300);
            }
        }
        window.addEventListener('load', hideSplashScreen);
        setTimeout(hideSplashScreen, 800);
        window.addEventListener('pageshow', hideSplashScreen);
        @endif

        // AJAX Real-time Tracking Synchronization
        const invoiceCode = "{{ $transaction->invoice_code }}";
        let currentStatus = "{{ $transaction->status }}";

        function updateTrackingUI(data) {
            // 1. Update Badge Text & Style (White theme)
            const badge = document.getElementById('heroBadge');
            if (badge) {
                badge.textContent = data.badge;
                badge.className = 'text-xs font-bold uppercase tracking-widest px-3.5 py-1 rounded-full border transition-all duration-300 ';
                if (data.theme === 'emerald') {
                    badge.classList.add('text-emerald-700', 'bg-emerald-50', 'border-emerald-200');
                } else if (data.theme === 'amber') {
                    badge.classList.add('text-amber-700', 'bg-amber-50', 'border-amber-200');
                } else {
                    badge.classList.add('text-sky-700', 'bg-sky-50', 'border-sky-200');
                }
            }

            // 2. Update Title
            const title = document.getElementById('heroTitle');
            if (title) {
                title.textContent = data.heading;
            }

            // 3. Update Hero Icon & Container (White theme)
            const iconContainer = document.getElementById('heroIconContainer');
            if (iconContainer) {
                iconContainer.className = 'w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-5 shadow-md transition-all duration-300 ';
                if (data.theme === 'emerald') {
                    iconContainer.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'text-emerald-600', 'shadow-emerald-100');
                } else if (data.theme === 'amber') {
                    iconContainer.classList.add('bg-amber-50', 'border', 'border-amber-200', 'text-amber-600', 'shadow-amber-100');
                } else {
                    iconContainer.classList.add('bg-sky-50', 'border', 'border-sky-200', 'text-sky-600', 'shadow-sky-100');
                }
            }

            const iconWrapper = document.getElementById('heroIconWrapper');
            if (iconWrapper) {
                const spinClass = data.spin ? 'animate-spin' : '';
                iconWrapper.innerHTML = `<i data-lucide="${data.icon}" class="w-8 h-8 sm:w-10 sm:h-10 ${spinClass}"></i>`;
            }

            // 4. Update Deskripsi Status
            const description = document.getElementById('heroDescription');
            if (description) {
                description.textContent = data.description;
            }

            // 5. Update Countdown Expire Box
            const expireBox = document.getElementById('expireCountdownBox');
            const expireTimeText = document.getElementById('expireTimeText');
            if (expireBox && expireTimeText) {
                if (data.is_completed && data.expire_time) {
                    expireTimeText.textContent = data.expire_time;
                    expireBox.classList.remove('hidden');
                } else {
                    expireBox.classList.add('hidden');
                }
            }

            // Render ulang icon Lucide
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons();
            }
        }

        @if(!isset($isExpired) || !$isExpired)
        let trackingPollInterval = null;

        function pollOrderStatus() {
            fetch(`/cek-pesanan/${invoiceCode}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) return null;
                return res.json();
            })
            .then(data => {
                if (!data) return;

                // Jika sudah kedaluwarsa (> 24 jam), reload halaman untuk menampilkan pesan akses ditutup
                if (data.is_expired) {
                    if (trackingPollInterval) clearInterval(trackingPollInterval);
                    window.location.reload();
                    return;
                }

                // Jika status pesanan berubah dari admin/kasir (misal 'Diambil' -> 'Proses' atau sebaliknya)
                if (data.status !== currentStatus) {
                    currentStatus = data.status;
                    updateTrackingUI(data);
                }
            })
            .catch(err => {
                console.log('Poll tracking info:', err);
            });
        }

        // Cek update status pesanan setiap 3 detik
        trackingPollInterval = setInterval(pollOrderStatus, 3000);
        @endif
    </script>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 750,
                once: false,
                mirror: true,
                offset: 50,
                easing: 'ease-out-cubic'
            });
        }
    </script>
</body>
</html>
