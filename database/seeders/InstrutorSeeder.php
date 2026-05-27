<?php

namespace Database\Seeders;

use App\Models\Instrutor;
use Illuminate\Database\Seeder;

class InstrutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 5 instrutores (o InstrutorFactory já cria os usuários do tipo 'instrutor')
        Instrutor::factory()->count(5)->create();
    }
}
