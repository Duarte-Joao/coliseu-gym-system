<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TreinadorAlunosController extends Controller
{
    public function __invoke(Request $request): View
    {
        $instrutor = Instrutor::where('usuario_id', auth()->id())->first();

        $treinos = Treino::with(['treinoAlunos.aluno'])
            ->where('instrutor_id', $instrutor?->id)
            ->get();

        $alunos = $treinos
            ->flatMap(fn($t) => $t->treinoAlunos->map(fn($ta) => [
                'treinoAluno' => $ta,
                'treino'      => $t,
                'usuario'     => $ta->aluno,
            ]))
            ->filter(fn($item) => $item['usuario'] !== null)
            ->groupBy(fn($item) => $item['usuario']->id)
            ->map(fn($fichas) => [
                'usuario' => $fichas->first()['usuario'],
                'fichas'  => $fichas->map(fn($f) => [
                    'ta'     => $f['treinoAluno'],
                    'treino' => $f['treino'],
                ]),
            ])
            ->values();

        if ($request->filled('busca')) {
            $busca  = mb_strtolower($request->busca);
            $alunos = $alunos
                ->filter(fn($item) => str_contains(mb_strtolower($item['usuario']->name), $busca))
                ->values();
        }

        return view('treinador.alunos', [
            'alunos'      => $alunos,
            'totalAlunos' => $alunos->count(),
            'busca'       => $request->busca,
        ]);
    }
}
