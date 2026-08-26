<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;

class FinancialReportSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data untuk HARI INI
        for ($i = 1; $i <= 3; $i++) {
            $today = Carbon::today();

            $trx = Transaction::create([
                'invoice_code' => 'INV-TODAY-' . rand(100, 999),
                'customer_name' => 'Pelanggan Hari Ini ' . $i,
                'customer_phone' => '081111222' . $i,
                'total_price' => 75000 * $i,
                'status' => 'Diambil',
                'user_id' => 1,
                'created_at' => $today,
                'updated_at' => $today,
            ]);

            $trx->details()->create([
                'service_id' => 1,
                'quantity' => 1,
                'subtotal' => $trx->total_price
            ]);

            Expense::create([
                'item_name' => 'Sabun Cuci Hari Ini #' . $i,
                'quantity' => 2,
                'unit_price' => 15000,
                'total_price' => 30000,
                'created_at' => $today,
                'updated_at' => $today,
            ]);
        }

        // 2. Buat Data untuk BULAN INI (Agustus 2026) tapi bukan hari ini
        for ($i = 1; $i <= 4; $i++) {
            $thisMonth = Carbon::now()->startOfMonth()->addDays(rand(1, 15));

            $trx = Transaction::create([
                'invoice_code' => 'INV-MONTH-' . rand(100, 999),
                'customer_name' => 'Pelanggan Bulan Ini ' . $i,
                'customer_phone' => '082222333' . $i,
                'total_price' => 150000,
                'status' => 'Diambil',
                'user_id' => 1,
                'created_at' => $thisMonth,
                'updated_at' => $thisMonth,
            ]);

            $trx->details()->create([
                'service_id' => 1,
                'quantity' => 2,
                'subtotal' => $trx->total_price
            ]);

            Expense::create([
                'item_name' => 'Pewangi Pakaian Bulanan #' . $i,
                'quantity' => 1,
                'unit_price' => 50000,
                'total_price' => 50000,
                'created_at' => $thisMonth,
                'updated_at' => $thisMonth,
            ]);
        }

        // 3. Buat Data untuk TAHUN LALU (2025) - Nilai besar untuk menguji filter
        for ($i = 1; $i <= 3; $i++) {
            $lastYear = Carbon::now()->subYear();

            $trx = Transaction::create([
                'invoice_code' => 'INV-OLD-' . rand(100, 999),
                'customer_name' => 'Pelanggan Tahun Lalu ' . $i,
                'customer_phone' => '083333444' . $i,
                'total_price' => 500000,
                'status' => 'Diambil',
                'user_id' => 1,
                'created_at' => $lastYear,
                'updated_at' => $lastYear,
            ]);

            $trx->details()->create([
                'service_id' => 1,
                'quantity' => 5,
                'subtotal' => $trx->total_price
            ]);

            Expense::create([
                'item_name' => 'Maintenance Mesin Tahun Lalu #' . $i,
                'quantity' => 1,
                'unit_price' => 200000,
                'total_price' => 200000,
                'created_at' => $lastYear,
                'updated_at' => $lastYear,
            ]);
        }
    }
}
