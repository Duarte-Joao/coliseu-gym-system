<?php

namespace Database\Factories;

use App\Models\Instrutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Instrutor>
 */
class InstrutorFactory extends Factory
{
    protected $model = Instrutor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => User::factory()->instrutor(),
            'especialidade' => fake()->randomElement(['Musculação', 'Pilates', 'Crossfit', 'Spinning', 'Dança', 'Yoga']),
            'salario' => fake()->randomFloat(2, 2000, 8000),
            'carga_hora' => fake()->randomElement(['06:00:00', '08:00:00', '04:00:00']),
            'turno' => fake()->randomElement(['Manhã', 'Tarde', 'Noite']),
        ];
    }
}
