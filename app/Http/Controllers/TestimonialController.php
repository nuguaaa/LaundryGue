<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\TestimonialToken;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Tampilkan Halaman Formulir Testimoni Sekali Pakai (One-Time Token Link)
     */
    public function create(Request $request, $token = null)
    {
        $tokenString = $token ?: $request->query('token');
        $settings = Setting::pluck('value', 'key');

        // Jika tidak ada token yang disertakan
        if (empty($tokenString)) {
            return view('frontend.testimonial-status', [
                'status' => 'token_required',
                'title' => 'Tautan Khusus Diperlukan',
                'message' => 'Halaman pengisian ulasan ini memerlukan tautan undangan khusus sekali pakai yang dikirimkan oleh kasir atau admin setelah cucian Anda selesai.',
                'settings' => $settings,
            ]);
        }

        // Cari token di database
        $tokenModel = TestimonialToken::where('token', $tokenString)->first();

        // Jika token tidak ditemukan
        if (!$tokenModel) {
            return view('frontend.testimonial-status', [
                'status' => 'not_found',
                'title' => 'Tautan Tidak Valid',
                'message' => 'Tautan ulasan yang Anda tuju tidak ditemukan atau salah. Pastikan Anda mengklik tautan lengkap yang kami kirimkan.',
                'settings' => $settings,
            ]);
        }

        // Jika token sudah pernah digunakan (One-time use)
        if ($tokenModel->is_used) {
            return view('frontend.testimonial-status', [
                'status' => 'already_used',
                'title' => 'Tautan Telah Digunakan & Expired',
                'message' => 'Terima kasih! Anda atau pelanggan telah berhasil mengirimkan ulasan menggunakan tautan ini sebelumnya. Setiap tautan ulasan hanya dapat digunakan satu kali untuk menjaga keaslian ulasan.',
                'tokenModel' => $tokenModel,
                'settings' => $settings,
            ]);
        }

        // Jika masa berlaku token telah kedaluwarsa
        if ($tokenModel->expires_at && $tokenModel->expires_at->isPast()) {
            return view('frontend.testimonial-status', [
                'status' => 'expired',
                'title' => 'Masa Berlaku Tautan Telah Berakhir',
                'message' => 'Maaf, masa aktif pengisian ulasan untuk tautan ini telah kedaluwarsa.',
                'tokenModel' => $tokenModel,
                'settings' => $settings,
            ]);
        }

        // Token valid: tampilkan formulir ulasan dengan rating bintang
        return view('frontend.testimonial', compact('settings', 'tokenModel'));
    }

    /**
     * Simpan Ulasan Testimoni Baru & Nonaktifkan Token (Expired)
     */
    public function store(Request $request, $token = null)
    {
        $tokenString = $token ?: $request->input('token') ?: $request->query('token');

        if (empty($tokenString)) {
            return redirect()->route('testimonial.create')
                ->withErrors(['token' => 'Tautan ulasan sekali pakai tidak valid.']);
        }

        $tokenModel = TestimonialToken::where('token', $tokenString)->first();

        if (!$tokenModel || !$tokenModel->isValid()) {
            return view('frontend.testimonial-status', [
                'status' => 'already_used',
                'title' => 'Tautan Tidak Dapat Digunakan',
                'message' => 'Tautan ulasan ini sudah tidak berlaku atau sudah pernah digunakan sebelumnya.',
                'settings' => Setting::pluck('value', 'key'),
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:5|max:1000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'rating.required' => 'Silakan tentukan rating bintang kepuasan Anda (1 sampai 5).',
            'rating.min' => 'Rating kepuasan minimal 1 bintang.',
            'rating.max' => 'Rating kepuasan maksimal 5 bintang.',
            'message.required' => 'Pesan atau ulasan testimoni wajib diisi.',
            'message.min' => 'Pesan testimoni minimal 5 karakter.',
        ]);

        // Kunci token secara atomik untuk mencegah race condition (TOCTOU)
        $affected = TestimonialToken::where('id', $tokenModel->id)
            ->where('is_used', false)
            ->update([
                'is_used' => true,
                'used_at' => Carbon::now(),
            ]);

        if ($affected === 0) {
            return view('frontend.testimonial-status', [
                'status' => 'already_used',
                'title' => 'Tautan Tidak Dapat Digunakan',
                'message' => 'Tautan ulasan ini sudah tidak berlaku atau sudah pernah digunakan sebelumnya.',
                'settings' => Setting::pluck('value', 'key'),
            ]);
        }

        $testimonial = Testimonial::create([
            'name' => trim($request->name),
            'role' => trim($request->role) ?: 'Pelanggan Setia',
            'rating' => (int) $request->rating,
            'message' => trim($request->message),
        ]);

        // Hubungkan id testimonial ke token yang telah dikunci
        $tokenModel->update([
            'testimonial_id' => $testimonial->id,
        ]);

        return view('frontend.testimonial-status', [
            'status' => 'success',
            'title' => 'Ulasan Berhasil Diterbitkan!',
            'message' => 'Terima kasih banyak atas penilaian dan ulasan Anda! Masukan Anda kini telah tampil di beranda utama. Tautan sekali pakai ini telah kedaluwarsa secara otomatis.',
            'testimonial' => $testimonial,
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }
}
