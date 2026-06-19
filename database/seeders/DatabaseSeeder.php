<?php

namespace Database\Seeders;

use App\Models\Instrutor;
use App\Models\Treino;
use App\Models\TreinoAluno;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Criar usuários fixos para teste manual de login (facilita o desenvolvimento)
        User::factory()->admin()->create([
            'name' => 'Administrador Coliseu',
            'email' => 'admin@coliseu.com',
            'password' => 'password',
        ]);

        $alunoPadrao = User::factory()->aluno()->create([
            'name' => 'João Aluno',
            'email' => 'aluno@coliseu.com',
            'password' => 'password',
        ]);

        $instrutorPadrao = User::factory()->instrutor()->create([
            'name' => 'Carlos Treinador',
            'email' => 'instrutor@coliseu.com',
            'password' => 'password',
        ]);
        Instrutor::factory()->create([
            'usuario_id'    => $instrutorPadrao->id,
            'especialidade' => 'Musculação',
            'turno'         => 'Manhã',
        ]);

        // 2. Criar mais 15 alunos aleatórios adicionais na academia
        User::factory()->count(15)->aluno()->create();

        // 3. Executar o InstrutorSeeder (Cria instrutores e seus respectivos usuários)
        $this->call(InstrutorSeeder::class);

        // 4. Executar o TreinoSeeder (Cria templates de treinos vinculados aos instrutores criados)
        $this->call(TreinoSeeder::class);

        // 5. Vincular treinos aos alunos existentes de forma realista
        $alunos = User::where('tipo', 'aluno')->get();
        $treinos = Treino::all();

        if ($treinos->isNotEmpty()) {
            foreach ($alunos as $aluno) {
                // Atribui de 1 a 2 programas de treino para cada aluno (ativos ou históricos)
                $treinosEscolhidos = $treinos->random(rand(1, 2));
                
                foreach ($treinosEscolhidos as $index => $treino) {
                    $ativo = ($index === 0); // O primeiro treino será o ativo atual
                    
                    TreinoAluno::create([
                        'usuario_id' => $aluno->id,
                        'treino_id'  => $treino->id,
                        'validade'   => now()->addYear()->format('Y-m-d'),
                        'descricao'  => $ativo ? 'Programa de hipertrofia atual.' : 'Programa de adaptação concluído.',
                    ]);
                }
            }
        }

        // 6. Executar o PlanoAlunoSeeder (Cria contratos de planos e faturamento mensal associados)
        $this->call(PlanoAlunoSeeder::class);

        // 7. Executar o AulaColetivaSeeder (Cria aulas coletivas e as reservas de alunos nas aulas)
        $this->call(AulaColetivaSeeder::class);
    }
}

