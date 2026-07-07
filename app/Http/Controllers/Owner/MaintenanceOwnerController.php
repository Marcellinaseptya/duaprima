<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use Carbon\Carbon;

class MaintenanceOwnerController extends Controller
{
    public function index(Request $request)
    {
        // Filter bulan & tahun dari request (default: bulan ini)
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Ambil data maintenance sesuai bulan & tahun
        $maintenances = Maintenance::with('mastertruk')
            ->whereMonth('tanggal_perbaikan', $bulan)
            ->whereYear('tanggal_perbaikan', $tahun)
            ->latest()
            ->get();

        // Total biaya maintenance bulan ini
        $totalBiayaMaintenance = $maintenances->sum('biaya_servis');

        return view('owner.maintenance.index', compact(
            'maintenances',
            'bulan',
            'tahun',
            'totalBiayaMaintenance'
        ));
    }
}
