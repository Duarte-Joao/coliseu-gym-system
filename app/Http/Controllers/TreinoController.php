<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Treino;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TreinoController extends Controller
{
    /**
     * Exibe a listagem de templates de treino.
     */ 
    public function index(Request $request): JsonResponse
    {
        $instrutorId = $request->query('instrutor_id');
        $nome = $request->query('nome');

        $query = Treino::query()->with('instrutor.usuario');

        if ($instrutorId) {
            $query->where('instrutor_id', $instrutorId);
        }

        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }

        $treinos = $query->paginate(15);

        return response()->json($treinos);
    }

        public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'instrutor_id' => 'required|exists:instrutores,id',
            'nome' => 'required|string|max:255',
            'obs' => 'nullable|string',
            'exercicios' => 'required|array',
            'exercicios.*.nome' => 'required|string|max:255',
            'exercicios.*.series' => 'required|integer|min:1',
            'exercicios.*.repeticoes' => 'required|integer|min:1',
            'exercicios.*.carga' => 'required|numeric|min:0',
        ]);

        $treino = Treino::create($validated);

        return response()->json($treino->load('instrutor.usuario'), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de um treino.
     */
    public function show(Treino $treino): JsonResponse
    {
        return response()->json($treino->load(['instrutor.usuario', 'treinoAlunos.aluno']));
    }

    /**
     * Atualiza as informações de um treino.
     */
    public function update(Request $request, Treino $treino): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'obs' => 'nullable|string',
            'exercicios' => 'sometimes|required|array',
            'exercicios.*.nome' => 'sometimes|required|string|max:255',
            'exercicios.*.series' => 'sometimes|required|integer|min:1',
            'exercicios.*.repeticoes' => 'sometimes|required|integer|min:1',
            'exercicios.*.carga' => 'sometimes|required|numeric|min:0',
        ]);

        $treino->update($validated);

        return response()->json($treino->load('instrutor.usuario'));
    }

    /**
     * Exclui logicamente um treino.
     */
    public function destroy(Treino $treino): JsonResponse
    {
        $treino->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
