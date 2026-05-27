<?php

namespace Database\Seeders;

use App\Models\AulaColetiva;
use App\Models\Instrutor;
use App\Models\ReservaAulaColetiva;
use App\Models\User;
use Illuminate\Database\Seeder;

class AulaColetivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrutores = Instrutor::all();
        $alunos = User::where('tipo', 'aluno')->get();

        if ($instrutores->isEmpty() || $alunos->isEmpty()) {
            return;
        }

        // Criar 10 aulas coletivas com instrutores aleatórios
        for ($i = 0; $i < 10; $i++) {
            $aula = AulaColetiva::factory()->create([
                'instrutor_id' => $instrutores->random()->id,
            ]);

            // Determinar quantidade de reservas para esta aula (respeitando limite de vagas)
            $vagasOcupadas = rand(3, min(10, $aula->vagas));
            
            // Selecionar alunos aleatórios para reservar a aula (sem repetição de aluno na mesma aula)
            $alunosSelecionados = $alunos->random($vagasOcupadas);

            foreach ($alunosSelecionados as $aluno) {
                // Status da reserva depende do status da aula coletiva
                $statusReserva = 'confirmada';
                if ($aula->status === 'realizada') {
                    $statusReserva = fake()->boolean(85) ? 'presenca_confirmada' : 'cancelada';
                } elseif ($aula->status === 'cancelada') {
                    $statusReserva = 'cancelada';
                } else {
                    $statusReserva = fake()->boolean(10) ? 'cancelada' : 'confirmada';
                }

                ReservaAulaColetiva::create([
                    'aula_coletiva_id' => $aula->id,
                    'usuario_id' => $aluno->id,
                    'status' => $statusReserva,
                ]);
            }
        }
    }
}
