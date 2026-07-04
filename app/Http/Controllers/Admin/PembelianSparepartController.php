<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Added for Transactions
use App\Models\PembelianSparepart;
use App\Models\Sparepart;

class PembelianSparepartController extends Controller
{
    public function index()
    {
        $pembelian = PembelianSparepart::with('sparepart')
            ->orderBy('tanggal_pembelian', 'desc')
            ->paginate(10);

        return view('admin.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $spareparts = Sparepart::all();
        $suppliers = PembelianSparepart::select('supplier')
            ->whereNotNull('supplier')
            ->distinct()
            ->pluck('supplier');

        return view('admin.pembelian.create', compact('spareparts', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id'      => 'required|exists:spareparts,id',
            'jumlah'            => 'required|integer|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
            'harga_total'       => 'required|numeric|min:0',
            'satuan'            => 'required|in:pcs,liter,unit',
            'supplier'          => 'nullable|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'nota'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan'           => 'nullable|string|max:1000',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Upload nota
                $notaPath = null;
                if ($request->hasFile('nota')) {
                    $notaPath = $request->file('nota')->store('nota_sparepart', 'public');
                }

                // Update stok dan harga sparepart
                $sparepart = Sparepart::findOrFail($request->sparepart_id);
                $sparepart->stok += $request->jumlah;
                $sparepart->harga_satuan = $request->harga_satuan;

                if (!$sparepart->supplier && $request->supplier) {
                    $sparepart->supplier = $request->supplier;
                }
                $sparepart->save();

                // Simpan data pembelian
                PembelianSparepart::create([
                    'sparepart_id'      => $request->sparepart_id,
                    'tanggal_pembelian' => $request->tanggal_pembelian,
                    'jumlah'            => $request->jumlah,
                    'harga_satuan'      => $request->harga_satuan,
                    'harga_total'       => $request->harga_total,
                    'satuan'            => $request->satuan,
                    'supplier'          => $request->supplier,
                    'nota'              => $notaPath,
                    'catatan'           => $request->catatan,
                ]);

                return redirect()->route('admin.pembelian.index')
                    ->with('success', 'Pembelian sparepart berhasil disimpan.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pembelian = PembelianSparepart::findOrFail($id);
        $spareparts = Sparepart::all();
        
        // Get unique suppliers for the dropdown/datalist
        $suppliers = PembelianSparepart::select('supplier')
            ->whereNotNull('supplier')
            ->distinct()
            ->pluck('supplier');

        return view('admin.pembelian.edit', compact('pembelian', 'spareparts', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sparepart_id'      => 'required|exists:spareparts,id',
            'jumlah'            => 'required|integer|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
            'harga_total'       => 'required|numeric|min:0',
            'satuan'            => 'required|in:pcs,liter,unit',
            'supplier'          => 'nullable|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'nota'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan'           => 'nullable|string|max:1000',
        ]);

        $pembelian = PembelianSparepart::findOrFail($id);

        try {
            return DB::transaction(function () use ($request, $pembelian) {
                $sparepart = Sparepart::findOrFail($request->sparepart_id);

                // 1. Rollback old stock from the original sparepart
                $oldSparepart = Sparepart::find($pembelian->sparepart_id);
                if ($oldSparepart) {
                    $oldSparepart->stok -= $pembelian->jumlah;
                    $oldSparepart->save();
                }

                // 2. Handle Nota (File) Update
                $notaPath = $pembelian->nota;
                if ($request->hasFile('nota')) {
                    // Delete old file if exists
                    if ($pembelian->nota) {
                        Storage::disk('public')->delete($pembelian->nota);
                    }
                    $notaPath = $request->file('nota')->store('nota_sparepart', 'public');
                }

                // 3. Update Current Sparepart Stock & Price
                $sparepart->stok += $request->jumlah;
                $sparepart->harga_satuan = $request->harga_satuan;
                $sparepart->save();

                // 4. Update Purchase Record
                $pembelian->update([
                    'sparepart_id'      => $request->sparepart_id,
                    'tanggal_pembelian' => $request->tanggal_pembelian,
                    'jumlah'            => $request->jumlah,
                    'harga_satuan'      => $request->harga_satuan,
                    'harga_total'       => $request->harga_total,
                    'satuan'            => $request->satuan,
                    'supplier'          => $request->supplier,
                    'nota'              => $notaPath,
                    'catatan'           => $request->catatan,
                ]);

                return redirect()->route('admin.pembelian.index')
                    ->with('success', 'Data pembelian berhasil diperbarui.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pembelian = PembelianSparepart::findOrFail($id);

        DB::transaction(function () use ($pembelian) {
            // Rollback stok sparepart
            if ($pembelian->sparepart) {
                $pembelian->sparepart->stok -= $pembelian->jumlah;
                $pembelian->sparepart->save();
            }

            // Hapus file nota jika ada
            if ($pembelian->nota) {
                Storage::disk('public')->delete($pembelian->nota);
            }

            $pembelian->delete();
        });

        return back()->with('success', 'Data pembelian berhasil dihapus.');
    }
}