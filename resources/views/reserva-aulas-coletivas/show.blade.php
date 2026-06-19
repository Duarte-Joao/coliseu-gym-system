@extends('layouts.gym')
@section('title', 'Reserva')
@section('content')
<div class="pg-header">
  <div><h1>Reserva</h1><p>{{ $reserva->aluno->name ?? '' }} — {{ $reserva->aula->modalidade ?? '' }}</p></div>
  <div class="actions">
    <a href="{{ route('reserva-aulas-coletivas.edit', $reserva) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('reserva-aulas-coletivas.destroy', $reserva) }}" onsubmit="return confirm('Cancelar reserva?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>
<div class="detail-card">
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $reserva->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Aula</label><span>{{ $reserva->aula->modalidade ?? '—' }}</span></div>
    <div class="detail-item"><label>Data/Hora</label><span>{{ $reserva->aula->datahora?->format('d/m/Y H:i') ?? '—' }}</span></div>
    <div class="detail-item"><label>Instrutor</label><span>{{ $reserva->aula->instrutor->usuario->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Status</label>
      <span class="badge {{ $reserva->status === 'presenca_confirmada' ? 'b-ok' : ($reserva->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $reserva->status }}</span>
    </div>
  </div>
</div>
@endsection
