<?php

namespace Database\Seeders;

use App\Models\PagamentoPlanoAluno;
use App\Models\PlanoAluno;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PlanoAlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alunos = User::where('tipo', 'aluno')->get();

        if ($alunos->isEmpty()) {
            return;
        }

        foreach ($alunos as $aluno) {
            // Cria um plano para o aluno
            $plano = PlanoAluno::factory()->create([
                'usuario_id' => $aluno->id,
            ]);

            // Cria uma parcela de pagamento para cada mês de duração do plano
            $dataVencimentoBase = Carbon::parse($plano->data_inicio);
            
            for ($mes = 0; $mes < $plano->duracao_meses; $mes++) {
                $dataVencimento = (clone $dataVencimentoBase)->addMonths($mes);
                
                // Se o vencimento for no passado, o pagamento provavelmente já foi quitado
                $status = $dataVencimento->isPast() ? 'pago' : 'pendente';
                
                // 5% de chance de cancelamento nas parcelas futuras
                if ($status === 'pendente' && fake()->boolean(5)) {
                    $status = 'cancelado';
                }

                PagamentoPlanoAluno::factory()->create([
                    'plano_aluno_id' => $plano->id,
                    'data' => $dataVencimento->format('Y-m-d'),
                    'status' => $status,
                    'tipo' => $status === 'pago'
                        ? fake()->randomElement(['Cartão de Crédito', 'Pix', 'Dinheiro'])
                        : 'Boleto',
                ]);
            }
        }
    }
}
