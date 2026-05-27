<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class InstrutorController extends Controller
{
    /**
     * Exibe a lista de instrutores cadastrados.
     */
    public function index(Request $request): JsonResponse
    {
        $turno = $request->query('turno');
        $especialidade = $request->query('especialidade');

        $query = Instrutor::query()->with('usuario');

        if ($turno) {
            $query->where('turno', $turno);
        }

        if ($especialidade) {
            $query->where('especialidade', 'like', "%{$especialidade}%");
        }

        $instrutores = $query->paginate(15);

        return response()->json($instrutores);
    }

    /**
     * Cadastra um novo perfil de instrutor.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id|unique:instrutores,usuario_id',
            'especialidade' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0',
            'carga_hora' => 'required|date_format:H:i:s',
            'turno' => ['required', 'string', Rule::in(['Manhã', 'Tarde', 'Noite'])],
        ]);

        $instrutor = Instrutor::create($validated);

        return response()->json($instrutor->load('usuario'), Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de um instrutor específico.
     */
    public function show(Instrutor $instrutor): JsonResponse
    {
        return response()->json($instrutor->load(['usuario', 'treinos', 'aulasColetivas']));
    }

    /**
     * Atualiza as informações do instrutor.
     */
    public function update(Request $request, Instrutor $instrutor): JsonResponse
    {
        $validated = $request->validate([
            'especialidade' => 'sometimes|required|string|max:255',
            'salario' => 'sometimes|required|numeric|min:0',
            'carga_hora' => 'sometimes|required|date_format:H:i:s',
            'turno' => ['sometimes', 'required', 'string', Rule::in(['Manhã', 'Tarde', 'Noite'])],
        ]);

        $instrutor->update($validated);

        return response()->json($instrutor->load('usuario'));
    }

    /**
     * Exclui logicamente o perfil de um instrutor.
     */
    public function destroy(Instrutor $instrutor): JsonResponse
    {
        $instrutor->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
