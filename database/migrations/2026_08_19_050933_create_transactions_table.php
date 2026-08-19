<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code');     // Kode Nota / Resi unik (contoh: LGT-20260601-001)
            $table->string('customer_name');    // Nama Pelanggan
            $table->string('customer_phone');   // Nomor WhatsApp Pelanggan
            $table->text('customer_address');   // Alamat Pelanggan
            $table->integer('total_price');     // Total harga keseluruhan
            $table->enum('status_payment', ['Lunas', 'DP', 'Belum Lunas']); // Status pembayaran
            $table->enum('status_laundry', ['Baru', 'Proses Cuci', 'Proses Setrika', 'Siap Ambil', 'Selesai'])->default('Baru'); // Status pengerjaan
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
