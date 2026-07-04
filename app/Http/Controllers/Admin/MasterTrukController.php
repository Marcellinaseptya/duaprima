<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterTruk;
use Illuminate\Http\Request;

class MasterTrukController extends Controller
{
    public function index()
    {
        $mastertruk = MasterTruk::paginate(10);
        return view('admin.mastertruk.index', compact('mastertruk'));
    }

    public function create()
    {
        $merkList = ['Hino', 'Isuzu', 'Mitsubishi', 'Toyota', 'Suzuki']; // bisa diambil dari DB juga
        $jenisTrukList = ['Dump Truck', 'Box Truck', 'Tronton', 'Engkel', 'Wingbox']; // contoh isian dropdown manual
        $statusList = ['aktif', 'servis', 'rusak', 'nonaktif'];

        return view('admin.mastertruk.create', compact('merkList', 'jenisTrukList', 'statusList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|unique:master_truk,plat_nomor',
            'jenis_truk' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'merk' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:aktif,servis,rusak,nonaktif',
            'keterangan' => 'nullable|string',
        ]);

        MasterTruk::create($request->all());

        return redirect()->route('admin.mastertruk.index')->with('success', 'Data truk berhasil disimpan');
    }
    public function edit($id)
    {
        $masterTruk = MasterTruk::findOrFail($id);
        $merkList = ['Hino', 'Isuzu', 'Mitsubishi', 'Toyota', 'Suzuki'];
        $jenisTrukList = ['Dump Truck', 'Box Truck', 'Tronton', 'Engkel', 'Wingbox'];
        $statusList = ['aktif', 'servis', 'rusak', 'nonaktif'];

        return view('admin.mastertruk.edit', compact('masterTruk', 'merkList', 'jenisTrukList', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|unique:master_truk,plat_nomor,' . $id,
            'jenis_truk' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'merk' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:aktif,servis,rusak,nonaktif',
            'keterangan' => 'nullable|string',
        ]);

        $masterTruk = MasterTruk::findOrFail($id);
        $masterTruk->update($request->all());

        return redirect()->route('admin.mastertruk.index')->with('success', 'Data truk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $masterTruk = MasterTruk::findOrFail($id);
        $masterTruk->delete();

        return redirect()->route('admin.mastertruk.index')->with('success', 'Data truk berhasil dihapus');
    }
}
