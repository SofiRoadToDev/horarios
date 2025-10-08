<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Preceptor;

/**
 * Seeder para crear preceptores de ejemplo
 */
class PreceptorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preceptores = [
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'dni' => '25678901',
                'password' => 'contraseña123',
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'dni' => '26789012',
                'password' => 'contraseña123',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'dni' => '27890123',
                'password' => 'contraseña123',
            ],
            [
                'nombre' => 'Roberto',
                'apellido' => 'López',
                'dni' => '28901234',
                'password' => 'contraseña123',
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'Fernández',
                'dni' => '29012345',
                'password' => 'contraseña123',
            ],
        ];

        foreach ($preceptores as $preceptor) {
            Preceptor::create($preceptor);
        }
    }
}
