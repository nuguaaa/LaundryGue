<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Promo;
use App\Models\Expense;
use App\Models\Setting; // <-- Pastikan model Setting di-import di sini
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

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $pesan,
                'status' => $transaction->status,
                'invoice_code' => $transaction->invoice_code,
                'customer_name' => $transaction->customer_name,
                'customer_phone' => $transaction->customer_phone,
            ]);
        }

        return redirect()->back()->with('success', $pesan);
    }

    private function applyDateFilter($transactionsQuery, $expensesQuery, Request $request)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $filter = $request->input('filter', 'all');
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));
        $date = $request->input('date', date('Y-m-d'));

        if ($filter === 'custom_month' || ($request->filled('month') && $request->filled('year') && !in_array($filter, ['today', 'week', 'month', 'year', 'custom_day', 'custom_date']))) {
            $filter = 'custom_month';
        } elseif ($filter === 'custom_day' || $filter === 'custom_date' || ($request->filled('date') && !in_array($filter, ['today', 'week', 'month', 'year']))) {
            $filter = 'custom_day';
        }

        if ($filter === 'today') {
            $transactionsQuery->whereDate('updated_at', Carbon::today());
            $expensesQuery->whereDate('created_at', Carbon::today());
            $d = Carbon::today();
            $label = 'Hari Ini (' . $d->format('d') . ' ' . ($namaBulan[(int)$d->format('n')] ?? $d->format('M')) . ' ' . $d->format('Y') . ')';
        } elseif ($filter === 'week') {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $transactionsQuery->whereBetween('updated_at', [$start, $end]);
            $expensesQuery->whereBetween('created_at', [$start, $end]);
            $label = 'Minggu Ini (' . $start->format('d') . ' ' . ($namaBulan[(int)$start->format('n')] ?? '') . ' - ' . $end->format('d') . ' ' . ($namaBulan[(int)$end->format('n')] ?? '') . ' ' . $end->format('Y') . ')';
        } elseif ($filter === 'month') {
            $currentMonth = (int) date('m');
            $currentYear = (int) date('Y');
            $transactionsQuery->whereMonth('updated_at', $currentMonth)->whereYear('updated_at', $currentYear);
            $expensesQuery->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear);
            $label = 'Bulan Ini (' . ($namaBulan[(int)date('n')] ?? date('F')) . ' ' . date('Y') . ')';
        } elseif ($filter === 'year') {
            $currentYear = (int) date('Y');
            $transactionsQuery->whereYear('updated_at', $currentYear);
            $expensesQuery->whereYear('created_at', $currentYear);
            $label = 'Tahun Ini (' . $currentYear . ')';
        } elseif ($filter === 'custom_month') {
            $transactionsQuery->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
            $expensesQuery->whereMonth('created_at', $month)->whereYear('created_at', $year);
            $monthName = $namaBulan[$month] ?? Carbon::createFromDate($year, $month, 1)->format('F');
            $label = "Bulan {$monthName} {$year}";
        } elseif ($filter === 'custom_day') {
            $transactionsQuery->whereDate('updated_at', $date);
            $expensesQuery->whereDate('created_at', $date);
            $d = Carbon::parse($date);
            $label = 'Tanggal ' . $d->format('d') . ' ' . ($namaBulan[(int)$d->format('n')] ?? $d->format('M')) . ' ' . $d->format('Y');
        } else {
            $filter = 'all';
            $label = 'Semua Waktu';
        }

        return [
            'filter' => $filter,
            'label' => $label,
            'month' => $month,
            'year' => $year,
            'date' => $date,
        ];
    }

    public function history(Request $request)
    {
        $services = Service::orderBy('name')->get();
        $userRole = Auth::user()->role ?? 'kasir';

        if ($userRole === 'admin') {
            $query = Transaction::with(['user', 'details.service'])->where('status', 'Diambil');
            $expensesQuery = Expense::query();

            $filterData = $this->applyDateFilter($query, $expensesQuery, $request);

            $totalPendapatan = (clone $query)->sum('total_price');
            $totalPengeluaran = (clone $expensesQuery)->sum('total_price');
            $pendapatanBersih = $totalPendapatan - $totalPengeluaran;

            if ($request->has('print')) {
                $transactions = $query->latest('updated_at')->get();
                $expenses = $expensesQuery->latest('created_at')->get();
            } else {
                $transactions = $query->latest('updated_at')->paginate(10, ['*'], 'trx_page')->withQueryString();
                $expenses = $expensesQuery->latest('created_at')->paginate(10, ['*'], 'exp_page')->withQueryString();
            }
        } else {
            // Kasir tidak boleh melihat riwayat transaksi atau rekap omzet
            $transactions = collect();
            $totalPendapatan = 0;
            $pendapatanBersih = 0;
            $filterData = ['filter' => 'all', 'label' => 'Semua Pengeluaran'];

            $expenses = Expense::latest('created_at')->paginate(15, ['*'], 'exp_page');
            $totalPengeluaran = Expense::sum('total_price');
        }

        return view('admin.transactions.history', compact(
            'transactions',
            'totalPendapatan',
            'expenses',
            'totalPengeluaran',
            'pendapatanBersih',
            'services',
            'filterData'
        ));
    }

    public function storeManual(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang diizinkan menginput riwayat transaksi manual.');
        }

        $request->validate([
            'transaction_date' => 'required|date',
        ]);

        $items = $request->input('items', []);
        if (empty($items) && $request->filled('customer_name')) {
            $items = [[
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'service_id' => $request->service_id,
                'quantity' => $request->quantity,
                'total_price' => $request->total_price,
                'invoice_code' => $request->invoice_code,
            ]];
        }

        if (empty($items)) {
            return back()->withErrors(['items' => 'Minimal harus mengisi 1 baris transaksi!'])->withInput();
        }

        $transactionDate = Carbon::parse($request->transaction_date);
        $savedCount = 0;
        $totalBatchNominal = 0;

        \Illuminate\Support\Facades\DB::transaction(function () use ($items, $transactionDate, &$savedCount, &$totalBatchNominal) {
            $serviceIds = array_filter(array_column($items, 'service_id'));
            $services = Service::whereIn('id', $serviceIds)->get()->keyBy('id');

            foreach ($items as $item) {
                if (empty($item['customer_name']) || empty($item['service_id']) || empty($item['quantity'])) {
                    continue;
                }

                $service = $services->get($item['service_id']);
                if (!$service) {
                    continue;
                }

                $qty = (float) $item['quantity'];
                if ($qty <= 0) {
                    continue;
                }

                $totalPrice = isset($item['total_price']) && $item['total_price'] !== '' && $item['total_price'] !== null
                    ? (float) $item['total_price']
                    : (float) ($service->price * $qty);

                $invoiceCode = !empty($item['invoice_code'])
                    ? trim($item['invoice_code'])
                    : 'INV-' . $transactionDate->format('Ymd') . '-' . rand(100, 999);

                while (Transaction::where('invoice_code', $invoiceCode)->exists()) {
                    $invoiceCode = 'INV-' . $transactionDate->format('Ymd') . '-' . rand(1000, 9999);
                }

                $transaction = new Transaction();
                $transaction->invoice_code = $invoiceCode;
                $transaction->customer_name = $item['customer_name'];
                $transaction->customer_phone = !empty($item['customer_phone']) ? $item['customer_phone'] : '-';
                $transaction->total_price = $totalPrice;
                $transaction->status = 'Diambil';
                $transaction->user_id = Auth::id() ?? 1;
                $transaction->created_at = $transactionDate;
                $transaction->updated_at = $transactionDate;
                $transaction->timestamps = false;
                $transaction->save();

                $detail = new \App\Models\TransactionDetail();
                $detail->transaction_id = $transaction->id;
                $detail->service_id = $service->id;
                $detail->quantity = $qty;
                $detail->subtotal = $totalPrice;
                $detail->created_at = $transactionDate;
                $detail->updated_at = $transactionDate;
                $detail->timestamps = false;
                $detail->save();

                $savedCount++;
                $totalBatchNominal += $totalPrice;
            }
        });

        if ($savedCount === 0) {
            return back()->withErrors(['items' => 'Tidak ada baris transaksi yang valid untuk disimpan. Pastikan Nama, Layanan, dan Jumlah sudah terisi.'])->withInput();
        }

        $formattedDate = $transactionDate->format('d/m/Y');
        $formattedNominal = number_format($totalBatchNominal, 0, ',', '.');
        $msg = "Berhasil menyimpan {$savedCount} transaksi pada tanggal {$formattedDate} (Total: Rp{$formattedNominal})!";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg
            ]);
        }

        return redirect()->route('admin.transactions.history')->with('success', $msg);
    }

    public function printReport(Request $request)
    {
        $query = Transaction::with(['user', 'details.service'])->where('status', 'Diambil');
        $expensesQuery = Expense::query();

        $filterData = $this->applyDateFilter($query, $expensesQuery, $request);

        $totalPendapatan = (clone $query)->sum('total_price');
        $transactions = $query->latest('updated_at')->get();

        $totalPengeluaran = (clone $expensesQuery)->sum('total_price');
        $expenses = $expensesQuery->latest('created_at')->get();

        $pendapatanBersih = $totalPendapatan - $totalPengeluaran;
        $filter = $filterData['label'];

        return view('admin.transactions.print', compact(
            'transactions',
            'totalPendapatan',
            'expenses',
            'totalPengeluaran',
            'pendapatanBersih',
            'filter',
            'filterData'
        ));
    }

    public function printReceipt(Transaction $transaction)
    {
        $transaction->load(['user', 'details.service']);

        // Mengambil data pengaturan website/toko dari database
        $settings = Setting::pluck('value', 'key');

        return view('admin.transactions.receipt', compact('transaction', 'settings'));
    }

    public function checkOrderStatus($invoiceCode)
    {
        $transaction = Transaction::with(['details.service', 'user'])
            ->where('invoice_code', $invoiceCode)
            ->firstOrFail();

        $isCompleted = in_array($transaction->status, ['Selesai', 'Diambil']);
        $isExpired = false;

        if ($isCompleted && $transaction->updated_at) {
            $completedAt = Carbon::parse($transaction->updated_at);
            // Tidak bisa diakses setelah 1 hari (24 jam)
            if ($completedAt->addDay()->isPast()) {
                $isExpired = true;
            }
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'status' => $transaction->status,
                'status_label' => match($transaction->status) {
                    'Baru' => 'Sedang Diterima & Masuk Antrean',
                    'Proses' => 'Sedang Diproses',
                    'Selesai' => 'Selesai & Siap Diambil!',
                    'Diambil' => 'Sudah Diambil (Selesai)',
                    default => $transaction->status,
                },
                'badge' => match($transaction->status) {
                    'Baru' => 'PESANAN BARU / DITERIMA',
                    'Proses' => 'SEDANG DIPROSES',
                    'Selesai' => 'SELESAI (SIAP AMBIL)',
                    'Diambil' => 'PESANAN DIAMBIL',
                    default => strtoupper($transaction->status),
                },
                'heading' => match($transaction->status) {
                    'Baru' => 'Cucian Baru Diterima',
                    'Proses' => 'Cucian Sedang Diproses',
                    'Selesai' => 'Cucian Selesai dan Siap Diambil!',
                    'Diambil' => 'Cucian Telah Diserahkan',
                    default => 'Status Pengerjaan Laundry',
                },
                'icon' => match($transaction->status) {
                    'Baru' => 'package-plus',
                    'Proses' => 'loader-2',
                    'Selesai' => 'check-check',
                    'Diambil' => 'check-circle-2',
                    default => 'clock',
                },
                'spin' => $transaction->status === 'Proses',
                'theme' => match($transaction->status) {
                    'Baru' => 'amber',
                    'Proses' => 'sky',
                    'Selesai' => 'emerald',
                    'Diambil' => 'emerald',
                    default => 'sky',
                },
                'description' => match($transaction->status) {
                    'Baru' => 'Pesanan Anda telah diterima di outlet dan masuk antrean pengerjaan mesin cuci.',
                    'Proses' => 'Cucian sedang dalam tahap proses pencucian / pengeringan / setrika rapi oleh tim kami. Harap menunggu pemberitahuan selanjutnya.',
                    'Selesai' => 'Cucian sudah selesai dicuci, dikeringkan, dan disetrika rapi! Silakan ambil ke outlet dengan membawa nomor resi ini.',
                    'Diambil' => 'Cucian dengan nomor resi ini telah diambil oleh pemilik pada ' . ($transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '') . '.',
                    default => 'Pesanan Anda sedang diproses oleh staf LaundryGue.',
                },
                'is_completed' => $isCompleted,
                'is_expired' => $isExpired,
                'updated_at' => $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : null,
                'expire_time' => $transaction->updated_at ? Carbon::parse($transaction->updated_at)->addDay()->format('d M Y, H:i') : null,
            ]);
        }

        return view('frontend.cek-pesanan', compact('transaction', 'isExpired'));
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'invoice_code' => 'required|string',
        ]);

        $transaction = Transaction::with(['details.service', 'user'])
            ->where('invoice_code', trim($request->invoice_code))
            ->first();

        if (!$transaction) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor nota / invoice tidak ditemukan. Periksa kembali ketikan Anda!'
                ], 404);
            }
            return back()->with('error', 'Nomor nota / invoice tidak ditemukan. Periksa kembali ketikan Anda!');
        }

        $isCompleted = in_array($transaction->status, ['Selesai', 'Diambil']);
        if ($isCompleted && $transaction->updated_at && Carbon::parse($transaction->updated_at)->addDay()->isPast()) {
            $msg = 'Akses pelacakan untuk nomor resi ' . $transaction->invoice_code . ' sudah tidak dapat diakses karena status pesanan sudah selesai lebih dari 1 hari yang lalu demi privasi dan keamanan data.';
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg
                ], 403);
            }
            return back()->with('error', $msg);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('cek.pesanan', $transaction->invoice_code)
            ]);
        }

        return redirect()->route('cek.pesanan', $transaction->invoice_code);
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'expense_date' => 'nullable|date',
        ]);

        $expenseDate = $request->filled('expense_date') ? Carbon::parse($request->expense_date) : Carbon::now();

        $expense = new Expense();
        $expense->item_name = $request->item_name;
        $expense->quantity = $request->quantity;
        $expense->unit_price = $request->unit_price;
        $expense->total_price = $request->quantity * $request->unit_price;
        $expense->created_at = $expenseDate;
        $expense->updated_at = $expenseDate;
        $expense->timestamps = false;
        $expense->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pengeluaran berhasil ditambahkan!'
            ]);
        }

        return back()->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function destroyExpense($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang diizinkan menghapus data pengeluaran.');
        }

        Expense::findOrFail($id)->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data pengeluaran berhasil dihapus!']);
        }

        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    public function destroy(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang diizinkan menghapus data transaksi.');
        }

        $transaction->details()->delete();
        $transaction->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data transaksi berhasil dihapus!']);
        }

        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus!');
    }
}
