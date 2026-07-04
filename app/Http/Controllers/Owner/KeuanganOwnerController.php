<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ritase;
use App\Models\NotaBbm;
use App\Models\NotaPerbaikan;
use App\Models\Transaksi;

class KeuanganOwnerController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Ambil data pemasukan dari ritase
        $pemasukan = Ritase::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $totalPemasukan = $pemasukan->sum(function ($r) {
            return ($r->muatan_netto * $r->tarif) - $r->biaya_bbm;
        });

        // Ambil pengeluaran dari nota BBM & perbaikan
        $totalBbm = NotaBbm::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah');
        $totalPerbaikan = NotaPerbaikan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('biaya');

        // Pinjaman sopir (opsional, kalau pakai Transaksi)
        $totalPinjaman = Transaksi::where('jenis', 'Peminjaman')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $totalBbm + $totalPerbaikan + $totalPinjaman;

        // Laba bersih
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        return view('owner.keuangan.index', compact(
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalPengeluaran',
            'totalBbm',
            'totalPerbaikan',
            'totalPinjaman',
            'labaBersih'
        ));
    }
}
