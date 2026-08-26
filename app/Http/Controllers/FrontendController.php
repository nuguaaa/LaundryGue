<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Promo;

class FrontendController extends Controller
{
    /**
     * Tampilkan Halaman Utama (Beranda)
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $services = Service::all();
        $testimonials = Testimonial::all();
        $promos = Promo::all();

        return view('frontend.home', compact('settings', 'services', 'testimonials', 'promos'));
    }

    /**
     * Tampilkan Halaman Kontak & Lokasi
     */
    public function contact()
    {
        $settings = Setting::pluck('value', 'key');

        return view('frontend.contact', compact('settings'));
    }
}
