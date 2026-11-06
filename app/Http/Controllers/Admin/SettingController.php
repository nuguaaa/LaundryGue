<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // Menampilkan halaman form pengaturan
    public function index()
    {
        // Mengambil semua data settings dan mengubahnya jadi key => value array
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    // Menyimpan atau memperbarui data pengaturan ke database
    public function update(Request $request)
    {
        $allowedKeys = [
            'name', 'address', 'phone', 'whatsapp', 'opening_hours', 
            'enable_splash_screen', 'meta_description', 'meta_keywords',
            'instagram_url', 'facebook_url', 'outlet_lat', 'outlet_lng'
        ];

        $data = $request->only($allowedKeys);

        // Checkbox handling: jika form submit tidak memuat 'enable_splash_screen', ubah jadi '0'
        if (!$request->has('enable_splash_screen')) {
            $data['enable_splash_screen'] = '0';
        }

        foreach ($data as $key => $value) {
            // Normalisasi nomor WhatsApp ke format internasional (misal 0812... -> 62812...)
            if ($key === 'whatsapp' && !empty($value)) {
                $clean = preg_replace('/[^0-9]/', '', (string)$value);
                if (str_starts_with($clean, '0')) {
                    $clean = '62' . substr($clean, 1);
                } elseif (str_starts_with($clean, '8')) {
                    $clean = '62' . $clean;
                }
                $value = $clean ?: '6281220295876';
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan informasi website berhasil diperbarui!',
                'settings' => Setting::pluck('value', 'key'),
            ]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan informasi website berhasil diperbarui!');
    }

    // Toggle status splash screen via AJAX secara instan
    public function toggleSplash(Request $request)
    {
        $current = Setting::where('key', 'enable_splash_screen')->value('value') ?? '0';
        $newStatus = ($current === '1') ? '0' : '1';

        Setting::updateOrCreate(
            ['key' => 'enable_splash_screen'],
            ['value' => $newStatus]
        );

        return response()->json([
            'success' => true,
            'enabled' => $newStatus === '1',
            'status_label' => $newStatus === '1' ? 'Aktif' : 'Nonaktif',
            'message' => $newStatus === '1' 
                ? 'Fitur Splash Screen berhasil diaktifkan!' 
                : 'Fitur Splash Screen berhasil dimatikan sesuai permintaan!'
        ]);
    }
}
