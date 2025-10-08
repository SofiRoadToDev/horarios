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
            // Turno Mañana
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
            // Turno Tarde
            [
                'bloque' => '14:10 a 14:50',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '14:50 a 15:30',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '15:30 a 16:10',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '16:10 a 16:50',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '16:50 a 17:30',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '17:30 a 18:10',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '18:10 a 18:50',
                'turno' => 'Tarde',
            ],
            [
                'bloque' => '18:50 a 19:30',
                'turno' => 'Tarde',
            ],
        ];

        foreach ($bloquesHoras as $bloqueHora) {
            BloqueHora::create($bloqueHora);
        }
    }
}
