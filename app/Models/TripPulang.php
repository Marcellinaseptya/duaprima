<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPulang extends Model
{
    use HasFactory;

    protected $table = 'trip_pulang'; // nama tabel sesuai database

    protected $fillable = [
        'jadwal_id',
        'muatan_netto',
        'ritase',
        'biaya_bbm',
        'tarif_per_rit',
        'catatan',
        'nota_bbm',
        'waktu_selesai',
        'tanggal_sampai',
        'lokasi_tujuan',
        'km_akhir',
        'total_pendapatan',
        'bonus',
        'total_gaji_sopir',
        'total_cv',
        'status_approval'
    ];

    /**
     * Relasi ke jadwal operasional / trip berangkat
     */
    public function jadwal()
    {
        return $this->belongsTo(\App\Models\JadwalOperasional::class, 'jadwal_id');
    }

    /**
     * Optional: relasi ke TripBerangkat jika dibutuhkan
     * Bisa gunakan jadwal_id sebagai foreign key
     */
    public function tripBerangkat()
    {
        return $this->belongsTo(\App\Models\TripBerangkat::class, 'jadwal_id');
    }

    /**
     * Hitung gaji sopir & CV
     * @param int $muatan
     * @param int $ritase
     * @param int $tarifPerRit
     * @return array
     */
    public static function hitungGaji($muatan, $ritase, $tarifPerRit, $uangMakan = 0, $biayaBbm = 0)
    {
        $total = $ritase * $tarifPerRit;
        $bonus = $muatan > 11500 ? 60000 : 0;
        $totalBersih = $total + $bonus + $uangMakan - $biayaBbm;

        $totalGaji = $totalBersih * 0.25;
        $totalCV = $totalBersih * 0.75;

        return [
            'total_pendapatan' => $totalBersih,
            'bonus' => $bonus,
            'total_gaji_sopir' => $totalGaji,
            'total_cv' => $totalCV
        ];
    }
}
