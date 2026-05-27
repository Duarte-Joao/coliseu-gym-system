<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TreinoAluno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TreinoAlunoController extends Controller
{
    /**
     * Exibe a listagem de atribuições de treinos a alunos.
     */
    public function index(Request $request): JsonResponse
    {
        $usuarioId = $request->query('usuario_id');
        $treinoId = $request->query('treino_id');

        $query = TreinoAluno::query()->with(['aluno', 'treino.instrutor.usuario']);

        if ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        }

        if ($treinoId) {
            $query->where('treino_id', $treinoId);
        }

        $atribuicoes = $query->paginate(15);

        return response()->json($atribuicoes);
    }

    /**
     * Atribui um novo treino a um aluno.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'treino_id' => 'required|exists:treinos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'descricao' => 'nullable|string|max:255',
        ]);

        $treinoAluno = TreinoAluno::create($validated);

        return response()->json($treinoAluno->load(['aluno', 'treino']), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de uma atribuição de treino específica.
     */
    public function show(TreinoAluno $treinoAluno): JsonResponse
    {
        return response()->json($treinoAluno->load(['aluno', 'treino.instrutor.usuario']));
    }

    /**
     * Atualiza as informações de atribuição (ex: data fim ao concluir/mudar o treino).
     */
    public function update(Request $request, TreinoAluno $treinoAluno): JsonResponse
    {
        $validated = $request->validate([
            'data_inicio' => 'sometimes|required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'descricao' => 'nullable|string|max:255',
        ]);

        $treinoAluno->update($validated);

        return response()->json($treinoAluno->load(['aluno', 'treino']));
    }

    /**
     * Remove a atribuição de um treino.
     */
    public function destroy(TreinoAluno $treinoAluno): JsonResponse
    {
        $treinoAluno->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
