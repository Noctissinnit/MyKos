<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kos;
use App\Models\Pembayaran;
use App\Models\RentalRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // days

        // Basic metrics
        $metrics = $this->getBasicMetrics($period);

        // Charts data
        $charts = $this->getChartsData($period);

        // Top performing data
        $topData = $this->getTopPerformingData($period);

        // Recent activities
        $activities = $this->getRecentActivities();

        return view('admin.analytics.index', compact('metrics', 'charts', 'topData', 'activities', 'period'));
    }

    private function getBasicMetrics($period)
    {
        $startDate = Carbon::now()->subDays($period);

        return [
            'total_users' => User::count(),
            'new_users_period' => User::where('created_at', '>=', $startDate)->count(),
            'total_kos' => Kos::where('status', 'approved')->count(),
            'new_kos_period' => Kos::where('status', 'approved')->where('created_at', '>=', $startDate)->count(),
            'total_payments' => Pembayaran::where('status', 'lunas')->count(),
            'payments_period' => Pembayaran::where('status', 'lunas')->where('created_at', '>=', $startDate)->count(),
            'total_revenue' => Pembayaran::where('status', 'lunas')->sum('jumlah'),
            'revenue_period' => Pembayaran::where('status', 'lunas')->where('created_at', '>=', $startDate)->sum('jumlah'),
            'pending_requests' => RentalRequest::where('status', 'pending')->count(),
            'conversion_rate' => $this->calculateConversionRate(),
        ];
    }

    private function getChartsData($period)
    {
        $startDate = Carbon::now()->subDays($period);

        // User registration trend
        $userRegistrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Payment trend
        $paymentTrend = Pembayaran::selectRaw('DATE(created_at) as date, SUM(jumlah) as total')
            ->where('status', 'lunas')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Kos approval trend
        $kosApprovals = Kos::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', 'approved')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates with 0
        $dateRange = $this->getDateRange($startDate, Carbon::now());
        $userRegistrations = $this->fillMissingDates($userRegistrations, $dateRange);
        $paymentTrend = $this->fillMissingDates($paymentTrend, $dateRange);
        $kosApprovals = $this->fillMissingDates($kosApprovals, $dateRange);

        return [
            'user_registrations' => $userRegistrations,
            'payment_trend' => $paymentTrend,
            'kos_approvals' => $kosApprovals,
            'date_labels' => array_keys($userRegistrations),
        ];
    }

    private function getTopPerformingData($period)
    {
        $startDate = Carbon::now()->subDays($period);

        // Top kos by revenue
        $topKos = DB::table('pembayarans')
            ->join('penghunis', 'pembayarans.penghuni_id', '=', 'penghunis.id')
            ->join('kamars', 'penghunis.kamar_id', '=', 'kamars.id')
            ->join('kos', 'kamars.kos_id', '=', 'kos.id')
            ->where('pembayarans.status', 'lunas')
            ->where('pembayarans.created_at', '>=', $startDate)
            ->select('kos.id', 'kos.nama', DB::raw('SUM(pembayarans.jumlah) as total_revenue'), DB::raw('COUNT(pembayarans.id) as payment_count'))
            ->groupBy('kos.id', 'kos.nama')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Top pemilik by revenue
        $topPemilik = DB::table('pembayarans')
            ->join('penghunis', 'pembayarans.penghuni_id', '=', 'penghunis.id')
            ->join('kamars', 'penghunis.kamar_id', '=', 'kamars.id')
            ->join('kos', 'kamars.kos_id', '=', 'kos.id')
            ->join('users', 'kos.user_id', '=', 'users.id')
            ->where('pembayarans.status', 'lunas')
            ->where('pembayarans.created_at', '>=', $startDate)
            ->select('users.id', 'users.name', DB::raw('SUM(pembayarans.jumlah) as total_revenue'), DB::raw('COUNT(pembayarans.id) as payment_count'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // User role distribution
        $userRoles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        return [
            'top_kos' => $topKos,
            'top_pemilik' => $topPemilik,
            'user_roles' => $userRoles,
        ];
    }

    private function getRecentActivities()
    {
        $activities = collect();

        // Recent user registrations
        $recentUsers = User::latest()->limit(3)->get();
        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user_registration',
                'icon' => 'bi-person-plus',
                'title' => "User baru: {$user->name}",
                'description' => "Email: {$user->email}",
                'time' => $user->created_at->diffForHumans(),
                'color' => 'success'
            ]);
        }

        // Recent kos approvals
        $recentKos = Kos::where('status', 'approved')->latest()->limit(3)->get();
        foreach ($recentKos as $kos) {
            $activities->push([
                'type' => 'kos_approval',
                'icon' => 'bi-check-circle',
                'title' => "Kos disetujui: {$kos->nama}",
                'description' => "Pemilik: {$kos->pemilik->name}",
                'time' => $kos->updated_at->diffForHumans(),
                'color' => 'primary'
            ]);
        }

        // Recent payments
        $recentPayments = Pembayaran::with(['penghuni.user'])->latest()->limit(3)->get();
        foreach ($recentPayments as $payment) {
            $activities->push([
                'type' => 'payment',
                'icon' => 'bi-cash',
                'title' => "Pembayaran: Rp " . number_format($payment->jumlah, 0, ',', '.'),
                'description' => "Oleh: " . (isset($payment->penghuni->user->name) ? $payment->penghuni->user->name : 'N/A'),
                'time' => $payment->created_at->diffForHumans(),
                'color' => 'warning'
            ]);
        }

        return $activities->sortByDesc(function ($activity) {
            return Carbon::parse($activity['time']);
        })->take(10);
    }

    private function calculateConversionRate()
    {
        $totalRequests = RentalRequest::count();
        if ($totalRequests == 0) return 0;

        $approvedRequests = RentalRequest::where('status', 'approved')->count();
        return round(($approvedRequests / $totalRequests) * 100, 1);
    }

    private function getDateRange(Carbon $start, Carbon $end)
    {
        $dates = [];
        $current = $start->copy();

        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }

        return $dates;
    }

    private function fillMissingDates($data, $dateRange)
    {
        $filled = [];
        foreach ($dateRange as $date) {
            $filled[$date] = isset($data[$date]) ? $data[$date] : 0;
        }
        return $filled;
    }
}