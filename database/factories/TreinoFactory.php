<?php

namespace Database\Factories;

use App\Models\Instrutor;
use App\Models\Treino;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Treino>
 */
class TreinoFactory extends Factory
{
    protected $model = Treino::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Estrutura de exercícios realista em pt_BR
        $exerciciosDisponiveis = [
            [
                ['nome' => 'Supino Reto', 'series' => 4, 'repeticoes' => 10, 'carga' => 45],
                ['nome' => 'Crucifixo Reto', 'series' => 3, 'repeticoes' => 12, 'carga' => 14],
                ['nome' => 'Desenvolvimento com Halteres', 'series' => 4, 'repeticoes' => 10, 'carga' => 16],
                ['nome' => 'Tríceps Corda', 'series' => 3, 'repeticoes' => 15, 'carga' => 25],
            ],
            [
                ['nome' => 'Agachamento Livre', 'series' => 4, 'repeticoes' => 8, 'carga' => 60],
                ['nome' => 'Leg Press 45', 'series' => 3, 'repeticoes' => 10, 'carga' => 160],
                ['nome' => 'Cadeira Extensora', 'series' => 4, 'repeticoes' => 12, 'carga' => 40],
                ['nome' => 'Cadeira Flexora', 'series' => 4, 'repeticoes' => 12, 'carga' => 35],
                ['nome' => 'Gêmeos Sentado', 'series' => 4, 'repeticoes' => 15, 'carga' => 40],
            ],
            [
                ['nome' => 'Puxada Frente', 'series' => 4, 'repeticoes' => 10, 'carga' => 50],
                ['nome' => 'Remada Baixa', 'series' => 3, 'repeticoes' => 12, 'carga' => 45],
                ['nome' => 'Crucifixo Invertido', 'series' => 3, 'repeticoes' => 12, 'carga' => 8],
                ['nome' => 'Rosca Direta', 'series' => 4, 'repeticoes' => 10, 'carga' => 12],
                ['nome' => 'Rosca Martelo', 'series' => 3, 'repeticoes' => 12, 'carga' => 10],
            ],
        ];

        return [
            'instrutor_id' => Instrutor::factory(),
            'nome' => fake()->randomElement([
                'Treino A - Peito, Ombro e Tríceps',
                'Treino B - Coxas, Panturrilhas e Glúteos',
                'Treino C - Costas, Bíceps e Abdômen',
                'Treino Full Body - Resistência',
                'Treino Funcional de Alta Intensidade'
            ]),
            'descricao' => fake()->optional(0.7)->sentence(),
            'exercicios' => fake()->randomElement($exerciciosDisponiveis),
        ];
    }
}
