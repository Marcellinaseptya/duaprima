<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\User;
use App\Models\mastertruk;
use Illuminate\Http\Request;
use PDF;

class PerbaikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perbaikan::with('sopir', 'truk');

        if ($request->filled('sopir_id')) {
            $query->where('sopir_id', $request->sopir_id);
        }

        $perbaikans = $query->latest()->get();
        $sopirs = User::where('role', 'sopir')->get();

        return view('perbaikan.index', compact('perbaikans', 'sopirs'));
    }

    public function create()
    {
        $sopirs = User::where('role', 'sopir')->get();
        $truks = mastertruk::all();

        return view('perbaikan.create', compact('sopirs', 'truks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sopir_id' => 'required|exists:users,id',
            'mastertruk_id' => 'required|exists:mastertruks,id',
            'keluhan' => 'required|string|max:255',
            'tanggal_perbaikan' => 'required|date',
            'status' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'sopir_id',
            'mastertruk_id',
            'keluhan',
            'tanggal_perbaikan',
            'status',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('perbaikan'), $namaFile);
            $data['foto'] = 'perbaikan/' . $namaFile;
        }

        Perbaikan::create($data);

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);

        if ($perbaikan->foto && file_exists(public_path($perbaikan->foto))) {
            unlink(public_path($perbaikan->foto));
        }

        $perbaikan->delete();

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = Perbaikan::with('sopir', 'truk');

        if ($request->filled('sopir_id')) {
            $query->where('sopir_id', $request->sopir_id);
        }

        $perbaikans = $query->get();
        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('perbaikan.export', compact('perbaikans', 'tanggalCetak'))->setPaper('A4', 'landscape');

        return $pdf->stream('laporan-perbaikan.pdf');
    }
}