<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\Promo;
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
        // 1. MEMBUAT AKUN DEFAULT (Admin & Kasir)
        $admin = User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin Laundry',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir1@gmail.com'],
            [
                'name' => 'Kasir Laundry',
                'password' => Hash::make('12345678'),
                'role' => 'kasir',
            ]
        );

// 2. PENGATURAN WEBSITE & INFORMASI UMUM (SETTINGS)
        Setting::updateOrCreate(['key' => 'whatsapp'], ['value' => '6281220295876']);
        Setting::updateOrCreate(['key' => 'address'], ['value' => 'Jl. Somawinata cidahu No.139, Tanimulya, Kec. Ngamprah, Kabupaten Bandung Barat, Jawa Barat']);
        Setting::updateOrCreate(['key' => 'operational_hours'], ['value' => 'Selasa - Minggu: 10.00 - 17.00 WIB']);
        // 3. TESTIMONI PELANGGAN
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'role' => 'Warga Tanimulya',
                'message' => 'Cucian di sini sangat bersih, wangi, dan rapi banget lipatannya. Paling mantap karena ada layanan antar-jemput!',
                'rating' => 5
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'Ibu Rumah Tangga',
                'message' => 'Pelayanannya ramah dan cepat. Sangat membantu saya yang sibuk kerja jadi tidak sempat cuci baju sendiri.',
                'rating' => 5
            ],
            [
                'name' => 'Rian Hidayat',
                'role' => 'Karyawan Swasta',
                'message' => 'Jas kantor dan pakaian formal saya selalu cuci di sini. Hasilnya tidak pernah mengecewakan, rapi dan tidak merusak kain.',
                'rating' => 5
            ]
        ];

        foreach ($testimonials as $testi) {
            Testimonial::firstOrCreate(['name' => $testi['name']], $testi);
        }

// 4. PROMO & DISKON AKTIF (SESUAI STRUKTUR TABEL)
        $promos = [
            [
                'title' => 'Diskon Merdeka Laundry',
                'code' => 'MERDEKA50',
                'type' => 'percentage',
                'value' => 50.00,
                'description' => 'Nikmati potongan harga spesial untuk minimal transaksi 5kg.',
                'expired_date' => '2026-08-31',
            ],
            [
                'title' => 'Promo Member Baru',
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10.00,
                'description' => 'Khusus pendaftaran member baru di outlet atau via WhatsApp.',
                'expired_date' => '2026-12-31',
            ]
        ];

        foreach ($promos as $promo) {
            Promo::firstOrCreate(['code' => $promo['code']], $promo);
        }
        // 5. DAFTAR LAYANAN LENGKAP (SERVICES)
        $services = [
            // --- LAUNDRY BAJU ---
            ['category' => 'Laundry Baju', 'name' => 'Cuci Sertrika Wangi (2 Hari)', 'duration' => '2 Hari', 'price' => 7000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Cuci Sertrika Wangi (1 Hari)', 'duration' => '1 Hari', 'price' => 10000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Cuci Sertrika Wangi (6 Jam)', 'duration' => '6 Jam', 'price' => 12000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Sertrika Wangi (2 Hari)', 'duration' => '2 Hari', 'price' => 5000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Sertrika Wangi (1 Hari)', 'duration' => '1 Hari', 'price' => 7000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Sertrika Wangi (6 Jam)', 'duration' => '6 Jam', 'price' => 9000, 'unit' => 'Kg'],
            ['category' => 'Laundry Baju', 'name' => 'Cuci Lipat Wangi (1 Hari)', 'duration' => '1 Hari', 'price' => 5000, 'unit' => 'Kg'],

            // --- LAUNDRY SEPATU ---
            ['category' => 'Laundry Sepatu', 'name' => 'Deep Clean (3 - 4 Hari)', 'duration' => '3 - 4 Hari', 'price' => 35000, 'unit' => 'Psg'],
            ['category' => 'Laundry Sepatu', 'name' => 'Deep Clean (1 Hari)', 'duration' => '1 Hari', 'price' => 45000, 'unit' => 'Psg'],
            ['category' => 'Laundry Sepatu', 'name' => 'Express Clean (45 Menit)', 'duration' => '45 Menit', 'price' => 40000, 'unit' => 'Psg'],

            // --- LAUNDRY BEDDING ---
            ['category' => 'Laundry Bedding', 'name' => 'Bed Cover (Kecil)', 'duration' => '3 Hari', 'price' => 25000, 'unit' => 'Pcs'],
            ['category' => 'Laundry Bedding', 'name' => 'Bed Cover (Medium)', 'duration' => '3 Hari', 'price' => 30000, 'unit' => 'Pcs'],
            ['category' => 'Laundry Bedding', 'name' => 'Bed Cover (Besar)', 'duration' => '3 Hari', 'price' => 35000, 'unit' => 'Pcs'],
            ['category' => 'Laundry Bedding', 'name' => 'Selimut (Kecil)', 'duration' => '3 Hari', 'price' => 20000, 'unit' => 'Pcs'],
            ['category' => 'Laundry Bedding', 'name' => 'Selimut (Medium)', 'duration' => '3 Hari', 'price' => 25000, 'unit' => 'Pcs'],
            ['category' => 'Laundry Bedding', 'name' => 'Selimut (Besar)', 'duration' => '3 Hari', 'price' => 30000, 'unit' => 'Pcs'],

            // --- FURNISHING LAUNDRY ---
            ['category' => 'Furnishing Laundry', 'name' => 'Karpet & Surpet (5 - 7 Hari)', 'duration' => '5 - 7 Hari', 'price' => 15000, 'unit' => 'm²'],
            ['category' => 'Furnishing Laundry', 'name' => 'Gorden (3 Hari)', 'duration' => '3 Hari', 'price' => 13000, 'unit' => 'm²'],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name'], 'duration' => $service['duration']],
                $service
            );
        }

        // 6. DATA DUMMY TRANSAKSI & PENGELUARAN (UNTUK LAPORAN KEUANGAN)
        $sampleService = Service::first();
        if ($sampleService) {
            for ($i = 1; $i <= 10; $i++) {
                $randomDate = Carbon::create(2026, rand(1, 8), rand(1, 28), rand(8, 18));

                $trx = Transaction::create([
                    'invoice_code' => 'INV-2026-' . rand(1000, 9999),
                    'customer_name' => 'Pelanggan #' . $i,
                    'customer_phone' => '08123456' . rand(100, 999),
                    'total_price' => rand(3, 10) * 10000,
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
                    'item_name' => 'Pembelian Deterjen/Pewangi #' . $i,
                    'quantity' => 1,
                    'unit_price' => 15000,
                    'total_price' => 15000,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);
            }
        }
    }
}
