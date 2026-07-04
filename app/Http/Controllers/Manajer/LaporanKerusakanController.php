<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $laporanKerusakan = LaporanKerusakan::with(['sopir', 'mastertruk'])
            ->orderByDesc('tanggal')
            ->get();

        return view('manajer.laporan-kerusakan.index', compact('laporanKerusakan'));
    }

    public function show($id)
    {
        $laporan = LaporanKerusakan::with(['sopir', 'mastertruk'])->findOrFail($id);

        return view('manajer.laporan-kerusakan.show', compact('laporan'));
    }
}
