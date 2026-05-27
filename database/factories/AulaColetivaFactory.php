<?php

namespace Database\Factories;

use App\Models\AulaColetiva;
use App\Models\Instrutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AulaColetiva>
 */
class AulaColetivaFactory extends Factory
{
    protected $model = AulaColetiva::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataHora = fake()->dateTimeBetween('-2 weeks', '+3 weeks');
        $agora = new \DateTime();

        // Inteligência cronológica para definir o status da aula
        $status = $dataHora < $agora ? 'realizada' : 'agendada';
        
        // 10% de chance de cancelamento geral
        if (fake()->boolean(10)) {
            $status = 'cancelada';
        }

        return [
            'instrutor_id' => Instrutor::factory(),
            'datahora' => $dataHora,
            'vagas' => fake()->numberBetween(12, 30),
            'obs' => fake()->optional(0.5)->sentence(),
            'status' => $status,
            'modalidade' => fake()->randomElement(['Spinning', 'Zumba', 'Pilates Solo', 'Functional Fit', 'Yoga Integral', 'Alongamento', 'Cross Combat']),
        ];
    }
}
