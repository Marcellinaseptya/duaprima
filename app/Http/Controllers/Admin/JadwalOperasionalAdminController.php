<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwaloperasional;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class JadwalOperasionalAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwaloperasional::with('sopir.user')->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $jadwals = $query->get();

        return view('admin.jadwal-operasional.index', compact('jadwals'));
    }

    public function export(Request $request)
    {
        $query = Jadwaloperasional::with('sopir.user')->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $jadwals = $query->get();

        $pdf = PDF::loadView('admin.jadwal-operasional.export', compact('jadwals'));
        return $pdf->stream('jadwal-operasional.pdf');
    }
}