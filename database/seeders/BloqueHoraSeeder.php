<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BloqueHora;

/**
 * Seeder para crear bloques horarios
 * Cada bloque tiene 40 minutos de duración
 */
class BloqueHoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloquesHoras = [
            [
                'bloque' => '7:45 a 8:25',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '8:25 a 9:05',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '9:05 a 9:45',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '9:45 a 10:25',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '10:25 a 11:05',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '11:05 a 11:45',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '11:45 a 12:25',
                'turno' => 'Mañana',
            ],
            [
                'bloque' => '12:25 a 13:05',
                'turno' => 'Mañana',
            ],
        ];

        foreach ($bloquesHoras as $bloqueHora) {
            BloqueHora::create($bloqueHora);
        }
    }
}
