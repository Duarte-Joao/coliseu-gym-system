<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PlanoAluno;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PlanoAlunoController extends Controller
{
    public function index(Request $request): View
    {
        $query = PlanoAluno::query()->with(['aluno', 'pagamentos']);

        if ($request->filled('busca')) {
            $query->whereHas('aluno', fn($q) => $q->where('name', 'like', "%{$request->busca}%"));
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $planos = $query->paginate(15)->withQueryString();

        return view('plano-alunos.index', compact('planos'));
    }

    public function create(): View
    {
        $usuarios = User::whereIn('tipo', ['aluno'])->orWhereNull('tipo')->get();
        return view('plano-alunos.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'usuario_id'    => 'required|exists:users,id',
            'tipo'          => ['required', 'string', Rule::in(['Mensal', 'Trimestral', 'Semestral', 'Anual'])],
            'valor'         => 'required|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
            'data_inicio'   => 'required|date',
            'data_fim'      => 'required|date|after:data_inicio',
        ]);

        PlanoAluno::create($validated);

        return redirect()->route('plano-alunos.index')->with('success', 'Plano criado com sucesso!');
    }

    public function show(PlanoAluno $plano): View
    {
        return view('plano-alunos.show', [
            'plano' => $plano->load(['aluno', 'pagamentos']),
        ]);
    }

    public function pdf(PlanoAluno $plano): Response
    {
        $plano->load(['aluno', 'pagamentos']);

        $pdf = Pdf::loadView('pdf.plano', compact('plano'))
            ->setPaper('a4', 'portrait');

        $nome = str_replace(' ', '-', strtolower($plano->aluno->name ?? 'plano'));
        return $pdf->stream("plano-{$nome}.pdf");
    }

    public function edit(PlanoAluno $plano): View
    {
        return view('plano-alunos.edit', compact('plano'));
    }

    public function update(Request $request, PlanoAluno $plano): RedirectResponse
    {
        $validated = $request->validate([
            'tipo'          => ['required', 'string', Rule::in(['Mensal', 'Trimestral', 'Semestral', 'Anual'])],
            'valor'         => 'required|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
            'data_inicio'   => 'required|date',
            'data_fim'      => 'required|date|after_or_equal:data_inicio',
        ]);

        $plano->update($validated);

        return redirect()->route('plano-alunos.show', $plano)->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy(PlanoAluno $plano): RedirectResponse
    {
        $plano->delete();
        return redirect()->route('plano-alunos.index')->with('success', 'Plano excluído com sucesso!');
    }
}
