@extends('layouts.gym')
@section('title', 'Nova Reserva')
@section('content')
<div class="pg-header">
  <div><h1>Nova Reserva</h1></div>
  <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('reserva-aulas-coletivas.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg span2">
        <label>Aula Coletiva *</label>
        <select name="aula_coletiva_id" required>
          <option value="">Selecione...</option>
          @foreach($aulas as $a)
            <option value="{{ $a->id }}" {{ old('aula_coletiva_id', $aulaSelecionada?->id) == $a->id ? 'selected' : '' }}>
              {{ $a->modalidade }} — {{ $a->datahora?->format('d/m/Y H:i') }} ({{ $a->instrutor->usuario->name ?? '?' }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="fg span2">
        <label>Aluno *</label>
        <select name="usuario_id" required>
          <option value="">Selecione...</option>
          @foreach($usuarios as $u)
            <option value="{{ $u->id }}" {{ old('usuario_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Status</label>
        <select name="status">
          <option value="confirmada" {{ old('status','confirmada') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
          <option value="cancelada" {{ old('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
          <option value="presenca_confirmada" {{ old('status') === 'presenca_confirmada' ? 'selected' : '' }}>Presença Confirmada</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Reservar</button>
      <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
