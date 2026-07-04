<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalOperasional;

class CetakJadwalController extends Controller
{
    public function cetak(Request $request)
    {
        $query = JadwalOperasional::query();

        if ($request->has('tanggal') && $request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $jadwals = $query->get();

        return view('manajer.jadwal.cetak', compact('jadwals'));
    }
}