<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ritase;
use Carbon\Carbon;

class RitaseOwnerController extends Controller
{
    public function index(Request $request)
    {
        // Filter bulan & tahun dari request, default ke bulan sekarang
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Ambil data ritase bulan & tahun itu
        $ritases = Ritase::with(['sopir', 'truk']) // pastikan relasi ada
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Hitung total pemasukan
        $totalPemasukan = $ritases->sum(function($ritase) {
            return $ritase->muatan_netto * $ritase->tarif;
        });

        // Total BBM
        $totalBbm = $ritases->sum('biaya_bbm');

        // Gaji sopir (25%) + bonus jika muatan > 11.500kg
        $totalGajiSopir = $ritases->sum(function($ritase) {
            $hasilBersih = ($ritase->muatan_netto * $ritase->tarif) - $ritase->biaya_bbm;
            $gaji = $hasilBersih * 0.25;
            if ($ritase->muatan_netto > 11500) {
                $gaji += 60000; // Bonus
            }
            return $gaji;
        });

        // Profit CV = 75% dari hasil bersih
        $totalProfitCv = $ritases->sum(function($ritase) {
            $hasilBersih = ($ritase->muatan_netto * $ritase->tarif) - $ritase->biaya_bbm;
            return $hasilBersih * 0.75;
        });

        return view('owner.ritase.index', compact(
            'ritases',
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalBbm',
            'totalGajiSopir',
            'totalProfitCv'
        ));
    }
}
