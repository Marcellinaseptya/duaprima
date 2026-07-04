<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use App\Models\MasterTruk;
use Illuminate\Http\Request;
use PDF;

class JadwalOperasionalController extends Controller
{
    // Menampilkan semua jadwal operasional
    public function index(Request $request)
    {
        $query = JadwalOperasional::with(['sopir', 'mastertruk', 'klien']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $jadwals = $query->latest()->get();

        return view('admin.jadwal-operasional.index', compact('jadwals'));
    }

    // Export PDF
    public function export(Request $request)
    {
        $query = JadwalOperasional::with(['sopir', 'mastertruk', 'klien']);

        // Filter tanggal (opsional)
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $jadwals = $query->get();

        $pdf = PDF::loadView('admin.jadwal-operasional.export', compact('jadwals'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-jadwal-operasional.pdf');
    }
}