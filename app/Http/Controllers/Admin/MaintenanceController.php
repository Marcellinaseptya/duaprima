<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\LaporanKerusakan;
use App\Models\MasterTruk;
use App\Models\Sparepart;
use PDF;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with(['laporan', 'mastertruk', 'sparepart'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        $maintenances = $query->paginate(10);

        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        // Laporan kerusakan yang sudah approve dan belum diproses maintenance
        $laporans = LaporanKerusakan::where('status', 'approve')
            ->doesntHave('maintenance')
            ->get();

        $mastertruk = MasterTruk::all();
        $spareparts = Sparepart::all();

        return view('admin.maintenance.create', compact('laporans', 'mastertruk', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_kerusakan_id' => 'required|exists:laporan_kerusakans,id',
            'master_truk_id'       => 'required|exists:master_truks,id',
            'sparepart_id'         => 'required|exists:spareparts,id',
            'tanggal'              => 'required|date',
            'keterangan'           => 'nullable|string',
            'biaya'                => 'required|numeric',
        ]);

        Maintenance::create($request->all());

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Data maintenance berhasil disimpan.');
    }

    public function show($id)
    {
        $maintenance = Maintenance::with(['laporan', 'mastertruk', 'sparepart'])->findOrFail($id);
        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Data maintenance berhasil dihapus.');
    }

    public function exportPDF(Request $request)
    {
        $query = Maintenance::with(['laporan', 'mastertruk', 'sparepart'])->latest();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        $maintenances = $query->get();

        $pdf = PDF::loadView('admin.maintenance.export', compact('maintenances'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_maintenance.pdf');
    }
}