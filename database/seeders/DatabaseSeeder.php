<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call(DiaSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(PreceptorSeeder::class);
        $this->call(DocenteSeeder::class);
        $this->call(CursoSeeder::class);
        $this->call(BloqueHoraSeeder::class);
        $this->call(MateriaSeeder::class);
    }
}
