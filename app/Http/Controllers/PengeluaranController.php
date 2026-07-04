<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
    // INDEX + FILTER
    public function pengeluaran(Request $request)
    {
        $query = Pengeluaran::query();

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Filter sumber
        if ($request->filled('sumber')) {
            $query->where('sumber', 'like', '%' . $request->sumber . '%');
        }

        $pengeluarans = $query->orderBy('tanggal', 'desc')->get();

        return view('pengeluaran', compact('pengeluarans'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('pengeluaran.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Pengeluaran::create($request->all());

        return redirect()->route('pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    // EXPORT PDF
    public function export(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('sumber')) {
            $query->where('sumber', 'like', '%' . $request->sumber . '%');
        }

        $pengeluarans = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('pengeluaran.export', compact('pengeluarans'));
        return $pdf->stream('laporan_pengeluaran.pdf');
    }

    // EDIT
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($request->all());

        return redirect()->route('pengeluaran')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    public function exportPdf(Request $request)
{
    $query = Pengeluaran::query();

    if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
        $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
    }

    if ($request->filled('sumber')) {
        $query->where('sumber', 'like', '%' . $request->sumber . '%');
    }

    $pengeluarans = $query->orderBy('tanggal', 'asc')->get();

    $pdf = Pdf::loadView('pengeluaran.export', compact('pengeluarans'))->setPaper('a4', 'portrait');
    return $pdf->stream('laporan_pengeluaran.pdf');
}

}
