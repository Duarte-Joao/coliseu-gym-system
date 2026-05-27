<?php

namespace Database\Seeders;

use App\Models\Instrutor;
use App\Models\Treino;
use Illuminate\Database\Seeder;

class TreinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrutores = Instrutor::all();

        if ($instrutores->isEmpty()) {
            // Fallback caso não haja instrutores
            Treino::factory()->count(10)->create();
            return;
        }

        // Criar 2 a 3 templates de treino para cada instrutor existente
        foreach ($instrutores as $instrutor) {
            Treino::factory()->count(rand(2, 3))->create([
                'instrutor_id' => $instrutor->id,
            ]);
        }
    }
}
