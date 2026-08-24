<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'customer_name',
        'customer_phone',
        'total_price',
        'status',
        'user_id'
    ];

    // Relasi ke User (Admin/Kasir yang melayani)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Transaksi (Layanan yang dibeli)
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
