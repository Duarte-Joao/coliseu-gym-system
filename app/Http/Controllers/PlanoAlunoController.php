<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PlanoAluno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PlanoAlunoController extends Controller
{
    /**
     * Exibe a listagem de planos contratados pelos alunos.
     */
    public function index(Request $request): JsonResponse
    {
        $usuarioId = $request->query('usuario_id');
        $tipo = $request->query('tipo');

        $query = PlanoAluno::query()->with(['aluno', 'pagamentos']);

        if ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        }

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        $planos = $query->paginate(15);

        return response()->json($planos);
    }

    /**
     * Contrata um novo plano para um aluno.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'tipo' => ['required', 'string', Rule::in(['Mensal', 'Trimestral', 'Semestral', 'Anual'])],
            'valor' => 'required|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
        ]);

        $plano = PlanoAluno::create($validated);

        return response()->json($plano->load('aluno'), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de um plano de aluno específico.
     */
    public function show(PlanoAluno $planoAluno): JsonResponse
    {
        return response()->json($planoAluno->load(['aluno', 'pagamentos']));
    }

    /**
     * Atualiza as informações do contrato de um plano.
     */
    public function update(Request $request, PlanoAluno $planoAluno): JsonResponse
    {
        $validated = $request->validate([
            'tipo' => ['sometimes', 'required', 'string', Rule::in(['Mensal', 'Trimestral', 'Semestral', 'Anual'])],
            'valor' => 'sometimes|required|numeric|min:0',
            'duracao_meses' => 'sometimes|required|integer|min:1',
            'data_inicio' => 'sometimes|required|date',
            'data_fim' => 'sometimes|required|date|after_or_equal:data_inicio',
        ]);

        $planoAluno->update($validated);

        return response()->json($planoAluno->load('aluno'));
    }

    /**
     * Exclui logicamente o contrato de um plano.
     */
    public function destroy(PlanoAluno $planoAluno): JsonResponse
    {
        $planoAluno->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
