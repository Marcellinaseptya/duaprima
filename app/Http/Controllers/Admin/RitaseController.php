<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripPulang;
use App\Models\Sopir;

class RitaseController extends Controller
{
    public function index(Request $request)
    {
        $query = TripPulang::with(['jadwal.sopir.user', 'jadwal.mastertruk', 'jadwal.klien']);

        // Filter berdasarkan tanggal pulang
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
        $sopirs = Sopir::with('user')->get();

        // Format angka untuk ditampilkan
        foreach ($trips as $trip) {
            $trip->muatan_netto_display = $trip->muatan_netto ? number_format($trip->muatan_netto, 0, ',', '.') : '0';
            $trip->ritase_display = $trip->ritase ? number_format($trip->ritase, 0, ',', '.') : '0';
        }

        return view('admin.ritase.index', compact('trips', 'sopirs'));
    }
}
