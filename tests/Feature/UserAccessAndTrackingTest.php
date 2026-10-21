<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserAccessAndTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Service::create([
            'category' => 'Kiloan',
            'name' => 'Cuci Kering Lipat',
            'duration' => '2 Hari',
            'price' => 7000,
            'unit' => 'Kg',
        ]);
    }

    public function test_admin_can_view_history_and_delete_transaction(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $transaction = Transaction::create([
            'invoice_code' => 'INV-TEST-001',
            'customer_name' => 'John Doe',
            'customer_phone' => '081234567890',
            'total_price' => 21000,
            'status' => 'Diambil',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.transactions.history'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Keuangan');
        $response->assertSee('INV-TEST-001');
        $response->assertSee('John Doe');

        // Admin can delete transaction
        $delResponse = $this->actingAs($admin)->delete(route('admin.transactions.destroy', $transaction->id));
        $delResponse->assertRedirect();
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    public function test_kasir_can_access_history_page_to_submit_expenses_but_cannot_see_transactions(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        Transaction::create([
            'invoice_code' => 'INV-SECRET-002',
            'customer_name' => 'Secret Customer',
            'customer_phone' => '0812999999',
            'total_price' => 50000,
            'status' => 'Diambil',
            'user_id' => $kasir->id,
        ]);

        $response = $this->actingAs($kasir)->get(route('admin.transactions.history'));
        $response->assertStatus(200);
        $response->assertSee('Pencatatan Pengeluaran Operasional');
        $response->assertDontSee('INV-SECRET-002');
        $response->assertDontSee('Secret Customer');
        $response->assertDontSee('Total Pendapatan Kotor');
        $response->assertDontSee('Input Riwayat Transaksi Manual (Banyak Transaksi Per Tanggal)');

        // Kasir can submit an expense
        $expenseResponse = $this->actingAs($kasir)->post(route('admin.expenses.store'), [
            'item_name' => 'Detergen Bubuk 10kg',
            'quantity' => 2,
            'unit_price' => 45000,
            'expense_date' => date('Y-m-d'),
        ]);
        $expenseResponse->assertRedirect();
        $this->assertDatabaseHas('expenses', ['item_name' => 'Detergen Bubuk 10kg', 'total_price' => 90000]);
    }

    public function test_kasir_cannot_delete_transaction_or_expense(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kasir = User::factory()->create(['role' => 'kasir']);

        $transaction = Transaction::create([
            'invoice_code' => 'INV-TEST-003',
            'customer_name' => 'Budi',
            'customer_phone' => '0811111111',
            'total_price' => 15000,
            'status' => 'Diambil',
            'user_id' => $admin->id,
        ]);

        $expense = Expense::create([
            'item_name' => 'Sabun Cuci',
            'quantity' => 1,
            'unit_price' => 20000,
            'total_price' => 20000,
        ]);

        // Kasir attempts delete transaction -> Forbidden 403
        $resTrx = $this->actingAs($kasir)->delete(route('admin.transactions.destroy', $transaction->id));
        $resTrx->assertStatus(403);
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id]);

        // Kasir attempts delete expense -> Forbidden 403
        $resExp = $this->actingAs($kasir)->delete(route('admin.expenses.destroy', $expense->id));
        $resExp->assertStatus(403);
        $this->assertDatabaseHas('expenses', ['id' => $expense->id]);
    }

    public function test_kasir_cannot_store_manual_history(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($kasir)->post(route('admin.transactions.manual.store'), [
            'transaction_date' => '2026-09-01',
            'items' => [
                [
                    'customer_name' => 'Manual Customer',
                    'service_id' => 1,
                    'quantity' => 2,
                ]
            ]
        ]);

        $response->assertStatus(403);
    }

    public function test_order_tracking_accessible_when_active_or_recently_completed(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $transaction = Transaction::create([
            'invoice_code' => 'INV-ACTIVE-001',
            'customer_name' => 'Dewi',
            'customer_phone' => '0812344444',
            'total_price' => 14000,
            'status' => 'Proses',
            'user_id' => $user->id,
        ]);

        // Tracking via form
        $trackRes = $this->post(route('track.order'), ['invoice_code' => 'INV-ACTIVE-001']);
        $trackRes->assertRedirect(route('cek.pesanan', 'INV-ACTIVE-001'));

        // Direct view
        $viewRes = $this->get(route('cek.pesanan', 'INV-ACTIVE-001'));
        $viewRes->assertStatus(200);
        $viewRes->assertSee('INV-ACTIVE-001');
        $viewRes->assertSee('Sedang Diproses');

        // AJAX JSON endpoint
        $ajaxRes = $this->getJson(route('cek.pesanan', 'INV-ACTIVE-001'));
        $ajaxRes->assertStatus(200);
        $ajaxRes->assertJson([
            'status' => 'Proses',
            'status_label' => 'Sedang Diproses',
        ]);

        // Completed 2 hours ago (< 1 day)
        DB::table('transactions')->where('id', $transaction->id)->update([
            'status' => 'Selesai',
            'updated_at' => Carbon::now()->subHours(2),
        ]);

        $recentRes = $this->get(route('cek.pesanan', 'INV-ACTIVE-001'));
        $recentRes->assertStatus(200);
        $recentRes->assertSee('Siap Diambil!');
        $recentRes->assertDontSee('Masa Akses Pelacakan Berakhir');
    }

    public function test_order_tracking_expires_after_one_day(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $completedTrx = Transaction::create([
            'invoice_code' => 'INV-EXPIRED-001',
            'customer_name' => 'Ahmad',
            'customer_phone' => '0819999999',
            'total_price' => 30000,
            'status' => 'Diambil',
            'user_id' => $user->id,
        ]);

        // Force updated_at to 2 days ago (> 24 hours) via direct DB update
        DB::table('transactions')->where('id', $completedTrx->id)->update([
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        // Attempting to track via form returns back with error flash
        $trackRes = $this->post(route('track.order'), ['invoice_code' => 'INV-EXPIRED-001']);
        $trackRes->assertSessionHas('error');

        // Direct URL access displays expired notice
        $viewRes = $this->get(route('cek.pesanan', 'INV-EXPIRED-001'));
        $viewRes->assertStatus(200);
        $viewRes->assertSee('Masa Akses Pelacakan Berakhir');
        $viewRes->assertSee('Akses Ditutup');
        $viewRes->assertSee('tidak dapat diakses setelah 1 hari (24 jam)');
    }

    public function test_main_page_does_not_display_login_button_for_guests(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee(route('login'));
        $response->assertDontSee('Masuk ke Portal Kasir');

        $servicesResponse = $this->get(route('frontend.services'));
        $servicesResponse->assertStatus(200);
        $servicesResponse->assertDontSee(route('login'));

        $contactResponse = $this->get(route('frontend.contact'));
        $contactResponse->assertStatus(200);
        $contactResponse->assertDontSee(route('login'));
    }

    public function test_tracking_resi_synchronizes_text_and_icons_when_status_changes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $transaction = Transaction::create([
            'invoice_code' => 'INV-SYNC-001',
            'customer_name' => 'Fani',
            'customer_phone' => '085712345678',
            'total_price' => 25000,
            'status' => 'Diambil',
            'user_id' => $admin->id,
        ]);

        // When status is 'Diambil', tracking resi displays "PESANAN DIAMBIL", "Cucian Telah Diserahkan", and icon 'check-circle-2'
        $viewRes = $this->get(route('cek.pesanan', 'INV-SYNC-001'));
        $viewRes->assertStatus(200);
        $viewRes->assertSee('PESANAN DIAMBIL');
        $viewRes->assertSee('Cucian Telah Diserahkan');
        $viewRes->assertSee('check-circle-2');

        // Admin/Kasir updates status from Pesanan Aktif to 'Proses'
        $updateRes = $this->actingAs($admin)->put(route('admin.transactions.status', $transaction->id), [
            'status' => 'Proses',
        ]);
        $updateRes->assertRedirect();
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id, 'status' => 'Proses']);

        // Now tracking resi updates to "SEDANG DIPROSES", "Cucian Sedang Diproses", and icon 'loader-2'
        $viewProsesRes = $this->get(route('cek.pesanan', 'INV-SYNC-001'));
        $viewProsesRes->assertStatus(200);
        $viewProsesRes->assertSee('SEDANG DIPROSES');
        $viewProsesRes->assertSee('Cucian Sedang Diproses');
        $viewProsesRes->assertSee('loader-2');

        // Real-time AJAX endpoint also returns matching data
        $ajaxRes = $this->getJson(route('cek.pesanan', 'INV-SYNC-001'));
        $ajaxRes->assertStatus(200);
        $ajaxRes->assertJson([
            'status' => 'Proses',
            'badge' => 'SEDANG DIPROSES',
            'heading' => 'Cucian Sedang Diproses',
            'icon' => 'loader-2',
            'spin' => true,
        ]);

        // Admin updates status to 'Selesai'
        $this->actingAs($admin)->put(route('admin.transactions.status', $transaction->id), [
            'status' => 'Selesai',
        ]);

        $viewSelesaiRes = $this->get(route('cek.pesanan', 'INV-SYNC-001'));
        $viewSelesaiRes->assertStatus(200);
        $viewSelesaiRes->assertSee('SELESAI (SIAP AMBIL!)');
        $viewSelesaiRes->assertSee('Cucian Selesai dan Siap Diambil!');
        $viewSelesaiRes->assertSee('check-check');
    }

    public function test_admin_panel_spa_structure_and_ajax_status_update(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $transaction = Transaction::create([
            'invoice_code' => 'INV-SPA-001',
            'customer_name' => 'Bambang',
            'customer_phone' => '08123456789',
            'total_price' => 35000,
            'status' => 'Baru',
            'user_id' => $admin->id,
        ]);

        // Verify Admin Layout contains SPA containers
        $spaPageRes = $this->actingAs($admin)->get(route('admin.transactions.index'), [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-SPA-Request' => '1',
        ]);
        $spaPageRes->assertStatus(200);
        $spaPageRes->assertSee('id="spa-progress"', false);
        $spaPageRes->assertSee('id="spa-toast-container"', false);
        $spaPageRes->assertSee('id="spa-content"', false);
        $spaPageRes->assertSee('INV-SPA-001');

        // Status change via AJAX returns JSON
        $ajaxStatusRes = $this->actingAs($admin)->putJson(route('admin.transactions.status', $transaction->id), [
            'status' => 'Proses',
        ]);
        $ajaxStatusRes->assertStatus(200);
        $ajaxStatusRes->assertJson([
            'success' => true,
            'status' => 'Proses',
            'invoice_code' => 'INV-SPA-001',
        ]);

        // Status change to Diambil via AJAX
        $ajaxDiambilRes = $this->actingAs($admin)->putJson(route('admin.transactions.status', $transaction->id), [
            'status' => 'Diambil',
        ]);
        $ajaxDiambilRes->assertStatus(200);
        $ajaxDiambilRes->assertJson([
            'success' => true,
            'status' => 'Diambil',
        ]);

        // Delete transaction via AJAX
        $ajaxDelRes = $this->actingAs($admin)->deleteJson(route('admin.transactions.destroy', $transaction->id));
        $ajaxDelRes->assertStatus(200);
        $ajaxDelRes->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    public function test_frontend_track_order_ajax(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Transaction::create([
            'invoice_code' => 'INV-TRACK-999',
            'customer_name' => 'Citra',
            'customer_phone' => '0813999999',
            'total_price' => 20000,
            'status' => 'Proses',
            'user_id' => $admin->id,
        ]);

        // AJAX Track Order - Valid invoice
        $validRes = $this->postJson(route('track.order'), [
            'invoice_code' => 'INV-TRACK-999',
        ]);
        $validRes->assertStatus(200);
        $validRes->assertJson([
            'success' => true,
            'redirect' => route('cek.pesanan', 'INV-TRACK-999'),
        ]);

        // AJAX Track Order - Invalid invoice
        $invalidRes = $this->postJson(route('track.order'), [
            'invoice_code' => 'INV-NOT-FOUND',
        ]);
        $invalidRes->assertStatus(404);
        $invalidRes->assertJson([
            'success' => false,
        ]);
    }

    public function test_nav_does_not_contain_lacak_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Lacak Resi');
        $response->assertDontSee('Lacak Resi Cucian');
    }

    public function test_latest_promo_floating_notification_appears_when_promo_exists(): void
    {
        Promo::create([
            'title' => 'Promo Diskon Merdeka',
            'code' => 'MERDEKA50',
            'type' => 'percentage',
            'value' => 50,
            'description' => 'Diskon 50% untuk cuci setrika',
            'expired_date' => Carbon::now()->addDays(7)->toDateString(),
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('latestPromoNotification');
        $response->assertSee('top-20');
        $response->assertSee('Promo Terbaru!');
        $response->assertSee('Promo Diskon Merdeka');
        $response->assertSee('MERDEKA50');
        $response->assertSee('50%');
        $response->assertSee('closePromoNotifBtn');
    }

    public function test_promo_floating_notification_does_not_appear_when_no_promos_exist(): void
    {
        Promo::query()->delete();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('latestPromoNotification');
        $response->assertDontSee('Promo Terbaru!');
    }

    public function test_admin_cannot_create_percentage_promo_with_value_over_100_or_under_1(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Persentase > 100 harus ditolak
        $responseOver = $this->actingAs($admin)->post(route('admin.promos.store'), [
            'title' => 'Diskon Lebay',
            'code' => 'LEBAY150',
            'type' => 'percentage',
            'value' => 150,
            'description' => 'Diskon di luar batas',
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);
        $responseOver->assertSessionHasErrors('value');
        $this->assertDatabaseMissing('promos', ['code' => 'LEBAY150']);

        // Persentase < 1 harus ditolak
        $responseUnder = $this->actingAs($admin)->post(route('admin.promos.store'), [
            'title' => 'Diskon Nol',
            'code' => 'NOL0',
            'type' => 'percentage',
            'value' => 0,
            'description' => 'Diskon di bawah batas',
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);
        $responseUnder->assertSessionHasErrors('value');
        $this->assertDatabaseMissing('promos', ['code' => 'NOL0']);
    }

    public function test_admin_can_create_percentage_promo_within_1_to_100_and_fixed_promo_with_any_nominal(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Persentase 1 - 100 harus berhasil
        $resPct = $this->actingAs($admin)->post(route('admin.promos.store'), [
            'title' => 'Diskon Valid 25 Persen',
            'code' => 'DISKON25',
            'type' => 'percentage',
            'value' => 25,
            'description' => 'Diskon valid 25%',
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);
        $resPct->assertRedirect(route('admin.promos.index'));
        $this->assertDatabaseHas('promos', ['code' => 'DISKON25', 'value' => 25]);

        // Nominal bebas (misal 50.000) harus berhasil
        $resFixed = $this->actingAs($admin)->post(route('admin.promos.store'), [
            'title' => 'Potongan 50 Ribu',
            'code' => 'HEMAT50RB',
            'type' => 'fixed',
            'value' => 50000,
            'description' => 'Potongan langsung 50rb',
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);
        $resFixed->assertRedirect(route('admin.promos.index'));
        $this->assertDatabaseHas('promos', ['code' => 'HEMAT50RB', 'value' => 50000]);
    }
}

