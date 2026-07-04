<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use App\Models\Maintenance;
use App\Models\Mastertruk;
use App\Models\JadwalOperasional;
use App\Models\TripBerangkat;

class DashboardManajerController extends Controller
{
    public function index()
    {
        // Total hitungan
        $totalLaporan = LaporanKerusakan::count();
        $totalPerbaikan = Maintenance::count();
        $totalJadwal = JadwalOperasional::count();

        // Histori perjalanan terakhir 5
        $historiPerjalanan = TripBerangkat::with('sopir')
            ->orderBy('tanggal_berangkat', 'desc') // pastikan kolom tanggal ada di DB
            ->take(5)
            ->get();

        // Histori perbaikan terakhir 5
        $historiPerbaikan = Maintenance::with('mastertruk')
            ->orderBy('tanggal_perbaikan', 'desc')
            ->take(5)
            ->get();

        // Histori laporan kerusakan terakhir 5
        $laporanKerusakan = LaporanKerusakan::with('sopir')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Jadwal operasional terakhir 5
        $jadwalOperasional = JadwalOperasional::with(['sopir', 'mastertruk'])
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        return view('manajer.dashboard', compact(
            'totalLaporan',
            'totalPerbaikan',
            'totalJadwal',
            'historiPerjalanan',
            'historiPerbaikan',
            'laporanKerusakan',
            'jadwalOperasional'
        ));
    }
}