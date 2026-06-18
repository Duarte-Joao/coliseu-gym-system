@extends('layouts.gym')
@section('title', 'Editar Reserva')
@section('content')
<div class="pg-header">
  <div><h1>Editar Reserva</h1><p>{{ $reserva->aluno->name ?? '' }} — {{ $reserva->aula->modalidade ?? '' }}</p></div>
  <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('reserva-aulas-coletivas.update', $reserva) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg span2">
        <label>Status *</label>
        <select name="status" required>
          <option value="confirmada" {{ old('status', $reserva->status) === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
          <option value="cancelada" {{ old('status', $reserva->status) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
          <option value="presenca_confirmada" {{ old('status', $reserva->status) === 'presenca_confirmada' ? 'selected' : '' }}>Presença Confirmada</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
