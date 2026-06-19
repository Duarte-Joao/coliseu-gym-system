@extends('layouts.gym')
@section('title', 'Treinos')
@section('content')
<x-page-header title="Treinos" subtitle="Gerencie os templates de treino">
  <a href="{{ route('treinos.create') }}" class="btn"><i class="ti ti-plus"></i> Novo Treino</a>
</x-page-header>

<form class="filter-bar" method="GET">
  @if(!isset($meuInstrutor) || !$meuInstrutor)
  <div class="fg">
    <label>Instrutor</label>
    <select name="instrutor_id">
      <option value="">Todos</option>
      @foreach($instrutores as $i)
        <option value="{{ $i->id }}" {{ request('instrutor_id') == $i->id ? 'selected' : '' }}>{{ $i->usuario->name }}</option>
      @endforeach
    </select>
  </div>
  @endif
  <div class="fg" style="flex:2;min-width:180px">
    <label>Nome</label>
    <input type="text" name="nome" value="{{ request('nome') }}" placeholder="Buscar por nome...">
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('treinos.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $treinos->total() }} treino(s)</h3></div>
  @if($treinos->isEmpty())
    <div class="empty"><i class="ti ti-barbell"></i>Nenhum treino cadastrado</div>
  @else
  <table>
    <thead><tr>
      <th>Nome</th>
      @if(!isset($meuInstrutor) || !$meuInstrutor)<th>Instrutor</th>@endif
      <th>Exercícios</th><th>Criado em</th><th></th>
    </tr></thead>
    <tbody>
    @foreach($treinos as $treino)
    <tr>
      <td><strong>{{ $treino->nome }}</strong>@if($treino->descricao)<span class="sub">{{ Str::limit($treino->descricao, 60) }}</span>@endif</td>
      @if(!isset($meuInstrutor) || !$meuInstrutor)
        <td>{{ $treino->instrutor->usuario->name ?? '—' }}</td>
      @endif
      <td><span class="badge b-pur">{{ count($treino->exercicios ?? []) }} exerc.</span></td>
      <td>{{ $treino->created_at->format('d/m/Y') }}</td>
      <td>
        <div class="actions">
          <a href="{{ route('treinos.show', $treino) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
          <a href="{{ route('treinos.edit', $treino) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('treinos.destroy', $treino) }}" onsubmit="return confirm('Excluir este treino?')">
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
<div class="pag-wrap">{{ $treinos->links() }}</div>
@endsection
