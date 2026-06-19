<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AlunoDashboardController extends Controller
{
    public function __invoke(): View
    {
        $usuario = Auth::user()->load([
            'treinoAlunos.treino',
            'planoAlunos.pagamentos',
            'reservaAulas.aula.instrutor.usuario',
        ]);

        $planoAtivo = $usuario->planoAlunos->sortByDesc('data_inicio')->first();

        $reservas = $usuario->reservaAulas
            ->where('status', '!=', 'cancelada')
            ->sortBy(fn($r) => optional($r->aula)->datahora);

        $aulasDisponiveis = AulaColetiva::where('status', 'agendada')
            ->where('datahora', '>=', now())
            ->whereDoesntHave('reservas', function ($q) use ($usuario) {
                $q->where('usuario_id', $usuario->id)->where('status', '!=', 'cancelada');
            })
            ->with('instrutor.usuario')
            ->withCount('reservas')
            ->orderBy('datahora')
            ->get();

        $pagamentos = $planoAtivo
            ? $planoAtivo->pagamentos->sortByDesc('data')
            : collect();

        $aulasEsseMes = $usuario->reservaAulas
            ->where('status', '!=', 'cancelada')
            ->filter(fn($r) => $r->aula?->datahora?->isCurrentMonth())
            ->count();

        return view('aluno.dashboard', [
            'usuario'          => $usuario,
            'planoAtivo'       => $planoAtivo,
            'reservas'         => $reservas,
            'aulasDisponiveis' => $aulasDisponiveis,
            'pagamentos'       => $pagamentos,
            'aulasEsseMes'     => $aulasEsseMes,
        ]);
    }
}
