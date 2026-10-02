<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@buensabor.pe'],
            [
                'name' => 'Adrián Jara (Administrador)',
                'password' => Hash::make('admin123'), // Contraseña encriptada
            ]
        );
    }
}
