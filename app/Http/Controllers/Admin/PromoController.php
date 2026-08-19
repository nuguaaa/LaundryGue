<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    // Menampilkan daftar promo
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promos.index', compact('promos'));
    }

    // Form Tambah Promo
    public function create()
    {
        return view('admin.promos.create');
    }

    // Menyimpan Promo Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:promos,code',
            'discount' => 'required|string|max:100',
            'description' => 'required|string',
            'expired_date' => 'required|date',
        ]);

        Promo::create($request->only(['title', 'code', 'discount', 'description', 'expired_date']));

        return redirect()->route('admin.promos.index')->with('success', 'Promo baru berhasil ditambahkan!');
    }

    // Form Edit Promo
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    // Proses Update Promo
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:promos,code,' . $promo->id,
            'discount' => 'required|string|max:100',
            'description' => 'required|string',
            'expired_date' => 'required|date',
        ]);

        $promo->update($request->only(['title', 'code', 'discount', 'description', 'expired_date']));

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    // Menghapus Promo
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus!');
    }
}
