<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan Laundry</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 20px; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2, .header p { margin: 5px 0; }
        .summary { display: flex; justify-content: space-between; margin-bottom: 20px; background: #f4f4f4; padding: 15px; border-radius: 5px; }
        .summary div { text-align: center; flex: 1; }
        .summary h3 { margin: 5px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; text-align: right; float: right; }

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

</body>
</html>
