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
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan informasi website berhasil diperbarui!');
    }
}
