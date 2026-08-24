<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
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

    // Manajemen Master Data
    Route::resource('services', ServiceController::class);
    Route::resource('promos', PromoController::class);

    // Manajemen Transaksi & Kasir
    Route::resource('transactions', TransactionController::class);
    Route::put('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.status');

    // Laporan Keuangan & Riwayat
    Route::get('transactions-history', [TransactionController::class, 'history'])->name('transactions.history');

    // Rute Pengeluaran (Baru)
    Route::post('expenses', [TransactionController::class, 'storeExpense'])->name('expenses.store');
    Route::delete('expenses/{id}', [TransactionController::class, 'destroyExpense'])->name('expenses.destroy');

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Rute User Lanjutan (Restore/Force Delete)
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});
// Rute untuk cek status pesanan via QR Code Struk
Route::get('/cek-pesanan/{invoice}', [TransactionController::class, 'checkOrderStatus'])->name('cek.pesanan');

Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'printReceipt'])->name('admin.transactions.receipt');

Route::get('/laporan/cetak', [TransactionController::class, 'printReport'])->name('laporan.cetak');

// Memuat rute bawaan login dari Breeze
require __DIR__.'/auth.php';
