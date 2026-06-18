@extends('layouts.gym')
@section('title', 'Pagamento')
@section('content')
<div class="pg-header">
  <div><h1>Pagamento</h1><p>{{ $pagamento->plano->aluno->name ?? '' }}</p></div>
  <div class="actions">
    <a href="{{ route('pagamento-plano-alunos.edit', $pagamento) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('pagamento-plano-alunos.destroy', $pagamento) }}" onsubmit="return confirm('Excluir pagamento?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>
<div class="detail-card">
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $pagamento->plano->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Plano</label><span>{{ $pagamento->plano->tipo ?? '—' }}</span></div>
    <div class="detail-item"><label>Método</label><span>{{ $pagamento->metodo_pagamento }}</span></div>
    <div class="detail-item"><label>Data</label><span>{{ $pagamento->data?->format('d/m/Y') }}</span></div>
    <div class="detail-item"><label>Status</label>
      <span class="badge {{ $pagamento->status === 'pago' ? 'b-ok' : ($pagamento->status === 'cancelado' ? 'b-err' : 'b-warn') }}">{{ $pagamento->status }}</span>
    </div>
  </div>
</div>
@endsection
