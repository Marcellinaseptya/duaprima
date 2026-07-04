<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catatan;

class CatatanController extends Controller
{
    public function index()
    {
        $catatans = Catatan::latest()->paginate(10);
        return view('manajer.catatan.index', compact('catatans'));
    }

    public function create()
    {
        return view('manajer.catatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'isi' => 'required|string',
        ]);

        Catatan::create($request->all());

        return redirect()->route('manajer.catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catatan = Catatan::findOrFail($id);
        return view('manajer.catatan.edit', compact('catatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'isi' => 'required|string',
        ]);

        $catatan = Catatan::findOrFail($id);
        $catatan->update($request->all());

        return redirect()->route('manajer.catatan.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Catatan::destroy($id);
        return redirect()->route('manajer.catatan.index')->with('success', 'Catatan berhasil dihapus.');
    }
}