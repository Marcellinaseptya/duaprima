<?php

// app/Http/Controllers/MerkTrukController.php
namespace App\Http\Controllers;

use App\Models\MerkTruk;
use Illuminate\Http\Request;

class MerkTrukController extends Controller
{
    public function index()
    {
        $data = MerkTruk::all();
        return view('merk.index', compact('data'));
    }

    public function create()
    {
        return view('merk.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        MerkTruk::create($request->all());
        return redirect()->route('merk.index')->with('success', 'Merk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $merk = MerkTruk::findOrFail($id);
        return view('merk.edit', compact('merk'));
    }

    public function update(Request $request, $id)
    {
        $merk = MerkTruk::findOrFail($id);
        $merk->update($request->all());
        return redirect()->route('merk.index')->with('success', 'Merk berhasil diupdate.');
    }

    public function destroy($id)
    {
        MerkTruk::destroy($id);
        return back()->with('success', 'Merk dihapus.');
    }
}
