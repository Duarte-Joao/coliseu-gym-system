<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use App\Models\Instrutor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AulaColetivaController extends Controller
{
    public function index(Request $request): View
    {
        $query = AulaColetiva::query()->with(['instrutor.usuario'])->withCount('reservas');

        if ($request->filled('instrutor_id')) {
            $query->where('instrutor_id', $request->instrutor_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aulas = $query->paginate(15)->withQueryString();
        $instrutores = Instrutor::with('usuario')->get();

        return view('aulas-coletivas.index', compact('aulas', 'instrutores'));
    }

    public function create(): View
    {
        $instrutores = Instrutor::with('usuario')->get();
        return view('aulas-coletivas.create', compact('instrutores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instrutor_id' => 'required|exists:instrutores,id',
            'datahora'     => 'required|date',
            'vagas'        => 'required|integer|min:1',
            'obs'          => 'nullable|string',
            'status'       => ['nullable', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade'   => 'required|string|max:255',
        ]);

        $validated['datahora'] = str_replace('T', ' ', $validated['datahora']);
        $validated['status'] = $validated['status'] ?? 'agendada';

        AulaColetiva::create($validated);

        return redirect()->route('aulas-coletivas.index')->with('success', 'Aula coletiva criada com sucesso!');
    }

    public function show(AulaColetiva $aula): View
    {
        return view('aulas-coletivas.show', [
            'aula' => $aula->load(['instrutor.usuario', 'reservas.aluno']),
        ]);
    }

    public function edit(AulaColetiva $aula): View
    {
        $instrutores = Instrutor::with('usuario')->get();
        return view('aulas-coletivas.edit', compact('aula', 'instrutores'));
    }

    public function update(Request $request, AulaColetiva $aula): RedirectResponse
    {
        $validated = $request->validate([
            'instrutor_id' => 'required|exists:instrutores,id',
            'datahora'     => 'required|date',
            'vagas'        => 'required|integer|min:1',
            'obs'          => 'nullable|string',
            'status'       => ['required', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade'   => 'required|string|max:255',
        ]);

        $validated['datahora'] = str_replace('T', ' ', $validated['datahora']);

        $aula->update($validated);

        return redirect()->route('aulas-coletivas.show', $aula)->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(AulaColetiva $aula): RedirectResponse
    {
        $aula->delete();
        return redirect()->route('aulas-coletivas.index')->with('success', 'Aula excluída com sucesso!');
    }
}
