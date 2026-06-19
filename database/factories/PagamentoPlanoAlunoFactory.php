<?php

namespace Database\Factories;

use App\Models\PagamentoPlanoAluno;
use App\Models\PlanoAluno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PagamentoPlanoAluno>
 */
class PagamentoPlanoAlunoFactory extends Factory
{
    protected $model = PagamentoPlanoAluno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plano_aluno_id' => PlanoAluno::factory(),
            'tipo' => fake()->randomElement(['Cartão de Crédito', 'Pix', 'Dinheiro', 'Boleto']),
            'data' => fake()->dateTimeBetween('-4 months', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['pago', 'pago', 'pago', 'pendente', 'cancelado']), // Maior probabilidade de estar pago
        ];
    }
}
