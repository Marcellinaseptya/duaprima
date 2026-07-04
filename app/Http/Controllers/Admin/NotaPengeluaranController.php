<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaPengeluaran;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class NotaPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = NotaPengeluaran::with('sopir.user')->latest();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $notaPengeluaran = $query->paginate(10);
        return view('admin.notapengeluaran.index', compact('notaPengeluaran'));
    }

    public function create()
    {
        $sopirs = Sopir::with('user')->get();
        return view('admin.notapengeluaran.create', compact('sopirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'jenis' => 'required|string',
            'file_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $filePath = $request->file('file_bukti')->store('nota-pengeluaran', 'public');

        NotaPengeluaran::create([
            'sopir_id' => $request->sopir_id,
            'jenis' => $request->jenis,
            'file_bukti' => $filePath,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.nota-pengeluaran.index')->with('success', 'Nota pengeluaran berhasil ditambahkan.');
    }

    public function edit(NotaPengeluaran $notaPengeluaran)
    {
        $sopirs = Sopir::with('user')->get();
        return view('admin.notapengeluaran.edit', compact('notaPengeluaran', 'sopirs'));
    }

    public function update(Request $request, NotaPengeluaran $notaPengeluaran)
    {
        $request->validate([
            'sopir_id' => 'required|exists:sopirs,id',
            'jenis' => 'required|string',
            'file_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('sopir_id', 'jenis', 'tanggal', 'keterangan');

        if ($request->hasFile('file_bukti')) {
            if ($notaPengeluaran->file_bukti && Storage::disk('public')->exists($notaPengeluaran->file_bukti)) {
                Storage::disk('public')->delete($notaPengeluaran->file_bukti);
            }
            $data['file_bukti'] = $request->file('file_bukti')->store('nota-pengeluaran', 'public');
        }

        $notaPengeluaran->update($data);

        return redirect()->route('admin.nota-pengeluaran.index')->with('success', 'Nota pengeluaran berhasil diperbarui.');
    }

    public function destroy(NotaPengeluaran $notaPengeluaran)
    {
        if ($notaPengeluaran->file_bukti && Storage::disk('public')->exists($notaPengeluaran->file_bukti)) {
            Storage::disk('public')->delete($notaPengeluaran->file_bukti);
        }
        $notaPengeluaran->delete();

        return redirect()->route('admin.nota-pengeluaran.index')->with('success', 'Nota pengeluaran berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = NotaPengeluaran::with('sopir.user')->latest();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $notaPengeluaran = $query->get();

        $pdf = PDF::loadView('admin.notapengeluaran.export', compact('notaPengeluaran'));
        return $pdf->download('laporan-nota-pengeluaran.pdf');
    }
}
