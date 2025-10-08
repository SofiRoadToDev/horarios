<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;


class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            [
                'nombre' => 'Matemáticas',

            ],
            [
                'nombre' => 'Historia',

            ],
            [
                'nombre' => 'Ciencias Naturales',

            ],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}
