@extends('layouts.gym')
@section('title', 'Editar Atribuição')
@section('content')
<x-page-header title="Editar Atribuição">
  <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>
<div class="form-card">
  <form method="POST" action="{{ route('treino-alunos.update', $atribuicao) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg"><label>Validade</label><input type="date" name="validade" value="{{ old('validade', $atribuicao->validade?->format('Y-m-d')) }}"></div>
      <div class="fg span2"><label>Descrição</label><input type="text" name="descricao" value="{{ old('descricao', $atribuicao->descricao) }}"></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('treino-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
