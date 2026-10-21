<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Resi #{{ $transaction->invoice_code }} — LaundryGue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-sky-500 selection:text-white relative overflow-x-hidden">

    <!-- Splash Screen Page Transition -->
    <div id="splashScreen" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-950/95 backdrop-blur-md transition-all duration-300 pointer-events-auto">
        <div class="flex flex-col items-center text-center p-6">
            <div class="relative flex items-center justify-center mb-5">
                <div class="absolute w-20 h-20 rounded-2xl bg-sky-500/20 animate-ping"></div>
                <div class="w-16 h-16 rounded-2xl bg-slate-900 border border-slate-700 text-sky-400 flex items-center justify-center font-black text-2xl shadow-2xl shadow-sky-500/20">
                    <span>LG</span>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <svg class="animate-spin h-4 w-4 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span class="text-xs font-bold tracking-widest text-slate-300 uppercase">Memuat Status Pesanan...</span>
            </div>
        </div>
    </div>

    <!-- Background Glow Effects -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-sky-500/10 blur-[120px] rounded-full pointer-events-none"></div>

    <!-- Header Sederhana -->
    <header class="w-full py-4 sm:py-6 px-4 sm:px-6 max-w-3xl mx-auto flex justify-between items-center z-10 gap-3">
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 sm:space-x-3 group">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-900 border border-slate-800 text-sky-400 flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                <i data-lucide="waves" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            </div>
            <div>
                <span class="text-sm sm:text-base font-extrabold tracking-tight text-white block leading-none">LaundryGue</span>
                <span class="text-[9px] font-bold tracking-widest text-sky-400 uppercase">Live Tracking System</span>
            </div>
        </a>
        <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1.5 bg-slate-900/80 border border-slate-800 px-3 sm:px-4 py-2 rounded-xl whitespace-nowrap">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> <span>Kembali</span><span class="hidden sm:inline">ke Beranda</span>
        </a>
    </header>

    <!-- Konten Utama -->
    <main class="w-full max-w-xl mx-auto px-4 py-4 sm:py-6 z-10 flex-grow flex items-center">
        <div class="w-full bg-slate-900/90 backdrop-blur-2xl border border-slate-800/80 rounded-2xl sm:rounded-3xl shadow-2xl p-5 sm:p-8 relative overflow-hidden animate-fade-in-up">

            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-500 via-indigo-500 to-sky-400"></div>

            @if(isset($isExpired) && $isExpired)
                <!-- KONDISI KEDALUWARSA: SUDAH LEWAT 1 HARI SEJAK SELESAI / DIAMBIL -->
                <div class="text-center py-6">
                    <div class="w-20 h-20 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-amber-500/5">
                        <i data-lucide="lock" class="w-10 h-10"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20">Akses Ditutup</span>
                    <h1 class="text-2xl font-black text-white mt-4 mb-1">Masa Akses Pelacakan Berakhir</h1>
                    <p class="text-xs font-mono text-slate-400 mb-6 bg-slate-950/50 py-1.5 px-3 rounded-lg inline-block border border-slate-800">{{ $transaction->invoice_code }}</p>

                    <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 text-sm text-slate-300 mb-8 text-left space-y-3">
                        <div class="flex items-start gap-3">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-amber-400 shrink-0 mt-0.5"></i>
                            <p class="text-xs leading-relaxed text-slate-400">
                                Pesanan dengan nomor resi ini telah diselesaikan pada <span class="text-slate-200 font-semibold">{{ $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '' }}</span>.
                                Sesuai kebijakan privasi dan keamanan sistem LaundryGue, pelacakan otomatis ditutup dan <strong>tidak dapat diakses setelah 1 hari (24 jam)</strong> sejak cucian selesai.
                            </p>
                        </div>
                        <div class="border-t border-slate-800/80 pt-3 text-[11px] text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                            Jika membutuhkan informasi lebih lanjut mengenai arsip transaksi ini, silakan hubungi admin outlet kami.
                        </div>
                    </div>

                    <a href="{{ url('/') }}" class="w-full block bg-slate-800 hover:bg-slate-700 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg text-sm border border-slate-700 text-center">
                        Kembali ke Beranda
                    </a>
                </div>

            @else
                <!-- STATUS AKTIF: MENGIKUTI PERUBAHAN DARI PESANAN AKTIF -->
                <div class="text-center py-4 sm:py-6" id="heroSection">
                    <!-- Hero Big Icon Container -->
                    <div id="heroIconContainer" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-5 shadow-xl transition-all duration-300
                        @if($transaction->status == 'Proses') bg-sky-500/10 border border-sky-500/20 text-sky-400 shadow-sky-500/5
                        @elseif($transaction->status == 'Selesai' || $transaction->status == 'Diambil') bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 shadow-emerald-500/5
                        @else bg-amber-500/10 border border-amber-500/20 text-amber-400 shadow-amber-500/5 @endif">
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
                        @if($transaction->status == 'Proses') text-sky-400 bg-sky-500/10 border-sky-500/20
                        @elseif($transaction->status == 'Selesai' || $transaction->status == 'Diambil') text-emerald-400 bg-emerald-500/10 border-emerald-500/20
                        @else text-amber-400 bg-amber-500/10 border-amber-500/20 @endif">
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
                    <h1 id="heroTitle" class="text-2xl sm:text-3xl font-black text-white mt-3.5 mb-1 tracking-tight transition-all duration-300">
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

                    <p class="text-xs font-mono text-slate-400 mb-5 bg-slate-950/60 py-1.5 px-3 rounded-lg inline-block border border-slate-800">
                        Resi: <span class="text-slate-200 font-bold">{{ $transaction->invoice_code }}</span>
                    </p>

                    <!-- Info Box Deskripsi -->
                    <div id="heroNoticeBox" class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 sm:p-5 text-sm text-slate-300 mb-6 text-left space-y-3">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-sky-400 shrink-0 mt-0.5"></i>
                            <p id="heroDescription" class="text-xs leading-relaxed text-slate-400">
                                @if($transaction->status == 'Baru')
                                    Pesanan Anda telah diterima di outlet dan masuk antrean pengerjaan mesin cuci.
                                @elseif($transaction->status == 'Proses')
                                    Cucian sedang dalam tahap proses pencucian / pengeringan / setrika rapi oleh tim kami. Harap menunggu pemberitahuan selanjutnya.
                                @elseif($transaction->status == 'Selesai')
                                    Cucian sudah selesai dicuci, dikeringkan, dan disetrika rapi! Silakan ambil ke outlet dengan membawa nomor resi ini.
                                @elseif($transaction->status == 'Diambil')
                                    Cucian dengan nomor resi ini telah diserahkan dan diambil oleh pemilik pada <span class="text-slate-200 font-semibold">{{ $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '' }}</span>.
                                @else
                                    Pesanan Anda sedang diproses oleh staf LaundryGue.
                                @endif
                            </p>
                        </div>

                        <!-- Info Batas Akses 24 Jam jika Selesai / Diambil -->
                        <div id="expireCountdownBox" class="border-t border-slate-800/80 pt-3 flex items-center justify-between text-[11px] text-amber-300 {{ in_array($transaction->status, ['Selesai', 'Diambil']) ? '' : 'hidden' }}">
                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5"></i> Akses pelacakan aktif sampai:</span>
                            <span id="expireTimeText" class="font-bold font-mono">{{ $transaction->updated_at ? Carbon\Carbon::parse($transaction->updated_at)->addDay()->format('d M Y, H:i') : '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelanggan & Petugas Kasir -->
                <div class="bg-slate-950/40 border border-slate-800/80 rounded-2xl p-4 space-y-3 mb-6 text-sm">
                    <div class="flex justify-between items-center text-slate-400 text-xs">
                        <span class="flex items-center gap-1.5"><i data-lucide="user" class="w-4 h-4 text-slate-500"></i> Nama Pelanggan</span>
                        <span class="font-bold text-slate-200 text-sm">{{ $transaction->customer_name }}</span>
                    </div>
                    <div class="border-t border-slate-800/60 pt-3 flex justify-between items-center text-slate-400 text-xs">
                        <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i> Waktu Masuk</span>
                        <span class="font-semibold text-slate-200">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="border-t border-slate-800/60 pt-3 flex justify-between items-center text-slate-400 text-xs">
                        <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-4 h-4 text-slate-500"></i> Petugas Kasir</span>
                        <span class="font-semibold text-slate-200">{{ $transaction->user->name ?? 'System Admin' }}</span>
                    </div>
                </div>

                <!-- Rincian Layanan & Tarif Cucian -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i data-lucide="receipt" class="w-4 h-4 text-sky-400"></i> Rincian Tarif & Layanan
                    </h2>
                    <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 space-y-3">
                        @foreach($transaction->details as $detail)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-300 font-medium">{{ $detail->service->name ?? 'Layanan' }} <span class="text-xs text-slate-500">({{ $detail->quantity }} {{ $detail->service->unit ?? 'Kg' }})</span></span>
                            <span class="font-mono font-semibold text-slate-200">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <div class="border-t border-slate-800 pt-3 flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-400">Total Biaya:</span>
                            <span class="text-sky-400 text-base font-mono">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if(isset($settings['whatsapp']))
                <div class="mt-6">
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}?text=Halo%20Admin%20LaundryGue,%20saya%20ingin%20menanyakan%20status%20pesanan%20dengan%20nomor%20resi%20*{{ $transaction->invoice_code }}*" target="_blank" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg shadow-emerald-900/20 text-sm">
                        <i data-lucide="message-circle" class="w-5 h-5"></i> Hubungi Outlet via WhatsApp
                    </a>
                </div>
                @endif
            @endif

        </div>
    </main>

    <footer class="w-full py-6 text-center text-xs text-slate-500 z-10 border-t border-slate-900/80 mt-10">
        <p>&copy; {{ date('Y') }} LaundryGue Enterprise System. All rights reserved.</p>
        @if(isset($settings['address']))
        <p class="text-slate-600 mt-1 max-w-md mx-auto">{{ $settings['address'] }}</p>
        @endif
        <p class="text-slate-400 mt-2 font-medium">Dibuat oleh <span class="text-sky-400 font-bold">nugua</span></p>
    </footer>

    <script>
        lucide.createIcons();

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

        // AJAX Real-time Tracking Synchronization
        const invoiceCode = "{{ $transaction->invoice_code }}";
        let currentStatus = "{{ $transaction->status }}";

        function updateTrackingUI(data) {
            // 1. Update Badge Text & Style
            const badge = document.getElementById('heroBadge');
            if (badge) {
                badge.textContent = data.badge;
                badge.className = 'text-xs font-bold uppercase tracking-widest px-3.5 py-1 rounded-full border transition-all duration-300 ';
                if (data.theme === 'emerald') {
                    badge.classList.add('text-emerald-400', 'bg-emerald-500/10', 'border-emerald-500/20');
                } else if (data.theme === 'amber') {
                    badge.classList.add('text-amber-400', 'bg-amber-500/10', 'border-amber-500/20');
                } else {
                    badge.classList.add('text-sky-400', 'bg-sky-500/10', 'border-sky-500/20');
                }
            }

            // 2. Update Title
            const title = document.getElementById('heroTitle');
            if (title) {
                title.textContent = data.heading;
            }

            // 3. Update Hero Icon & Container
            const iconContainer = document.getElementById('heroIconContainer');
            if (iconContainer) {
                iconContainer.className = 'w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-5 shadow-xl transition-all duration-300 ';
                if (data.theme === 'emerald') {
                    iconContainer.classList.add('bg-emerald-500/10', 'border', 'border-emerald-500/20', 'text-emerald-400', 'shadow-emerald-500/5');
                } else if (data.theme === 'amber') {
                    iconContainer.classList.add('bg-amber-500/10', 'border', 'border-amber-500/20', 'text-amber-400', 'shadow-amber-500/5');
                } else {
                    iconContainer.classList.add('bg-sky-500/10', 'border', 'border-sky-500/20', 'text-sky-400', 'shadow-sky-500/5');
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
            lucide.createIcons();
        }

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
        setInterval(pollOrderStatus, 3000);
    </script>
</body>
</html>

