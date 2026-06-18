@extends('layouts.gym')
@section('title', 'Usuários')
@section('content')
<div class="pg-header">
  <div><h1>Usuários</h1><p>Gerencie os usuários do sistema</p></div>
  <a href="{{ route('usuarios.create') }}" class="btn"><i class="ti ti-plus"></i> Novo Usuário</a>
</div>

<form class="filter-bar" method="GET">
  <div class="fg">
    <label>Tipo</label>
    <select name="tipo">
      <option value="">Todos</option>
      @foreach(['aluno','instrutor','admin'] as $t)
        <option value="{{ $t }}" {{ request('tipo') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
      @endforeach
    </select>
  </div>
  <div class="fg">
    <label>Status</label>
    <select name="status">
      <option value="">Todos</option>
      <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
      <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('usuarios.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $usuarios->total() }} usuário(s)</h3></div>
  @if($usuarios->isEmpty())
    <div class="empty"><i class="ti ti-users"></i>Nenhum usuário cadastrado</div>
  @else
  <table>
    <thead><tr><th>Nome</th><th>CPF</th><th>Telefone</th><th>Tipo</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($usuarios as $u)
    <tr>
      <td><strong>{{ $u->name }}</strong><span class="sub">{{ $u->email }}</span></td>
      <td>{{ $u->cpf ?? '—' }}</td>
      <td>{{ $u->numero_telefone ?? '—' }}</td>
      <td><span class="badge b-pur">{{ $u->tipo ?? '—' }}</span></td>
      <td><span class="badge {{ $u->status === 'ativo' ? 'b-ok' : 'b-err' }}">{{ $u->status ?? '—' }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('usuarios.show', $u) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
          <a href="{{ route('usuarios.edit', $u) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('usuarios.destroy', $u) }}" onsubmit="return confirm('Excluir este usuário?')">
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
<div class="pag-wrap">{{ $usuarios->links() }}</div>
@endsection
