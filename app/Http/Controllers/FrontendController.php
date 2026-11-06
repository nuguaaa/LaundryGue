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
        // Ambil 10 testimoni teratas untuk animasi card geser ke samping
        $testimonials = Testimonial::latest()->take(10)->get();
        $totalTestimonials = Testimonial::count();
        $promos = Promo::where('expired_date', '>=', now()->toDateString())->get();

        return view('frontend.home', compact('settings', 'services', 'testimonials', 'totalTestimonials', 'promos'));
    }

    /**
     * Tampilkan Halaman Publik Seluruh Testimoni Pelanggan
     */
    public function testimonials(Request $request)
    {
        $settings = Setting::pluck('value', 'key');
        $query = Testimonial::latest();

        if ($request->filled('rating') && in_array((int)$request->rating, [1, 2, 3, 4, 5])) {
            $query->where('rating', (int)$request->rating);
        }

        $testimonials = $query->paginate(12)->withQueryString();
        $totalTestimonials = Testimonial::count();
        $avgRating = round(Testimonial::avg('rating') ?: 5.0, 1);
        $ratingCounts = [
            5 => Testimonial::where('rating', 5)->count(),
            4 => Testimonial::where('rating', 4)->count(),
            3 => Testimonial::where('rating', 3)->count(),
            2 => Testimonial::where('rating', 2)->count(),
            1 => Testimonial::where('rating', 1)->count(),
        ];

        return view('frontend.testimonials', compact('settings', 'testimonials', 'totalTestimonials', 'avgRating', 'ratingCounts'));
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
