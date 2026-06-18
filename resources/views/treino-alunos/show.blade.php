@extends('layouts.gym')
@section('title', 'Atribuição de Treino')
@section('content')
<div class="pg-header">
  <div><h1>Atribuição de Treino</h1><p>{{ $atribuicao->aluno->name ?? '' }}</p></div>
  <div class="actions">
    <a href="{{ route('treino-alunos.edit', $atribuicao) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('treino-alunos.destroy', $atribuicao) }}" onsubmit="return confirm('Remover atribuição?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>
<div class="detail-card">
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $atribuicao->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Treino</label><span>{{ $atribuicao->treino->nome ?? '—' }}</span></div>
    <div class="detail-item"><label>Instrutor</label><span>{{ $atribuicao->treino->instrutor->usuario->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Início</label><span>{{ $atribuicao->data_inicio?->format('d/m/Y') }}</span></div>
    <div class="detail-item"><label>Fim</label><span>{{ $atribuicao->data_fim?->format('d/m/Y') ?? 'Indefinido' }}</span></div>
    @if($atribuicao->descricao)<div class="detail-item" style="grid-column:span 2"><label>Descrição</label><span>{{ $atribuicao->descricao }}</span></div>@endif
  </div>
</div>
@endsection
