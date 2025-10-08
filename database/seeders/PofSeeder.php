<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pofs = [
            // POF 1: Juan Pérez - Matemática I - 11CBTM (3 obligaciones)
            [
                'tipo' => 'Alta',
                'docente_id' => 1,
                'materia_id' => 1,
                'curso_id' => 1,
                'condicion_docente' => 'Titular',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-15',
                'obligaciones' => 3,
                'causal' => 'Renuncia',
                'instrumento_legal' => 'Resolución 001/2025',
                'observaciones' => 'Designación titular para ciclo lectivo 2025',
            ],

            // POF 2: María López González - Lengua I - 12CBTM (2 obligaciones)
            [
                'tipo' => 'Alta',
                'docente_id' => 2,
                'materia_id' => 2,
                'curso_id' => 2,
                'condicion_docente' => 'Interino',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-15',
                'obligaciones' => 2,
                'causal' => 'Jubilacion',
                'instrumento_legal' => 'Resolución 002/2025',
                'observaciones' => 'Designación interina por licencia del titular',
            ],

            // POF 3: Carlos García Rodríguez - Historia - 21CBTM (2 obligaciones)
            [
                'tipo' => 'Alta',
                'docente_id' => 3,
                'materia_id' => 3,
                'curso_id' => 3,
                'condicion_docente' => 'Suplente',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-03-01',
                'obligaciones' => 2,
                'causal' => 'Renuncia',
                'instrumento_legal' => 'Resolución 003/2025',
                'observaciones' => 'Suplencia por enfermedad del titular',
            ],

            // POF 4: Juan Pérez - Ciencias Naturales - 12CBTM (2 obligaciones)
            [
                'tipo' => 'Alta',
                'docente_id' => 1,
                'materia_id' => 4,
                'curso_id' => 2,
                'condicion_docente' => 'Titular',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-15',
                'obligaciones' => 2,
                'causal' => 'Fallecimiento',
                'instrumento_legal' => 'Resolución 004/2025',
                'observaciones' => 'Designación titular para ciclo lectivo 2025',
            ],

            // POF 5: María López González - Lengua I - 21CBTM (2 obligaciones)
            [
                'tipo' => 'Alta',
                'docente_id' => 2,
                'materia_id' => 2, // Lengua I
                'curso_id' => 3,
                'condicion_docente' => 'Interino',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-20',
                'obligaciones' => 2,
                'causal' => 'Fallecimiento',
                'instrumento_legal' => 'Resolución 005/2025',
                'observaciones' => 'Designación interina por cargo de mayor jerarquía del titular',
            ],

            // POF 6: Carlos García Rodríguez - Historia - 11CBTM (1 obligación)
            [
                'tipo' => 'Alta',
                'docente_id' => 3,
                'materia_id' => 3,
                'curso_id' => 1,
                'condicion_docente' => 'Suplente',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-03-01',
                'obligaciones' => 1,
                'causal' => 'Jubilacion',
                'instrumento_legal' => 'Resolución 006/2025',
                'observaciones' => 'Suplencia temporal',
            ],

            // POF 7: Juan Pérez - Inglés - 21CBTM (1 obligación)
            [
                'tipo' => 'Alta',
                'docente_id' => 1,
                'materia_id' => 5, // Inglés
                'curso_id' => 3,
                'condicion_docente' => 'Titular',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-15',
                'obligaciones' => 1,
                'causal' => 'Renuncia',
                'instrumento_legal' => 'Resolución 007/2025',
                'observaciones' => 'Designación titular para ciclo lectivo 2025',
            ],

            // POF 8: María López González - Educación Física - 12CBTM (1 obligación)
            [
                'tipo' => 'Alta',
                'docente_id' => 2,
                'materia_id' => 6, // Educación Física
                'curso_id' => 2,
                'condicion_docente' => 'Interino',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-02-25',
                'obligaciones' => 1,
                'causal' => 'Jubilacion',
                'instrumento_legal' => 'Resolución 008/2025',
                'observaciones' => 'Designación interina por jubilación del titular',
            ],

            // POF 9: Carlos García Rodríguez - Matemática I - 12CBTM (1 obligación)
            [
                'tipo' => 'Alta',
                'docente_id' => 3,
                'materia_id' => 1, // Matemática I
                'curso_id' => 2,
                'condicion_docente' => 'Suplente',
                'ciclo_lectivo' => '2025-01-01',
                'fecha' => '2025-03-05',
                'obligaciones' => 1,
                'causal' => 'Renuncia',
                'instrumento_legal' => 'Resolución 009/2025',
                'observaciones' => 'Suplencia por licencia Lic.art.24',
            ],
        ];

        DB::table('pofs')->insert($pofs);
    }
}
