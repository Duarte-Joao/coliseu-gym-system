<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use App\Models\TreinoAluno;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TreinoAlunoController extends Controller
{
    private function instrutorAtual(): ?Instrutor
    {
        if (auth()->user()->tipo !== 'instrutor') return null;
        return Instrutor::where('usuario_id', auth()->id())->first();
    }

    public function index(Request $request): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $query = TreinoAluno::query()->with(['aluno', 'treino.instrutor.usuario']);

        if ($meuInstrutor) {
            $query->whereHas('treino', fn($q) => $q->where('instrutor_id', $meuInstrutor->id));
        }

        if ($request->filled('busca')) {
            $query->whereHas('aluno', fn($q) => $q->where('name', 'like', "%{$request->busca}%"));
        }

        $atribuicoes = $query->paginate(15)->withQueryString();

        return view('treino-alunos.index', compact('atribuicoes', 'meuInstrutor'));
    }

    public function create(): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $usuarios     = User::where('tipo', 'aluno')->get();
        $treinos      = $meuInstrutor
            ? Treino::with('instrutor.usuario')->where('instrutor_id', $meuInstrutor->id)->get()
            : Treino::with('instrutor.usuario')->get();

        return view('treino-alunos.create', compact('usuarios', 'treinos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();

        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'treino_id'  => 'required|exists:treinos,id',
            'validade'   => 'nullable|date',
            'descricao'  => 'nullable|string|max:255',
        ]);

        if ($meuInstrutor) {
            $treino = Treino::findOrFail($validated['treino_id']);
            if ($treino->instrutor_id !== $meuInstrutor->id) abort(403);
        }

        TreinoAluno::create($validated);

        return redirect()->route('treino-alunos.index')->with('success', 'Treino atribuído ao aluno com sucesso!');
    }

    public function show(TreinoAluno $treinoAluno): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treinoAluno->treino->instrutor_id !== $meuInstrutor->id) abort(403);

        return view('treino-alunos.show', [
            'atribuicao' => $treinoAluno->load(['aluno', 'treino.instrutor.usuario']),
        ]);
    }

    public function edit(TreinoAluno $treinoAluno): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treinoAluno->treino->instrutor_id !== $meuInstrutor->id) abort(403);

        return view('treino-alunos.edit', ['atribuicao' => $treinoAluno]);
    }

    public function update(Request $request, TreinoAluno $treinoAluno): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treinoAluno->treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $validated = $request->validate([
            'validade'  => 'nullable|date',
            'descricao' => 'nullable|string|max:255',
        ]);

        $treinoAluno->update($validated);

        return redirect()->route('treino-alunos.index')->with('success', 'Atribuição atualizada com sucesso!');
    }

    public function destroy(TreinoAluno $treinoAluno): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treinoAluno->treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $treinoAluno->delete();

        return redirect()->route('treino-alunos.index')->with('success', 'Atribuição removida com sucesso!');
    }
}
