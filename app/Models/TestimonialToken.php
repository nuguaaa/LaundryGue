<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TestimonialToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }

    public static function generateToken(array $attributes = []): self
    {
        $tokenString = Str::random(32);
        while (self::where('token', $tokenString)->exists()) {
            $tokenString = Str::random(32);
        }

        return self::create(array_merge([
            'token' => $tokenString,
            'is_used' => false,
        ], $attributes));
    }

    public function getUrlAttribute(): string
    {
        return route('testimonial.create', ['token' => $this->token]);
    }

    public function isValid(): bool
    {
        if ($this->is_used) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }
}
