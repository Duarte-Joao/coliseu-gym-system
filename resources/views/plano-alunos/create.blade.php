@extends('layouts.gym')
@section('title', 'Novo Plano')
@section('content')
<div class="pg-header">
  <div><h1>Novo Plano</h1><p>Contratar plano para um aluno</p></div>
  <a href="{{ route('plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('plano-alunos.store') }}">
    @csrf
    <div class="form-grid">
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
        <label>Tipo *</label>
        <select name="tipo" required>
          @foreach(['Mensal','Trimestral','Semestral','Anual'] as $t)
            <option value="{{ $t }}" {{ old('tipo') === $t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Valor (R$) *</label><input type="number" name="valor" value="{{ old('valor') }}" min="0" step="0.01" required></div>
      <div class="fg"><label>Duração (meses) *</label><input type="number" name="duracao_meses" value="{{ old('duracao_meses') }}" min="1" required></div>
      <div class="fg"><label>Data de Início *</label><input type="date" name="data_inicio" value="{{ old('data_inicio') }}" required></div>
      <div class="fg"><label>Data de Fim *</label><input type="date" name="data_fim" value="{{ old('data_fim') }}" required></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Salvar</button>
      <a href="{{ route('plano-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
