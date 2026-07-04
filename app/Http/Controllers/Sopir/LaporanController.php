<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanController extends Controller
{
    // Menampilkan semua laporan milik sopir yang login
    
        public function index()
        {
            $sopirId = 1; // ganti sesuai sopir yang sedang digunakan
        
            $laporans = Laporan::where('sopir_id', $sopirId)->latest()->get();
            return view('sopir.laporan.index', compact('laporans'));
        }

    

    // Menampilkan form create laporan
    public function create()
    {
        return view('sopir.laporan.create');
    }

    // Menyimpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'plat_truk' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

         // Ganti ID ini sesuai sopir yang kamu mau simulasikan
    $sopirId = 1; // <- sementara pakai sopir id 1

    $namaSopir = \App\Models\Sopir::find($sopirId)?->nama ?? 'Sopir Tidak Diketahui';

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        Laporan::create([
            'sopir_id'   => $sopir->id,
            'tanggal'    => $request->tanggal,
            'nama_sopir' => $sopir->nama,
            'plat_truk'  => $request->plat_truk,
            'deskripsi'  => $request->deskripsi,
            'foto'       => $fotoPath,
        ]);

        return redirect()->route('sopir.laporan.index')->with('success', 'Laporan berhasil dikirim.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        $sopir = Auth::user()->sopir;

        if (!$sopir || $laporan->sopir_id !== $sopir->id) {
            abort(403);
        }

        return view('sopir.laporan.edit', compact('laporan'));
    }

    // Menyimpan update
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $sopir = Auth::user()->sopir;

        if (!$sopir || $laporan->sopir_id !== $sopir->id) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'plat_truk' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
            $laporan->foto = $fotoPath;
        }

        $laporan->update([
            'tanggal'    => $request->tanggal,
            'plat_truk'  => $request->plat_truk,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()->route('sopir.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    // Menghapus laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $sopir = Auth::user()->sopir;

        if (!$sopir || $laporan->sopir_id !== $sopir->id) {
            abort(403);
        }

        $laporan->delete();

        return redirect()->route('sopir.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}