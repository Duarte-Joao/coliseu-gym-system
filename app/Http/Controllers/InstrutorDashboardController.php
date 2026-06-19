<?php
// app/Http/Controllers/InstrutorDashboardController.php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use App\Models\User;
use Illuminate\Contracts\View\View;

class InstrutorDashboardController extends Controller
{
    public function __invoke(): View
    {
        // Busca o registro de instrutor do usuário logado
        $instrutor = Instrutor::where('usuario_id', auth()->id())->first();

        // Todos os alunos, trazendo junto seus treinos atribuídos
        $alunos = User::where('tipo', 'aluno')
            ->with(['treinoAlunos.treino'])
            ->get();

        // Alunos que não têm nenhum treino atribuído
        $alunosSemFicha = $alunos->filter(
            fn(User $u) => $u->treinoAlunos->isEmpty()
        )->values();

        // Todas as fichas de treino para popular os selects
        $treinos = Treino::with('instrutor.usuario')->get();

        return view('instrutor.dashboard', [
            'instrutor'      => $instrutor,
            'alunos'         => $alunos,
            'alunosSemFicha' => $alunosSemFicha,
            'totalAlunos'    => $alunos->count(),
            'semFicha'       => $alunosSemFicha->count(),
            'treinos'        => $treinos,
        ]);
    }
}