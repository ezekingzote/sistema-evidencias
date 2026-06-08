<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Docente;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Ezequiel Mendoza',
                'password' => Hash::make('admin'),
                'rol' => 'admin'
            ]
        );
        Docente::updateOrCreate(
            ['user_id' => $adminUser->id],
            [
                'departamento' => 'Ciencias Basicas',
                'cargo' => 'ADMIN', // Puedes ajustarlo si usas otro cargo por defecto
                'activo' => 1
            ]
        );
    }
}
