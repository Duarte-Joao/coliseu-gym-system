<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TreinoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Treino::query()->with('instrutor.usuario');

        if ($request->filled('instrutor_id')) {
            $query->where('instrutor_id', $request->instrutor_id);
        }
        if ($request->filled('nome')) {
            $query->where('nome', 'like', "%{$request->nome}%");
        }

        $treinos = $query->paginate(15)->withQueryString();
        $instrutores = Instrutor::with('usuario')->get();

        return view('treinos.index', compact('treinos', 'instrutores'));
    }

    public function create(): View
    {
        $instrutores = Instrutor::with('usuario')->get();
        return view('treinos.create', compact('instrutores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instrutor_id'             => 'required|exists:instrutores,id',
            'nome'                     => 'required|string|max:255',
            'obs'                      => 'nullable|string',
            'exercicios'               => 'required|array|min:1',
            'exercicios.*.nome'        => 'required|string|max:255',
            'exercicios.*.series'      => 'required|integer|min:1',
            'exercicios.*.repeticoes'  => 'required|integer|min:1',
            'exercicios.*.carga'       => 'required|numeric|min:0',
        ]);

        Treino::create($validated);

        return redirect()->route('treinos.index')->with('success', 'Treino criado com sucesso!');
    }

    public function show(Treino $treino): View
    {
        return view('treinos.show', [
            'treino' => $treino->load(['instrutor.usuario', 'treinoAlunos.aluno']),
        ]);
    }

    public function edit(Treino $treino): View
    {
        $instrutores = Instrutor::with('usuario')->get();
        return view('treinos.edit', compact('treino', 'instrutores'));
    }

    public function update(Request $request, Treino $treino): RedirectResponse
    {
        $validated = $request->validate([
            'nome'                     => 'required|string|max:255',
            'obs'                      => 'nullable|string',
            'exercicios'               => 'required|array|min:1',
            'exercicios.*.nome'        => 'required|string|max:255',
            'exercicios.*.series'      => 'required|integer|min:1',
            'exercicios.*.repeticoes'  => 'required|integer|min:1',
            'exercicios.*.carga'       => 'required|numeric|min:0',
        ]);

        $treino->update($validated);

        return redirect()->route('treinos.show', $treino)->with('success', 'Treino atualizado com sucesso!');
    }

    public function destroy(Treino $treino): RedirectResponse
    {
        $treino->delete();
        return redirect()->route('treinos.index')->with('success', 'Treino excluído com sucesso!');
    }
}
