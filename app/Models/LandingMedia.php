<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingMedia extends Model
{
    use HasFactory;

    protected $table = 'landing_media';

    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'file_size',
        'mime_type',
    ];

    /**
     * URL lengkap asset gambar
     */
    public function getUrlAttribute(): string
    {
        return asset($this->path);
    }

    /**
     * Format ukuran file yang mudah dibaca (KB / MB)
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes <= 0) {
            return '0 KB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        return number_format($bytes / 1024, 0) . ' KB';
    }
}
