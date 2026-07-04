<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TripBerangkatController extends Controller
{
    // INDEX → tampilkan semua trip berangkat beserta data yang diisi sopir
    public function index(Request $request)
    {
        $query = JadwalOperasional::with(['sopir.user','mastertruk','klien','tripBerangkat'])
                    ->where('status','!=','Siap Berangkat')
                    ->orderBy('tanggal','desc');

        // filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        $jadwals = $query->paginate(10)->withQueryString();

        // Ambil nilai uang jalan, uang makan, dan bbm dari tripBerangkat
        foreach ($jadwals as $jadwal) {
            $jadwal->uang_jalan_display = $jadwal->tripBerangkat->uang_jalan ?? 0;
            $jadwal->uang_makan_display = $jadwal->tripBerangkat->uang_makan ?? 0;
            $jadwal->harga_bbm_display = $jadwal->tripBerangkat->harga_bbm ?? 0;
        }

        return view('admin.tripberangkat.index', compact('jadwals'));
    }

    // EXPORT PDF
    public function export(Request $request)
    {
        $query = JadwalOperasional::with(['sopir.user','mastertruk','klien','tripBerangkat'])
                    ->where('status','!=','Siap Berangkat')
                    ->orderBy('tanggal','desc');

        // filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        $jadwals = $query->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->uang_jalan_display = $jadwal->tripBerangkat->uang_jalan ?? 0;
            $jadwal->uang_makan_display = $jadwal->tripBerangkat->uang_makan ?? 0;
            $jadwal->harga_bbm_display = $jadwal->tripBerangkat->harga_bbm ?? 0;
        }

        $pdf = Pdf::loadView('admin.tripberangkat.export', compact('jadwals'))
                  ->setPaper('a4','landscape');

        return $pdf->download('riwayat_trip_berangkat.pdf');
    }
}
