<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use App\Models\Instrutor;
use App\Models\Treino;
use Illuminate\Contracts\View\View;

class TreinadorDashboardController extends Controller
{
    public function __invoke(): View
    {
        $instrutor = Instrutor::where('usuario_id', auth()->id())
            ->with('usuario')
            ->first();

        $treinos = Treino::with(['treinoAlunos.aluno'])
            ->where('instrutor_id', $instrutor?->id)
            ->get();

        $aulas = AulaColetiva::with(['reservas.aluno'])
            ->where('instrutor_id', $instrutor?->id)
            ->orderBy('datahora', 'asc')
            ->get();

        $totalAlunos = $treinos
            ->flatMap(fn($t) => $t->treinoAlunos)
            ->pluck('usuario_id')
            ->unique()
            ->count();

        return view('treinador.dashboard', [
            'instrutor'    => $instrutor,
            'treinos'      => $treinos,
            'aulas'        => $aulas,
            'totalTreinos' => $treinos->count(),
            'totalAlunos'  => $totalAlunos,
            'totalAulas'   => $aulas->count(),
        ]);
    }
}
