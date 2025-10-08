<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Estructura simplificada: Solo pof_id, dia_id, bloque_hora_id
     * El POF ya contiene: docente, materia, curso, condicion, ciclo_lectivo, obligaciones
     */
    public function run(): void
    {
        $horarios = [
            // POF 1: Juan Pérez - Matemática I - 11CBTM (3 obligaciones)
            ['pof_id' => 1, 'dia_id' => 1, 'bloque_hora_id' => 1], // Lunes 7:45-8:25
            ['pof_id' => 1, 'dia_id' => 3, 'bloque_hora_id' => 2], // Miércoles 8:25-9:05
            ['pof_id' => 1, 'dia_id' => 5, 'bloque_hora_id' => 3], // Viernes 9:05-9:45

            // POF 2: María López - Lengua I - 12CBTM (2 obligaciones)
            ['pof_id' => 2, 'dia_id' => 2, 'bloque_hora_id' => 3], // Martes 9:05-9:45
            ['pof_id' => 2, 'dia_id' => 4, 'bloque_hora_id' => 4], // Jueves 9:45-10:25

            // POF 3: Carlos García - Historia - 21CBTM (2 obligaciones)
            ['pof_id' => 3, 'dia_id' => 1, 'bloque_hora_id' => 5], // Lunes 10:25-11:05
            ['pof_id' => 3, 'dia_id' => 3, 'bloque_hora_id' => 6], // Miércoles 11:05-11:45

            // POF 4: Juan Pérez - Ciencias Naturales - 12CBTM (2 obligaciones)
            ['pof_id' => 4, 'dia_id' => 2, 'bloque_hora_id' => 1], // Martes 7:45-8:25
            ['pof_id' => 4, 'dia_id' => 4, 'bloque_hora_id' => 7], // Jueves 11:45-12:25

            // POF 5: María López - Lengua I - 21CBTM (2 obligaciones)
            ['pof_id' => 5, 'dia_id' => 1, 'bloque_hora_id' => 2], // Lunes 8:25-9:05
            ['pof_id' => 5, 'dia_id' => 5, 'bloque_hora_id' => 5], // Viernes 10:25-11:05

            // POF 6: Carlos García - Historia - 11CBTM (1 obligación)
            ['pof_id' => 6, 'dia_id' => 2, 'bloque_hora_id' => 6], // Martes 11:05-11:45

            // POF 7: Juan Pérez - Inglés - 21CBTM (1 obligación)
            ['pof_id' => 7, 'dia_id' => 4, 'bloque_hora_id' => 2], // Jueves 8:25-9:05

            // POF 8: María López - Educación Física - 12CBTM (1 obligación)
            ['pof_id' => 8, 'dia_id' => 3, 'bloque_hora_id' => 4], // Miércoles 9:45-10:25

            // POF 9: Carlos García - Matemática I - 12CBTM (1 obligación)
            ['pof_id' => 9, 'dia_id' => 5, 'bloque_hora_id' => 1], // Viernes 7:45-8:25
        ];

        DB::table('horarios')->insert($horarios);
    }
}
