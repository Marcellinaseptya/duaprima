<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;

class AdminJadwalOperasionalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalOperasional::with(['sopir', 'truk'])
        ->latest()
        ->paginate(10); // <- ini penting
    
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