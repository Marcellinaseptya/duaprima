<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMerk extends Model
{
    use HasFactory;

    protected $table = 'master_merk';

    protected $fillable = ['nama'];

    public function truks()
{
    return $this->hasMany(MasterTruk::class, 'merk_id');
}

}

