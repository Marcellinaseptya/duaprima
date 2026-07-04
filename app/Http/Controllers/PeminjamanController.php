<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class PeminjamanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with('sopir');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('sumber')) {
            $query->where('sumber', 'like', '%' . $request->sumber . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_pelunasan', $request->status);
        }

        $peminjaman = $query->get();
        return view('peminjaman', compact('peminjaman'));
    }

    public function exportPdf(Request $request)
{
    $query = Peminjaman::with('sopir');

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    if ($request->filled('sumber')) {
        $query->where('sumber', 'like', '%' . $request->sumber . '%');
    }

    if ($request->filled('status')) {
        $query->where('status_pelunasan', $request->status);
    }

    $peminjaman = $query->get();
    $totalPinjaman = $peminjaman->sum('nominal');
    $totalTerbayar = $peminjaman->sum('terbayar');
    $tanggalCetak = Carbon::now()->translatedFormat('d F Y');

    $pdf = Pdf::loadView('peminjaman.export', compact(
        'peminjaman',
        'totalPinjaman',
        'totalTerbayar',
        'tanggalCetak'
    ))->setPaper('a4', 'portrait'); // <- perhatikan tutup kurung di sini

    return $pdf->stream('laporan_peminjaman.pdf');
}

    

    public function create()
    {
        $sopirs = Sopir::all();
        return view('peminjaman.create', compact('sopirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'terbayar' => 'required|numeric|min:0',
            'status_pelunasan' => 'required|in:LUNAS,BELUM LUNAS',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Peminjaman::create($request->all());

        return redirect()->route('peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $sopirs = Sopir::all();
        return view('peminjaman.edit', compact('peminjaman', 'sopirs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'terbayar' => 'required|numeric|min:0',
            'status_pelunasan' => 'required|in:LUNAS,BELUM LUNAS',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());

        return redirect()->route('peminjaman')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
