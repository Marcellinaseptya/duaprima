<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nama', 'email', 'password', 'role'
    ];

    // Tambahkan ini agar Laravel tidak komplain soal Hash saat session check
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function sopir()
    {
        return $this->hasOne(\App\Models\Sopir::class, 'user_id', 'id');
    }
}