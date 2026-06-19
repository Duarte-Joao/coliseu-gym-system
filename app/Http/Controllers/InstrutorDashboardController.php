<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use App\Models\Instrutor;
use App\Models\PagamentoPlanoAluno;
use App\Models\Treino;
use App\Models\User;
use Illuminate\Contracts\View\View;

class InstrutorDashboardController extends Controller
{
    public function __invoke(): View
    {
        $alunos = User::where('tipo', 'aluno')
            ->with(['treinoAlunos.treino'])
            ->get();

        $treinos = Treino::with('instrutor.usuario')->get();

        $alunosSemFicha = $alunos
            ->filter(fn(User $u) => $u->treinoAlunos->isEmpty())
            ->values();

        $alunosComPagamentoPendente = User::where('tipo', 'aluno')
            ->whereHas('planoAlunos.pagamentos', fn($q) => $q->where('status', 'pendente'))
            ->get();

        $alunosComPendencia = collect()
            ->merge($alunosSemFicha->map(fn($u) => ['usuario' => $u, 'tipo' => 'sem_ficha']))
            ->merge($alunosComPagamentoPendente->map(fn($u) => ['usuario' => $u, 'tipo' => 'pagamento_pendente']));

        return view('instrutor.dashboard', [
            'alunos'               => $alunos,
            'alunosSemFicha'       => $alunosSemFicha,
            'alunosComPendencia'   => $alunosComPendencia,
            'treinos'              => $treinos,
            'totalAlunos'          => $alunos->count(),
            'semFicha'             => $alunosSemFicha->count(),
            'totalInstrutores'     => Instrutor::count(),
            'totalTreinos'         => $treinos->count(),
            'totalAulas'           => AulaColetiva::count(),
            'totalPendentes'       => PagamentoPlanoAluno::where('status', 'pendente')->count(),
        ]);
    }
}
