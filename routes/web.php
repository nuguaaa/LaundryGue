<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\LandingMediaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Models\Service;
use App\Models\Promo;
use App\Models\Setting;

// ==========================================
// RUTE PUBLIK (Halaman Depan & Tracking)
// ==========================================

Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');

Route::get('/layanan', function () {
    $services = Service::all();
    $promos = Promo::where('expired_date', '>=', now()->toDateString())->get();
    $settings = Setting::pluck('value', 'key');
    return view('frontend.services', compact('services', 'promos', 'settings'));
})->name('frontend.services');

Route::get('/kontak', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('/semua-testimoni', [FrontendController::class, 'testimonials'])->name('frontend.testimonials');
Route::redirect('/ulasan', '/semua-testimoni');

// Tracking & Cek Pesanan / Cek Nota (dilindungi rate limiter untuk privasi PII)
Route::post('/track-order', [TransactionController::class, 'trackOrder'])->middleware('throttle:30,1')->name('track.order');
Route::post('/cek-pesanan/search', [TransactionController::class, 'trackOrder'])->middleware('throttle:30,1');
Route::post('/cek-nota', [TransactionController::class, 'trackOrder'])->middleware('throttle:30,1')->name('cek.nota.post');
Route::get('/cek-pesanan/{invoice}', [TransactionController::class, 'checkOrderStatus'])->middleware('throttle:30,1')->name('cek.pesanan');
Route::get('/cek-pesanan', function () {
    return redirect()->to(url('/') . '#tracking');
})->name('cek.pesanan.home');
Route::get('/cek-nota/{invoice?}', function ($invoice = null) {
    if ($invoice) {
        return redirect()->route('cek.pesanan', $invoice);
    }
    return redirect()->to(url('/') . '#tracking');
})->name('cek.nota');

// Halaman Khusus Formulir Testimoni Sekali Pakai (One-Time Token Link)
Route::get('/testimoni/{token?}', [TestimonialController::class, 'create'])->name('testimonial.create');
Route::post('/testimoni/{token?}', [TestimonialController::class, 'store'])->name('testimonial.store');
Route::get('/ulasan/isi/{token?}', [TestimonialController::class, 'create'])->name('ulasan.create');
Route::post('/ulasan/isi/{token?}', [TestimonialController::class, 'store'])->name('ulasan.store');


// ==========================================
// RUTE OTENTIKASI & DASHBOARD
// ==========================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin,kasir'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// RUTE KHUSUS KASIR & ADMIN (Akses Operasional)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    // Rute Kelola Testimoni & Token Undangan Sekali Pakai
    Route::get('testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('testimonials/tokens', [AdminTestimonialController::class, 'generateToken'])->name('testimonials.tokens.store');
    Route::delete('testimonials/tokens/{token}', [AdminTestimonialController::class, 'destroyToken'])->name('testimonials.tokens.destroy');
    Route::delete('testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Rute Pengaturan Website
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/toggle-splash', [SettingController::class, 'toggleSplash'])->name('settings.toggle-splash');

    // Rute Kelola Media Gambar & Tampilan Landing Page
    Route::get('landing-media', [LandingMediaController::class, 'index'])->name('landing-media.index');
    Route::post('landing-media/upload', [LandingMediaController::class, 'upload'])->name('landing-media.upload');
    Route::post('landing-media/set-slot', [LandingMediaController::class, 'setSlot'])->name('landing-media.set-slot');
    Route::post('landing-media/reset-slot', [LandingMediaController::class, 'resetSlot'])->name('landing-media.reset-slot');
    Route::delete('landing-media/{landingMedia}', [LandingMediaController::class, 'destroy'])->name('landing-media.destroy');
    Route::post('landing-media/texts', [LandingMediaController::class, 'updateTexts'])->name('landing-media.texts');

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
