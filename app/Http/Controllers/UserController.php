<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Exibe a listagem de usuários do sistema.
     */
    public function index(Request $request): JsonResponse
    {
        $tipo = $request->query('tipo');
        $status = $request->query('status');

        $query = User::query();

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $usuarios = $query->paginate(15);

        return response()->json($usuarios);
    }

    /**
     * Armazena um novo usuário.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'cpf' => 'required|string|size:14|unique:users',
            'data_nascimento' => 'required|date',
            'rua' => 'required|string|max:255',
            'numero_rua' => 'required|integer',
            'cep' => 'required|string|size:9',
            'numero_telefone' => 'required|string|max:20',
            'status' => ['nullable', Rule::in(['ativo', 'inativo'])],
            'tipo' => ['nullable', Rule::in(['aluno', 'instrutor', 'admin'])],
        ]);

        $usuario = User::create($validated);

        return response()->json($usuario, Response::HTTP_CREATED);
    }

    /**
     * Exibe os detalhes de um usuário específico.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user->load(['instrutor', 'planoAlunos']));
    }

    /**
     * Atualiza os dados de um usuário existente.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'cpf' => ['sometimes', 'required', 'string', 'size:14', Rule::unique('users')->ignore($user->id)],
            'data_nascimento' => 'sometimes|required|date',
            'rua' => 'sometimes|required|string|max:255',
            'numero_rua' => 'sometimes|required|integer',
            'cep' => 'sometimes|required|string|size:9',
            'numero_telefone' => 'sometimes|required|string|max:20',
            'status' => ['nullable', Rule::in(['ativo', 'inativo'])],
            'tipo' => ['nullable', Rule::in(['aluno', 'instrutor', 'admin'])],
        ]);

        if (!isset($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    /**
     * Remove (exclui logicamente) um usuário do sistema.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
