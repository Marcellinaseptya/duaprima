<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\TripPulang;
use App\Models\Sopir;
use Illuminate\Http\Request;

class RitaseController extends Controller
{
    public function index(Request $request)
    {
        $query = TripPulang::with(['jadwal.mastertruk', 'jadwal.sopir']);

        // Filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('waktu_selesai', [$request->from, $request->to]);
        }

        // Filter sopir
        if ($request->filled('sopir_id')) {
            $query->whereHas('jadwal', function ($q) use ($request) {
                $q->where('sopir_id', $request->sopir_id);
            });
        }

        $ritases = $query->latest()->paginate(10);
        $sopirs = Sopir::all();

        return view('sopir.ritase.index', compact('ritases', 'sopirs'));
    }
}
