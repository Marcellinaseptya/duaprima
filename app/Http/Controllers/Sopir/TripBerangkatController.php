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

    // CREATE → form isi data sebelum mulai trip (Mandiri)
    public function create()
    {
        $sopir = Auth::user()->sopir;
        if (!$sopir) return redirect()->back()->with('error', 'Data sopir tidak ditemukan.');

        $kliens = \App\Models\Klien::where('status', 'Aktif')->get();

        return view('sopir.trip-berangkat.create', compact('kliens'));
    }

    // STORE → simpan data form & buat JadwalOperasional otomatis
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_berangkat' => 'required|date',
            'lokasi_berangkat' => 'required|string|max:255',
            'km_awal'          => 'required|numeric',
            'klien_id'         => 'nullable|exists:klien,id',
            'catatan'          => 'nullable|string',
        ]);

        $sopir = Auth::user()->sopir;

        if (!$sopir || !$sopir->mastertruk_id) {
            return redirect()->route('sopir.trip-berangkat.index')
                             ->with('error', 'Anda belum ditugaskan ke truk tertentu.');
        }

        // 1. Buat Jadwal Operasional Otomatis
        $jadwal = JadwalOperasional::create([
            'tanggal'          => $request->tanggal_berangkat,
            'sopir_id'         => $sopir->id,
            'mastertruk_id'    => $sopir->mastertruk_id,
            'klien_id'         => $request->klien_id, // Disimpan sesuai input dropdown
            'lokasi_berangkat' => $request->lokasi_berangkat,
            'catatan'          => $request->catatan,
            'status'           => 'Siap Berangkat',
        ]);

        // 2. Buat record Trip Berangkat
        \App\Models\TripBerangkat::create([
            'jadwal_id'         => $jadwal->id,
            'sopir_id'          => $sopir->id,
            'uang_jalan'        => 0, // default jika sopir bikin sendiri
            'uang_makan'        => 0,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'lokasi_berangkat'  => $request->lokasi_berangkat,
            'km_awal'           => $request->km_awal,
            'waktu_mulai'       => Carbon::now(),
            'catatan'           => $request->catatan,
        ]);

        return redirect()->route('sopir.trip-berangkat.index')
                         ->with('success', 'Trip berhasil dimulai secara mandiri!');
    }
}
