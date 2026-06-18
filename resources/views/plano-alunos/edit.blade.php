@extends('layouts.gym')
@section('title', 'Editar Plano')
@section('content')
<div class="pg-header">
  <div><h1>Editar Plano</h1><p>{{ $plano->aluno->name ?? '' }} — {{ $plano->tipo }}</p></div>
  <a href="{{ route('plano-alunos.show', $plano) }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('plano-alunos.update', $plano) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg">
        <label>Tipo *</label>
        <select name="tipo" required>
          @foreach(['Mensal','Trimestral','Semestral','Anual'] as $t)
            <option value="{{ $t }}" {{ old('tipo', $plano->tipo) === $t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Valor (R$) *</label><input type="number" name="valor" value="{{ old('valor', $plano->valor) }}" min="0" step="0.01" required></div>
      <div class="fg"><label>Duração (meses) *</label><input type="number" name="duracao_meses" value="{{ old('duracao_meses', $plano->duracao_meses) }}" min="1" required></div>
      <div class="fg"><label>Data de Início *</label><input type="date" name="data_inicio" value="{{ old('data_inicio', $plano->data_inicio?->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Data de Fim *</label><input type="date" name="data_fim" value="{{ old('data_fim', $plano->data_fim?->format('Y-m-d')) }}" required></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('plano-alunos.show', $plano) }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
