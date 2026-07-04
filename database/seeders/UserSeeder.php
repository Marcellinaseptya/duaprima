<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama' => 'Admin Dua Prima',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        $admin->assignRole('admin');

        // Manajer
        $manajer = User::updateOrCreate(
            ['email' => 'manajer@gmail.com'],
            [
                'nama' => 'Manajer Operasional',
                'password' => Hash::make('manajer123'),
                'role' => 'manajer',
            ]
        );
        $manajer->assignRole('manajer');

        // Sopir
        $sopir = User::updateOrCreate(
            ['email' => 'sopir1@gmail.com'],
            [
                'nama' => 'Sopir 1',
                'password' => Hash::make('sopir123'),
                'role' => 'sopir',
            ]
        );
        $sopir->assignRole('sopir');

        // Owner
        $owner = User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'nama' => 'Owner CV Dua Satu Prima',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );
        $owner->assignRole('owner');
    }
}