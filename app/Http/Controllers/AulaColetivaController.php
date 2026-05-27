<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AulaColetivaController extends Controller
{
    /**
     * Exibe a listagem de aulas coletivas.
     */
    public function index(Request $request): JsonResponse
    {
        $instrutorId = $request->query('instrutor_id');
        $modalidade = $request->query('modalidade');
        $status = $request->query('status');

        $query = AulaColetiva::query()->with(['instrutor.usuario', 'reservas']);

        if ($instrutorId) {
            $query->where('instrutor_id', $instrutorId);
        }

        if ($modalidade) {
            $query->where('modalidade', 'like', "%{$modalidade}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $aulas = $query->paginate(15);

        return response()->json($aulas);
    }

    /**
     * Cria uma nova aula coletiva na grade.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'instrutor_id' => 'required|exists:instrutores,id',
            'datahora' => 'required|date_format:Y-m-d H:i:s',
            'vagas' => 'required|integer|min:1',
            'obs' => 'nullable|string',
            'status' => ['nullable', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade' => 'required|string|max:255',
        ]);

        $aula = AulaColetiva::create($validated);

        return response()->json($aula->load('instrutor.usuario'), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de uma aula coletiva específica.
     */
    public function show(AulaColetiva $aulaColetiva): JsonResponse
    {
        return response()->json($aulaColetiva->load(['instrutor.usuario', 'reservas.aluno']));
    }

    /**
     * Atualiza as informações de uma aula coletiva.
     */
    public function update(Request $request, AulaColetiva $aulaColetiva): JsonResponse
    {
        $validated = $request->validate([
            'instrutor_id' => 'sometimes|required|exists:instrutores,id',
            'datahora' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'vagas' => 'sometimes|required|integer|min:1',
            'obs' => 'nullable|string',
            'status' => ['sometimes', 'required', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade' => 'sometimes|required|string|max:255',
        ]);

        $aulaColetiva->update($validated);

        return response()->json($aulaColetiva->load('instrutor.usuario'));
    }

    /**
     * Cancela ou exclui logicamente uma aula coletiva.
     */
    public function destroy(AulaColetiva $aulaColetiva): JsonResponse
    {
        $aulaColetiva->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
