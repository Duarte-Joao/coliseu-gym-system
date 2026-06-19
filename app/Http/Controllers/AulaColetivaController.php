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
    private function instrutorAtual(): ?Instrutor
    {
        if (auth()->user()->tipo !== 'instrutor') return null;
        return Instrutor::where('usuario_id', auth()->id())->first();
    }

    public function index(Request $request): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $query = AulaColetiva::query()->with(['instrutor.usuario'])->withCount('reservas');

        if ($meuInstrutor) {
            $query->where('instrutor_id', $meuInstrutor->id);
        } else {
            if ($request->filled('instrutor_id')) {
                $query->where('instrutor_id', $request->instrutor_id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aulas       = $query->paginate(15)->withQueryString();
        $instrutores = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('aulas-coletivas.index', compact('aulas', 'instrutores', 'meuInstrutor'));
    }

    public function create(): View
    {
        $meuInstrutor = $this->instrutorAtual();
        $instrutores  = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('aulas-coletivas.create', compact('instrutores', 'meuInstrutor'));
    }

    public function store(Request $request): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();

        $validated = $request->validate([
            'instrutor_id' => $meuInstrutor ? 'nullable' : 'required|exists:instrutores,id',
            'datahora'     => 'required|date',
            'vagas'        => 'required|integer|min:1',
            'obs'          => 'nullable|string',
            'status'       => ['nullable', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade'   => 'required|string|max:255',
        ]);

        if ($meuInstrutor) {
            $validated['instrutor_id'] = $meuInstrutor->id;
        }

        $validated['datahora'] = str_replace('T', ' ', $validated['datahora']);
        $validated['status']   = $validated['status'] ?? 'agendada';

        AulaColetiva::create($validated);

        return redirect()->route('aulas-coletivas.index')->with('success', 'Aula coletiva criada com sucesso!');
    }

    public function show(AulaColetiva $aula): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $aula->instrutor_id !== $meuInstrutor->id) abort(403);

        return view('aulas-coletivas.show', [
            'aula' => $aula->load(['instrutor.usuario', 'reservas.aluno']),
        ]);
    }

    public function edit(AulaColetiva $aula): View
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $aula->instrutor_id !== $meuInstrutor->id) abort(403);

        $instrutores = $meuInstrutor ? collect() : Instrutor::with('usuario')->get();

        return view('aulas-coletivas.edit', compact('aula', 'instrutores', 'meuInstrutor'));
    }

    public function update(Request $request, AulaColetiva $aula): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $aula->instrutor_id !== $meuInstrutor->id) abort(403);

        $validated = $request->validate([
            'datahora'   => 'required|date',
            'vagas'      => 'required|integer|min:1',
            'obs'        => 'nullable|string',
            'status'     => ['required', Rule::in(['agendada', 'cancelada', 'realizada'])],
            'modalidade' => 'required|string|max:255',
        ]);

        $validated['datahora'] = str_replace('T', ' ', $validated['datahora']);

        $aula->update($validated);

        return redirect()->route('aulas-coletivas.show', $aula)->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(AulaColetiva $aula): RedirectResponse
    {
        $meuInstrutor = $this->instrutorAtual();
        if ($meuInstrutor && $aula->instrutor_id !== $meuInstrutor->id) abort(403);

        $aula->delete();

        return redirect()->route('aulas-coletivas.index')->with('success', 'Aula excluída com sucesso!');
    }
}
