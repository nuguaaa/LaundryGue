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
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-sky-500 selection:text-white relative overflow-x-hidden">

    <!-- Background Glow Effects -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-sky-500/10 blur-[120px] rounded-full pointer-events-none"></div>

    <!-- Header Sederhana -->
    <header class="w-full py-6 px-6 max-w-3xl mx-auto flex justify-between items-center z-10">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-sky-400 flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                <i data-lucide="waves" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-base font-extrabold tracking-tight text-white block leading-none">LaundryGue</span>
                <span class="text-[9px] font-bold tracking-widest text-sky-400 uppercase">Live Tracking System</span>
            </div>
        </a>
        <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1.5 bg-slate-900/80 border border-slate-800 px-4 py-2 rounded-xl">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda
        </a>
    </header>

    <!-- Konten Utama -->
    <main class="w-full max-w-xl mx-auto px-4 py-6 z-10 flex-grow flex items-center">
        <div class="w-full bg-slate-900/90 backdrop-blur-2xl border border-slate-800/80 rounded-3xl shadow-2xl p-8 relative overflow-hidden">

            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-500 via-indigo-500 to-sky-400"></div>

            @if($transaction->status == 'Diambil')
                <div class="text-center py-6">
                    <div class="w-20 h-20 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-500/5">
                        <i data-lucide="check-circle-2" class="w-10 h-10"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">Arsip Selesai</span>
                    <h1 class="text-2xl font-black text-white mt-4 mb-1">Pesanan Telah Diambil</h1>
                    <p class="text-xs font-mono text-slate-400 mb-6 bg-slate-950/50 py-1.5 px-3 rounded-lg inline-block border border-slate-800">{{ $transaction->invoice_code }}</p>

                    <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 text-sm text-slate-300 mb-8 text-left space-y-2">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-sky-400 shrink-0 mt-0.5"></i>
                            <p class="text-xs leading-relaxed text-slate-400">
                                Cucian dengan nomor resi ini telah diserahterimakan kepada pemilik pada <span class="text-slate-200 font-semibold">{{ $transaction->updated_at->format('d M Y, H:i') }}</span>. Tautan pelacakan ini otomatis dinonaktifkan demi privasi.
                            </p>
                        </div>
                    </div>

                    <a href="{{ url('/') }}" class="w-full block bg-slate-800 hover:bg-slate-700 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg text-sm border border-slate-700">
                        Buat Pesanan Baru
                    </a>
                </div>
            @else
                <div class="text-center mb-8">
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-400 bg-sky-500/10 px-3 py-1 rounded-full border border-sky-500/20">Real-Time Status</span>
                    <h1 class="text-2xl font-black text-white mt-3 mb-1">Status Pengerjaan Laundry</h1>
                    <p class="text-xs font-mono text-slate-400 bg-slate-950/50 py-1 px-3 rounded-lg inline-block border border-slate-800 mt-1">Resi: {{ $transaction->invoice_code }}</p>
                </div>

                <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 mb-6 text-center relative">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Posisi Proses Saat Ini</span>
                    <div class="flex items-center justify-center gap-3 text-sky-400">
                        @if($transaction->status == 'Baru')
                            <i data-lucide="package-plus" class="w-7 h-7 animate-pulse text-sky-400"></i>
                            <span class="text-lg font-extrabold text-white">Sedang Diterima & Masuk Antrean</span>
                        @elseif($transaction->status == 'Proses')
                            <i data-lucide="loader-2" class="w-7 h-7 animate-spin text-sky-400"></i>
                            <span class="text-lg font-extrabold text-white">Sedang Dicuci & Diproses</span>
                        @elseif($transaction->status == 'Selesai')
                            <i data-lucide="check-check" class="w-7 h-7 text-emerald-400"></i>
                            <span class="text-lg font-extrabold text-emerald-400">Selesai & Siap Diambil!</span>
                        @else
                            <span class="text-lg font-extrabold text-white">{{ $transaction->status }}</span>
                        @endif
                    </div>
                </div>

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
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
