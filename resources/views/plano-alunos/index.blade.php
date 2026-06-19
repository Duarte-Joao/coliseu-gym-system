@extends('layouts.gym')
@section('title', 'Planos')
@section('content')
<x-page-header title="Planos" subtitle="Planos contratados pelos alunos">
  <a href="{{ route('plano-alunos.create') }}" class="btn"><i class="ti ti-plus"></i> Novo Plano</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg" style="flex:2;min-width:200px">
    <label>Buscar aluno</label>
    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do aluno...">
  </div>
  <div class="fg">
    <label>Tipo de plano</label>
    <select name="tipo">
      <option value="">Todos</option>
      @foreach(['Mensal','Trimestral','Semestral','Anual'] as $t)
        <option value="{{ $t }}" {{ request('tipo') === $t ? 'selected' : '' }}>{{ $t }}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('plano-alunos.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $planos->total() }} plano(s)</h3></div>
  @if($planos->isEmpty())
    <div class="empty"><i class="ti ti-id-badge-2"></i>Nenhum plano encontrado</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Tipo</th><th>Valor</th><th>Duração</th><th>Início</th><th>Fim</th><th>Pagamentos</th><th></th></tr></thead>
    <tbody>
    @foreach($planos as $plano)
    <tr>
      <td><strong>{{ $plano->aluno->name ?? '—' }}</strong></td>
      <td><span class="badge b-pur">{{ $plano->tipo }}</span></td>
      <td>R$ {{ number_format($plano->valor, 2, ',', '.') }}</td>
      <td>{{ $plano->duracao_meses }} mês(es)</td>
      <td>{{ $plano->data_inicio?->format('d/m/Y') }}</td>
      <td>{{ $plano->data_fim?->format('d/m/Y') }}</td>
      <td><span class="badge b-ok">{{ $plano->pagamentos->count() }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('plano-alunos.show', $plano) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
          <a href="{{ route('plano-alunos.edit', $plano) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('plano-alunos.destroy', $plano) }}" onsubmit="return confirm('Excluir este plano?')">
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
<div class="pag-wrap">{{ $planos->links() }}</div>
@endsection
