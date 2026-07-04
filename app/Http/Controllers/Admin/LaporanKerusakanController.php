<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use PDF;

class LaporanKerusakanController extends Controller
{
    // Tampilkan semua laporan, bisa difilter berdasarkan status
    public function index(Request $request)
    {
        $query = LaporanKerusakan::with(['sopir', 'mastertruk'])->latest();

        if ($request->has('status') && in_array($request->status, ['PENDING', 'DISETUJUI', 'DITOLAK'])) {
            $query->where('status', $request->status);
        }

        $laporans = $query->get();

        return view('admin.laporan-kerusakan.index', compact('laporans'));
    }

    // Tampilkan detail laporan kerusakan
    public function show($id)
    {
        $laporan = LaporanKerusakan::with(['sopir', 'mastertruk'])->findOrFail($id);

        return view('admin.laporan-kerusakan.show', compact('laporan'));
    }

    // Export PDF semua data yang sudah diproses (bukan PENDING)
    public function exportPdf(Request $request)
    {
        $laporans = LaporanKerusakan::with(['sopir', 'mastertruk'])
            ->whereIn('status', ['DISETUJUI', 'DITOLAK'])
            ->orderBy('created_at', 'desc')
            ->get();
        $tanggalCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('admin.laporan-kerusakan.export', compact('laporans', 'tanggalCetak'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan_kerusakan.pdf');
    }
}