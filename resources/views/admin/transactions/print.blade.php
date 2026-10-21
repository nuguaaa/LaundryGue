<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan Laundry</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; color: #1e293b; margin: 0; padding: 20px; font-size: 13px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #0f172a; padding-bottom: 12px; }
        .header h2 { margin: 0 0 6px 0; font-size: 20px; font-weight: 800; color: #0f172a; }
        .header p { margin: 3px 0; font-size: 12px; color: #64748b; }
        .summary { display: flex; justify-content: space-between; gap: 15px; margin-bottom: 25px; background: #f8fafc; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .summary div { text-align: center; flex: 1; }
        .summary small { text-transform: uppercase; font-size: 10px; font-weight: 700; letter-spacing: 0.5px; color: #64748b; display: block; margin-bottom: 4px; }
        .summary h3 { margin: 0; font-size: 18px; font-weight: 800; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: left; }
        th { background-color: #f1f5f9; font-weight: 700; color: #334155; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; text-align: right; float: right; font-size: 12px; }

        /* Pengaturan khusus saat dicetak (Print Mode) */
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol kembali (tidak ikut tercetak) -->
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.history.back()" style="padding: 8px 15px; cursor: pointer;">&larr; Kembali</button>
        <button onclick="window.print()" style="padding: 8px 15px; cursor: pointer; background: #4f46e5; color: white; border: none; border-radius: 4px; margin-left: 10px;">Cetak / Print</button>
    </div>

    <div class="header">
        <h2>LAPORAN KEUANGAN LAUNDRY</h2>
        <p>Periode Filter: <strong>{{ strtoupper($filter == '' ? 'SEMUA WAKTU' : $filter) }}</strong></p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- Ringkasan Keuangan -->
    <div class="summary">
        <div>
            <small>Total Pendapatan</small>
            <h3 style="color: #2563eb;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
        <div>
            <small>Total Pengeluaran</small>
            <h3 style="color: #dc2626;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div>
            <small>Profit Bersih</small>
            <h3 style="color: #16a34a;">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Tabel Rincian Pendapatan -->
    <h3>A. Riwayat Pendapatan Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->invoice_code }}</td>
                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                <td>{{ $trx->customer_name }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pendapatan untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabel Rincian Pengeluaran -->
    <h3>B. Rincian Pengeluaran Operasional</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengeluaran</th>
                <th>Tanggal</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $index => $exp)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $exp->item_name }}</td>
                <td>{{ $exp->created_at->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($exp->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data pengeluaran untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Pimpinan / Admin Laundry</p>
        <br><br><br>
        <p><strong>( ___________________ )</strong></p>
    </div>

    <div style="clear: both; padding-top: 40px; text-align: center; font-size: 11px; color: #64748b;">
        <p>Sistem Informasi LaundryGue &bull; Dibuat oleh <strong>nugua</strong></p>
    </div>

</body>
</html>
