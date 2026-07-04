<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\LaporanNotaHauling;

class LaporanNotaHaulingController extends Controller
{
    public function index()
    {
        $sopirId = auth()->user()->sopir->id ?? null;
        if (!$sopirId) return redirect()->back()->with('error', 'Data sopir tidak ditemukan.');

        $notas = LaporanNotaHauling::where('sopir_id', $sopirId)->latest()->get();
        return view('sopir.laporan-nota-hauling.index', compact('notas'));
    }

    public function create()
    {
        return view('sopir.laporan-nota-hauling.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'file_nota' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tarif_per_rit' => 'required|integer',
            'jumlah_ritase' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $sopir = auth()->user()->sopir;

        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');

        $fileNota = $request->file('file_nota')->store('nota-hauling', 'public');
        $buktiTransfer = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

        LaporanNotaHauling::create([
            'sopir_id' => $sopir->id,
            'tanggal' => $tanggal,
            'file_nota' => $fileNota,
            'bukti_transfer' => $buktiTransfer,
            'tarif_per_rit' => $request->tarif_per_rit,
            'jumlah_ritase' => $request->jumlah_ritase,
            'keterangan' => $request->keterangan,
            'status' => 'MENUNGGU', // default status sopir input
        ]);

        return redirect()->route('sopir.laporan-nota-hauling.index')->with('success', 'Nota hauling berhasil diunggah.');
    }

    public function edit($id)
    {
        $laporan = LaporanNotaHauling::findOrFail($id);

        $sopirId = auth()->user()->sopir->id ?? null;
        if ($laporan->sopir_id !== $sopirId) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return view('sopir.laporan-nota-hauling.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'file_nota' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tarif_per_rit' => 'required|integer',
            'jumlah_ritase' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $nota = LaporanNotaHauling::findOrFail($id);
        $sopirId = auth()->user()->sopir->id ?? null;
        if ($nota->sopir_id !== $sopirId) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $data = [
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'tarif_per_rit' => $request->tarif_per_rit,
            'jumlah_ritase' => $request->jumlah_ritase,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('file_nota')) {
            if ($nota->file_nota) {
                Storage::disk('public')->delete($nota->file_nota);
            }
            $data['file_nota'] = $request->file('file_nota')->store('nota-hauling', 'public');
        }

        if ($request->hasFile('bukti_transfer')) {
            if ($nota->bukti_transfer) {
                Storage::disk('public')->delete($nota->bukti_transfer);
            }
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        $nota->update($data);

        return redirect()->route('sopir.laporan-nota-hauling.index')->with('success', 'Nota hauling berhasil diupdate.');
    }

    public function destroy($id)
    {
        $nota = LaporanNotaHauling::findOrFail($id);
        if ($nota->file_nota) {
            Storage::disk('public')->delete($nota->file_nota);
        }
        if ($nota->bukti_transfer) {
            Storage::disk('public')->delete($nota->bukti_transfer);
        }
        $nota->delete();

        return redirect()->route('sopir.laporan-nota-hauling.index')->with('success', 'Nota hauling berhasil dihapus.');
    }
}
