@extends('layouts.gym')
@section('title', 'Instrutores')
@section('content')
<x-page-header title="Instrutores" subtitle="Gerencie os instrutores da academia">
  <a href="{{ route('instrutores.create') }}" class="btn"><i class="ti ti-plus"></i> Novo Instrutor</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg">
    <label>Turno</label>
    <select name="turno">
      <option value="">Todos</option>
      <option value="Manhã" {{ request('turno') === 'Manhã' ? 'selected' : '' }}>Manhã</option>
      <option value="Tarde" {{ request('turno') === 'Tarde' ? 'selected' : '' }}>Tarde</option>
      <option value="Noite" {{ request('turno') === 'Noite' ? 'selected' : '' }}>Noite</option>
    </select>
  </div>
  <div class="fg">
    <label>Especialidade</label>
    <input type="text" name="especialidade" value="{{ request('especialidade') }}" placeholder="Buscar...">
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('instrutores.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $instrutores->total() }} instrutor(es)</h3></div>
  @if($instrutores->isEmpty())
    <div class="empty"><i class="ti ti-user-star"></i>Nenhum instrutor cadastrado</div>
  @else
  <table>
    <thead><tr><th>Nome</th><th>Especialidade</th><th>Turno</th><th>Salário</th><th>Carga Horária</th><th></th></tr></thead>
    <tbody>
    @foreach($instrutores as $instrutor)
    <tr>
      <td><strong>{{ $instrutor->usuario->name ?? '—' }}</strong><span class="sub">{{ $instrutor->usuario->email ?? '' }}</span></td>
      <td>{{ $instrutor->especialidade }}</td>
      <td><span class="badge b-pur">{{ $instrutor->turno }}</span></td>
      <td>R$ {{ number_format($instrutor->salario, 2, ',', '.') }}</td>
      <td>{{ $instrutor->carga_hora }}</td>
      <td>
        <div class="actions">
          <a href="{{ route('instrutores.show', $instrutor) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
          <a href="{{ route('instrutores.edit', $instrutor) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('instrutores.destroy', $instrutor) }}" onsubmit="return confirm('Excluir este instrutor?')">
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
<div class="pag-wrap">{{ $instrutores->links() }}</div>
@endsection
