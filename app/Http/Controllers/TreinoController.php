<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\Treino;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TreinoController extends Controller
{
    private function instrutorAtual(): ?Instrutor
    {
        if (auth()->user()->tipo !== 'instrutor') return null;
        return Instrutor::where('usuario_id', auth()->id())->first();
    }

    public function index(Request $request): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $query = Treino::query()->with('instrutor.usuario');

        if ($meuInstrutor) {
            $query->where('instrutor_id', $meuInstrutor->id);
        } else {
            if ($request->filled('instrutor_id')) {
                $query->where('instrutor_id', $request->instrutor_id);
            }
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', "%{$request->nome}%");
        }

        $treinos     = $query->paginate(15)->withQueryString();
        $instrutores = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('treinos.index', compact('treinos', 'instrutores', 'meuInstrutor'));
    }

    public function create(): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $instrutores  = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('treinos.create', compact('instrutores', 'meuInstrutor'));
    }

    public function store(Request $request): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();

        $validated = $request->validate([
            'instrutor_id'            => $meuInstrutor ? 'nullable' : 'required|exists:instrutores,id',
            'nome'                    => 'required|string|max:255',
            'descricao'               => 'nullable|string',
            'exercicios'              => 'required|array|min:1',
            'exercicios.*.nome'       => 'required|string|max:255',
            'exercicios.*.series'     => 'required|integer|min:1',
            'exercicios.*.repeticoes' => 'required|integer|min:1',
            'exercicios.*.carga'      => 'required|numeric|min:0',
            'exercicios.*.imagem'     => 'nullable|image|max:2048',
        ]);

        if ($meuInstrutor) {
            $validated['instrutor_id'] = $meuInstrutor->id;
        }

        $validated['exercicios'] = $this->processExercicios($request, $validated['exercicios']);

        Treino::create($validated);

        return redirect()->route('treinos.index')->with('success', 'Treino criado com sucesso!');
    }

    private function processExercicios(Request $request, array $exercicios): array
    {
        foreach ($exercicios as $index => &$exercicio) {
            $imagem = $request->file("exercicios.{$index}.imagem");

            if ($imagem) {
                $exercicio['imagem'] = $imagem->store('treinos/exercicios', 'public');
            } elseif (!empty($exercicio['imagem_antiga'])) {
                $exercicio['imagem'] = $exercicio['imagem_antiga'];
            } else {
                $exercicio['imagem'] = null;
            }

            unset($exercicio['imagem_antiga']);
        }

        return $exercicios;
    }

    public function show(Treino $treino): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treino->instrutor_id !== $meuInstrutor->id) abort(403);

        return view('treinos.show', [
            'treino' => $treino->load(['instrutor.usuario', 'treinoAlunos.aluno']),
        ]);
    }

    public function pdf(Treino $treino): Response
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $treino->load(['instrutor.usuario', 'treinoAlunos.aluno']);

        $pdf = Pdf::loadView('pdf.treino', compact('treino'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("ficha-{$treino->id}.pdf");
    }

    public function edit(Treino $treino): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $instrutores = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('treinos.edit', compact('treino', 'instrutores', 'meuInstrutor'));
    }

    public function update(Request $request, Treino $treino): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $validated = $request->validate([
            'nome'                       => 'required|string|max:255',
            'descricao'                  => 'nullable|string',
            'exercicios'                 => 'required|array|min:1',
            'exercicios.*.nome'          => 'required|string|max:255',
            'exercicios.*.series'        => 'required|integer|min:1',
            'exercicios.*.repeticoes'    => 'required|integer|min:1',
            'exercicios.*.carga'         => 'required|numeric|min:0',
            'exercicios.*.imagem'        => 'nullable|image|max:2048',
            'exercicios.*.imagem_antiga' => 'nullable|string',
        ]);

        $validated['exercicios'] = $this->processExercicios($request, $validated['exercicios']);

        $treino->update($validated);

        return redirect()->route('treinos.show', $treino)->with('success', 'Treino atualizado com sucesso!');
    }

    public function destroy(Treino $treino): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $treino->instrutor_id !== $meuInstrutor->id) abort(403);

        $treino->delete();

        return redirect()->route('treinos.index')->with('success', 'Treino excluído com sucesso!');
    }
}
