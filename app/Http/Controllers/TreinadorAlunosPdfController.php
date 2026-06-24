<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TreinadorAlunosPdfController extends Controller
{
    public function __invoke(Request $request): Response
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

        $busca = $request->busca;

        if ($request->filled('busca')) {
            $termo  = mb_strtolower($request->busca);
            $alunos = $alunos
                ->filter(fn($item) => str_contains(mb_strtolower($item['usuario']->name), $termo))
                ->values();
        }

        $instrutorNome = auth()->user()->name;

        $pdf = Pdf::loadView('pdf.treinador-alunos', compact('alunos', 'busca', 'instrutorNome'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('relatorio-alunos-' . now()->format('Y-m-d') . '.pdf');
    }
}
