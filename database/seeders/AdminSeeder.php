<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Ezequiel Mendoza',
                'departamento' => 'Ciencias Basicas',
                'password' => Hash::make('admin'),
                'activo' => true,
                'rol' => 'admin'
            ]
        );
    }
}
