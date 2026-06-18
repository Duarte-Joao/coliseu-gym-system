@extends('layouts.gym')
@section('title', 'Editar Aula Coletiva')
@section('content')
<div class="pg-header">
  <div><h1>Editar Aula</h1><p>{{ $aula->modalidade }}</p></div>
  <a href="{{ route('aulas-coletivas.show', $aula) }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('aulas-coletivas.update', $aula) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg">
        <label>Instrutor *</label>
        <select name="instrutor_id" required>
          @foreach($instrutores as $i)
            <option value="{{ $i->id }}" {{ old('instrutor_id', $aula->instrutor_id) == $i->id ? 'selected' : '' }}>{{ $i->usuario->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Modalidade *</label><input type="text" name="modalidade" value="{{ old('modalidade', $aula->modalidade) }}" required></div>
      <div class="fg"><label>Data e Hora *</label><input type="datetime-local" name="datahora" value="{{ old('datahora', $aula->datahora?->format('Y-m-d\TH:i')) }}" required></div>
      <div class="fg"><label>Vagas *</label><input type="number" name="vagas" value="{{ old('vagas', $aula->vagas) }}" min="1" required></div>
      <div class="fg">
        <label>Status *</label>
        <select name="status" required>
          @foreach(['agendada','realizada','cancelada'] as $s)
            <option value="{{ $s }}" {{ old('status', $aula->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg span2"><label>Observações</label><textarea name="obs">{{ old('obs', $aula->obs) }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('aulas-coletivas.show', $aula) }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
