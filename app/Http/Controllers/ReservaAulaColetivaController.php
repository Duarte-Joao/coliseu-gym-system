<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AulaColetiva;
use App\Models\ReservaAulaColetiva;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservaAulaColetivaController extends Controller
{
    public function index(Request $request): View
    {
        $query = ReservaAulaColetiva::query()->with(['aula', 'aluno']);

        if ($request->filled('busca')) {
            $query->where(fn($q) => $q
                ->whereHas('aluno', fn($q2) => $q2->where('name', 'like', "%{$request->busca}%"))
                ->orWhereHas('aula', fn($q2) => $q2->where('modalidade', 'like', "%{$request->busca}%")));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservas = $query->paginate(15)->withQueryString();

        return view('reserva-aulas-coletivas.index', compact('reservas'));
    }

    public function create(Request $request): View
    {
        $aulas   = AulaColetiva::where('status', 'agendada')->with('instrutor.usuario')->get();
        $usuarios = User::where('tipo', 'aluno')->orWhereNull('tipo')->get();
        $aulaSelecionada = $request->filled('aula_coletiva_id')
            ? AulaColetiva::find($request->aula_coletiva_id)
            : null;

        return view('reserva-aulas-coletivas.create', compact('aulas', 'usuarios', 'aulaSelecionada'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aula_coletiva_id' => [
                'required',
                'exists:aulas_coletivas,id',
                Rule::unique('reserva_aula_coletivas')->where(fn ($q) => $q->where('usuario_id', $request->usuario_id)),
            ],
            'usuario_id' => 'required|exists:users,id',
            'status'     => ['nullable', Rule::in(['confirmada', 'cancelada', 'presenca_confirmada'])],
        ]);

        $aula = AulaColetiva::findOrFail($validated['aula_coletiva_id']);

        $ocupadas = ReservaAulaColetiva::where('aula_coletiva_id', $aula->id)
            ->where('status', '!=', 'cancelada')
            ->count();

        if ($ocupadas >= $aula->vagas) {
            return back()->withErrors(['aula_coletiva_id' => 'Não há vagas disponíveis para esta aula.'])->withInput();
        }

        if ($aula->status !== 'agendada') {
            return back()->withErrors(['aula_coletiva_id' => "Não é possível reservar uma aula com status '{$aula->status}'."]) ->withInput();
        }

        ReservaAulaColetiva::create($validated);

        $from = $request->input('_from');
        $redirect = $from === 'aluno-dashboard'
            ? redirect()->route('dashboard.aluno')
            : redirect()->route('reserva-aulas-coletivas.index');

        return $redirect->with('success', 'Reserva realizada com sucesso!');
    }

    public function show(ReservaAulaColetiva $reserva): View
    {
        return view('reserva-aulas-coletivas.show', ['reserva' => $reserva->load(['aula', 'aluno'])]);
    }

    public function edit(ReservaAulaColetiva $reserva): View
    {
        return view('reserva-aulas-coletivas.edit', ['reserva' => $reserva->load(['aula', 'aluno'])]);
    }

    public function update(Request $request, ReservaAulaColetiva $reserva): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['confirmada', 'cancelada', 'presenca_confirmada'])],
        ]);

        $reserva->update($validated);

        return redirect()->route('reserva-aulas-coletivas.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(ReservaAulaColetiva $reserva): RedirectResponse
    {
        $reserva->delete();
        return redirect()->route('reserva-aulas-coletivas.index')->with('success', 'Reserva cancelada com sucesso!');
    }
}
