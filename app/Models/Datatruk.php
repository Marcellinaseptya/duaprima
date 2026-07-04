<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mastertruk extends Model
{
    protected $table = 'mastertruks'; // nama tabelnya

    protected $fillable = [
        'plat_nomor',
        'jenis',
        'sopir_id',
        'created_at',
        'updated_at'
    ];

    // Relasi ke sopir
    public function sopir(): BelongsTo
    {
        return $this->belongsTo(Sopir::class, 'sopir_id', 'id');
    }
}