<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Tambahkan baris $fillable ini agar model mengizinkan penyimpanan data
    protected $fillable = [
        'category',
        'name',
        'duration',
        'price',
        'unit'
    ];
}
