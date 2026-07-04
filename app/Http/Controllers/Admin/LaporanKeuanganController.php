<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripPulang;
use App\Models\Maintenance;
use App\Models\PembelianSparepart;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // 1. Query Data Utama
        $query = TripPulang::with(['tripBerangkat.sopir', 'tripBerangkat.truk']);
        $maintenanceQuery = Maintenance::with(['mastertruk']);
        $sparepartQuery = PembelianSparepart::query();

        if ($start && $end) {
            $query->whereBetween('waktu_selesai', [$start, $end]);
            $maintenanceQuery->whereBetween('tanggal_perbaikan', [$start, $end]);
            $sparepartQuery->whereBetween('tanggal_pembelian', [$start, $end]);
        }

        $trips = $query->get();
        $maintenance = $maintenanceQuery->get();
        $sparepart = $sparepartQuery->get();

        // 2. Inisialisasi Variabel Kalkulasi
        $totalPendapatan = 0;
        $totalGajiSopir  = 0;
        $totalUntungCV   = 0;
        $gajiPerSopir    = []; // Untuk fitur rekap gaji per sopir

        foreach ($trips as $trip) {
            $ritase     = $trip->ritase ?? 0;
            $tarif      = $trip->tarif_per_rit ?? 0;
            $bbm        = $trip->biaya_bbm ?? 0;
            $uang_makan = $trip->uang_makan ?? 0;
            $bonus      = ($trip->muatan_netto ?? 0) > 11500 ? 60000 : 0;

            // Hitung Bersih (Ritase + Makan + Bonus - BBM)
            $totalBersih = ($ritase * $tarif + $bonus + $uang_makan) - $bbm;
            
            $gajiSopirCurrent = $totalBersih * 0.25; // Gaji Sopir 25%
            $untungCVCurrent  = $totalBersih * 0.75; // Untung CV 75%

            $totalPendapatan += $totalBersih;
            $totalGajiSopir  += $gajiSopirCurrent;
            $totalUntungCV   += $untungCVCurrent;

            // Logika Rekap per Nama Sopir
            $namaSopir = data_get($trip, 'tripBerangkat.sopir.nama', 'Tanpa Nama');
            if (!isset($gajiPerSopir[$namaSopir])) {
                $gajiPerSopir[$namaSopir] = [
                    'total_gaji' => 0,
                    'total_rit'  => 0
                ];
            }
            $gajiPerSopir[$namaSopir]['total_gaji'] += $gajiSopirCurrent;
            $gajiPerSopir[$namaSopir]['total_rit']  += $ritase;
        }

        $totalMaintenance = $maintenance->sum('biaya_servis');
        $totalSparepart   = $sparepart->sum('harga_total');

        return view('admin.laporan_keuangan.index', compact(
            'trips', 'maintenance', 'sparepart',
            'totalPendapatan', 'totalGajiSopir', 'totalUntungCV',
            'totalMaintenance', 'totalSparepart', 
            'gajiPerSopir', 'start', 'end'
        ));
    }
}
