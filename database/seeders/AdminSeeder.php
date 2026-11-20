<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@foodshare.local'],
            [
                'name' => 'Admin FoodShare',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        User::updateOrCreate(
            ['email' => 'pemohon1@foodshare.local'],
            [
                'name' => 'Pemohon Satu',
                'password' => Hash::make('password'),
                'role' => 'pemohon',
            ]
        );
        User::updateOrCreate(
            ['email' => 'pemohon2@foodshare.local'],
            [
                'name' => 'Pemohon Dua',
                'password' => Hash::make('password'),
                'role' => 'pemohon',
            ]
        );
    }
}
