@extends('layouts.gym')
@section('title', 'Reservas')
@section('content')
<x-page-header title="Reservas" subtitle="Reservas em aulas coletivas">
  <a href="{{ route('reserva-aulas-coletivas.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Reserva</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg" style="flex:2;min-width:200px">
    <label>Buscar</label>
    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Aluno ou modalidade...">
  </div>
  <div class="fg">
    <label>Status</label>
    <select name="status">
      <option value="">Todos</option>
      <option value="confirmada" {{ request('status') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
      <option value="presenca_confirmada" {{ request('status') === 'presenca_confirmada' ? 'selected' : '' }}>Presença confirmada</option>
      <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('reserva-aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $reservas->total() }} reserva(s)</h3></div>
  @if($reservas->isEmpty())
    <div class="empty"><i class="ti ti-ticket"></i>Nenhuma reserva encontrada</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Aula</th><th>Data</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($reservas as $r)
    <tr>
      <td><strong>{{ $r->aluno->name ?? '—' }}</strong></td>
      <td>{{ $r->aula->modalidade ?? '—' }}</td>
      <td>{{ $r->aula->datahora?->format('d/m/Y H:i') ?? '—' }}</td>
      <td><span class="badge {{ $r->status === 'presenca_confirmada' ? 'b-ok' : ($r->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $r->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('reserva-aulas-coletivas.edit', $r) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('reserva-aulas-coletivas.destroy', $r) }}" onsubmit="return confirm('Cancelar esta reserva?')">
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
<div class="pag-wrap">{{ $reservas->links() }}</div>
@endsection
