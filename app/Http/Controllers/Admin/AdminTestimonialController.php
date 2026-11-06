<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\TestimonialToken;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    /**
     * Tampilkan halaman kelola testimoni dan tautan undangan ulasan
     */
    public function index()
    {
        $tokens = TestimonialToken::with('testimonial')->latest()->paginate(15, ['*'], 'tokens_page');
        $testimonials = Testimonial::with('token')->latest()->paginate(15, ['*'], 'testimonials_page');
        $recentTransactions = Transaction::latest()->take(60)->get(['id', 'invoice_code', 'customer_name', 'customer_phone', 'status', 'total_price', 'created_at']);

        return view('admin.testimonials.index', compact('tokens', 'testimonials', 'recentTransactions'));
    }

    /**
     * Generate Link Testimoni Sekali Pakai (One-Time Link)
     * Dapat digenerate langsung dari data transaksi pelanggan yang dicari
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'transaction_id' => 'nullable|exists:transactions,id',
            'customer_name' => 'nullable|string|max:100',
            'customer_phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:255',
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ]);

        $customerName = $request->customer_name;
        $customerPhone = $request->customer_phone;
        $notes = $request->notes;

        if ($request->filled('transaction_id')) {
            $trx = Transaction::find($request->transaction_id);
            if ($trx) {
                $customerName = $trx->customer_name;
                $customerPhone = $trx->customer_phone;
                $notes = 'Invoice #' . $trx->invoice_code . ' (' . $trx->status . ')';
            }
        }

        $expiresAt = null;
        if ($request->filled('expires_in_days')) {
            $expiresAt = Carbon::now()->addDays((int) $request->expires_in_days);
        }

        $token = TestimonialToken::generateToken([
            'customer_name' => $customerName ? trim($customerName) : null,
            'customer_phone' => $customerPhone ? trim($customerPhone) : null,
            'notes' => $notes ? trim($notes) : null,
            'expires_at' => $expiresAt,
        ]);

        $link = route('testimonial.create', ['token' => $token->token]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Link ulasan sekali pakai untuk ' . ($customerName ?: 'Pelanggan') . ' berhasil dibuat!')
            ->with('new_token', $token)
            ->with('new_link', $link);
    }

    /**
     * Hapus Link Token
     */
    public function destroyToken(TestimonialToken $token)
    {
        $token->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Link undangan testimoni berhasil dihapus.');
    }

    /**
     * Hapus Ulasan Testimoni Publik
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Ulasan testimoni berhasil dihapus dari sistem.');
    }
}
