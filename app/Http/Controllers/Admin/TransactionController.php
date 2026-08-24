<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Promo;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'details.service'])
            ->whereIn('status', ['Baru', 'Proses', 'Selesai'])
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $services = Service::all();
        $promos = Promo::all();
        return view('admin.transactions.kasir', compact('services', 'promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $service = Service::findOrFail($request->service_id);
        $subtotal = $service->price * $request->quantity;
        $discount = 0;

        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo) {
                if ($promo->type == 'percentage') {
                    $discount = ($subtotal * $promo->value) / 100;
                } else {
                    $discount = $promo->value;
                }
            } else {
                return back()->withErrors(['promo_code' => 'Kode promo tidak valid!'])->withInput();
            }
        }

        $finalPrice = max(0, $subtotal - $discount);

        $transaction = Transaction::create([
            'invoice_code' => 'INV-' . date('Ymd') . '-' . rand(100, 999),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'total_price' => $finalPrice,
            'status' => 'Baru',
            'user_id' => Auth::id(),
        ]);

        $transaction->details()->create([
            'service_id' => $service->id,
            'quantity' => $request->quantity,
            'subtotal' => $finalPrice,
        ]);

        // Langsung arahkan ke halaman cetak struk (bukan ke index lagi)
        return redirect()->route('admin.transactions.receipt', $transaction->id);
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $transaction->update(['status' => $request->status]);

        $pesan = $request->status == 'Diambil'
            ? 'Pesanan selesai dan dipindahkan ke History Laporan!'
            : 'Status pesanan berhasil diperbarui!';

        return redirect()->route('admin.transactions.index')->with('success', $pesan);
    }

    public function history(Request $request)
    {
        $query = Transaction::with(['user', 'details.service'])->where('status', 'Diambil');

        if ($request->has('filter') && $request->filter != '') {
            if ($request->filter == 'today') {
                $query->whereDate('updated_at', today());
            } elseif ($request->filter == 'week') {
                $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $query->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'));
            } elseif ($request->filter == 'year') {
                $query->whereYear('updated_at', date('Y'));
            }
        }

        $totalPendapatan = (clone $query)->sum('total_price');

        $expensesQuery = Expense::query();
        if ($request->has('filter') && $request->filter != '') {
            if ($request->filter == 'today') {
                $expensesQuery->whereDate('created_at', today());
            } elseif ($request->filter == 'week') {
                $expensesQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $expensesQuery->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            } elseif ($request->filter == 'year') {
                $expensesQuery->whereYear('created_at', date('Y'));
            }
        }

        $totalPengeluaran = (clone $expensesQuery)->sum('total_price');

        if ($request->has('print')) {
            $transactions = $query->latest()->get();
            $expenses = $expensesQuery->latest()->get();
        } else {
            $transactions = $query->latest()->paginate(10, ['*'], 'trx_page')->withQueryString();
            $expenses = $expensesQuery->latest()->paginate(10, ['*'], 'exp_page')->withQueryString();
        }

        $pendapatanBersih = $totalPendapatan - $totalPengeluaran;

        return view('admin.transactions.history', compact(
            'transactions',
            'totalPendapatan',
            'expenses',
            'totalPengeluaran',
            'pendapatanBersih'
        ));
    }

    public function printReport(Request $request)
    {
        $query = Transaction::with(['user', 'details.service'])->where('status', 'Diambil');

        if ($request->has('filter') && $request->filter != '') {
            if ($request->filter == 'today') {
                $query->whereDate('updated_at', today());
            } elseif ($request->filter == 'week') {
                $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $query->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'));
            } elseif ($request->filter == 'year') {
                $query->whereYear('updated_at', date('Y'));
            }
        }

        $totalPendapatan = (clone $query)->sum('total_price');
        $transactions = $query->latest()->get();

        $expensesQuery = Expense::query();
        if ($request->has('filter') && $request->filter != '') {
            if ($request->filter == 'today') {
                $expensesQuery->whereDate('created_at', today());
            } elseif ($request->filter == 'week') {
                $expensesQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $expensesQuery->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            } elseif ($request->filter == 'year') {
                $expensesQuery->whereYear('created_at', date('Y'));
            }
        }

        $totalPengeluaran = (clone $expensesQuery)->sum('total_price');
        $expenses = $expensesQuery->latest()->get();

        $pendapatanBersih = $totalPendapatan - $totalPengeluaran;
        $filter = $request->input('filter', 'Semua Waktu');

        return view('admin.transactions.print', compact(
            'transactions',
            'totalPendapatan',
            'expenses',
            'totalPengeluaran',
            'pendapatanBersih',
            'filter'
        ));
    }

    public function printReceipt(Transaction $transaction)
    {
        $transaction->load(['user', 'details.service']);
        return view('admin.transactions.receipt', compact('transaction'));
    }

public function checkOrderStatus($invoiceCode)
    {
        $transaction = Transaction::with(['details.service', 'user'])
            ->where('invoice_code', $invoiceCode)
            ->firstOrFail();

        return view('frontend.cek-pesanan', compact('transaction'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        Expense::create([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->quantity * $request->unit_price,
        ]);

        return back()->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function destroyExpense($id)
    {
        Expense::findOrFail($id)->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->details()->delete();
        $transaction->delete();
        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus!');
    }
}
