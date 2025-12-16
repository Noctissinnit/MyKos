<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kos;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
         $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get system statistics
        $stats = [
            'total_users' => User::count(),
            'total_kos' => Kos::where('status', 'approved')->count(),
            'total_payments' => \App\Models\Pembayaran::where('status', 'lunas')->count(),
            'total_revenue' => \App\Models\Pembayaran::where('status', 'lunas')->sum('jumlah'),
        ];

        // Get recent activities (mock data for now - can be enhanced with real activity logging)
        $recentActivities = collect([
            [
                'type' => 'success',
                'icon' => 'bi-check-circle',
                'title' => 'Kos baru disetujui: Kos Mawar',
                'time' => '2 jam yang lalu'
            ],
            [
                'type' => 'info',
                'icon' => 'bi-person-plus',
                'title' => 'User baru terdaftar: john@example.com',
                'time' => '4 jam yang lalu'
            ],
            [
                'type' => 'warning',
                'icon' => 'bi-exclamation-triangle',
                'title' => 'Pembayaran pending: Rp 500.000',
                'time' => '6 jam yang lalu'
            ],
            [
                'type' => 'success',
                'icon' => 'bi-cash',
                'title' => 'Pembayaran lunas: Rp 750.000',
                'time' => '1 hari yang lalu'
            ],
        ]);

        return view('admin.dashboard', compact('stats', 'recentActivities'));
    }

    public function banUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Prevent admin from banning themselves
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat memban akun sendiri.');
        }
        $user->banned = true;
        $user->save();

        return redirect()->back()->with('success', 'User telah dibanned.');
    }

    public function unbanUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Prevent admin from unbanning themselves accidentally (no-op)
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Operasi tidak diperbolehkan.');
        }
        $user->banned = false;
        $user->save();

        return redirect()->back()->with('success', 'User telah diunban.');
    }

    public function approveKos(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);
        $kos->status = 'approved';
        $kos->save();

        return redirect()->back()->with('success', 'Pengajuan kos disetujui.');
    }

    public function rejectKos(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);
        $kos->status = 'rejected';
        $kos->save();

        return redirect()->back()->with('success', 'Pengajuan kos ditolak.');
    }

    public function kosApplications()
    {
        $pending = Kos::where('status', 'pending')->with('pemilik')->get();

        return view('admin.kos_applications', ['kosList' => $pending]);
    }

    public function usersList()
    {
        $users = User::all();

        return view('admin.users', ['users' => $users]);
    }

    /**
     * Admin revenue report: sum of payments (lunas) per pemilik
     */
    public function revenueReport(Request $request)
    {
        // optional date filters (YYYY-MM-DD)
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = DB::table('pembayarans')
            ->join('penghunis', 'pembayarans.penghuni_id', '=', 'penghunis.id')
            ->join('kamars', 'penghunis.kamar_id', '=', 'kamars.id')
            ->join('kos', 'kamars.kos_id', '=', 'kos.id')
            ->join('users', 'kos.user_id', '=', 'users.id')
            ->where('pembayarans.status', 'lunas');

        if ($start && $end) {
            $query->whereBetween('pembayarans.tanggal_bayar', [$start, $end]);
        } elseif ($start) {
            $query->where('pembayarans.tanggal_bayar', '>=', $start);
        } elseif ($end) {
            $query->where('pembayarans.tanggal_bayar', '<=', $end);
        }

        $rows = $query->select('users.id as pemilik_id', 'users.name as pemilik_name', 'users.email as pemilik_email', DB::raw('SUM(pembayarans.jumlah) as total_revenue'), DB::raw('COUNT(pembayarans.id) as total_payments'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_revenue')
            ->get();

        return view('admin.revenue', ['rows' => $rows, 'start' => $start, 'end' => $end]);
    }
}
