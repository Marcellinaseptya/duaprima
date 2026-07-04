<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{ use HasFactory;

    protected $table ='spareparts';
    protected $fillable = [
        'sparepart_id', 'nama_sparepart', 'kategori', 'stok', 'nota', 'harga_satuan', 'supplier','satuan'
    ];

    public function pembelian()
    {
        return $this->hasMany(PembelianSparepart::class);
    }

    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}

    
}