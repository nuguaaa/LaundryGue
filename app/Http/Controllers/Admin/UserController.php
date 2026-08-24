<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        $trashed = User::onlyTrashed()->get(); // User yang sudah dihapus
        return view('admin.users.index', compact('users', 'trashed'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'role' => 'required|in:admin,kasir'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make('password123'),
        'role' => $request->role
    ]);

    return back()->with('success', 'User berhasil ditambahkan.');
}

    public function destroy(User $user) {
        $user->delete(); // Ini otomatis masuk ke tabel trashed (soft delete)
        return back()->with('success', 'User dipindahkan ke history.');
    }

    public function restore($id) {
        User::onlyTrashed()->find($id)->restore();
        return back()->with('success', 'User dikembalikan.');
    }

    public function forceDelete($id) {
        User::onlyTrashed()->find($id)->forceDelete(); // Hapus permanen dari database
        return back()->with('success', 'User dihapus permanen.');
    }
}
