<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PagamentoPlanoAluno;
use App\Models\PlanoAluno;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PagamentoPlanoAlunoController extends Controller
{
    public function index(Request $request): View
    {
        $query = PagamentoPlanoAluno::query()->with('plano.aluno');

        if ($request->filled('plano_aluno_id')) {
            $query->where('plano_aluno_id', $request->plano_aluno_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pagamentos = $query->paginate(15)->withQueryString();

        return view('pagamento-plano-alunos.index', compact('pagamentos'));
    }

    public function create(Request $request): View
    {
        $planos = PlanoAluno::with('aluno')->get();
        $planoSelecionado = $request->filled('plano_aluno_id')
            ? PlanoAluno::find($request->plano_aluno_id)
            : null;

        return view('pagamento-plano-alunos.create', compact('planos', 'planoSelecionado'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plano_aluno_id'   => 'required|exists:plano_alunos,id',
            'metodo_pagamento' => 'required|string|max:255',
            'data'             => 'required|date',
            'status'           => ['nullable', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        PagamentoPlanoAluno::create($validated);

        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento registrado com sucesso!');
    }

    public function show(PagamentoPlanoAluno $pagamento): View
    {
        return view('pagamento-plano-alunos.show', ['pagamento' => $pagamento->load('plano.aluno')]);
    }

    public function edit(PagamentoPlanoAluno $pagamento): View
    {
        return view('pagamento-plano-alunos.edit', ['pagamento' => $pagamento->load('plano.aluno')]);
    }

    public function update(Request $request, PagamentoPlanoAluno $pagamento): RedirectResponse
    {
        $validated = $request->validate([
            'metodo_pagamento' => 'required|string|max:255',
            'data'             => 'required|date',
            'status'           => ['required', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        $pagamento->update($validated);

        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function destroy(PagamentoPlanoAluno $pagamento): RedirectResponse
    {
        $pagamento->delete();
        return redirect()->route('pagamento-plano-alunos.index')->with('success', 'Pagamento excluído com sucesso!');
    }
}
