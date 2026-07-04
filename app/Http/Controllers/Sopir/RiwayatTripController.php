<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalOperasional;

class RiwayatTripController extends Controller
{
    public function index()
    {
        $sopirId = Auth::user()->sopir->id;

        // Ambil semua jadwal sopir
        $jadwals = JadwalOperasional::with(['truk','klien'])
            ->where('sopir_id', $sopirId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('sopir.riwayat-trip.index', compact('jadwals'));
    }
}
