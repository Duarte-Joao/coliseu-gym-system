<?php

namespace Database\Factories;

use App\Models\AulaColetiva;
use App\Models\ReservaAulaColetiva;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReservaAulaColetiva>
 */
class ReservaAulaColetivaFactory extends Factory
{
    protected $model = ReservaAulaColetiva::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aula_coletiva_id' => AulaColetiva::factory(),
            'usuario_id' => User::factory()->aluno(),
            'status' => fake()->randomElement(['confirmada', 'confirmada', 'confirmada', 'presenca_confirmada', 'cancelada']),
        ];
    }
}
