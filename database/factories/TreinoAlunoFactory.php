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
        return [
            'usuario_id' => User::factory()->aluno(),
            'treino_id'  => Treino::factory(),
            'validade'   => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'descricao'  => fake()->optional(0.6)->sentence(),
        ];
    }
}
