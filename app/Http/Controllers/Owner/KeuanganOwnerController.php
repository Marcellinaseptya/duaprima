<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ritase;
use App\Models\NotaBbm;
use App\Models\NotaPerbaikan;
use App\Models\Transaksi;

use App\Models\Invoice;
use App\Models\TripBerangkat;

class KeuanganOwnerController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? now()->endOfMonth()->toDateString();

        // 1. Pemasukan (Invoice Lunas)
        $totalPemasukan = Invoice::where('status', 'sudah_bayar')
            ->whereBetween('tanggal_invoice', [$start_date, $end_date])
            ->sum('total_tagihan');

        // 2. Pengeluaran Lapangan (Trip yang disetujui)
        // Ambil TripPulang yang disetujui
        $tripPulangs = \App\Models\TripPulang::with('jadwal.tripBerangkat')
            ->where('status_approval', 'Disetujui')
            ->whereBetween('waktu_selesai', [$start_date, $end_date])
            ->get();

        $uangJalan = 0;
        $uangMakan = 0;
        $totalBbmTrip = 0;

        foreach ($tripPulangs as $tp) {
            $totalBbmTrip += $tp->biaya_bbm ?? 0;
            if ($tp->jadwal && $tp->jadwal->tripBerangkat) {
                $uangJalan += $tp->jadwal->tripBerangkat->uang_jalan ?? 0;
                $uangMakan += $tp->jadwal->tripBerangkat->uang_makan ?? 0;
            } elseif ($tp->jadwal) {
                // Fallback jika terjadi bug sebelumnya (TripBerangkat tidak terbuat)
                $uangJalan += $tp->jadwal->uang_jalan ?? 0;
                
                // Cari uang makan di tabel transaksi
                $transaksi = \App\Models\Transaksi::where('kategori', 'trip pulang')
                    ->whereDate('tanggal', \Carbon\Carbon::parse($tp->waktu_selesai)->format('Y-m-d'))
                    ->where('keterangan', 'like', "%{$tp->jadwal->masterTruk->plat_nomor}%")
                    ->first();
                    
                if ($transaksi) {
                    $makan = $transaksi->nominal - ($tp->jadwal->uang_jalan ?? 0) - ($tp->biaya_bbm ?? 0);
                    $uangMakan += max(0, $makan);
                }
            }
        }
        $totalTripBiaya = $uangJalan + $uangMakan;

        // 3. Pengeluaran Manual & Perbaikan (Hanya yang disetujui)
        $totalBbmManual = NotaBbm::where('status', 'Disetujui')
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->sum('jumlah');
        $totalBbm = $totalBbmManual + $totalBbmTrip;

        // Perbaikan: Sum column depends on what column is actually holding the cost.
        $totalPerbaikan = \App\Models\Maintenance::whereBetween('tanggal_perbaikan', [$start_date, $end_date])
            ->sum('biaya_servis');

        // 4. Pinjaman sopir
        $totalPinjaman = Transaksi::where('jenis', 'Peminjaman')
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $totalBbm + $totalPerbaikan + $totalPinjaman + $totalTripBiaya;

        // Laba bersih
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        return view('owner.keuangan.index', compact(
            'start_date',
            'end_date',
            'totalPemasukan',
            'totalPengeluaran',
            'totalBbm',
            'totalPerbaikan',
            'totalPinjaman',
            'totalTripBiaya',
            'labaBersih'
        ));
    }
}
