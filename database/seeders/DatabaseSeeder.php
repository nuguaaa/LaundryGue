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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Default (Admin & Kasir)
        $admin = User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin Laundry',
                'password' => Hash::make('12345678'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir1@gmail.com'],
            [
                'name' => 'Kasir Laundry',
                'password' => Hash::make('12345678'),
            ]
        );

        // 2. Data Daftar Harga Sesuai Gambar Desain Asli
        $services = [
            // --- LAUNDRY BAJU ---
            [
                'category' => 'Laundry Baju',
                'name' => 'Cuci Sertrika Wangi (2 Hari)',
                'duration' => '2 Hari',
                'price' => 7000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Cuci Sertrika Wangi (1 Hari)',
                'duration' => '1 Hari',
                'price' => 10000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Cuci Sertrika Wangi (6 Jam)',
                'duration' => '6 Jam',
                'price' => 12000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Sertrika Wangi (2 Hari)',
                'duration' => '2 Hari',
                'price' => 5000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Sertrika Wangi (1 Hari)',
                'duration' => '1 Hari',
                'price' => 7000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Sertrika Wangi (6 Jam)',
                'duration' => '6 Jam',
                'price' => 9000,
                'unit' => 'Kg',
            ],
            [
                'category' => 'Laundry Baju',
                'name' => 'Cuci Lipat Wangi (1 Hari)',
                'duration' => '1 Hari',
                'price' => 5000,
                'unit' => 'Kg',
            ],

            // --- LAUNDRY SEPATU ---
            [
                'category' => 'Laundry Sepatu',
                'name' => 'Deep Clean (3 - 4 Hari)',
                'duration' => '3 - 4 Hari',
                'price' => 35000,
                'unit' => 'Psg',
            ],
            [
                'category' => 'Laundry Sepatu',
                'name' => 'Deep Clean (1 Hari)',
                'duration' => '1 Hari',
                'price' => 45000,
                'unit' => 'Psg',
            ],
            [
                'category' => 'Laundry Sepatu',
                'name' => 'Express Clean (45 Menit)',
                'duration' => '45 Menit',
                'price' => 40000,
                'unit' => 'Psg',
            ],

            // --- LAUNDRY BEDDING ---
            [
                'category' => 'Laundry Bedding',
                'name' => 'Bed Cover (Kecil)',
                'duration' => '3 Hari',
                'price' => 25000,
                'unit' => 'Pcs',
            ],
            [
                'category' => 'Laundry Bedding',
                'name' => 'Bed Cover (Medium)',
                'duration' => '3 Hari',
                'price' => 30000,
                'unit' => 'Pcs',
            ],
            [
                'category' => 'Laundry Bedding',
                'name' => 'Bed Cover (Besar)',
                'duration' => '3 Hari',
                'price' => 35000,
                'unit' => 'Pcs',
            ],
            [
                'category' => 'Laundry Bedding',
                'name' => 'Selimut (Kecil)',
                'duration' => '3 Hari',
                'price' => 20000,
                'unit' => 'Pcs',
            ],
            [
                'category' => 'Laundry Bedding',
                'name' => 'Selimut (Medium)',
                'duration' => '3 Hari',
                'price' => 25000,
                'unit' => 'Pcs',
            ],
            [
                'category' => 'Laundry Bedding',
                'name' => 'Selimut (Besar)',
                'duration' => '3 Hari',
                'price' => 30000,
                'unit' => 'Pcs',
            ],

            // --- FURNISHING LAUNDRY ---
            [
                'category' => 'Furnishing Laundry',
                'name' => 'Karpet & Surpet (5 - 7 Hari)',
                'duration' => '5 - 7 Hari',
                'price' => 15000,
                'unit' => 'm²',
            ],
            [
                'category' => 'Furnishing Laundry',
                'name' => 'Gorden (3 Hari)',
                'duration' => '3 Hari',
                'price' => 13000,
                'unit' => 'm²',
            ],
        ];

        // Masukkan data layanan ke database tanpa duplikasi
        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                $service
            );
        }

        // Ambil ID layanan pertama untuk relasi detail transaksi dummy
        $sampleService = Service::first();

        // 3. Data Dummy Pendapatan (History) & Pengeluaran Masif (Tahun 2026)
        if ($sampleService) {

            // A. Buat 30 Data Acak Tersebar di Tahun 2026 (Januari - Agustus)
            for ($i = 1; $i <= 30; $i++) {
                $randomDate = Carbon::create(2026, rand(1, 8), rand(1, 28), rand(8, 18));

                $trx = Transaction::create([
                    'invoice_code' => 'INV-2026-' . rand(1000, 9999),
                    'customer_name' => 'Pelanggan 2026 #' . $i,
                    'customer_phone' => '08123456' . rand(100, 999),
                    'total_price' => rand(3, 15) * 10000, // Harga bervariasi 30rb - 150rb
                    'status' => 'Diambil',
                    'user_id' => $admin->id,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);

                $trx->details()->create([
                    'service_id' => $sampleService->id,
                    'quantity' => rand(1, 3),
                    'subtotal' => $trx->total_price
                ]);

                Expense::create([
                    'item_name' => 'Pengeluaran Operasional #' . $i,
                    'quantity' => 1,
                    'unit_price' => rand(1, 5) * 10000,
                    'total_price' => rand(1, 5) * 10000,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);
            }

            // B. Data KHUSUS HARI INI (Agar filter "Hari Ini" pasti ada isinya)
            for ($i = 1; $i <= 5; $i++) {
                $today = Carbon::today();

                $trx = Transaction::create([
                    'invoice_code' => 'INV-TODAY-' . rand(100, 999),
                    'customer_name' => 'Pelanggan Hari Ini ' . $i,
                    'customer_phone' => '08888888' . $i,
                    'total_price' => 50000 * $i,
                    'status' => 'Diambil',
                    'user_id' => $admin->id,
                    'created_at' => $today,
                    'updated_at' => $today,
                ]);

                $trx->details()->create([
                    'service_id' => $sampleService->id,
                    'quantity' => 1,
                    'subtotal' => $trx->total_price
                ]);

                Expense::create([
                    'item_name' => 'Belanja Hari Ini #' . $i,
                    'quantity' => 1,
                    'unit_price' => 15000,
                    'total_price' => 15000,
                    'created_at' => $today,
                    'updated_at' => $today,
                ]);
            }

            // C. Data TAHUN LALU (2025) - Untuk memastikan filter tidak bocor
            for ($i = 1; $i <= 5; $i++) {
                $lastYear = Carbon::now()->subYear();

                $trx = Transaction::create([
                    'invoice_code' => 'INV-OLD-' . rand(100, 999),
                    'customer_name' => 'Pelanggan Tahun Lalu ' . $i,
                    'customer_phone' => '08999999' . $i,
                    'total_price' => 300000,
                    'status' => 'Diambil',
                    'user_id' => $admin->id,
                    'created_at' => $lastYear,
                    'updated_at' => $lastYear,
                ]);

                $trx->details()->create([
                    'service_id' => $sampleService->id,
                    'quantity' => 5,
                    'subtotal' => $trx->total_price
                ]);

                Expense::create([
                    'item_name' => 'Maintenance Tahun Lalu #' . $i,
                    'quantity' => 1,
                    'unit_price' => 100000,
                    'total_price' => 100000,
                    'created_at' => $lastYear,
                    'updated_at' => $lastYear,
                ]);
            }
        }
    }
}
