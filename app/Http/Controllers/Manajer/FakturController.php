<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Klien;

class FakturController extends Controller
{
    public function index()
    {
        $fakturs = Invoice::with('klien')->latest()->get();
        return view('manajer.faktur.index', compact('fakturs'));
    }

    public function create()
    {
        $kliens = Klien::all();
        return view('manajer.faktur.create', compact('kliens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klien_id' => 'required',
            'kode_invoice' => 'required|unique:invoice,kode_invoice',
            'tanggal_invoice' => 'required|date',
            'total_tagihan' => 'required|numeric',
            'status' => 'required|in:belum_bayar,sudah_bayar,dp',
            'keterangan' => 'nullable|string'
        ]);

        Invoice::create($request->all());

        return redirect()->route('manajer.faktur.index')->with('success', 'Faktur berhasil ditambahkan');
    }

    public function edit($id)
    {
        $faktur = Invoice::findOrFail($id);
        $kliens = Klien::all();
        return view('manajer.faktur.edit', compact('faktur', 'kliens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'klien_id' => 'required',
            'kode_invoice' => 'required|unique:invoice,kode_invoice,' . $id,
            'tanggal_invoice' => 'required|date',
            'total_tagihan' => 'required|numeric',
            'status' => 'required|in:belum_bayar,sudah_bayar,dp',
            'keterangan' => 'nullable|string'
        ]);

        $faktur = Invoice::findOrFail($id);
        $faktur->update($request->all());

        return redirect()->route('manajer.faktur.index')->with('success', 'Faktur berhasil diupdate');
    }

    public function destroy($id)
    {
        $faktur = Invoice::findOrFail($id);
        $faktur->delete();

        return redirect()->route('manajer.faktur.index')->with('success', 'Faktur berhasil dihapus');
    }
}
