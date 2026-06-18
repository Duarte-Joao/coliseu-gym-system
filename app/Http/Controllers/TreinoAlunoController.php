<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Treino;
use App\Models\TreinoAluno;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TreinoAlunoController extends Controller
{
    public function index(Request $request): View
    {
        $query = TreinoAluno::query()->with(['aluno', 'treino.instrutor.usuario']);

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }
        if ($request->filled('treino_id')) {
            $query->where('treino_id', $request->treino_id);
        }

        $atribuicoes = $query->paginate(15)->withQueryString();

        return view('treino-alunos.index', compact('atribuicoes'));
    }

    public function create(): View
    {
        $usuarios = User::where('tipo', 'aluno')->orWhereNull('tipo')->get();
        $treinos  = Treino::with('instrutor.usuario')->get();
        return view('treino-alunos.create', compact('usuarios', 'treinos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'usuario_id'  => 'required|exists:users,id',
            'treino_id'   => 'required|exists:treinos,id',
            'data_inicio' => 'required|date',
            'data_fim'    => 'nullable|date|after_or_equal:data_inicio',
            'descricao'   => 'nullable|string|max:255',
        ]);

        TreinoAluno::create($validated);

        return redirect()->route('treino-alunos.index')->with('success', 'Treino atribuído ao aluno com sucesso!');
    }

    public function show(TreinoAluno $treinoAluno): View
    {
        return view('treino-alunos.show', [
            'atribuicao' => $treinoAluno->load(['aluno', 'treino.instrutor.usuario']),
        ]);
    }

    public function edit(TreinoAluno $treinoAluno): View
    {
        return view('treino-alunos.edit', ['atribuicao' => $treinoAluno]);
    }

    public function update(Request $request, TreinoAluno $treinoAluno): RedirectResponse
    {
        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim'    => 'nullable|date|after_or_equal:data_inicio',
            'descricao'   => 'nullable|string|max:255',
        ]);

        $treinoAluno->update($validated);

        return redirect()->route('treino-alunos.index')->with('success', 'Atribuição atualizada com sucesso!');
    }

    public function destroy(TreinoAluno $treinoAluno): RedirectResponse
    {
        $treinoAluno->delete();
        return redirect()->route('treino-alunos.index')->with('success', 'Atribuição removida com sucesso!');
    }
}
