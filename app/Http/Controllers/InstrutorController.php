<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instrutor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstrutorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Instrutor::query()->with('usuario');

        if ($request->filled('turno')) {
            $query->where('turno', $request->turno);
        }
        if ($request->filled('especialidade')) {
            $query->where('especialidade', 'like', "%{$request->especialidade}%");
        }

        $instrutores = $query->paginate(15)->withQueryString();

        return view('instrutores.index', compact('instrutores'));
    }

    public function create(): View
    {
        $usuarios = User::whereDoesntHave('instrutor')->where('tipo', 'instrutor')->get();
        return view('instrutores.create', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'usuario_id'    => 'required|exists:users,id|unique:instrutores,usuario_id',
            'especialidade' => 'required|string|max:255',
            'salario'       => 'required|numeric|min:0',
            'carga_hora'    => 'required|date_format:H:i:s',
            'turno'         => ['required', 'string', Rule::in(['Manhã', 'Tarde', 'Noite'])],
        ]);

        Instrutor::create($validated);

        return redirect()->route('instrutores.index')->with('success', 'Instrutor cadastrado com sucesso!');
    }

    public function show(Instrutor $instrutor): View
    {
        return view('instrutores.show', [
            'instrutor' => $instrutor->load(['usuario', 'treinos', 'aulasColetivas']),
        ]);
    }

    public function edit(Instrutor $instrutor): View
    {
        return view('instrutores.edit', compact('instrutor'));
    }

    public function update(Request $request, Instrutor $instrutor): RedirectResponse
    {
        $validated = $request->validate([
            'especialidade' => 'required|string|max:255',
            'salario'       => 'required|numeric|min:0',
            'carga_hora'    => 'required|date_format:H:i:s',
            'turno'         => ['required', 'string', Rule::in(['Manhã', 'Tarde', 'Noite'])],
        ]);

        $instrutor->update($validated);

        return redirect()->route('instrutores.show', $instrutor)->with('success', 'Instrutor atualizado com sucesso!');
    }

    public function destroy(Instrutor $instrutor): RedirectResponse
    {
        $instrutor->delete();
        return redirect()->route('instrutores.index')->with('success', 'Instrutor excluído com sucesso!');
    }
}
