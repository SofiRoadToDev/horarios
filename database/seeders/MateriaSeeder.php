<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materia;
use App\Models\Curso;

/**
 * Seeder para crear materias y relacionarlas con cursos
 */
class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materias = [
            [
                'nombre' => 'Matemática I',
                'departamento_id' => 1,
            ],
            [
                'nombre' => 'Lengua I',
                'departamento_id' => 2,
            ],
            [
                'nombre' => 'Historia',
                'departamento_id' => 2,
            ],
            [
                'nombre' => 'Ciencias Naturales',
                'departamento_id' => 3,
            ],
            [
                'nombre' => 'Inglés',
                'departamento_id' => 1,
            ],
            [
                'nombre' => 'Educación Física',
                'departamento_id' => 2,
            ],
        ];

        // Crear materias
        foreach ($materias as $materiaData) {
            $materia = Materia::create($materiaData);

            // Obtener cursos aleatorios para relacionar (entre 1 y 3 cursos)
            $cursos = Curso::inRandomOrder()->limit(rand(1, 3))->pluck('id');

            // Relacionar materia con cursos mediante la tabla pivot
            $materia->cursos()->attach($cursos);
        }
    }
}
