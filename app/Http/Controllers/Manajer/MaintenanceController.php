<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\LaporanKerusakan;
use App\Models\MasterTruk;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('mastertruk')->latest('tanggal_perbaikan')->get();
        return view('manajer.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $mastertruk = MasterTruk::all();
        return view('manajer.maintenance.create', compact('mastertruk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mastertruk_id'        => 'required|exists:master_truk,id',
            'tanggal_perbaikan'    => 'required|date',
            'deskripsi_perbaikan'  => 'required|string',
            'biaya_servis'                => 'required|numeric',
            'foto_bukti'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti-maintenance', 'public');
        }

        Maintenance::create($data);

        return redirect()->route('manajer.maintenance.index')->with('success', 'Data maintenance berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $mastertruk = MasterTruk::all();
        return view('manajer.maintenance.edit', compact('maintenance', 'mastertruk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mastertruk_id'        => 'required|exists:master_truk,id',
            'tanggal_perbaikan'    => 'required|date',
            'deskripsi_perbaikan'  => 'required|string',
            'biaya_servis'                => 'required|numeric',
            'foto_bukti'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $maintenance = Maintenance::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti-maintenance', 'public');
        }

        $maintenance->update($data);

        return redirect()->route('manajer.maintenance.index')->with('success', 'Data maintenance berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('manajer.maintenance.index')->with('success', 'Data maintenance berhasil dihapus.');
    }

    public function createFromLaporan($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $mastertruk = MasterTruk::all();

        return view('manajer.maintenance.create-from-laporan', compact('laporan', 'mastertruk'));
    }

    public function print(Request $request)
    {
        $query = Maintenance::with(['laporan', 'mastertruk'])->latest('tanggal_perbaikan');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_perbaikan', [$request->from, $request->to]);
        }

        $maintenances = $query->get();

        $pdf = \PDF::loadView('admin.maintenance.export', compact('maintenances'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_maintenance.pdf');
    }
}
