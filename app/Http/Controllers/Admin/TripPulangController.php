<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripPulang;
use App\Models\Sopir;
use Illuminate\Http\Request;

class TripPulangController extends Controller
{
    // Tampilkan daftar trip pulang
    public function index(Request $request)
    {
        $query = TripPulang::with(['jadwal.mastertruk', 'jadwal.sopir']);

        // Filter berdasarkan tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('waktu_selesai', [$request->from, $request->to]);
        }

        // Filter berdasarkan sopir
        if ($request->filled('sopir_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('sopir_id', $request->sopir_id);
            });
        }

        $trips = $query->latest()->paginate(10);
        $sopirs = Sopir::all();

        return view('admin.trippulang.index', compact('trips', 'sopirs'));
    }
}
