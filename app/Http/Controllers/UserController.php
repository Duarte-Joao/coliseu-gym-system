<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PlanoAluno;
use App\Models\Treino;
use App\Models\TreinoAluno;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $usuarios = $query->paginate(15)->withQueryString();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => 'required|string|min:8',
            'cpf'             => 'required|string|size:14|unique:users',
            'data_nascimento' => 'required|date',
            'rua'             => 'required|string|max:255',
            'numero_rua'      => 'required|integer',
            'cep'             => 'required|string|size:9',
            'numero_telefone' => 'required|string|max:20',
            'status'          => ['required', Rule::in(['ativo', 'inativo'])],
            'tipo'            => ['required', Rule::in(['aluno', 'instrutor', 'admin'])],
        ]);

        $user = User::create($validated);

        // Criação opcional de plano e ficha (formulário do dashboard do instrutor)
        if ($request->filled('plano_tipo')) {
            $duracoes = ['Mensal' => 1, 'Trimestral' => 3, 'Semestral' => 6, 'Anual' => 12];
            $meses = $duracoes[$request->plano_tipo] ?? 1;
            PlanoAluno::create([
                'usuario_id'    => $user->id,
                'tipo'          => $request->plano_tipo,
                'valor'         => 0,
                'duracao_meses' => $meses,
                'data_inicio'   => now()->toDateString(),
                'data_fim'      => now()->addMonths($meses)->toDateString(),
            ]);
        }

        if ($request->filled('treino_id') && Treino::where('id', $request->treino_id)->exists()) {
            TreinoAluno::create([
                'usuario_id'  => $user->id,
                'treino_id'   => $request->treino_id,
                'data_inicio' => now()->toDateString(),
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $usuario): View
    {
        return view('usuarios.show', [
            'usuario' => $usuario->load(['instrutor', 'planoAlunos']),
        ]);
    }

    public function edit(User $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'cpf'             => ['required', 'string', 'size:14', Rule::unique('users')->ignore($usuario->id)],
            'data_nascimento' => 'required|date',
            'rua'             => 'required|string|max:255',
            'numero_rua'      => 'required|integer',
            'cep'             => 'required|string|size:9',
            'numero_telefone' => 'required|string|max:20',
            'status'          => ['required', Rule::in(['ativo', 'inativo'])],
            'tipo'            => ['required', Rule::in(['aluno', 'instrutor', 'admin'])],
        ]);

        $usuario->update($validated);

        return redirect()->route('usuarios.show', $usuario)->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
