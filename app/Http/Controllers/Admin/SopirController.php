<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sopir;
use App\Models\User;
use App\Models\MasterTruk;
use Illuminate\Http\Request;

class SopirController extends Controller
{
    public function index()
    {
        $sopirs = Sopir::with('masterTruk', 'user')->orderBy('id', 'desc')->paginate(10); 
        return view('admin.sopir.index', compact('sopirs'));
    }

    public function create()
    {
        $availableTruks = MasterTruk::whereDoesntHave('sopir')->get();
        $users = User::whereDoesntHave('sopir')->get();

        return view('admin.sopir.create', compact('availableTruks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            // PERBAIKAN 1: required diubah jadi nullable
            'mastertruk_id' => 'nullable|exists:master_truk,id|unique:sopir,mastertruk_id',
        ]);

        // PERBAIKAN 2: Gabungkan +62 untuk nomor HP
        $nomor_hp = ltrim($request->no_hp, '0'); // Buang angka 0 di depan jika ada
        $nomor_hp_lengkap = '+62' . $nomor_hp;

        Sopir::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'no_hp' => $nomor_hp_lengkap, // Simpan nomor yang sudah ditambah +62
            'alamat' => $request->alamat,
            'status' => $request->status,
            'mastertruk_id' => $request->mastertruk_id,
        ]);

        return redirect()->route('admin.sopir.index')->with('success', 'Sopir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sopir = Sopir::findOrFail($id);

        $availableTruks = MasterTruk::whereDoesntHave('sopir')
                            ->orWhere('id', $sopir->mastertruk_id)
                            ->get();

        $users = User::whereDoesntHave('sopir')
                        ->orWhere('id', $sopir->user_id)
                        ->get();

        return view('admin.sopir.edit', compact('sopir', 'availableTruks', 'users'));
    }

    public function update(Request $request, $id)
    {
        $sopir = Sopir::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            // PERBAIKAN 1: required diubah jadi nullable
            'mastertruk_id' => 'nullable|exists:master_truk,id|unique:sopir,mastertruk_id,' . $id,
        ]);

        // PERBAIKAN 2: Gabungkan +62 untuk nomor HP (untuk edit)
        $nomor_hp = ltrim($request->no_hp, '0'); 
        $nomor_hp_lengkap = '+62' . $nomor_hp;

        $sopir->update([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'no_hp' => $nomor_hp_lengkap, // Simpan nomor yang sudah ditambah +62
            'alamat' => $request->alamat,
            'status' => $request->status,
            'mastertruk_id' => $request->mastertruk_id,
        ]);

        return redirect()->route('admin.sopir.index')->with('success', 'Sopir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sopir = Sopir::findOrFail($id);
        $sopir->delete();

        return redirect()->route('admin.sopir.index')->with('success', 'Sopir berhasil dihapus.');
    }
}