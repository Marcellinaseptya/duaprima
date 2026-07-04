<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Sopir;
use App\Models\MasterTruk;
use App\Models\LaporanKerusakan;
use App\Models\TripBerangkat;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Ringkasan
        $totalPemasukan = Transaksi::where('kategori', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('kategori', 'pengeluaran')->sum('jumlah');
        $totalTrukAktif = MasterTruk::where('status', 'aktif')->count();
        $totalSopirAktif = Sopir::where('status', 'aktif')->count();
        $totalLaporan = LaporanKerusakan::count();

        // Grafik Trip Berangkat (7 hari terakhir)
        $tripBerangkat = TripBerangkat::select('tanggal_berangkat as tanggal', DB::raw('COUNT(*) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal','asc')
            ->take(7)
            ->get()
            ->map(function($item){
                return [
                    'tanggal' => date('d M', strtotime($item->tanggal)),
                    'total' => $item->total
                ];
            });

        // Grafik Pengeluaran per kategori
        $transaksiOperasional = Transaksi::where('kategori','pengeluaran')
            ->select('keterangan as kategori', DB::raw('SUM(jumlah) as total'))
            ->groupBy('keterangan')
            ->get();

        // Grafik Laporan Kerusakan per Sopir
        $laporanPerSopir = LaporanKerusakan::select('sopir_id', DB::raw('COUNT(*) as total'))
            ->groupBy('sopir_id')
            ->with('sopir')
            ->get()
            ->map(function($item){
                return [
                    'nama_sopir' => $item->sopir->nama ?? 'Tidak Diketahui',
                    'total' => $item->total
                ];
            });

        // Laporan terbaru
        $laporanTerbaru = LaporanKerusakan::with('sopir')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPemasukan','totalPengeluaran','totalTrukAktif','totalSopirAktif','totalLaporan',
            'tripBerangkat','transaksiOperasional','laporanPerSopir','laporanTerbaru'
        ));
    }
}