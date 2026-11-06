<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\TestimonialToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonial_page_without_token_shows_token_required_notice(): void
    {
        $response = $this->get(route('testimonial.create'));
        $response->assertStatus(200);
        $response->assertSee('Tautan Khusus Diperlukan');
        $response->assertSee('memerlukan tautan undangan khusus sekali pakai');
    }

    public function test_testimonial_page_with_invalid_token_shows_not_found_notice(): void
    {
        $response = $this->get(route('testimonial.create', ['token' => 'invalid-random-token-xyz']));
        $response->assertStatus(200);
        $response->assertSee('Tautan Tidak Valid');
    }

    public function test_main_page_does_not_contain_direct_navigation_link_to_testimonial_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('href="/testimoni"', false);
    }

    public function test_admin_can_generate_one_time_testimonial_token(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.testimonials.tokens.store'), [
            'customer_name' => 'Ibu Rina Wijaya',
            'customer_phone' => '081234567890',
            'notes' => 'Nota Cuci Bedcover #INV-009',
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $response->assertSessionHas('new_token');
        $response->assertSessionHas('new_link');

        $this->assertDatabaseHas('testimonial_tokens', [
            'customer_name' => 'Ibu Rina Wijaya',
            'customer_phone' => '081234567890',
            'notes' => 'Nota Cuci Bedcover #INV-009',
            'is_used' => false,
        ]);

        // Admin can view the list of tokens
        $indexRes = $this->actingAs($admin)->get(route('admin.testimonials.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertSee('Ibu Rina Wijaya');
        $indexRes->assertSee('Nota Cuci Bedcover #INV-009');
        $indexRes->assertSee('Aktif / Menunggu Diisi');
    }

    public function test_customer_can_open_form_with_valid_token_and_submit_review(): void
    {
        $token = TestimonialToken::generateToken([
            'customer_name' => 'Siti Nurhaliza',
            'customer_phone' => '081298765432',
        ]);

        // Customer opens form with valid token
        $formRes = $this->get(route('testimonial.create', ['token' => $token->token]));
        $formRes->assertStatus(200);
        $formRes->assertSee('Kirim Ulasan & Testimoni', false);
        $formRes->assertSee('value="Siti Nurhaliza"', false);
        $formRes->assertSee('Rating Kepuasan Layanan', false);

        // Customer submits review with 5 stars
        $submitRes = $this->post(route('testimonial.store', ['token' => $token->token]), [
            'name' => 'Siti Nurhaliza',
            'role' => 'Pelanggan Setia',
            'rating' => 5,
            'message' => 'Pakaian wangi dan rapi banget, pelayanannya sangat cepat!',
        ]);

        $submitRes->assertStatus(200);
        $submitRes->assertSee('Ulasan Berhasil Diterbitkan!');
        $submitRes->assertSee('Tautan ini sekarang telah kedaluwarsa');

        // Verify database: Testimonial is created
        $this->assertDatabaseHas('testimonials', [
            'name' => 'Siti Nurhaliza',
            'rating' => 5,
            'message' => 'Pakaian wangi dan rapi banget, pelayanannya sangat cepat!',
        ]);

        // Verify database: Token is marked as used
        $token->refresh();
        $this->assertTrue($token->is_used);
        $this->assertNotNull($token->used_at);
        $this->assertNotNull($token->testimonial_id);

        // Verify it displays on the home page with chosen stars
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('Siti Nurhaliza');
        $homeRes->assertSee('5.0');
        $homeRes->assertSee('Pakaian wangi dan rapi banget, pelayanannya sangat cepat!');
    }

    public function test_once_filled_the_page_expires_and_cannot_be_opened_again(): void
    {
        $token = TestimonialToken::generateToken([
            'customer_name' => 'Ahmad Dani',
        ]);

        // Customer submits review
        $this->post(route('testimonial.store', ['token' => $token->token]), [
            'name' => 'Ahmad Dani',
            'role' => 'Pelanggan',
            'rating' => 4,
            'message' => 'Cucian selesai tepat waktu dan bersih rapi.',
        ]);

        // Customer tries to revisit the link
        $revisitRes = $this->get(route('testimonial.create', ['token' => $token->token]));
        $revisitRes->assertStatus(200);
        $revisitRes->assertSee('Tautan Telah Digunakan &amp; Expired', false);
        $revisitRes->assertSee('Tautan Kedaluwarsa (Expired)');
        $revisitRes->assertDontSee('Kirim Ulasan Sekarang');

        // Customer tries to post again to the same token
        $rePostRes = $this->post(route('testimonial.store', ['token' => $token->token]), [
            'name' => 'Ahmad Dani',
            'rating' => 5,
            'message' => 'Mencoba mengisi ulasan kedua kalinya.',
        ]);
        $rePostRes->assertSee('Tautan Tidak Dapat Digunakan');
        $this->assertDatabaseMissing('testimonials', [
            'message' => 'Mencoba mengisi ulasan kedua kalinya.',
        ]);
    }

    public function test_admin_can_delete_token_and_testimonial(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $token = TestimonialToken::generateToken([
            'customer_name' => 'Delete Target',
        ]);

        $testimonial = Testimonial::create([
            'name' => 'Testi Delete',
            'rating' => 5,
            'message' => 'Testimonial to be deleted',
        ]);

        // Delete token
        $delTokenRes = $this->actingAs($admin)->delete(route('admin.testimonials.tokens.destroy', $token->id));
        $delTokenRes->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonial_tokens', ['id' => $token->id]);

        // Delete testimonial
        $delTestiRes = $this->actingAs($admin)->delete(route('admin.testimonials.destroy', $testimonial->id));
        $delTestiRes->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_admin_can_generate_token_directly_from_transaction_selection(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $trx = \App\Models\Transaction::create([
            'invoice_code' => 'INV-TEST-777',
            'customer_name' => 'Bambang Pamungkas',
            'customer_phone' => '081233445566',
            'total_price' => 50000,
            'status' => 'Selesai',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.testimonials.tokens.store'), [
            'transaction_id' => $trx->id,
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonial_tokens', [
            'customer_name' => 'Bambang Pamungkas',
            'customer_phone' => '081233445566',
            'is_used' => false,
        ]);
    }

    public function test_testimonial_form_shows_personal_greeting_and_locked_name(): void
    {
        $token = TestimonialToken::generateToken([
            'customer_name' => 'Kurniawan Dwi Yulianto',
            'customer_phone' => '081399887766',
        ]);

        $response = $this->get(route('testimonial.create', ['token' => $token->token]));
        $response->assertStatus(200);
        $response->assertSee('Hai,');
        $response->assertSee('Kurniawan Dwi Yulianto');
        $response->assertSee('Gimana hasil cucian kamu');
        $response->assertSee('value="Kurniawan Dwi Yulianto"', false);
    }

    public function test_public_all_testimonials_page_displays_testimonials_and_filter(): void
    {
        Testimonial::create([
            'name' => 'Customer Lima Bintang',
            'rating' => 5,
            'message' => 'Layanan bintang lima sangat memuaskan!',
        ]);

        Testimonial::create([
            'name' => 'Customer Tiga Bintang',
            'rating' => 3,
            'message' => 'Cukup lumayan tapi agak terlambat.',
        ]);

        // Access /semua-testimoni
        $response = $this->get(route('frontend.testimonials'));
        $response->assertStatus(200);
        $response->assertSee('Ulasan Asli Pelanggan Kami');
        $response->assertSee('Customer Lima Bintang');
        $response->assertSee('Customer Tiga Bintang');

        // Filter by 5 stars
        $filter5Res = $this->get(route('frontend.testimonials', ['rating' => 5]));
        $filter5Res->assertStatus(200);
        $filter5Res->assertSee('Customer Lima Bintang');
        $filter5Res->assertDontSee('Customer Tiga Bintang');
    }

    public function test_home_page_shows_sideways_testimonial_marquee_and_view_all_button(): void
    {
        Testimonial::create([
            'name' => 'Marquee Customer',
            'rating' => 5,
            'message' => 'Marquee animasinya keren banget!',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('animate-marquee-infinite');
        $response->assertSee('Lihat Seluruh Testimoni');
        $response->assertSee(route('frontend.testimonials'));
    }

    public function test_user_facing_pages_include_aos_and_admin_panel_excludes_aos(): void
    {
        // Frontend home has AOS configured for scroll down and up animation
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('unpkg.com/aos@2.3.1/dist/aos.css');
        $homeRes->assertSee('AOS.init(');
        $homeRes->assertSee('once: false', false);
        $homeRes->assertSee('mirror: true', false);
        $homeRes->assertSee('data-aos=', false);

        // Frontend /semua-testimoni has AOS
        $testiRes = $this->get(route('frontend.testimonials'));
        $testiRes->assertStatus(200);
        $testiRes->assertSee('unpkg.com/aos@2.3.1/dist/aos.css');
        $testiRes->assertSee('once: false', false);
        $testiRes->assertSee('mirror: true', false);
        $testiRes->assertSee('data-aos=', false);

        // Admin panel does NOT have AOS
        $admin = User::factory()->create(['role' => 'admin']);
        $adminRes = $this->actingAs($admin)->get(route('admin.transactions.index'));
        $adminRes->assertStatus(200);
        $adminRes->assertDontSee('unpkg.com/aos');
        $adminRes->assertDontSee('AOS.init');
    }
}
