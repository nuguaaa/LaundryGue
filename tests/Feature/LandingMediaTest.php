<?php

namespace Tests\Feature;

use App\Models\LandingMedia;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LandingMediaTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin_media_test@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'phone' => '081234567899',
        ]);
    }

    public function test_guest_cannot_access_landing_media_management(): void
    {
        $response = $this->get(route('admin.landing-media.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_kasir_cannot_access_landing_media_management(): void
    {
        $kasir = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir_test@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
            'phone' => '081234567890',
        ]);

        $response = $this->actingAs($kasir)->get(route('admin.landing-media.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_landing_media_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.landing-media.index'));
        $response->assertStatus(200);
        $response->assertSee('Kelola Gambar & Tampilan Beranda');
        $response->assertSee('Slot Gambar Utama');
        $response->assertSee('Pratinjau Live Web');
        $response->assertSee('liveWebPreviewIframe');
    }

    public function test_frontend_pages_contain_pickup_distance_and_gps_elements(): void
    {
        // Test Home Page
        $homeRes = $this->get(route('frontend.home'));
        $homeRes->assertStatus(200);
        $homeRes->assertSee('orderCustDistance');
        $homeRes->assertSee('orderGpsBtn');
        $homeRes->assertSee('Somawinata cidahu');
        $homeRes->assertSee('serviceModal');

        // Test Services Page
        $servicesRes = $this->get(route('frontend.services'));
        $servicesRes->assertStatus(200);
        $servicesRes->assertSee('orderCustDistance');
        $servicesRes->assertSee('orderGpsBtn');
        $servicesRes->assertSee('categoryButtons');
        $servicesRes->assertSee('serviceModal');
    }

    public function test_admin_can_upload_new_image(): void
    {
        $file = UploadedFile::fake()->image('test_hero.jpg', 800, 600);

        $response = $this->actingAs($this->admin)->post(route('admin.landing-media.upload'), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.landing-media.index'));
        $this->assertDatabaseHas('landing_media', [
            'original_name' => 'test_hero.jpg',
        ]);

        // Cleanup uploaded fake file
        $media = LandingMedia::where('original_name', 'test_hero.jpg')->latest()->first();
        if ($media && File::exists(public_path($media->path))) {
            File::delete(public_path($media->path));
        }
    }

    public function test_admin_can_set_and_reset_slot(): void
    {
        $media = LandingMedia::create([
            'filename' => 'hero-bg.jpg',
            'original_name' => 'Hero Test',
            'path' => 'img/hero/hero-bg.jpg',
            'file_size' => 1024,
            'mime_type' => 'image/jpeg',
        ]);

        // Set slot
        $response = $this->actingAs($this->admin)->postJson(route('admin.landing-media.set-slot'), [
            'slot_key' => 'landing_hero_bg',
            'media_id' => $media->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertEquals('img/hero/hero-bg.jpg', Setting::where('key', 'landing_hero_bg')->value('value'));

        // Reset slot
        $resetResponse = $this->actingAs($this->admin)->postJson(route('admin.landing-media.reset-slot'), [
            'slot_key' => 'landing_hero_bg',
        ]);

        $resetResponse->assertStatus(200);
        $resetResponse->assertJson(['success' => true]);
        $this->assertNull(Setting::where('key', 'landing_hero_bg')->first());
    }

    public function test_admin_can_update_landing_texts(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.landing-media.texts'), [
            'hero_badge' => 'Badge Custom Test',
            'hero_title' => 'Judul Hero Custom Test',
            'hero_subtitle_highlight' => 'Highlight Custom',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals('Badge Custom Test', Setting::where('key', 'hero_badge')->value('value'));
        $this->assertEquals('Judul Hero Custom Test', Setting::where('key', 'hero_title')->value('value'));
    }
}
