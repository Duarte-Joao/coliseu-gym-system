<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PagamentoPlanoAluno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PagamentoPlanoAlunoController extends Controller
{
    /**
     * Exibe a listagem de pagamentos.
     */
    public function index(Request $request): JsonResponse
    {
        $planoAlunoId = $request->query('plano_aluno_id');
        $status = $request->query('status');

        $query = PagamentoPlanoAluno::query()->with('plano.aluno');

        if ($planoAlunoId) {
            $query->where('plano_aluno_id', $planoAlunoId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $pagamentos = $query->paginate(15);

        return response()->json($pagamentos);
    }

    /**
     * Lança um novo registro de pagamento/parcela.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plano_aluno_id' => 'required|exists:plano_alunos,id',
            'metodo_pagamento' => 'required|string|max:255',
            'data' => 'required|date',
            'status' => ['nullable', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        $pagamento = PagamentoPlanoAluno::create($validated);

        return response()->json($pagamento->load('plano.aluno'), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de um pagamento específico.
     */
    public function show(PagamentoPlanoAluno $pagamentoPlanoAluno): JsonResponse
    {
        return response()->json($pagamentoPlanoAluno->load('plano.aluno'));
    }

    /**
     * Atualiza as informações do pagamento (ex: marcar de pendente para pago ao liquidar).
     */
    public function update(Request $request, PagamentoPlanoAluno $pagamentoPlanoAluno): JsonResponse
    {
        $validated = $request->validate([
            'metodo_pagamento' => 'sometimes|required|string|max:255',
            'data' => 'sometimes|required|date',
            'status' => ['sometimes', 'required', Rule::in(['pago', 'pendente', 'cancelado'])],
        ]);

        $pagamentoPlanoAluno->update($validated);

        return response()->json($pagamentoPlanoAluno->load('plano.aluno'));
    }

    /**
     * Remove um lançamento de pagamento.
     */
    public function destroy(PagamentoPlanoAluno $pagamentoPlanoAluno): JsonResponse
    {
        $pagamentoPlanoAluno->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
