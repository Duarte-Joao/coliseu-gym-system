@extends('layouts.gym')
@section('title', 'Plano')
@section('content')
<div class="pg-header">
  <div><h1>Plano {{ $plano->tipo }}</h1><p>{{ $plano->aluno->name ?? '—' }}</p></div>
  <div class="actions">
    <a href="{{ route('plano-alunos.edit', $plano) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('plano-alunos.destroy', $plano) }}" onsubmit="return confirm('Excluir este plano?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>
<div class="detail-card">
  <div class="detail-header"><h2>{{ $plano->tipo }}</h2></div>
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $plano->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Valor</label><span>R$ {{ number_format($plano->valor, 2, ',', '.') }}</span></div>
    <div class="detail-item"><label>Duração</label><span>{{ $plano->duracao_meses }} mês(es)</span></div>
    <div class="detail-item"><label>Início</label><span>{{ $plano->data_inicio?->format('d/m/Y') }}</span></div>
    <div class="detail-item"><label>Fim</label><span>{{ $plano->data_fim?->format('d/m/Y') }}</span></div>
  </div>
</div>
<div class="tbl-wrap">
  <div class="tbl-head">
    <h3>Pagamentos ({{ $plano->pagamentos->count() }})</h3>
    <a href="{{ route('pagamento-plano-alunos.create', ['plano_aluno_id' => $plano->id]) }}" class="btn btn-sm"><i class="ti ti-plus"></i> Registrar</a>
  </div>
  @forelse($plano->pagamentos as $pag)
  <table><tbody>
    <tr>
      <td><strong>{{ $pag->metodo_pagamento }}</strong><span class="sub">{{ $pag->data?->format('d/m/Y') }}</span></td>
      <td><span class="badge {{ $pag->status === 'pago' ? 'b-ok' : ($pag->status === 'cancelado' ? 'b-err' : 'b-warn') }}">{{ $pag->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('pagamento-plano-alunos.edit', $pag) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('pagamento-plano-alunos.destroy', $pag) }}" onsubmit="return confirm('Excluir?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn danger btn-sm"><i class="ti ti-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
  </tbody></table>
  @empty
    <div class="empty"><i class="ti ti-cash"></i>Nenhum pagamento registrado</div>
  @endforelse
</div>
@endsection
