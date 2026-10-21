<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Models\Service;

// ==========================================
// RUTE PUBLIK (Halaman Depan & Tracking)
// ==========================================

Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');

Route::get('/layanan', function () {
    $services = Service::all();
    return view('frontend.services', compact('services'));
})->name('frontend.services');

Route::get('/kontak', [FrontendController::class, 'contact'])->name('frontend.contact');

Route::post('/track-order', [TransactionController::class, 'trackOrder'])->name('track.order');

Route::get('/cek-pesanan/{invoice}', [TransactionController::class, 'checkOrderStatus'])->name('cek.pesanan');


// ==========================================
// RUTE OTENTIKASI & DASHBOARD
// ==========================================
Route::get('/dashboard', function () {
    return redirect()->route('admin.transactions.create');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// RUTE KHUSUS KASIR & ADMIN (Akses Operasional)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::put('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.status');
    Route::get('transactions/{transaction}/receipt', [TransactionController::class, 'printReceipt'])->name('transactions.receipt');

    // Halaman History / Pengeluaran (Bisa diakses Kasir untuk input pengeluaran)
    Route::get('transactions-history', [TransactionController::class, 'history'])->name('transactions.history');
    Route::post('expenses', [TransactionController::class, 'storeExpense'])->name('expenses.store');
});


// ==========================================
// RUTE KHUSUS ADMIN / OWNER (Akses Sensitif & Keuangan)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('promos', PromoController::class);

    // Rute Pengaturan Website
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Input manual riwayat lama & hapus hanya oleh admin
    Route::post('transactions/manual', [TransactionController::class, 'storeManual'])->name('transactions.manual.store');
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::delete('expenses/{id}', [TransactionController::class, 'destroyExpense'])->name('expenses.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});

Route::get('/laporan/cetak', [TransactionController::class, 'printReport'])->name('laporan.cetak')->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';
