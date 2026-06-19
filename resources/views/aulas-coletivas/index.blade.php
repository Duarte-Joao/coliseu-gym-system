@extends('layouts.gym')
@section('title', 'Aulas Coletivas')
@section('content')
<x-page-header title="Aulas Coletivas" subtitle="Grade de aulas coletivas">
  <a href="{{ route('aulas-coletivas.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Aula</a>
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
  <div class="fg">
    <label>Status</label>
    <select name="status">
      <option value="">Todos</option>
      @foreach(['agendada','realizada','cancelada'] as $s)
        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $aulas->total() }} aula(s)</h3></div>
  @if($aulas->isEmpty())
    <div class="empty"><i class="ti ti-calendar-event"></i>Nenhuma aula cadastrada</div>
  @else
  <table>
    <thead><tr>
      <th>Modalidade</th>
      @if(!isset($meuInstrutor) || !$meuInstrutor)<th>Instrutor</th>@endif
      <th>Data/Hora</th><th>Vagas</th><th>Ocupado</th><th>Status</th><th></th>
    </tr></thead>
    <tbody>
    @foreach($aulas as $aula)
    <tr>
      <td><strong>{{ $aula->modalidade }}</strong></td>
      @if(!isset($meuInstrutor) || !$meuInstrutor)
        <td>{{ $aula->instrutor->usuario->name ?? '—' }}</td>
      @endif
      <td>{{ $aula->datahora?->format('d/m/Y H:i') }}</td>
      <td>{{ $aula->vagas }}</td>
      <td>{{ $aula->reservas_count }}</td>
      <td><span class="badge {{ $aula->status === 'agendada' ? 'b-ok' : ($aula->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $aula->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('aulas-coletivas.show', $aula) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
          <a href="{{ route('aulas-coletivas.edit', $aula) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('aulas-coletivas.destroy', $aula) }}" onsubmit="return confirm('Excluir esta aula?')">
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
<div class="pag-wrap">{{ $aulas->links() }}</div>
@endsection
