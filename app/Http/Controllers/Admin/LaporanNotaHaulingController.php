<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanNotaHauling;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanNotaHaulingController extends Controller
{
    public function index()
    {
        // Pastikan relasi sopir ada. Kalau ada relasi user di Sopir, boleh tambah ->with('sopir.user')
        $notas = LaporanNotaHauling::with('sopir')->latest()->paginate(10);
        return view('admin.nota-hauling.index', compact('notas')); // << kirim $notas
    }

    public function show($id)
    {
        $nota = LaporanNotaHauling::with('sopir')->findOrFail($id);
        return view('admin.nota-hauling.show', compact('nota'));
    }

    public function export()
    {
        $notas = LaporanNotaHauling::with('sopir')->latest()->get();
        $pdf = Pdf::loadView('admin.nota-hauling.export', compact('notas'));
        return $pdf->download('laporan-nota-hauling.pdf');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED',
        ]);

        $nota = LaporanNotaHauling::findOrFail($id);
        $nota->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status nota hauling berhasil diperbarui menjadi ' . $request->status . '.');
    }
}