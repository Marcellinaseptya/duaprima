<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;


class ManajerKerusakanController extends Controller
{
    public function index()
    {
        $kerusakan = LaporanKerusakan::latest()->get();
        return view('manajer.laporan-kerusakan.index', compact('kerusakan'));
    }

    public function show($id)
    {
        $laporan = LaporanKerusakan::with(['sopir.user', 'mastertruk'])->findOrFail($id);
        return view('manajer.laporan-kerusakan.show', compact('laporan'));
    }

    public function setujui($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $laporan->update(['status' => 'DISETUJUI']);
        return redirect()->back()->with('success', 'Laporan kerusakan disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);
        $laporan = LaporanKerusakan::findOrFail($id);
        $laporan->update([
            'status' => 'DITOLAK',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);
        return redirect()->back()->with('success', 'Laporan kerusakan ditolak.');
    }

    public function export(Request $request)
    {
        $laporans = LaporanKerusakan::with(['sopir', 'mastertruk'])
            ->whereIn('status', ['DISETUJUI', 'DITOLAK'])
            ->orderBy('created_at', 'desc')
            ->get();
        $tanggalCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');

        $pdf = \PDF::loadView('admin.laporan-kerusakan.export', compact('laporans', 'tanggalCetak'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan_kerusakan.pdf');
    }
}
