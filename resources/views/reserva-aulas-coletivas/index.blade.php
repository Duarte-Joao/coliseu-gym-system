@extends('layouts.gym')
@section('title', 'Reservas')
@section('content')
<div class="pg-header">
  <div><h1>Reservas</h1><p>Reservas em aulas coletivas</p></div>
  <a href="{{ route('reserva-aulas-coletivas.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Reserva</a>
</div>
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
