<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Ringkasan Eksekutif untuk Admin dan Kasir
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = ($user->role === 'admin');

        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. STATISTIK HARI INI
        $todayNewOrders = Transaction::whereDate('created_at', $today)->count();
        $todayCompletedOrders = Transaction::where('status', 'Diambil')->whereDate('updated_at', $today)->count();
        $todayRevenue = Transaction::where('status', 'Diambil')->whereDate('updated_at', $today)->sum('total_price');
        $todayExpenses = Expense::whereDate('created_at', $today)->sum('total_price');
        $todayNetProfit = $todayRevenue - $todayExpenses;

        // 2. STATISTIK BULAN INI
        $monthRevenue = Transaction::where('status', 'Diambil')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->sum('total_price');
        $monthExpenses = Expense::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');
        $monthNetProfit = $monthRevenue - $monthExpenses;
        $monthTotalOrders = Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // 3. STATISTIK ANTREAN STATUS CUCIAN AKTIF
        $countBaru = Transaction::where('status', 'Baru')->count();
        $countProses = Transaction::where('status', 'Proses')->count();
        $countSelesai = Transaction::where('status', 'Selesai')->count();
        $totalActiveOrders = $countBaru + $countProses + $countSelesai;

        // 4. SMART ALERTS: Cucian Selesai yang belum diambil > 2 hari (Perlu Follow-up)
        $unclaimedThreshold = Carbon::now()->subDays(2);
        $unclaimedOrders = Transaction::with(['details.service', 'user'])
            ->where('status', 'Selesai')
            ->where('updated_at', '<=', $unclaimedThreshold)
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 5. TREN OMZET 7 HARI TERAKHIR (Visualisasi Grafik)
        $namaHari = [
            0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
        ];

        $weeklyChart = [];
        $maxDailyRevenue = 10000; // minimum baseline to prevent divide by zero

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayRev = (float) Transaction::where('status', 'Diambil')
                ->whereDate('updated_at', $date)
                ->sum('total_price');
            $dayCount = Transaction::whereDate('created_at', $date)->count();

            if ($dayRev > $maxDailyRevenue) {
                $maxDailyRevenue = $dayRev;
            }

            $weeklyChart[] = [
                'date' => $date->format('Y-m-d'),
                'dayName' => $namaHari[(int)$date->dayOfWeek] ?? $date->format('D'),
                'displayDate' => $date->format('d/m'),
                'revenue' => $dayRev,
                'orders' => $dayCount,
            ];
        }

        // 6. 5 PESANAN AKTIF TERBARU (Pintasan Aksi Cepat)
        $recentActiveOrders = Transaction::with(['details.service', 'user'])
            ->whereIn('status', ['Baru', 'Proses', 'Selesai'])
            ->latest()
            ->take(5)
            ->get();

        // 7. LAYANAN TERLARIS BULAN INI
        $topServices = Service::withSum('transactionDetails', 'quantity')
            ->withSum('transactionDetails', 'subtotal')
            ->orderByDesc('transaction_details_sum_quantity')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'isAdmin',
            'todayNewOrders',
            'todayCompletedOrders',
            'todayRevenue',
            'todayExpenses',
            'todayNetProfit',
            'monthRevenue',
            'monthExpenses',
            'monthNetProfit',
            'monthTotalOrders',
            'countBaru',
            'countProses',
            'countSelesai',
            'totalActiveOrders',
            'unclaimedOrders',
            'weeklyChart',
            'maxDailyRevenue',
            'recentActiveOrders',
            'topServices'
        ));
    }
}
