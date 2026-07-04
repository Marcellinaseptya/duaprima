<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $transaksis = $query->latest()->paginate(10);

        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function export(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $transaksis = $query->get();

        $pdf = Pdf::loadView('admin.transaksi.export', compact('transaksis'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_transaksi.pdf');
    }
}