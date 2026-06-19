@extends('layouts.gym')
@section('title', 'Editar Atribuição')
@section('content')
<div class="pg-header">
  <div><h1>Editar Atribuição</h1></div>
  <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('treino-alunos.update', $atribuicao) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg"><label>Data de Início *</label><input type="date" name="data_inicio" value="{{ old('data_inicio', $atribuicao->data_inicio?->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Data de Fim</label><input type="date" name="data_fim" value="{{ old('data_fim', $atribuicao->data_fim?->format('Y-m-d')) }}"></div>
      <div class="fg span2"><label>Descrição</label><input type="text" name="descricao" value="{{ old('descricao', $atribuicao->descricao) }}"></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('treino-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
