<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Docente;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Juan Pérez - puede dictar Matemática I, Ciencias Naturales e Inglés
        $juan = Docente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
        ]);
        $juan->materias()->attach([1, 4, 5]); // Matemática I, Ciencias Naturales, Inglés

        // María López González - puede dictar Lengua I y Educación Física
        $maria = Docente::create([
            'nombre' => 'María López',
            'apellido' => 'González',
            'dni' => '87654321',
        ]);
        $maria->materias()->attach([2, 6]); // Lengua I, Educación Física

        // Carlos García Rodríguez - puede dictar Historia y Matemática I
        $carlos = Docente::create([
            'nombre' => 'Carlos García',
            'apellido' => 'Rodríguez',
            'dni' => '23456789',
        ]);
        $carlos->materias()->attach([3, 1]); // Historia, Matemática I
    }


}
