<?php

namespace App\Http\Controllers;

use App\Models\Truk;
use App\Models\Sopir;
use App\Models\mastertruk;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan di atas
use Illuminate\Http\Request;

class TrukController extends Controller
{
    // INDEX + FILTER
    public function truk(Request $request)
    {
        $query = Truk::with(['mastertruk', 'sopir']);

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter sopir
        if ($request->filled('sopir_id')) {
            $query->where('sopir_id', $request->sopir_id);
        }

        // Filter perusahaan
        if ($request->filled('perusahaan')) {
            $query->where('perusahaan', 'like', '%' . $request->perusahaan . '%');
        }

        $truks = $query->get();

        $sopirs = Sopir::where('status', 'aktif')->get();
        $perusahaans = Truk::select('perusahaan')->distinct()->pluck('perusahaan');

        return view('truk', compact('truks', 'sopirs', 'perusahaans'));
    }

    // FORM TAMBAH
    public function create()
    {
        $mastertruks = mastertruk::all();
        $sopirs = Sopir::where('status', 'aktif')->get();
        return view('truk.create', compact('mastertruks', 'sopirs'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->merge([
            'tarif' => preg_replace('/[^0-9]/', '', $request->tarif),
            'bbm' => preg_replace('/[^0-9]/', '', $request->bbm),
            'netto' => preg_replace('/[^0-9]/', '', $request->netto),
        ]);

        $validated = $request->validate([
            'mastertruk_id' => 'required|exists:mastertruks,id',
            'sopir_id' => 'required|exists:sopirs,id',
            'tanggal' => 'required|date',
            'perusahaan' => 'required|string|max:255',
            'tarif' => 'required|numeric',
            'bbm' => 'required|numeric',
            'netto' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $keuntunganBersih = $validated['tarif'] - $validated['bbm'];
        $bonus = $validated['netto'] > 11500 ? 60000 : 0;
        $keuntunganSopir = $keuntunganBersih * 0.25 + $bonus;
        $keuntunganPerusahaan = $keuntunganBersih * 0.75;

        $keterangan = $validated['netto'] > 11500
            ? 'Sopir mendapat bonus Rp 60.000 karena muatan melebihi 11.500 Kg.'
            : 'Sopir tidak mendapat bonus karena muatan kurang dari atau sama dengan 11.500 Kg.';

        Truk::create([
            'mastertruk_id' => $validated['mastertruk_id'],
            'sopir_id' => $validated['sopir_id'],
            'tanggal' => $validated['tanggal'],
            'perusahaan' => $validated['perusahaan'],
            'tarif' => $validated['tarif'],
            'bbm' => $validated['bbm'],
            'netto' => $validated['netto'],
            'keuntungan_sopir' => $keuntunganSopir,
            'keuntungan_perusahaan' => $keuntunganPerusahaan,
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('truk')->with('success', 'Data truk berhasil disimpan.');
    }

    // FORM EDIT
    public function edit($id)
    {
        $truk = Truk::findOrFail($id);
        $mastertruks = mastertruk::all();
        $sopirs = Sopir::where('status', 'aktif')->get();
        return view('truk.edit', compact('truk', 'mastertruks', 'sopirs'));
    }

    // PROSES UPDATE
    public function update(Request $request, $id)
    {
        $request->merge([
            'tarif' => preg_replace('/[^0-9]/', '', $request->tarif),
            'bbm' => preg_replace('/[^0-9]/', '', $request->bbm),
            'netto' => preg_replace('/[^0-9]/', '', $request->netto),
        ]);

        $validated = $request->validate([
            'mastertruk_id' => 'required|exists:mastertruks,id',
            'sopir_id' => 'required|exists:sopirs,id',
            'tanggal' => 'required|date',
            'perusahaan' => 'required|string|max:255',
            'tarif' => 'required|numeric',
            'bbm' => 'required|numeric',
            'netto' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $keuntunganBersih = $validated['tarif'] - $validated['bbm'];
        $bonus = $validated['netto'] > 11500 ? 60000 : 0;
        $keuntunganSopir = $keuntunganBersih * 0.25 + $bonus;
        $keuntunganPerusahaan = $keuntunganBersih * 0.75;

        $keterangan = $validated['netto'] > 11500
            ? 'Sopir mendapat bonus Rp 60.000 karena muatan melebihi 11.500 Kg.'
            : 'Sopir tidak mendapat bonus karena muatan kurang dari atau sama dengan 11.500 Kg.';

        $truk = Truk::findOrFail($id);
        $truk->update([
            'mastertruk_id' => $validated['mastertruk_id'],
            'sopir_id' => $validated['sopir_id'],
            'tanggal' => $validated['tanggal'],
            'perusahaan' => $validated['perusahaan'],
            'tarif' => $validated['tarif'],
            'bbm' => $validated['bbm'],
            'netto' => $validated['netto'],
            'keuntungan_sopir' => $keuntunganSopir,
            'keuntungan_perusahaan' => $keuntunganPerusahaan,
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('truk')->with('success', 'Data truk berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $truk = Truk::findOrFail($id);
        $truk->delete();

        return redirect()->route('truk')->with('success', 'Data truk berhasil dihapus.');
    }

public function exportPdf(Request $request)
{
    $query = Truk::with(['mastertruk', 'sopir']);

    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    if ($request->filled('sopir_id')) {
        $query->where('sopir_id', $request->sopir_id);
    }

    if ($request->filled('perusahaan')) {
        $query->where('perusahaan', 'like', '%' . $request->perusahaan . '%');
    }

    $truks = $query->get();

    // Harga bersih = Netto x Tarif
    foreach ($truks as $truk) {
        $truk->harga_bersih = $truk->netto * $truk->tarif;
    }

    $pdf = Pdf::loadView('truk.export', compact('truks'));
    return $pdf->stream('laporan-data-truk.pdf');
}
}