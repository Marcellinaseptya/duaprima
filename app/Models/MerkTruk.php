<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerkTruk extends Model
{
    protected $fillable = ['nama'];

    public function truks()
    {
        return $this->hasMany(MasterTruk::class, 'merk_id');
    }
}
