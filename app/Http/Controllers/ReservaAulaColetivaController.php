<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use App\Models\ReservaAulaColetiva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ReservaAulaColetivaController extends Controller
{
    /**
     * Exibe a lista de reservas do sistema.
     */
    public function index(Request $request): JsonResponse
    {
        $aulaColetivaId = $request->query('aula_coletiva_id');
        $usuarioId = $request->query('usuario_id');

        $query = ReservaAulaColetiva::query()->with(['aula', 'aluno']);

        if ($aulaColetivaId) {
            $query->where('aula_coletiva_id', $aulaColetivaId);
        }

        if ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        }

        $reservas = $query->paginate(15);

        return response()->json($reservas);
    }

    /**
     * Efetua a reserva de uma vaga para o aluno em uma aula coletiva.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'aula_coletiva_id' => [
                'required',
                'exists:aulas_coletivas,id',
                // Evita reserva duplicada do mesmo aluno na mesma aula
                Rule::unique('reserva_aula_coletivas')->where(function ($query) use ($request) {
                    return $query->where('usuario_id', $request->input('usuario_id'));
                }),
            ],
            'usuario_id' => 'required|exists:users,id',
            'status' => ['nullable', Rule::in(['confirmada', 'cancelada', 'presenca_confirmada'])],
        ]);

        // Regra de Negócio: Verificar se a aula coletiva ainda possui vagas disponíveis
        $aula = AulaColetiva::withCount('reservas')->findOrFail($validated['aula_coletiva_id']);
        
        // Apenas contar reservas que não estão canceladas
        $reservasAtivasCount = ReservaAulaColetiva::where('aula_coletiva_id', $aula->id)
            ->where('status', '!=', 'cancelada')
            ->count();

        if ($reservasAtivasCount >= $aula->vagas) {
            return response()->json([
                'message' => 'Não há vagas disponíveis para esta aula coletiva.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Regra de Negócio: Impedir reservas em aulas que já foram realizadas ou canceladas
        if ($aula->status !== 'agendada') {
            return response()->json([
                'message' => "Não é possível reservar vagas para uma aula com status '{$aula->status}'.",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $reserva = ReservaAulaColetiva::create($validated);

        return response()->json($reserva->load(['aula', 'aluno']), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de uma reserva específica.
     */
    public function show(ReservaAulaColetiva $reservaAulaColetiva): JsonResponse
    {
        return response()->json($reservaAulaColetiva->load(['aula', 'aluno']));
    }

    /**
     * Atualiza o status da reserva (ex: marcar presença ou cancelar a reserva do aluno).
     */
    public function update(Request $request, ReservaAulaColetiva $reservaAulaColetiva): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['confirmada', 'cancelada', 'presenca_confirmada'])],
        ]);

        $reservaAulaColetiva->update($validated);

        return response()->json($reservaAulaColetiva->load(['aula', 'aluno']));
    }

    /**
     * Exclui fisicamente ou cancela uma reserva.
     */
    public function destroy(ReservaAulaColetiva $reservaAulaColetiva): JsonResponse
    {
        $reservaAulaColetiva->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
