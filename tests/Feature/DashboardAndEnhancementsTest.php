<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\Promo;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAndEnhancementsTest extends TestCase
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

        Setting::updateOrCreate(['key' => 'whatsapp'], ['value' => '6281220295876']);
    }

    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $adminRes = $this->get('/admin/dashboard');
        $adminRes->assertRedirect('/login');
    }

    public function test_admin_can_view_dashboard_with_full_financial_kpi_and_chart(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Transaksi selesai & diambil hari ini
        $trx = Transaction::create([
            'invoice_code' => 'INV-DASH-001',
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'total_price' => 35000,
            'status' => 'Diambil',
            'user_id' => $admin->id,
        ]);
        $trx->updated_at = Carbon::today();
        $trx->save();

        // Pengeluaran hari ini
        Expense::create([
            'item_name' => 'Pewangi Pakaian',
            'quantity' => 1,
            'unit_price' => 15000,
            'total_price' => 15000,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan Eksekutif');
        $response->assertSee('Omzet Hari Ini');
        $response->assertSee('Omzet Bulan Ini');
        $response->assertSee('Biaya Operasional');
        $response->assertSee('Laba Bersih (Profit)');
        $response->assertSee('Tren Pendapatan 7 Hari Terakhir');
        $response->assertSee('Status Pengerjaan Outlet');
        $response->assertSee('Layanan Terlaris');

        // Check via /admin/dashboard
        $responseAdmin = $this->actingAs($admin)->get(route('admin.dashboard'));
        $responseAdmin->assertStatus(200);
    }

    public function test_kasir_can_view_dashboard_with_operational_focus(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        // Cucian aktif dalam proses
        Transaction::create([
            'invoice_code' => 'INV-DASH-KASIR',
            'customer_name' => 'Ani Lestari',
            'customer_phone' => '085711223344',
            'total_price' => 28000,
            'status' => 'Proses',
            'user_id' => $kasir->id,
        ]);

        $response = $this->actingAs($kasir)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan Eksekutif');
        $response->assertSee('Order Masuk Hari Ini');
        $response->assertSee('Cucian Diserahkan');
        $response->assertSee('Sedang Dikerjakan');
        $response->assertSee('Siap Diambil');
        $response->assertSee('INV-DASH-KASIR');
        $response->assertSee('Ani Lestari');
    }

    public function test_smart_alert_appears_when_order_finished_over_2_days_not_picked_up(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Buat pesanan status 'Selesai' 3 hari yang lalu
        $unclaimedTrx = Transaction::create([
            'invoice_code' => 'INV-LUPA-AMBIL',
            'customer_name' => 'Doni Terbengkalai',
            'customer_phone' => '081987654321',
            'total_price' => 50000,
            'status' => 'Selesai',
            'user_id' => $admin->id,
        ]);
        $unclaimedTrx->updated_at = Carbon::now()->subDays(3);
        $unclaimedTrx->save();

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Perhatian: Cucian Selesai Belum Diambil');
        $response->assertSee('INV-LUPA-AMBIL');
        $response->assertSee('Doni Terbengkalai');
        $response->assertSee('Ingatkan via WA');
    }

    public function test_tracking_by_customer_phone_number_redirects_to_active_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Transaction::create([
            'invoice_code' => 'INV-PHONE-TRACK',
            'customer_name' => 'Siti Nurhaliza',
            'customer_phone' => '082212345678',
            'total_price' => 42000,
            'status' => 'Proses',
            'user_id' => $admin->id,
        ]);

        // Cari menggunakan nomor HP via JSON (AJAX)
        $res = $this->postJson(route('track.order'), [
            'invoice_code' => '082212345678',
        ]);

        $res->assertStatus(200);
        $res->assertJson([
            'success' => true,
            'redirect' => route('cek.pesanan', 'INV-PHONE-TRACK'),
        ]);

        // Cari menggunakan format input form biasa (Redirect)
        $resRedirect = $this->post(route('track.order'), [
            'invoice_code' => '082212345678',
        ]);
        $resRedirect->assertRedirect(route('cek.pesanan', 'INV-PHONE-TRACK'));
    }

    public function test_services_page_renders_interactive_cost_calculator(): void
    {
        Promo::create([
            'title' => 'Diskon Kilat',
            'code' => 'KILAT10',
            'type' => 'percentage',
            'value' => 10,
            'description' => 'Diskon 10 persen',
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);

        $response = $this->get(route('frontend.services'));
        $response->assertStatus(200);
        $response->assertSee('Kalkulator Estimasi Biaya Laundry');
        $response->assertSee('calculatorSection');
        $response->assertSee('calcServiceSelect');
        $response->assertSee('calcQtyInput');
        $response->assertSee('calcPromoSelect');
        $response->assertSee('calcFinalPriceText');
        $response->assertSee('calcWhatsAppBtn');
        $response->assertSee('KILAT10');
    }

    public function test_receipt_view_contains_whatsapp_sharing_button(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::first();

        $trx = Transaction::create([
            'invoice_code' => 'INV-RECEIPT-WA',
            'customer_name' => 'Rina Cantika',
            'customer_phone' => '081234567890',
            'total_price' => 21000,
            'status' => 'Baru',
            'user_id' => $admin->id,
        ]);

        $trx->details()->create([
            'service_id' => $service->id,
            'quantity' => 3,
            'subtotal' => 21000,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.transactions.receipt', $trx->id));
        $response->assertStatus(200);
        $response->assertSee('Kirim Nota ke WhatsApp Pelanggan');
        $response->assertSee('INV-RECEIPT-WA');
        $response->assertSee('https://wa.me/6281234567890');
    }

    public function test_admin_can_toggle_splash_screen_via_ajax_and_update_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Toggle Splash Screen from 0 to 1
        Setting::updateOrCreate(['key' => 'enable_splash_screen'], ['value' => '0']);
        $toggleRes = $this->actingAs($admin)->postJson(route('admin.settings.toggle-splash'));
        $toggleRes->assertStatus(200);
        $toggleRes->assertJson([
            'success' => true,
            'enabled' => true,
        ]);
        $this->assertEquals('1', Setting::where('key', 'enable_splash_screen')->value('value'));

        // Toggle again from 1 to 0
        $toggleRes2 = $this->actingAs($admin)->postJson(route('admin.settings.toggle-splash'));
        $toggleRes2->assertStatus(200);
        $toggleRes2->assertJson([
            'success' => true,
            'enabled' => false,
        ]);
        $this->assertEquals('0', Setting::where('key', 'enable_splash_screen')->value('value'));
    }

    public function test_splash_screen_is_not_rendered_when_disabled_in_settings(): void
    {
        // When disabled
        Setting::updateOrCreate(['key' => 'enable_splash_screen'], ['value' => '0']);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('id="splashScreen"', false);

        // When enabled
        Setting::updateOrCreate(['key' => 'enable_splash_screen'], ['value' => '1']);
        $responseEnabled = $this->get('/');
        $responseEnabled->assertStatus(200);
        $responseEnabled->assertSee('id="splashScreen"', false);
    }

    public function test_track_order_ajax_returns_rich_order_data_without_page_reload(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::first();

        $trx = Transaction::create([
            'invoice_code' => 'INV-AJAX-TRACK-01',
            'customer_name' => 'Dimas Prakoso',
            'customer_phone' => '081299887766',
            'total_price' => 35000,
            'status' => 'Proses',
            'user_id' => $admin->id,
        ]);

        $trx->details()->create([
            'service_id' => $service->id,
            'quantity' => 5,
            'subtotal' => 35000,
        ]);

        $ajaxRes = $this->postJson(route('track.order'), [
            'invoice_code' => 'INV-AJAX-TRACK-01',
        ]);

        $ajaxRes->assertStatus(200);
        $ajaxRes->assertJson([
            'success' => true,
            'order' => [
                'invoice_code' => 'INV-AJAX-TRACK-01',
                'customer_name' => 'Dimas Prakoso',
                'status' => 'Proses',
                'total_price' => 35000,
            ]
        ]);
    }

    public function test_login_page_renders_modern_ui_with_demo_credentials_and_password_toggle(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Admin Demo');
        $response->assertSee('Kasir Demo');
        $response->assertSee('togglePasswordBtn');
        $response->assertSee('admin1@gmail.com');
        $response->assertSee('kasir1@gmail.com');
    }
}
