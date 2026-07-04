<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopirTruk extends Model
{
    use HasFactory;

    protected $table = 'sopirtruks'; // Nama tabel, sesuaikan jika berbeda

    // Jika kamu tidak memakai timestamps (created_at, updated_at), bisa nonaktifkan:
    public $timestamps = false;

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'tanggal',
        'sopir',
        'perusahaan',
        'tarif',
        'bbm',
        'netto',
        'keuntungan_sopir',
        'keuntungan_perusahaan',
        'keterangan',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function truk()
{
    return $this->hasOne(Truk::class, 'sopir_id'); // relasi ke truk yang dia pakai
}
}
