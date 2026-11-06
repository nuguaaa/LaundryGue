<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingMedia;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LandingMediaController extends Controller
{
    /**
     * Definisi seluruh slot gambar yang digunakan di index utama / landing page
     */
    public static function getSlots(): array
    {
        return [
            'landing_hero_bg' => [
                'label' => 'Foto Hero Background (Layar Utama Atas)',
                'description' => 'Gambar latar belakang beranda utama di balik judul dan pelacakan resi.',
                'default' => 'img/hero/hero-bg.jpg',
                'section' => 'Hero Utama',
            ],
            'landing_promo_bg' => [
                'label' => 'Foto Promo Background',
                'description' => 'Gambar latar belakang bagian kartu promo dan voucher diskon aktif.',
                'default' => 'img/backgrounds/promo-bg.jpg',
                'section' => 'Promo & Penawaran',
            ],
            'landing_why_1' => [
                'label' => 'Galeri 1 (Mesin Cuci Modern)',
                'description' => 'Foto galeri keunggulan: infrastruktur mesin cuci modern otomatis.',
                'default' => 'img/gallery/mesin-cuci.jpg',
                'section' => 'Keunggulan Layanan',
            ],
            'landing_why_2' => [
                'label' => 'Galeri 2 (Setrika Uap Presisi)',
                'description' => 'Foto galeri keunggulan: proses setrika uap presisi anti kusut.',
                'default' => 'img/gallery/setrika.jpg',
                'section' => 'Keunggulan Layanan',
            ],
            'landing_why_3' => [
                'label' => 'Galeri 3 (Pakaian Rapi & Higienis)',
                'description' => 'Foto galeri keunggulan: lipatan pakaian rapi dan sterilisasi kain.',
                'default' => 'img/gallery/pakaian-rapi.jpg',
                'section' => 'Keunggulan Layanan',
            ],
            'landing_why_4' => [
                'label' => 'Galeri 4 (Perawatan Serat Tekstil)',
                'description' => 'Foto galeri keunggulan: perawatan serat kain terlindung lembut.',
                'default' => 'img/gallery/tekstil.jpg',
                'section' => 'Keunggulan Layanan',
            ],
            'landing_contact_bg' => [
                'label' => 'Foto Background Kontak & Bantuan',
                'description' => 'Gambar latar belakang bagian kontak outlet & tombol pemesanan WhatsApp.',
                'default' => 'img/backgrounds/contact-bg.jpg',
                'section' => 'Kontak & Lokasi',
            ],
            'services_calc_bg' => [
                'label' => 'Foto Background Kalkulator Biaya',
                'description' => 'Gambar latar belakang pada kotak simulasi kalkulator tarif layanan.',
                'default' => 'img/backgrounds/calculator-bg.jpg',
                'section' => 'Halaman Layanan',
            ],
            'site_logo' => [
                'label' => 'Logo LaundryGue',
                'description' => 'Logo utama yang tampil di navbar atas, footer, dan tab browser.',
                'default' => 'img/logo.png',
                'section' => 'Identitas Brand',
            ],
        ];
    }

    /**
     * Tampilkan halaman kelola media gambar & slot landing page
     */
    public function index()
    {
        $this->ensureDefaultMediaSeeded();

        $slots = self::getSlots();
        $settings = Setting::pluck('value', 'key');
        $mediaList = LandingMedia::latest()->get();

        // Hitung slot mana yang sedang menggunakan masing-masing media
        $usageMap = [];
        foreach ($slots as $slotKey => $slotInfo) {
            $currentPath = $settings[$slotKey] ?? $slotInfo['default'];
            if (!isset($usageMap[$currentPath])) {
                $usageMap[$currentPath] = [];
            }
            $usageMap[$currentPath][] = $slotInfo['label'];
        }

        return view('admin.landing_media.index', compact('slots', 'settings', 'mediaList', 'usageMap'));
    }

    /**
     * Upload gambar baru ke pustaka media
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:5120',
            'slot_key' => 'nullable|string',
        ], [
            'image.required' => 'Pilih file gambar terlebih dahulu.',
            'image.image' => 'File yang diunggah harus berupa file gambar valid.',
            'image.mimes' => 'Format gambar yang didukung: JPG, JPEG, PNG, WEBP.',
            'image.max' => 'Ukuran gambar maksimal adalah 5 MB.',
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->extension() ?: 'jpg');
        $filename = 'media_' . time() . '_' . Str::lower(Str::random(6)) . '.' . $extension;

        // Simpan langsung ke folder public/uploads/landing/
        // Pendekatan ini aman dan langsung bekerja di hosting InfinityFree tanpa symlink
        $uploadDir = public_path('uploads/landing');
        if (!File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true, true);
        }

        $file->move($uploadDir, $filename);
        $relativePath = 'uploads/landing/' . $filename;
        $fileSize = File::exists(public_path($relativePath)) ? File::size(public_path($relativePath)) : 0;

        $media = LandingMedia::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'path' => $relativePath,
            'file_size' => $fileSize,
            'mime_type' => $file->getClientMimeType() ?: 'image/' . $extension,
        ]);

        // Jika upload ditujukan langsung untuk mengisi slot tertentu
        if ($request->filled('slot_key') && array_key_exists($request->slot_key, self::getSlots())) {
            Setting::updateOrCreate(
                ['key' => $request->slot_key],
                ['value' => $relativePath]
            );
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload dan disimpan ke pustaka media!',
                'media' => [
                    'id' => $media->id,
                    'filename' => $media->filename,
                    'original_name' => $media->original_name,
                    'path' => $media->path,
                    'url' => asset($media->path),
                    'size' => $media->formatted_size,
                ],
            ]);
        }

        return redirect()->route('admin.landing-media.index')
            ->with('success', 'Gambar baru berhasil diupload dan disimpan ke pustaka media!');
    }

    /**
     * Pasang / terapkan gambar dari pustaka media ke slot landing page
     */
    public function setSlot(Request $request)
    {
        $slots = self::getSlots();
        $request->validate([
            'slot_key' => 'required|string|in:' . implode(',', array_keys($slots)),
            'media_id' => 'nullable|exists:landing_media,id',
            'image_path' => 'nullable|string',
        ]);

        $slotKey = $request->slot_key;
        $path = null;

        if ($request->filled('media_id')) {
            $media = LandingMedia::findOrFail($request->media_id);
            $path = $media->path;
        } elseif ($request->filled('image_path')) {
            $path = trim($request->image_path);
        }

        if (!$path) {
            return response()->json(['success' => false, 'message' => 'Pilih gambar yang valid.'], 422);
        }

        Setting::updateOrCreate(['key' => $slotKey], ['value' => $path]);

        $slotLabel = $slots[$slotKey]['label'] ?? $slotKey;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Gambar untuk {$slotLabel} berhasil diperbarui!",
                'slot_key' => $slotKey,
                'path' => $path,
                'url' => asset($path),
            ]);
        }

        return redirect()->route('admin.landing-media.index')
            ->with('success', "Gambar untuk {$slotLabel} berhasil diperbarui!");
    }

    /**
     * Kembalikan slot ke gambar bawaan (default)
     */
    public function resetSlot(Request $request)
    {
        $slots = self::getSlots();
        $request->validate([
            'slot_key' => 'required|string|in:' . implode(',', array_keys($slots)),
        ]);

        $slotKey = $request->slot_key;
        Setting::where('key', $slotKey)->delete();

        $defaultPath = $slots[$slotKey]['default'] ?? '';
        $slotLabel = $slots[$slotKey]['label'] ?? $slotKey;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Slot {$slotLabel} berhasil dikembalikan ke gambar default bawaan!",
                'slot_key' => $slotKey,
                'url' => asset($defaultPath),
                'default_path' => $defaultPath,
            ]);
        }

        return redirect()->route('admin.landing-media.index')
            ->with('success', "Slot {$slotLabel} berhasil dikembalikan ke gambar default bawaan!");
    }

    /**
     * Hapus gambar dari pustaka media
     */
    public function destroy(LandingMedia $landingMedia)
    {
        $path = $landingMedia->path;

        // Reset slot-slot yang sedang memakai gambar ini agar kembali ke default
        $slots = self::getSlots();
        foreach ($slots as $slotKey => $slotInfo) {
            $currentSetting = Setting::where('key', $slotKey)->value('value');
            if ($currentSetting === $path) {
                Setting::where('key', $slotKey)->delete();
            }
        }

        // Hapus file fisik hanya jika berada di folder uploads/ (jangan hapus file aset bawaan img/)
        if (str_starts_with($path, 'uploads/')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $landingMedia->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus dari pustaka media.',
            ]);
        }

        return redirect()->route('admin.landing-media.index')
            ->with('success', 'Gambar berhasil dihapus dari pustaka media.');
    }

    /**
     * Simpan kustomisasi teks di bagian penting landing page
     */
    public function updateTexts(Request $request)
    {
        $allowedKeys = [
            'hero_badge',
            'hero_title',
            'hero_subtitle_highlight',
            'hero_description',
            'why_badge',
            'why_title',
            'why_description',
            'why_1_title',
            'why_1_desc',
            'why_2_title',
            'why_2_desc',
            'why_3_title',
            'why_3_desc',
        ];

        foreach ($allowedKeys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->input($key, '') ?? '']
                );
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teks landing page berhasil diperbarui!',
            ]);
        }

        return redirect()->route('admin.landing-media.index')
            ->with('success', 'Teks bagian penting landing page berhasil diperbarui!');
    }

    /**
     * Mendaftarkan gambar bawaan ke tabel landing_media saat pertama kali dibuka
     */
    protected function ensureDefaultMediaSeeded(): void
    {
        if (LandingMedia::count() > 0) {
            return;
        }

        $defaults = [
            [
                'filename' => 'hero-bg.jpg',
                'original_name' => 'Foto Hero Mesin Cuci Laundry (Default)',
                'path' => 'img/hero/hero-bg.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'promo-bg.jpg',
                'original_name' => 'Foto Promo Background (Default)',
                'path' => 'img/backgrounds/promo-bg.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'mesin-cuci.jpg',
                'original_name' => 'Mesin Cuci Industri (Default)',
                'path' => 'img/gallery/mesin-cuci.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'setrika.jpg',
                'original_name' => 'Setrika Uap Presisi (Default)',
                'path' => 'img/gallery/setrika.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'pakaian-rapi.jpg',
                'original_name' => 'Pakaian Rapi Lipatan Higienis (Default)',
                'path' => 'img/gallery/pakaian-rapi.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'tekstil.jpg',
                'original_name' => 'Perawatan Serat Tekstil (Default)',
                'path' => 'img/gallery/tekstil.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'contact-bg.jpg',
                'original_name' => 'Background Kontak CS (Default)',
                'path' => 'img/backgrounds/contact-bg.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'calculator-bg.jpg',
                'original_name' => 'Background Kalkulator (Default)',
                'path' => 'img/backgrounds/calculator-bg.jpg',
                'mime_type' => 'image/jpeg',
            ],
            [
                'filename' => 'logo.png',
                'original_name' => 'Logo LaundryGue (Default)',
                'path' => 'img/logo.png',
                'mime_type' => 'image/png',
            ],
        ];

        foreach ($defaults as $def) {
            $fullPath = public_path($def['path']);
            $size = File::exists($fullPath) ? File::size($fullPath) : 0;
            LandingMedia::create([
                'filename' => $def['filename'],
                'original_name' => $def['original_name'],
                'path' => $def['path'],
                'file_size' => $size,
                'mime_type' => $def['mime_type'],
            ]);
        }
    }
}
