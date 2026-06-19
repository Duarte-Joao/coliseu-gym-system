@extends('layouts.gym')
@section('title', 'Atribuição de Treino')
@section('content')
<x-page-header title="Atribuição de Treino" :subtitle="$atribuicao->aluno->name ?? ''">
  <div class="actions">
    <a href="{{ route('treino-alunos.edit', $atribuicao) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('treino-alunos.destroy', $atribuicao) }}" onsubmit="return confirm('Remover atribuição?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</x-page-header>
<div class="detail-card">
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $atribuicao->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Treino</label><span>{{ $atribuicao->treino->nome ?? '—' }}</span></div>
    <div class="detail-item"><label>Instrutor</label><span>{{ $atribuicao->treino->instrutor->usuario->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Validade</label><span>{{ $atribuicao->validade?->format('d/m/Y') ?? '—' }}</span></div>
    @if($atribuicao->descricao)<div class="detail-item" style="grid-column:span 2"><label>Descrição</label><span>{{ $atribuicao->descricao }}</span></div>@endif
  </div>
</div>
@endsection
