<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $horarios = [
            // Juan Pérez - Matemática I en 11CBTM (Curso ID: 1) - POF 1
            [
                'docente_id' => 1,
                'curso_id' => 1,
                'materia_id' => 1, // Matemática I
                'dia_id' => 1, // Lunes
                'bloque_hora_id' => 1, // 7:45 a 8:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 1,
                'condicion_docente' => 'Titular',
            ],
            [
                'docente_id' => 1,
                'curso_id' => 1,
                'materia_id' => 1, // Matemática I
                'dia_id' => 3, // Miércoles
                'bloque_hora_id' => 2, // 8:25 a 9:05
                'ciclo_lectivo' => 2025,
                'pof_id' => 1,
                'condicion_docente' => 'Titular',
            ],
            [
                'docente_id' => 1,
                'curso_id' => 1,
                'materia_id' => 1, // Matemática I
                'dia_id' => 5, // Viernes
                'bloque_hora_id' => 3, // 9:05 a 9:45
                'ciclo_lectivo' => 2025,
                'pof_id' => 1,
                'condicion_docente' => 'Titular',
            ],

            // María López González - Lengua I en 12CBTM (Curso ID: 2) - POF 2
            [
                'docente_id' => 2,
                'curso_id' => 2,
                'materia_id' => 2, // Lengua I
                'dia_id' => 2, // Martes
                'bloque_hora_id' => 3, // 9:05 a 9:45
                'ciclo_lectivo' => 2025,
                'pof_id' => 2,
                'condicion_docente' => 'Interino',
            ],
            [
                'docente_id' => 2,
                'curso_id' => 2,
                'materia_id' => 2, // Lengua I
                'dia_id' => 4, // Jueves
                'bloque_hora_id' => 4, // 9:45 a 10:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 2,
                'condicion_docente' => 'Interino',
            ],

            // Carlos García Rodríguez - Historia en 21CBTM (Curso ID: 3) - POF 3
            [
                'docente_id' => 3,
                'curso_id' => 3,
                'materia_id' => 3, // Historia
                'dia_id' => 1, // Lunes
                'bloque_hora_id' => 5, // 10:25 a 11:05
                'ciclo_lectivo' => 2025,
                'pof_id' => 3,
                'condicion_docente' => 'Suplente',
            ],
            [
                'docente_id' => 3,
                'curso_id' => 3,
                'materia_id' => 3, // Historia
                'dia_id' => 3, // Miércoles
                'bloque_hora_id' => 6, // 11:05 a 11:45
                'ciclo_lectivo' => 2025,
                'pof_id' => 3,
                'condicion_docente' => 'Suplente',
            ],

            // Juan Pérez - Ciencias Naturales en 12CBTM (Curso ID: 2) - POF 4
            [
                'docente_id' => 1,
                'curso_id' => 2,
                'materia_id' => 4, // Ciencias Naturales
                'dia_id' => 2, // Martes
                'bloque_hora_id' => 1, // 7:45 a 8:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 4,
                'condicion_docente' => 'Titular',
            ],
            [
                'docente_id' => 1,
                'curso_id' => 2,
                'materia_id' => 4, // Ciencias Naturales
                'dia_id' => 4, // Jueves
                'bloque_hora_id' => 7, // 11:45 a 12:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 4,
                'condicion_docente' => 'Titular',
            ],

            // María López González - Lengua I en 21CBTM (Curso ID: 3) - POF 5
            [
                'docente_id' => 2,
                'curso_id' => 3,
                'materia_id' => 2, // Lengua I
                'dia_id' => 1, // Lunes
                'bloque_hora_id' => 2, // 8:25 a 9:05
                'ciclo_lectivo' => 2025,
                'pof_id' => 5,
                'condicion_docente' => 'Interino',
            ],
            [
                'docente_id' => 2,
                'curso_id' => 3,
                'materia_id' => 2, // Lengua I
                'dia_id' => 5, // Viernes
                'bloque_hora_id' => 5, // 10:25 a 11:05
                'ciclo_lectivo' => 2025,
                'pof_id' => 5,
                'condicion_docente' => 'Interino',
            ],

            // Carlos García Rodríguez - Historia en 11CBTM (Curso ID: 1) - POF 6
            [
                'docente_id' => 3,
                'curso_id' => 1,
                'materia_id' => 3, // Historia
                'dia_id' => 2, // Martes
                'bloque_hora_id' => 6, // 11:05 a 11:45
                'ciclo_lectivo' => 2025,
                'pof_id' => 6,
                'condicion_docente' => 'Suplente',
            ],

            // Juan Pérez - Inglés en 21CBTM (Curso ID: 3) - POF 7
            [
                'docente_id' => 1,
                'curso_id' => 3,
                'materia_id' => 5, // Inglés
                'dia_id' => 4, // Jueves
                'bloque_hora_id' => 2, // 8:25 a 9:05
                'ciclo_lectivo' => 2025,
                'pof_id' => 7,
                'condicion_docente' => 'Titular',
            ],

            // María López González - Educación Física en 12CBTM (Curso ID: 2) - POF 8
            [
                'docente_id' => 2,
                'curso_id' => 2,
                'materia_id' => 6, // Educación Física
                'dia_id' => 3, // Miércoles
                'bloque_hora_id' => 4, // 9:45 a 10:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 8,
                'condicion_docente' => 'Interino',
            ],

            // Carlos García Rodríguez - Matemática I en 12CBTM (Curso ID: 2) - POF 9
            [
                'docente_id' => 3,
                'curso_id' => 2,
                'materia_id' => 1, // Matemática I
                'dia_id' => 5, // Viernes
                'bloque_hora_id' => 1, // 7:45 a 8:25
                'ciclo_lectivo' => 2025,
                'pof_id' => 9,
                'condicion_docente' => 'Suplente',
            ],
        ];

        DB::table('horarios')->insert($horarios);
    }
}
