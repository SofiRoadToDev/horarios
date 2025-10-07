<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dias')->insert([
            ['id' => 1, 'nombre' => 'Lunes'],
            ['id' => 2, 'nombre' => 'Martes'],
            ['id' => 3, 'nombre' => 'Miércoles'],
            ['id' => 4, 'nombre' => 'Jueves'],
            ['id' => 5, 'nombre' => 'Viernes'],
        ]);
    }
}
