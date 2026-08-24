<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - {{ $transaction->invoice_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-md p-6 border border-gray-100">

        @if($transaction->status == 'Diambil')
            <!-- TAMPILAN JIKA PESANAN SUDAH DIAMBIL (TIDAK AKTIF) -->
            <div class="text-center py-6">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                    ✓
                </div>
                <h1 class="text-xl font-black text-gray-800 mb-1">PESANAN TELAH SELESAI</h1>
                <p class="text-sm text-gray-500 font-mono mb-4">{{ $transaction->invoice_code }}</p>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600 mb-6">
                    Pesanan dengan nomor nota ini <strong>sudah diambil</strong> oleh pemilik pada tanggal {{ $transaction->updated_at->format('d M Y, H:i') }}. Halaman pengecekan ini sudah tidak aktif.
                </div>

                <div class="text-xs text-gray-400">
                    <p>Terima kasih telah menggunakan jasa Laundry Kami.</p>
                </div>
            </div>
        @else
            <!-- TAMPILAN NORMAL JIKA MASIH BERJALAN (BARU / PROSES / SELESAI) -->
            <div class="text-center mb-6">
                <h1 class="text-xl font-black text-gray-800">STATUS PESANAN LAUNDRY</h1>
                <p class="text-sm text-gray-500 font-mono mt-1">{{ $transaction->invoice_code }}</p>
            </div>

            <!-- Status Badge -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-center mb-6">
                <span class="text-xs text-blue-600 font-semibold uppercase tracking-wider block mb-1">Status Saat Ini:</span>
                <span class="text-xl font-bold text-blue-700">
                    @if($transaction->status == 'Baru') 📥 Sedang Diterima / Menunggu Antrean
                    @elseif($transaction->status == 'Proses') 🔄 Sedang Dicuci & Diproses
                    @elseif($transaction->status == 'Selesai') ✅ Selesai & Siap Diambil
                    @else {{ $transaction->status }}
                    @endif
                </span>
            </div>

            <!-- Detail Informasi Pelanggan -->
            <div class="space-y-3 text-sm text-gray-600 border-b border-gray-100 pb-4 mb-4">
                <div class="flex justify-between">
                    <span>Nama Pelanggan:</span>
                    <span class="font-semibold text-gray-800">{{ $transaction->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tanggal Masuk:</span>
                    <span class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <!-- Rincian Layanan -->
            <div class="mb-6">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Rincian Cucian</h2>
                <div class="bg-gray-50 rounded-xl p-3 space-y-2">
                    @foreach($transaction->details as $detail)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">{{ $detail->service->name ?? 'Layanan' }} ({{ $detail->quantity }} {{ $detail->service->unit ?? 'Kg' }})</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <div class="border-t pt-2 flex justify-between text-sm font-bold text-gray-900">
                        <span>Total Biaya:</span>
                        <span class="text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center text-xs text-gray-400">
                <p>Terima kasih telah mempercayakan cucian Anda di Laundry Kami.</p>
            </div>
        @endif

    </div>

</body>
</html>
