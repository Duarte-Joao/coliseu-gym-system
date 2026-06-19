@extends('layouts.gym')
@section('title', 'Editar Instrutor')
@section('content')
<x-page-header title="Editar Instrutor" :subtitle="$instrutor->usuario->name ?? ''">
  <a href="{{ route('instrutores.show', $instrutor) }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>

<div class="form-card">
  <form method="POST" action="{{ route('instrutores.update', $instrutor) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg span2">
        <label>Especialidade *</label>
        <input type="text" name="especialidade" value="{{ old('especialidade', $instrutor->especialidade) }}" required>
      </div>
      <div class="fg">
        <label>Salário (R$) *</label>
        <input type="number" name="salario" value="{{ old('salario', $instrutor->salario) }}" min="0" step="0.01" required>
      </div>
      <div class="fg">
        <label>Carga Horária (HH:MM:SS) *</label>
        <input type="text" name="carga_hora" value="{{ old('carga_hora', $instrutor->carga_hora) }}" required>
      </div>
      <div class="fg">
        <label>Turno *</label>
        <select name="turno" required>
          @foreach(['Manhã','Tarde','Noite'] as $t)
            <option value="{{ $t }}" {{ old('turno', $instrutor->turno) === $t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('instrutores.show', $instrutor) }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
