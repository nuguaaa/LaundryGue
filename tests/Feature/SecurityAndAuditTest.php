<?php

namespace Tests\Feature;

use App\Models\LandingMedia;
use App\Models\Promo;
use App\Models\Service;
use App\Models\TestimonialToken;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SecurityAndAuditTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->service = Service::create([
            'category' => 'Kiloan',
            'name' => 'Cuci Komplit Kilat',
            'duration' => '1 Hari',
            'price' => 10000,
            'unit' => 'Kg',
        ]);
    }

    public function test_testimonial_token_url_attribute_is_valid(): void
    {
        $token = TestimonialToken::generateToken([
            'customer_name' => 'Andi Wijaya',
            'customer_phone' => '081234567890',
        ]);

        $url = $token->url;
        $this->assertNotEmpty($url);
        $this->assertStringContainsString('/testimoni/' . $token->token, $url);

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSee('Kirim Ulasan & Testimoni Pelanggan');
    }

    public function test_track_order_ajax_returns_masked_phone_and_correct_items(): void
    {
        $trx = Transaction::create([
            'invoice_code' => 'INV-20261105-ABC123',
            'customer_name' => 'Siti Rahma',
            'customer_phone' => '081234567890',
            'total_price' => 20000,
            'status' => 'Proses',
            'user_id' => $this->admin->id,
        ]);

        $trx->details()->create([
            'service_id' => $this->service->id,
            'quantity' => 2,
            'subtotal' => 20000,
        ]);

        $response = $this->postJson('/track-order', [
            'invoice_code' => 'INV-20261105-ABC123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'order' => [
                'invoice_code' => 'INV-20261105-ABC123',
                'customer_name' => 'Siti Rahma',
                'customer_phone' => '0812****890',
                'status' => 'Proses',
                'total_price' => 20000,
                'items' => [
                    [
                        'name' => 'Cuci Komplit Kilat',
                        'qty' => 2,
                        'unit' => 'Kg',
                        'price' => 10000,
                        'formatted_price' => 'Rp 10.000',
                        'subtotal' => 20000,
                        'formatted_subtotal' => 'Rp 20.000',
                    ]
                ]
            ]
        ]);
    }

    public function test_expired_promo_code_is_rejected_on_transaction_store(): void
    {
        Promo::create([
            'code' => 'KEDALUWARSA20',
            'title' => 'Diskon Masa Lalu',
            'description' => 'Deskripsi promo kedaluwarsa',
            'type' => 'percentage',
            'value' => 20,
            'expired_date' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.transactions.store'), [
            'customer_name' => 'Rina',
            'customer_phone' => '081299998888',
            'service_id' => $this->service->id,
            'quantity' => 2,
            'promo_code' => 'KEDALUWARSA20',
        ]);

        $response->assertSessionHasErrors(['promo_code']);
        $this->assertEquals(0, Transaction::count());
    }

    public function test_active_promo_code_is_applied_and_invoice_code_is_unique(): void
    {
        Promo::create([
            'code' => 'DISKON10',
            'title' => 'Diskon 10 Persen',
            'description' => 'Deskripsi promo aktif',
            'type' => 'percentage',
            'value' => 10,
            'expired_date' => Carbon::now()->addDays(5)->toDateString(),
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.transactions.store'), [
            'customer_name' => 'Rina',
            'customer_phone' => '081299998888',
            'service_id' => $this->service->id,
            'quantity' => 2,
            'promo_code' => 'DISKON10',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, Transaction::count());

        $trx = Transaction::first();
        // 20000 - 10% (2000) = 18000
        $this->assertEquals(18000, $trx->total_price);
        $this->assertStringStartsWith('INV-' . date('Ymd') . '-', $trx->invoice_code);
        $this->assertGreaterThanOrEqual(19, strlen($trx->invoice_code));
    }

    public function test_svg_file_upload_is_rejected_for_security(): void
    {
        $svgContent = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert("xss")</script></svg>';
        $file = UploadedFile::fake()->createWithContent('malicious.svg', $svgContent);

        $response = $this->actingAs($this->admin)->post(route('admin.landing-media.upload'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors(['image']);
        $this->assertEquals(0, LandingMedia::count());
    }

    public function test_route_aliases_work_properly(): void
    {
        $ulasanRes = $this->get('/ulasan');
        $ulasanRes->assertRedirect('/semua-testimoni');

        $searchRes = $this->postJson('/cek-pesanan/search', [
            'invoice_code' => 'NON-EXISTENT',
        ]);
        $searchRes->assertStatus(404);
    }
}
