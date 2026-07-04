<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalOperasional;
use App\Models\Sopir;
use App\Models\Truk;

class JadwalOperasionalManajerController extends Controller
{
    public function index()
    {
        $jadwal = JadwalOperasional::with(['sopir', 'truk'])->latest()->get();
        return view('manajer.jadwal_operasional.index', compact('jadwal'));
    }

    public function create()
    {
        $sopirs = Sopir::all();
        $truks = Truk::all();
        return view('manajer.jadwal_operasional.create', compact('sopirs', 'truks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'truk_id' => 'required|exists:truks,id',
            'tanggal' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JadwalOperasional::create([
            'sopir_id' => $request->sopir_id,
            'truk_id' => $request->truk_id,
            'tanggal' => $request->tanggal,
            'tujuan' => $request->tujuan,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu Persetujuan Owner',
        ]);

        return redirect()->route('manajer.jadwal-operasional.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalOperasional::findOrFail($id);
        $sopirs = Sopir::all();
        $truks = Truk::all();
        return view('manajer.jadwal_operasional.edit', compact('jadwal', 'sopirs', 'truks'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalOperasional::findOrFail($id);

        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'truk_id' => 'required|exists:truks,id',
            'tanggal' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal->update([
            'sopir_id' => $request->sopir_id,
            'truk_id' => $request->truk_id,
            'tanggal' => $request->tanggal,
            'tujuan' => $request->tujuan,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu Persetujuan Owner',
        ]);

        return redirect()->route('manajer.jadwal-operasional.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        JadwalOperasional::findOrFail($id)->delete();
        return redirect()->route('manajer.jadwal-operasional.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
