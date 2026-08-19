<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Default (Admin & Kasir)
        User::firstOrCreate(
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

        // Masukkan data ke database tanpa duplikasi
        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
