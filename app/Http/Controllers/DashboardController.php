<?php

namespace App\Http\Controllers;

use Modules\Donasis\Models\Donasis;
use Modules\Pengajuan\Models\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $baseQuery = Pengajuan::query();
        if ($user->role !== 'admin') {
            $baseQuery->where('user_id', $user->id);
        }

        $data = [
            'jumlahDonasis' => Donasis::count(),
            'jumlahPengajuan' => (clone $baseQuery)->count(),
            'jumlahMenunggu' => (clone $baseQuery)->where('status', 'Menunggu')->count(),
            'totalPorsiDisetujui' => (clone $baseQuery)->where('status', 'Disetujui')->sum('jumlah_porsi'),
            'PengajuanTerbaru' => (clone $baseQuery)->with(['Donasis', 'user'])->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }

    public function profile()
    {
        return view('profile');
    }
}
