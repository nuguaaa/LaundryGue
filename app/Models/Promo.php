<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'type',        // <-- Pastikan ini ada
        'value',       // <-- Pastikan ini ada
        'description',
        'expired_date',
    ];
}
