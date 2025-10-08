<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docentes = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'dni' => '12345678',
            ],
            [
                'nombre' => 'María López',
                'apellido' => 'González',
                'dni' => '87654321',
            ],
            [
                'nombre' => 'Carlos García',
                'apellido' => 'Rodríguez',
                'dni' => '23456789',
            ],
        ];
    }
}
