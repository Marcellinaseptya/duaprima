<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanNotaHauling;

class NotaHaulingOwnerController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanNotaHauling::where('status', 'MENUNGGU');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $notas = $query->latest()->get();
        return view('owner.nota-hauling.index', compact('notas'));
    }

    public function approve($id)
    {
        $nota = LaporanNotaHauling::findOrFail($id);
        $nota->status = 'approved';
        $nota->save();

        return redirect()->back()->with('success', 'Nota berhasil di-approve');
    }

    public function reject($id)
    {
        $nota = LaporanNotaHauling::findOrFail($id);
        $nota->status = 'rejected';
        $nota->save();

        return redirect()->back()->with('success', 'Nota berhasil ditolak');
    }
}
