<?php

namespace App\Http\Controllers\Manajer;

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

        return view('manajer.trippulang.index', compact('trips', 'sopirs'));
    }

    // Setujui Biaya Lapangan
    public function approve(TripPulang $tripPulang)
    {
        $tripPulang->update(['status_approval' => 'Disetujui']);
        return back()->with('success', 'Biaya lapangan berhasil disetujui.');
    }

    // Tolak Biaya Lapangan
    public function reject(TripPulang $tripPulang)
    {
        $tripPulang->update(['status_approval' => 'Ditolak']);
        return back()->with('success', 'Biaya lapangan ditolak.');
    }

    // Set Tarif per Rit
    public function updateTarif(Request $request, TripPulang $tripPulang)
    {
        // Bersihkan format rupiah
        if ($request->has('tarif_per_rit')) {
            $request->merge([
                'tarif_per_rit' => str_replace('.', '', $request->tarif_per_rit)
            ]);
        }

        $request->validate([
            'tarif_per_rit' => 'required|numeric|min:0',
        ]);

        $uang_makan = 0;
        if ($tripPulang->jadwal && $tripPulang->jadwal->tripBerangkat) {
            $uang_makan = $tripPulang->jadwal->tripBerangkat->uang_makan ?? 0;
        }

        $gaji = \App\Models\TripPulang::hitungGaji(
            $tripPulang->muatan_netto,
            $tripPulang->ritase,
            $request->tarif_per_rit,
            $uang_makan,
            $tripPulang->biaya_bbm
        );

        $tripPulang->update(array_merge([
            'tarif_per_rit' => $request->tarif_per_rit,
        ], $gaji));

        // Update ritase if exists
        if ($tripPulang->jadwal && $tripPulang->jadwal->tripBerangkat) {
            $ritase = \App\Models\Ritase::where('trip_berangkat_id', $tripPulang->jadwal->tripBerangkat->id)->first();
            if ($ritase) {
                $ritase->update([
                    'tarif' => $request->tarif_per_rit,
                    'gaji_sopir' => $gaji['total_gaji_sopir'],
                    'keuntungan_cv' => $gaji['total_cv'],
                    'bonus' => $gaji['bonus'],
                ]);
            }
        }

        return back()->with('success', 'Tarif berhasil diupdate dan gaji dikalkulasi ulang.');
    }
}
