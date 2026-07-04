<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaHauling;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaHaulingController extends Controller
{
    public function index(Request $request)
    {
        $notaHauling = NotaHauling::with('sopir')
            ->when($request->tanggal_mulai && $request->tanggal_selesai, function ($query) use ($request) {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->latest()->get();

        return view('admin.nota-hauling.index', compact('notaHauling'));
    }

    public function exportPdf(Request $request)
    {
        $data = NotaHauling::with('sopir')
            ->when($request->tanggal_mulai && $request->tanggal_selesai, function ($query) use ($request) {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->latest()->get();

        $pdf = Pdf::loadView('admin.nota-hauling.export', ['notaHauling' => $data]);
        return $pdf->stream('laporan-nota-hauling.pdf');
    }
}
