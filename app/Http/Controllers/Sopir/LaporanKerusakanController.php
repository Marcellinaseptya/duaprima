<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\LaporanKerusakan;
use App\Models\MasterTruk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $sopir = Auth::user()->sopir;

        if (!$sopir) {
            return redirect()->back()->with('error', 'Akun Anda belum terdaftar sebagai sopir.');
        }

        $laporans = LaporanKerusakan::with('mastertruk')
                        ->where('sopir_id', $sopir->id)
                        ->latest()
                        ->get();

        return view('sopir.laporan-kerusakan.index', compact('laporans'));
    }

    public function create()
    {
        $sopir = Auth::user()->sopir;

        if (!$sopir) {
            return redirect()->back()->with('error', 'Akun Anda belum terdaftar sebagai sopir.');
        }

        $truks = MasterTruk::all(); // bisa difilter sesuai kebutuhan

        return view('sopir.laporan-kerusakan.create', compact('truks'));
    }

    public function store(Request $request)
    {
        $sopir = Auth::user()->sopir;

        if (!$sopir) {
            return redirect()->back()->with('error', 'Akun Anda belum terdaftar sebagai sopir.');
        }

        $request->validate([
            'mastertruk_id' => 'required|exists:master_truk,id',
            'tanggal' => 'required|date',
            'deskripsi_kerusakan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'mastertruk_id' => $request->mastertruk_id,
            'sopir_id' => $sopir->id,
            'tanggal' => $request->tanggal,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'status' => 'MENUNGGU',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kerusakan', 'public');
        }

        LaporanKerusakan::create($data);

        return redirect()->route('sopir.laporan-kerusakan.index')->with('success', 'Laporan berhasil dikirim.');
    }
}