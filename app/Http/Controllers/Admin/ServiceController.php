<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Menampilkan daftar harga
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    // Form Tambah Layanan Baru
    public function create()
    {
        return view('admin.services.create');
    }

    // Menyimpan Layanan Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|integer',
            'unit' => 'required|string|max:50',
        ]);

        // Menggunakan only() agar aman dari error token keamanan (_token)
        Service::create($request->only(['category', 'name', 'duration', 'price', 'unit']));

        return redirect()->route('admin.services.index')->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    // Form Edit Layanan
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Proses Update Layanan
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|integer',
            'unit' => 'required|string|max:50',
        ]);

        // Menggunakan only() agar aman saat proses update data
        $service->update($request->only(['category', 'name', 'duration', 'price', 'unit']));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    // Menghapus Layanan
    public function destroy(Service $service)
    {
        $service->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Layanan berhasil dihapus!']);
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
