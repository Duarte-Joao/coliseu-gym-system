@extends('layouts.gym')
@section('title', 'Pagamentos')
@section('content')
<div class="pg-header">
  <div><h1>Pagamentos</h1><p>Registros de pagamentos de planos</p></div>
  <a href="{{ route('pagamento-plano-alunos.create') }}" class="btn"><i class="ti ti-plus"></i> Registrar Pagamento</a>
</div>

<form class="filter-bar" method="GET">
  <div class="fg">
    <label>Status</label>
    <select name="status">
      <option value="">Todos</option>
      @foreach(['pago','pendente','cancelado'] as $s)
        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $pagamentos->total() }} pagamento(s)</h3></div>
  @if($pagamentos->isEmpty())
    <div class="empty"><i class="ti ti-cash"></i>Nenhum pagamento registrado</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Plano</th><th>Método</th><th>Data</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($pagamentos as $pag)
    <tr>
      <td>{{ $pag->plano->aluno->name ?? '—' }}</td>
      <td>{{ $pag->plano->tipo ?? '—' }}</td>
      <td>{{ $pag->metodo_pagamento }}</td>
      <td>{{ $pag->data?->format('d/m/Y') }}</td>
      <td><span class="badge {{ $pag->status === 'pago' ? 'b-ok' : ($pag->status === 'cancelado' ? 'b-err' : 'b-warn') }}">{{ $pag->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('pagamento-plano-alunos.edit', $pag) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('pagamento-plano-alunos.destroy', $pag) }}" onsubmit="return confirm('Excluir este pagamento?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn danger btn-sm"><i class="ti ti-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @endif
</div>
<div class="pag-wrap">{{ $pagamentos->links() }}</div>
@endsection
