<?php

namespace App\Http\Controllers;

use App\Models\mastertruk;
use Illuminate\Http\Request;

class mastertrukController extends Controller
{
    public function index()
    {
        $mastertruks = mastertruk::all();
        return view('mastertruk.index', compact('mastertruks'));
    }

    public function create()
    {
        return view('mastertruk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|unique:mastertruks|max:50',
            'jenis' => 'nullable|string|max:100',
        ]);

        mastertruk::create($request->all());

        return redirect()->route('mastertruk.index')->with('success', 'Truk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mastertruk = mastertruk::findOrFail($id);
        return view('mastertruk.edit', compact('mastertruk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|max:50|unique:mastertruks,plat_nomor,' . $id,
            'jenis' => 'nullable|string|max:100',
        ]);

        $mastertruk = mastertruk::findOrFail($id);
        $mastertruk->update($request->all());

        return redirect()->route('mastertruk.index')->with('success', 'Data truk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mastertruk = mastertruk::findOrFail($id);
        $mastertruk->delete();

        return redirect()->route('mastertruk.index')->with('success', 'Data truk berhasil dihapus.');
    }
}