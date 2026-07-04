<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);
        return view('admin.sparepart.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
        ]);
    
        $sparepart = Sparepart::where('nama_sparepart', $request->nama_sparepart)->first();
    
        if ($sparepart) {
            if ($sparepart->satuan !== $request->satuan) {
                return back()->withErrors(['satuan' => 'Satuan berbeda dengan data sebelumnya!']);
            }
    
            $sparepart->stok += $request->jumlah;
            $sparepart->harga_satuan = $request->harga_satuan;
            $sparepart->save();
        } else {
            Sparepart::create([
                'nama_sparepart' => $request->nama_sparepart,
                'stok' => $request->jumlah,
                'satuan' => $request->satuan,
                'harga_satuan' => $request->harga_satuan,
            ]);
        }
    
        return redirect()->back()->with('success', 'Sparepart berhasil ditambahkan/ditambah stok.');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('admin.sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update([
            'nama_sparepart' => $request->nama_sparepart,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
        ]);

        return redirect()->route('admin.sparepart.index')->with('success', 'Data sparepart berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return redirect()->route('admin.sparepart.index')->with('success', 'Data sparepart berhasil dihapus');
    }
}