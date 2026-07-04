<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Sopir;
use App\Models\JadwalOperasional;
use App\Models\NotaHauling;

class DashboardSopirController extends Controller
{
    public function Dashboard()
    {
        $user = Auth::user();

        // Ambil data sopir + truk
        $sopir = Sopir::with('mastertruk')->where('user_id', $user->id)->first();

        // SOLUSI: Jika $sopir null, kita beri ID 0 atau null agar query di bawah tidak crash
        $sopirId = $sopir ? $sopir->id : null;

        // Cek plat nomor dengan aman
        $platNomor = $sopir && $sopir->mastertruk 
            ? $sopir->mastertruk->plat_nomor 
            : '-';

        // Gunakan $sopirId yang sudah divalidasi di semua query di bawah
        
        // Total perjalanan selesai
        $totalPerjalanan = $sopirId 
            ? JadwalOperasional::where('sopir_id', $sopirId)->where('status', 'Selesai')->count() 
            : 0;

        // Jadwal aktif
        $jadwalAktif = $sopirId 
            ? JadwalOperasional::where('sopir_id', $sopirId)
                ->whereIn('status', ['Siap Berangkat', 'Berangkat', 'Pulang'])
                ->latest('tanggal')
                ->first() 
            : null;

        // Histori jadwal (5 terakhir)
        $historiJadwal = $sopirId 
            ? JadwalOperasional::where('sopir_id', $sopirId)->latest('tanggal')->take(5)->get() 
            : collect();

        // Pinjaman (dummy)
        $sisaPinjaman = 0;
        $statusPelunasan = 'BELUM';

        // Histori nota perjalanan
        $laporanPerjalanan = $sopirId 
            ? NotaHauling::where('sopir_id', $sopirId)->latest('tanggal')->take(5)->get() 
            : collect();

        $totalNota = $sopirId 
            ? NotaHauling::where('sopir_id', $sopirId)->count() 
            : 0;

        // Cek apakah ada nota yang belum diupload
        $belumUnggahNota = $sopirId 
            ? JadwalOperasional::where('sopir_id', $sopirId)
                ->where('status', 'Selesai')
                ->whereDoesntHave('notaHauling')
                ->exists() 
            : false;

        return view('sopir.dashboard', compact(
            'platNomor',
            'totalPerjalanan',
            'sisaPinjaman',
            'statusPelunasan',
            'jadwalAktif',
            'historiJadwal',
            'laporanPerjalanan',
            'totalNota',
            'belumUnggahNota',
            'sopir' // Kirim data sopir untuk cek di view nanti
        ));
    }
}