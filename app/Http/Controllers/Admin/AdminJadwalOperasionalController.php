<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;

class AdminJadwalOperasionalController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalOperasional::with(['sopir', 'truk', 'tripBerangkat', 'tripPulang']);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $jadwals = $query->latest()->paginate(10)->withQueryString();
    
        return view('admin.jadwal-operasional.index', compact('jadwals'));
    }

    public function export(Request $request)
    {
        $jadwals = JadwalOperasional::with(['sopir.user', 'truk']);

        if ($request->filled('tanggal')) {
            $jadwals->whereDate('created_at', $request->tanggal);
        }

        $pdf = \PDF::loadView('admin.jadwal-operasional.export', [
            'jadwals' => $jadwals->get()
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_jadwal_operasional.pdf');
    }
}