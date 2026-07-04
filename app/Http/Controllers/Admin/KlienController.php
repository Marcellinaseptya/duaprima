<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klien;
use Illuminate\Http\Request;

class KlienController extends Controller
{
    public function index()
    {
        // Mengambil data klien beserta riwayat status terakhir, 10 per halaman
        $klien = Klien::with(['riwayatStatus' => function($query) {
                        $query->orderByDesc('mulai');
                    }])->latest()->paginate(10); // <-- paginate

        return view('admin.klien.index', compact('klien'));
    }

    public function create()
    {
        return view('admin.klien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255|unique:klien,nama_perusahaan',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:klien,no_hp',
            'email' => 'nullable|email|unique:klien,email',
            'status' => 'required|in:aktif,nonaktif',
            'keterangan' => 'nullable|string',
        ]);

        $klien = Klien::create($request->all());

        // Tambahkan riwayat status awal
        $klien->riwayatStatus()->create([
            'status' => $request->status,
            'mulai' => now(),
            'selesai' => null
        ]);

        return redirect()->route('admin.klien.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $klien = Klien::findOrFail($id);
        return view('admin.klien.edit', compact('klien'));
    }

    public function update(Request $request, $id)
    {
        $klien = Klien::findOrFail($id);

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255|unique:klien,nama_perusahaan,'.$id,
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:klien,no_hp,'.$id,
            'email' => 'nullable|email|unique:klien,email,'.$id,
            'status' => 'required|in:aktif,nonaktif',
            'keterangan' => 'nullable|string',
        ]);

        $klien->update($request->all());

        // Update riwayat status jika berubah
        $latestStatus = $klien->riwayatStatus()->orderByDesc('mulai')->first();
        if($latestStatus->status != $request->status){
            $latestStatus->update(['selesai' => now()]); // tutup status lama
            $klien->riwayatStatus()->create([
                'status' => $request->status,
                'mulai' => now(),
                'selesai' => null
            ]);
        }

        return redirect()->route('admin.klien.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $klien = Klien::findOrFail($id);
        $klien->riwayatStatus()->delete(); // hapus riwayat
        $klien->delete();

        return redirect()->route('admin.klien.index')->with('success', 'Klien berhasil dihapus.');
    }
}
