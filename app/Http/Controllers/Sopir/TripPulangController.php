<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\JadwalOperasional;
use App\Models\Ritase;
use App\Models\Transaksi;

class TripPulangController extends Controller
{
    /**
     * Daftar trip pulang & selesai milik sopir login
     */
    public function index()
    {
        $sopirId = Auth::user()->sopir->id;

        $tripPulang = JadwalOperasional::with(['sopir.user', 'masterTruk'])
            ->where('sopir_id', $sopirId)
            ->whereIn('status', ['Berangkat', 'Pulang', 'Selesai'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('sopir.trip-pulang.index', compact('tripPulang'));
    }

    /**
     * Tampilkan form pengisian trip pulang
     */
    public function form($id)
    {
        $jadwal = JadwalOperasional::with(['sopir.user', 'masterTruk'])->findOrFail($id);

        // Kalau status bukan "Berangkat" atau "Pulang", redirect
        if (!in_array($jadwal->status, ['Berangkat', 'Pulang'])) {
            return redirect()->route('sopir.trip-pulang.index')
                ->with('error', 'Trip ini sudah diselesaikan atau belum masuk status yang tepat.');
        }

        return view('sopir.trip-pulang.form', compact('jadwal'));
    }

    /**
     * Simpan data form trip pulang
     */
    public function store(Request $request, $id)
    {
        $jadwal = JadwalOperasional::findOrFail($id);

        if (!in_array($jadwal->status, ['Berangkat', 'Pulang'])) {
            return redirect()->route('sopir.trip-pulang.index')
                ->with('error', 'Trip ini tidak bisa diisi lagi.');
        }

        // Validasi input
        $request->validate([
            'muatan_netto' => 'required|numeric|min:0',
            'ritase' => 'required|numeric|min:1',
            'uang_jalan' => 'required|numeric|min:0',
            'uang_makan' => 'required|numeric|min:0',
            'biaya_bbm' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'nota_bbm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload nota BBM
        $notaPath = $jadwal->nota_bbm;
        if ($request->hasFile('nota_bbm')) {
            // hapus file lama kalau ada
            if ($notaPath && Storage::disk('public')->exists($notaPath)) {
                Storage::disk('public')->delete($notaPath);
            }
            $notaPath = $request->file('nota_bbm')->store('nota_bbm', 'public');
        }

        // Update jadwal (status jadi "Selesai")
        $jadwal->update([
            'netto' => $request->muatan_netto,
            'rit_ke' => $request->ritase,
            'uang_jalan' => $request->uang_jalan,
            'catatan' => $request->catatan,
            'status' => 'Selesai',
            'waktu_selesai' => now(),
        ]);

        if ($jadwal->tripBerangkat) {
            $jadwal->tripBerangkat->update([
                'uang_jalan' => $request->uang_jalan,
                'uang_makan' => $request->uang_makan,
            ]);
        }

        $gaji = \App\Models\TripPulang::hitungGaji(
            $request->muatan_netto,
            $request->ritase,
            0, // tarif per rit default jika tidak ada
            $request->uang_makan,
            $request->biaya_bbm ?? 0
        );

        \App\Models\TripPulang::updateOrCreate(
            ['jadwal_id' => $jadwal->id],
            array_merge([
                'muatan_netto' => $request->muatan_netto,
                'ritase' => $request->ritase,
                'biaya_bbm' => $request->biaya_bbm ?? 0,
                'tarif_per_rit' => 0,
                'catatan' => $request->catatan,
                'nota_bbm' => $notaPath,
                'waktu_selesai' => now(),
            ], $gaji)
        );

        // Simpan ritase (jika trip berangkat ada)
        if ($jadwal->tripBerangkat) {
            Ritase::create([
                'trip_berangkat_id' => $jadwal->tripBerangkat->id,
                'sopir_id' => Auth::user()->sopir->id,
                'tanggal' => now()->format('Y-m-d'),
                'muatan_netto' => $request->muatan_netto,
                'tarif' => 0,
                'biaya_bbm' => $request->biaya_bbm ?? 0,
                'gaji_sopir' => 0,
                'keuntungan_cv' => 0,
                'bonus' => 0,
            ]);
        }

        // Simpan transaksi (pengeluaran)
        Transaksi::create([
            'tanggal' => now(),
            'jenis' => 'pengeluaran',
            'kategori' => 'trip pulang',
            'nominal' => $request->uang_jalan + $request->uang_makan + ($request->biaya_bbm ?? 0),
            'keterangan' => "Trip pulang {$jadwal->masterTruk->plat_nomor} - Sopir {$jadwal->sopir->user->nama}",
            'sumber' => 'trip pulang',
        ]);

        return redirect()->route('sopir.trip-pulang.index')
            ->with('success', 'Form trip pulang berhasil disimpan, status trip selesai.');
    }
}