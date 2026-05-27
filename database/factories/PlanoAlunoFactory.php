<?php

namespace Database\Factories;

use App\Models\PlanoAluno;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanoAluno>
 */
class PlanoAlunoFactory extends Factory
{
    protected $model = PlanoAluno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $configPlanos = [
            'Mensal' => ['valor' => 119.90, 'meses' => 1],
            'Trimestral' => ['valor' => 299.90, 'meses' => 3],
            'Semestral' => ['valor' => 539.90, 'meses' => 6],
            'Anual' => ['valor' => 959.90, 'meses' => 12],
        ];

        $tipo = fake()->randomElement(array_keys($configPlanos));
        $plano = $configPlanos[$tipo];

        $dataInicio = fake()->dateTimeBetween('-6 months', 'now');
        $dataFim = (clone $dataInicio)->modify("+{$plano['meses']} months");

        return [
            'usuario_id' => User::factory()->aluno(),
            'tipo' => $tipo,
            'valor' => $plano['valor'],
            'duracao_meses' => $plano['meses'],
            'data_inicio' => $dataInicio->format('Y-m-d'),
            'data_fim' => $dataFim->format('Y-m-d'),
        ];
    }
}
