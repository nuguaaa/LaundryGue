<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $isPercentage = $request->input('type') === 'percentage';

        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:promos,code',
            'type' => 'required|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:1',
                $isPercentage ? 'max:100' : 'nullable',
            ],
            'description' => 'required|string',
            'expired_date' => 'required|date',
        ], [
            'value.min' => 'Besar nilai promo minimal adalah 1.',
            'value.max' => 'Besar nilai persentase hanya dibatasi dari 1 sampai 100%.',
        ]);

        Promo::create($request->only(['title', 'code', 'type', 'value', 'description', 'expired_date']));

        return redirect()->route('admin.promos.index')->with('success', 'Promo baru berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $isPercentage = $request->input('type') === 'percentage';

        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:promos,code,' . $promo->id,
            'type' => 'required|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:1',
                $isPercentage ? 'max:100' : 'nullable',
            ],
            'description' => 'required|string',
            'expired_date' => 'required|date',
        ], [
            'value.min' => 'Besar nilai promo minimal adalah 1.',
            'value.max' => 'Besar nilai persentase hanya dibatasi dari 1 sampai 100%.',
        ]);

        $promo->update($request->only(['title', 'code', 'type', 'value', 'description', 'expired_date']));

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Promo berhasil dihapus!']);
        }

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus!');
    }
}
