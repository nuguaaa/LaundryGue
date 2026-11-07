<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Laundry - {{ $transaction->invoice_code }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: 0 auto; padding: 10px; color: #000; font-size: 12px; }
        .text-center { text-align: center; }
        .flex { display: flex; justify-content: space-between; }
        .border-bottom { border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px; }
        table { width: 100%; font-size: 12px; }
        .no-print { margin-bottom: 15px; text-align: center; }
        @media print {
            .no-print { display: none; }
            body { width: 100%; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Aksi (Hilang saat diprint) -->
    <div class="no-print" style="margin-bottom: 15px; text-align: center; display: flex; flex-direction: column; gap: 8px; align-items: center;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;">
            <a href="{{ route('admin.transactions.create') }}" style="text-decoration: none; padding: 6px 12px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; font-weight: bold; font-size: 11px; background: #ffffff; color: #1e293b; display: inline-flex; align-items: center; gap: 4px;">&larr; Kembali ke Kasir</a>
            <a href="{{ route('admin.transactions.index') }}" style="text-decoration: none; padding: 6px 12px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; font-weight: bold; font-size: 11px; background: #f1f5f9; color: #1e293b; display: inline-flex; align-items: center; gap: 4px;">📋 Pesanan Aktif</a>
            <button onclick="window.print()" style="padding: 6px 12px; cursor: pointer; background: #000; color: #fff; border-radius: 6px; border: none; font-weight: bold; font-size: 11px;">🖨️ Cetak Struk</button>
        </div>

        @php
            $rawPhone = $transaction->customer_phone;
            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }
            $trackingLink = url('/cek-pesanan/' . $transaction->invoice_code);
            $waMsg = "Halo kak *" . $transaction->customer_name . "*,\n\n"
                   . "Terima kasih telah mempercayakan pakaian Anda di *LaundryGue*! ✨\n\n"
                   . "🧾 *NOTA DIGITAL LAUNDRY*\n"
                   . "• No. Nota: *" . $transaction->invoice_code . "*\n"
                   . "• Tanggal : " . $transaction->created_at->format('d/m/Y H:i') . "\n";
            foreach($transaction->details as $d) {
                $waMsg .= "• " . ($d->service->name ?? 'Layanan') . " (" . $d->quantity . " " . ($d->service->unit ?? 'Kg') . ") : Rp " . number_format($d->subtotal, 0, ',', '.') . "\n";
            }
            $waMsg .= "• *Total Biaya: Rp " . number_format($transaction->total_price, 0, ',', '.') . "*\n"
                   . "• Status Cucian: *" . $transaction->status . "*\n\n"
                   . "🔍 Anda dapat memantau proses pengerjaan cucian secara berkala melalui link berikut:\n" . $trackingLink . "\n\n"
                   . "Pakaian Anda kami cuci bersih, wangi, dan rapi! 🧺";
        @endphp

        @if(!empty($cleanPhone) && strlen($cleanPhone) >= 7)
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waMsg) }}" target="_blank"
               style="display: inline-block; padding: 7px 14px; background: #16a34a; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 11px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                📱 Kirim Nota ke WhatsApp Pelanggan
            </a>
        @endif
    </div>

    <!-- Header Toko (Mengambil dari Database Settings & Nama LaundryGue) -->
    <div class="text-center border-bottom">
        <h3 style="margin: 0;">LAUNDRY GUE</h3>
        <p style="margin: 2px 0;">{{ $settings['address'] ?? 'Alamat belum diatur' }}</p>
        <br>
        <p style="margin: 2px 0;">Telp/WA: {{ $settings['whatsapp'] ?? 'Belum diatur' }}</p>
    </div>

    <!-- Info Transaksi -->
    <div class="border-bottom">
        <p style="margin: 2px 0;">No. Nota: <strong>{{ $transaction->invoice_code }}</strong></p>
        <p style="margin: 2px 0;">Tanggal : {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        <p style="margin: 2px 0;">Kasir   : {{ $transaction->user->name ?? 'Admin' }}</p>
        <p style="margin: 2px 0;">Pelanggan: {{ $transaction->customer_name }}</p>
    </div>

    <!-- Detail Item -->
    <div class="border-bottom">
        <table>
            @foreach($transaction->details as $detail)
            <tr>
                <td colspan="2"><strong>{{ $detail->service->name ?? 'Layanan' }}</strong></td>
            </tr>
            <tr>
                <td>{{ $detail->quantity }} {{ $detail->service->unit ?? 'Kg' }} x Rp {{ number_format($detail->service->price ?? 0, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Total Pembayaran -->
    <div class="border-bottom">
        <div class="flex">
            <span><strong>Total Bayar:</strong></span>
            <span><strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></span>
        </div>
        <div class="flex">
            <span>Status:</span>
            <span><strong>{{ $transaction->status }}</strong></span>
        </div>
    </div>

    <!-- Bagian QR Code untuk Cek Pesanan -->
    <div class="text-center" style="margin-top: 15px;">
        <p style="margin: 0 0 5px 0; font-size: 11px;">Scan QR di bawah untuk cek status cucian:</p>

        @php
            $checkUrl = url('/cek-pesanan/' . $transaction->invoice_code);
        @endphp
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($checkUrl) }}" alt="QR Cek Pesanan" style="width: 110px; height: 110px;">

        <p style="font-size: 10px; margin: 5px 0 0 0; color: #555;">{{ $transaction->invoice_code }}</p>
    </div>

    <div class="text-center" style="margin-top: 15px; font-size: 11px;">
        <p style="margin: 2px 0;">Terima Kasih Atas Kunjungan Anda di LaundryGue</p>
        <p style="margin: 2px 0;">Cucian belum diambil > 30 hari diluar tanggung jawab kami.</p>
        <p style="margin: 4px 0 0 0; font-size: 10px; color: #555;">Dibuat oleh <strong>nugua</strong></p>
    </div>

</body>
</html>
