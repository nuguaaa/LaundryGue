<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun
        $admin = User::firstOrCreate(['email' => 'admin1@gmail.com'], ['name' => 'Admin', 'password' => Hash::make('12345678')]);

        // 2. Services (Singkat agar tidak panjang)
        $services = [['name' => 'Cuci Express', 'price' => 10000], ['name' => 'Deep Clean', 'price' => 40000]];
        foreach ($services as $s) Service::firstOrCreate(['name' => $s['name']], $s);
        $sId = Service::first()->id;

        // 3. SEEDER DATA MASIF (Tahun 2026)
        // Kita buat 50 data transaksi dan 50 pengeluaran tersebar di tahun 2026
        for ($i = 1; $i <= 50; $i++) {
            // Random tanggal di tahun 2026
            $randomDate = Carbon::create(2026, rand(1, 8), rand(1, 28), rand(8, 20));

            // Transaksi (Pendapatan)
            $trx = Transaction::create([
                'invoice_code' => 'INV-2026-' . $i,
                'customer_name' => 'Pelanggan ' . $i,
                'customer_phone' => '08123456789',
                'total_price' => rand(5, 20) * 10000,
                'status' => 'Diambil',
                'user_id' => $admin->id,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
            $trx->details()->create(['service_id' => $sId, 'quantity' => 1, 'subtotal' => $trx->total_price]);

            // Pengeluaran
            Expense::create([
                'item_name' => 'Item Pengeluaran ' . $i,
                'quantity' => 1,
                'unit_price' => rand(1, 5) * 10000,
                'total_price' => rand(1, 5) * 10000,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
