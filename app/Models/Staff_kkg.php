<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff_kkg extends Model
{
    protected $table = 'staff_kkg';
    protected $primaryKey = 'staff_id';
    protected $fillable = ['nama', 'jabatan', 'dokumentasi_id', 'foto'];
}
