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
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->string('item_name'); // Nama barang (misal: Sabun Cuci)
        $table->integer('quantity'); // Jumlah beli
        $table->decimal('unit_price', 12, 2); // Harga satuan
        $table->decimal('total_price', 12, 2); // Total otomatis (qty * price)
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('expenses');
}
};
