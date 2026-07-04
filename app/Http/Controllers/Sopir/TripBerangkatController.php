<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalOperasional;
use App\Models\Ritase;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TripBerangkatController extends Controller
{
    // INDEX → daftar trip siap berangkat
    public function index()
    {
        $sopir = Auth::user()->sopir;
        if (!$sopir) return redirect()->back()->with('error', 'Data sopir tidak ditemukan.');
        $sopirId = $sopir->id;

        $jadwals = JadwalOperasional::with(['mastertruk', 'klien'])
            ->where('sopir_id', $sopirId)
            ->where('status', 'Siap Berangkat')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('sopir.trip-berangkat.index', compact('jadwals'));
    }

    // CREATE → form isi data sebelum mulai trip
    public function create($id)
    {
        $jadwal = JadwalOperasional::with(['mastertruk','klien'])->findOrFail($id);

        if ($jadwal->sopir_id !== Auth::user()->sopir->id) {
            return redirect()->route('sopir.trip-berangkat.index')
                             ->with('error', 'Anda tidak bisa memulai trip ini.');
        }

        return view('sopir.trip-berangkat.create', compact('jadwal'));
    }

    // STORE → simpan data form & update status jadi BERANGKAT
    public function store(Request $request, $id)
    {
        $request->validate([
            'lokasi_berangkat' => 'required|string|max:255',
            'uang_jalan'       => 'nullable|numeric',
            'uang_makan'       => 'nullable|numeric',
            'catatan'          => 'nullable|string',
            'nota_perjalanan'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $jadwal = JadwalOperasional::findOrFail($id);

        if ($jadwal->sopir_id !== Auth::user()->sopir->id) {
            return redirect()->route('sopir.trip-berangkat.index')
                             ->with('error', 'Anda tidak bisa memulai trip ini.');
        }

        $filename = null;
        if ($request->hasFile('nota_perjalanan')) {
            $file = $request->file('nota_perjalanan');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/nota_perjalanan'), $filename);
        }

        // simpan data ke jadwal_operasional (tanpa uang_makan)
        $jadwal->update([
            'lokasi_berangkat' => $request->lokasi_berangkat,
            'uang_jalan'       => $request->uang_jalan,
            'catatan'          => $request->catatan,
            'waktu_mulai'      => Carbon::now(),
            'status'           => 'Berangkat',
            'nota_perjalanan'  => $filename ?? $jadwal->nota_perjalanan
        ]);

        // simpan record ke tabel trip_berangkat
        \App\Models\TripBerangkat::updateOrCreate(
            ['jadwal_id' => $jadwal->id],
            [
                'sopir_id' => $jadwal->sopir_id,
                'uang_jalan' => $request->uang_jalan ?? 0,
                'uang_makan' => $request->uang_makan ?? 0,
                'tanggal_berangkat' => Carbon::now()->format('Y-m-d'),
                'lokasi_berangkat' => $request->lokasi_berangkat,
                'waktu_mulai' => Carbon::now(),
                'nota_perjalanan' => $filename,
                'catatan' => $request->catatan,
            ]
        );

        return redirect()->route('sopir.trip-berangkat.index')
                         ->with('success', 'Trip berhasil dimulai!');
    }
}
