<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalOperasional;

class JadwalSopirController extends Controller
{
    // 🔹 Tampilkan jadwal berangkat
    public function tripBerangkatIndex()
    {
        $sopirId = Auth::user()->sopir->id;

        $jadwals = JadwalOperasional::where('sopir_id', $sopirId)
            ->whereIn('status', ['Siap Berangkat', 'Berangkat'])
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('sopir.trip-berangkat.index', compact('jadwals'));
    }

    // 🔹 Mulai perjalanan
    public function mulai($id)
    {
        $jadwal = JadwalOperasional::where('id', $id)
            ->where('sopir_id', Auth::user()->sopir->id)
            ->firstOrFail();

        $jadwal->update([
            'status' => 'Berangkat',
            'waktu_mulai' => now(),
        ]);

        if ($jadwal->tripBerangkat) {
            $jadwal->tripBerangkat->update([
                'waktu_mulai' => now(),
            ]);
        } else {
            // Buat TripBerangkat baru jika Admin yang buat jadwal
            \App\Models\TripBerangkat::create([
                'jadwal_id'         => $jadwal->id,
                'sopir_id'          => $jadwal->sopir_id,
                'uang_jalan'        => 0,
                'uang_makan'        => 0,
                'tanggal_berangkat' => $jadwal->tanggal ?? now()->toDateString(),
                'lokasi_berangkat'  => $jadwal->lokasi_berangkat ?? '-',
                'km_awal'           => 0,
                'waktu_mulai'       => now(),
                'catatan'           => $jadwal->catatan,
            ]);
        }

        return redirect()->back()->with('success', 'Perjalanan dimulai.');
    }

    // 🔹 Selesaikan perjalanan → pindah ke daftar trip pulang
    public function selesai($id)
    {
        $jadwal = JadwalOperasional::where('id', $id)
            ->where('sopir_id', Auth::user()->sopir->id)
            ->firstOrFail();

        $jadwal->update([
            'status' => 'Selesai',
            'waktu_selesai' => now(),
        ]);

        return redirect()->route('sopir.trip-pulang.index')->with('success', 'Perjalanan selesai. Silakan lengkapi data trip pulang.');
    }

    // 🔹 Batal perjalanan
    public function batal(Request $request, $id)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:255',
        ]);

        $jadwal = JadwalOperasional::where('id', $id)
            ->where('sopir_id', Auth::user()->sopir->id)
            ->firstOrFail();

        $jadwal->update([
            'status' => 'Dibatalkan oleh Sopir',
            'alasan_batal' => $request->alasan_batal,
        ]);

        return redirect()->back()->with('success', 'Perjalanan dibatalkan.');
    }
}