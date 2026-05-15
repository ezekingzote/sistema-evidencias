<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevisionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('revisiones')->insert([
            ['nombre' => 'Primera Revisión', 'numero' => 1],
            ['nombre' => 'Segunda Revisión', 'numero' => 2],
            ['nombre' => 'Tercera Revisión', 'numero' => 3],
            ['nombre' => 'Cuarta Revisión', 'numero' => 4],
        ]);
    }
}