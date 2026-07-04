<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;

class KerusakanOwnerController extends Controller
{
    public function index()
    {
        // Ambil semua laporan kerusakan yang sudah diproses
        $kerusakan = LaporanKerusakan::whereIn('status', ['Disetujui Manajer', 'Ditolak'])->latest()->get();

        return view('owner.kerusakan.index', compact('kerusakan'));
    }
}
