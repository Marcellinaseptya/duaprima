<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotaPengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanNotaPengeluaranController extends Controller
{
    // Tampilkan semua nota sopir
    public function index()
    {
        $sopirId = Auth::user()->sopir->id ?? null;

        if (!$sopirId) {
            return redirect()->back()->with('error', 'Data sopir tidak ditemukan.');
        }

        $notas = NotaPengeluaran::where('sopir_id', $sopirId)->latest()->get();

        return view('sopir.nota-pengeluaran.index', compact('notas'));
    }

    // Form tambah nota
    public function create()
    {
        $sopirId = Auth::user()->sopir->id ?? null;

        if (!$sopirId) {
            return redirect()->back()->with('error', 'Data sopir tidak ditemukan.');
        }

        $notas = NotaPengeluaran::where('sopir_id', $sopirId)->latest()->get();

        return view('sopir.nota-pengeluaran.create', compact('notas'));
    }

    // Simpan nota baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis'      => 'required|in:hauling,bbm,perbaikan,lainnya',
            'file_nota'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $sopir = Auth::user()->sopir;
        if (!$sopir) {
            return back()->with('error', 'Data sopir tidak ditemukan.');
        }

        // Upload file ke storage/app/public/nota-pengeluaran
        $filePath = $request->file('file_nota')->store('nota-pengeluaran', 'public');

        NotaPengeluaran::create([
            'sopir_id'   => $sopir->id,
            'jenis'      => $request->jenis,
            'file_nota'  => $filePath,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('sopir.nota-pengeluaran.index')->with('success', 'Nota pengeluaran berhasil diunggah.');
    }

    // Form edit nota
    public function edit($id)
    {
        $nota = NotaPengeluaran::findOrFail($id);

        $sopirId = Auth::user()->sopir->id ?? null;
        if ($nota->sopir_id !== $sopirId) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return view('sopir.nota-pengeluaran.edit', compact('nota'));
    }

    // Update nota
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis'      => 'required|in:hauling,bbm,perbaikan,lainnya',
            'file_nota'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $nota = NotaPengeluaran::findOrFail($id);
        
        $sopirId = Auth::user()->sopir->id ?? null;
        if ($nota->sopir_id !== $sopirId) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $data = [
            'jenis'      => $request->jenis,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('file_nota')) {
            if ($nota->file_nota) {
                Storage::disk('public')->delete($nota->file_nota);
            }
            $data['file_nota'] = $request->file('file_nota')->store('nota-pengeluaran', 'public');
        }

        $nota->update($data);

        return redirect()->route('sopir.nota-pengeluaran.index')->with('success', 'Nota pengeluaran berhasil diupdate.');
    }

    // Hapus nota
    public function destroy($id)
    {
        $nota = NotaPengeluaran::findOrFail($id);

        // Hapus file fisik
        Storage::disk('public')->delete($nota->file_nota);

        $nota->delete();

        return redirect()->route('sopir.nota-pengeluaran.index')->with('success', 'Nota berhasil dihapus.');
    }
}
