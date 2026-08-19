<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromoController;
use App\Models\Service;

// Halaman Depan Publik
Route::get('/', function () {
    $services = Service::all();
    return view('frontend.home', compact('services'));
});

// Mengarahkan /dashboard bawaan Breeze langsung ke halaman admin services
Route::get('/dashboard', function () {
    return redirect()->route('admin.services.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Rute Admin dengan Proteksi Login (auth)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('promos', PromoController::class);
});

// Memuat rute bawaan login dari Breeze
require __DIR__.'/auth.php';
