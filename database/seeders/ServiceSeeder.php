<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Service::insert([
            // Laundry Baju
            ['name' => 'Cuci Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '2 Hari', 'price' => 7000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuci Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '1 Hari', 'price' => 10000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuci Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '6 Jam', 'price' => 12000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '2 Hari', 'price' => 5000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '1 Hari', 'price' => 7000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sertrika Wangi', 'category' => 'Laundry Baju', 'duration' => '6 Jam', 'price' => 9000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuci Lipat Wangi', 'category' => 'Laundry Baju', 'duration' => '1 Hari', 'price' => 5000, 'unit' => 'Kg', 'created_at' => now(), 'updated_at' => now()],

            // Laundry Sepatu
            ['name' => 'Deep Clean', 'category' => 'Laundry Sepatu', 'duration' => '3-4 Hari', 'price' => 35000, 'unit' => 'Psg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deep Clean', 'category' => 'Laundry Sepatu', 'duration' => '1 Hari', 'price' => 45000, 'unit' => 'Psg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Express Clean', 'category' => 'Laundry Sepatu', 'duration' => '45 Menit', 'price' => 40000, 'unit' => 'Psg', 'created_at' => now(), 'updated_at' => now()],

            // Furnishing Laundry
            ['name' => 'Karpet & Surpet', 'category' => 'Furnishing Laundry', 'duration' => '5-7 Hari', 'price' => 15000, 'unit' => 'm²', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gorden', 'category' => 'Furnishing Laundry', 'duration' => '3 Hari', 'price' => 13000, 'unit' => 'm²', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
