<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotaHauling;
use App\Models\NotaBbm;
use App\Models\NotaPerbaikan;
use App\Models\LaporanKerusakan;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Ritase; // pastikan model Ritase sudah dibuat
use App\Models\Maintenance;
use App\Models\Sparepart;
use Carbon\Carbon;

class DashboardOwnerController extends Controller
{
    public function index()
    {
        // Total validasi
        $totalNotaHauling    = NotaHauling::where('status', 'Menunggu Validasi')->count();
        $totalNotaBbm        = NotaBbm::where('status', 'Menunggu Validasi')->count();
        $totalNotaPerbaikan  = NotaPerbaikan::where('status', 'Menunggu Validasi')->count();
        $totalKerusakan      = LaporanKerusakan::where('status', 'Disetujui Manajer')->count();

        // Total pemasukan, pengeluaran, pinjaman sopir
        $totalPemasukan      = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran    = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalPinjamanSopir  = Peminjaman::where('status', 'Belum Lunas')->sum('jumlah');

        // Total dari Trip / Ritase
        $ritases = Ritase::all(); // ambil semua ritase sebagai Collection
        $totalPendapatan = $ritases->sum(function($r){
            return ($r->ritase * $r->tarif_per_rit + $r->bonus) - $r->biaya_bbm;
        });
        $totalGajiSopir = $ritases->sum('total_gaji_sopir');
        $totalUntungCV  = $ritases->sum('total_cv');

        // Total Maintenance
        $maintenances = Maintenance::all();
        $totalMaintenance = $maintenances->sum('biaya_servis');

        // Total Sparepart
        $spareparts = Sparepart::all();
        $totalSparepart = $spareparts->sum(function($sp){
            return $sp->stok * $sp->harga_satuan;
        });

        // Pie Chart Peminjaman
        $dataPiePeminjaman = [
            'labels' => ['Lunas', 'Belum Lunas'],
            'datasets' => [[
                'data' => [
                    Peminjaman::where('status', 'Lunas')->count(),
                    Peminjaman::where('status', 'Belum Lunas')->count()
                ],
                'backgroundColor' => ['#4CAF50', '#F44336']
            ]]
        ];

        // Pie Chart Kerusakan
        $dataPieKerusakan = [
            'labels' => ['Disetujui', 'Ditolak'],
            'datasets' => [[
                'data' => [
                    LaporanKerusakan::where('status', 'Disetujui Manajer')->count(),
                    LaporanKerusakan::where('status', 'Ditolak')->count()
                ],
                'backgroundColor' => ['#2196F3', '#FF9800']
            ]]
        ];

        // Bar Chart Pemasukan & Pengeluaran per Bulan
        $dataBarPemasukan = [
            'labels' => [],
            'datasets' => [[
                'label' => 'Pemasukan',
                'backgroundColor' => '#4CAF50',
                'data' => []
            ]]
        ];
        $dataBarPengeluaran = [
            'labels' => [],
            'datasets' => [[
                'label' => 'Pengeluaran',
                'backgroundColor' => '#F44336',
                'data' => []
            ]]
        ];

        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->format('F');
            $dataBarPemasukan['labels'][] = $monthName;
            $dataBarPengeluaran['labels'][] = $monthName;

            $pemasukan = Transaksi::where('jenis', 'pemasukan')->whereMonth('tanggal', $i)->sum('jumlah');
            $pengeluaran = Transaksi::where('jenis', 'pengeluaran')->whereMonth('tanggal', $i)->sum('jumlah');

            $dataBarPemasukan['datasets'][0]['data'][] = $pemasukan;
            $dataBarPengeluaran['datasets'][0]['data'][] = $pengeluaran;
        }

        return view('owner.dashboard', compact(
            'totalNotaHauling',
            'totalNotaBbm',
            'totalNotaPerbaikan',
            'totalKerusakan',
            'totalPendapatan',
            'totalGajiSopir',
            'totalUntungCV',
            'totalMaintenance',
            'totalSparepart',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPinjamanSopir',
            'dataPiePeminjaman',
            'dataPieKerusakan',
            'dataBarPemasukan',
            'dataBarPengeluaran'
        ));
    }
}
