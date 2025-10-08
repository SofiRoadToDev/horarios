<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            [
                'codigo' => '11CBTM', // 1 nivel 1 division CB Ciclo Basico TM Turno Mañana
                'ciclo' => 'Básico',
                'turno' => 'Mañana',
                'preceptor_id' => 1,
            ],
            [
                'codigo' => '12CBTM',
                'ciclo' => 'Básico',
                'turno' => 'Mañana',
                'preceptor_id' => 2,
            ],
            [
                'codigo' => '21CBTM',
                'ciclo' => 'Básico',
                'turno' => 'Mañana',
                'preceptor_id' => 3,
            ],
            [
                'codigo' => '22CBTT',
                'ciclo' => 'Básico',
                'turno' => 'Tarde',
                'preceptor_id' => 4,
            ],
            [
                'codigo' => '23CBTT',
                'ciclo' => 'Básico',
                'turno' => 'Tarde',
                'preceptor_id' => 5,
            ],
        ];

        foreach ($cursos as $curso) {
            \App\Models\Curso::create($curso);
        }
    }
}
