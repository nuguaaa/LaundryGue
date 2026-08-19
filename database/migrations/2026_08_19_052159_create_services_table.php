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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Contoh: "Cuci Setrika Wangi"
            $table->string('category');     // Contoh: "Laundry Baju"
            $table->string('duration');     // Contoh: "2 Hari"
            $table->integer('price');       // Contoh: 7000
            $table->string('unit');         // Contoh: "Kg" atau "Psg" atau "m2"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
