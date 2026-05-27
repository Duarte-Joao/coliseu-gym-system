<?php

namespace Database\Factories;

use App\Models\Treino;
use App\Models\TreinoAluno;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TreinoAluno>
 */
class TreinoAlunoFactory extends Factory
{
    protected $model = TreinoAluno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataInicio = fake()->dateTimeBetween('-4 months', 'now');
        
        // 40% de chance de o treino já ter expirado ou ter data fim planejada
        $dataFim = fake()->optional(0.4)->dateTimeBetween($dataInicio, '+3 months');

        return [
            'usuario_id' => User::factory()->aluno(),
            'treino_id' => Treino::factory(),
            'data_inicio' => $dataInicio->format('Y-m-d'),
            'data_fim' => $dataFim ? $dataFim->format('Y-m-d') : null,
            'descricao' => fake()->optional(0.6)->sentence(),
        ];
    }
}
