<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalOperasional;
use App\Models\Sopir;
use App\Models\MasterTruk;
use App\Models\Klien;

class JadwalOperasionalController extends Controller
{
    // Tampilkan semua jadwal
    public function index()
    {
        $jadwals = JadwalOperasional::with(['sopir.user', 'mastertruk', 'klien'])
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('manajer.jadwal.index', compact('jadwals'));
    }

    // Form tambah jadwal
    public function create()
    {
        $sopir = Sopir::with('user')->get();
        $mastertruk = MasterTruk::all();
        $kliens = Klien::all();

        return view('manajer.jadwal.create', compact('sopir', 'mastertruk', 'kliens'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sopir_id' => 'required|exists:sopir,id',
            'mastertruk_id' => 'required|exists:master_truk,id',
            'klien_id' => 'nullable|exists:klien,id',
            'tujuan' => 'required|string|max:255',
            'rute' => 'nullable|string|max:255',
            'bruto' => 'nullable|numeric',
            'tara' => 'nullable|numeric',
            'no_surat_jalan' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:255',
        ]);

        $bruto = $request->bruto !== null && $request->bruto !== '' ? (float) $request->bruto : 0;
        $tara = $request->tara !== null && $request->tara !== '' ? (float) $request->tara : 0;
        $netto = $bruto - $tara;

        JadwalOperasional::create([
            'tanggal' => $request->tanggal,
            'sopir_id' => $request->sopir_id,
            'mastertruk_id' => $request->mastertruk_id,
            'klien_id' => $request->klien_id ?: null,
            'tujuan' => $request->tujuan,
            'rute' => $request->rute ?: null,
            'bruto' => $request->bruto !== '' ? $request->bruto : null,
            'tara' => $request->tara !== '' ? $request->tara : null,
            'netto' => $netto,
            'no_surat_jalan' => $request->no_surat_jalan ?: null,
            'catatan' => $request->catatan ?: null,
            'status' => 'Siap Berangkat', // otomatis siap berangkat
        ]);

        return redirect()->route('manajer.jadwal.index')
                         ->with('success', 'Jadwal berhasil ditambahkan dan siap untuk trip berangkat sopir.');
    }

    // Form edit jadwal
    public function edit(JadwalOperasional $jadwal)
    {
        $sopir = Sopir::with('user')->get();
        $mastertruk = MasterTruk::all();
        $kliens = Klien::all();

        return view('manajer.jadwal.edit', compact('jadwal', 'sopir', 'mastertruk', 'kliens'));
    }

    // Update jadwal
    public function update(Request $request, JadwalOperasional $jadwal)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sopir_id' => 'required|exists:sopir,id',
            'mastertruk_id' => 'required|exists:master_truk,id',
            'klien_id' => 'nullable|exists:klien,id',
            'tujuan' => 'required|string|max:255',
            'rute' => 'nullable|string|max:255',
            'bruto' => 'nullable|numeric',
            'tara' => 'nullable|numeric',
            'no_surat_jalan' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:255',
            'status' => 'nullable|in:Menunggu,Siap Berangkat,Berangkat,Pulang,Selesai,Dibatalkan oleh Sopir',
            'alasan_batal' => 'nullable|string|max:255',
        ]);

        $bruto = $request->bruto !== null && $request->bruto !== '' ? (float) $request->bruto : 0;
        $tara = $request->tara !== null && $request->tara !== '' ? (float) $request->tara : 0;
        $netto = $bruto - $tara;

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'sopir_id' => $request->sopir_id,
            'mastertruk_id' => $request->mastertruk_id,
            'klien_id' => $request->klien_id ?: null,
            'tujuan' => $request->tujuan,
            'rute' => $request->rute ?: null,
            'bruto' => $request->bruto !== '' ? $request->bruto : null,
            'tara' => $request->tara !== '' ? $request->tara : null,
            'netto' => $netto,
            'no_surat_jalan' => $request->no_surat_jalan ?: null,
            'catatan' => $request->catatan ?: null,
            'status' => $request->status ?? $jadwal->status, // jangan override jika null
            'alasan_batal' => $request->alasan_batal,
        ]);

        return redirect()->route('manajer.jadwal.index')
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    // Hapus jadwal
    public function destroy(JadwalOperasional $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('manajer.jadwal.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}