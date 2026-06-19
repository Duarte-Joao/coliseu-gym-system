@extends('layouts.gym')
@section('title', $aula->modalidade)
@section('content')
<x-page-header :title="$aula->modalidade" :subtitle="$aula->datahora?->format('d/m/Y H:i')">
  <div class="actions">
    <a href="{{ route('aulas-coletivas.edit', $aula) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('aulas-coletivas.destroy', $aula) }}" onsubmit="return confirm('Excluir esta aula?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</x-page-header>
<div class="detail-card">
  <div class="detail-header">
    <h2>{{ $aula->modalidade }}</h2>
    <span class="badge {{ $aula->status === 'agendada' ? 'b-ok' : ($aula->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $aula->status }}</span>
  </div>
  <div class="detail-grid">
    <div class="detail-item"><label>Instrutor</label><span>{{ $aula->instrutor->usuario->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Data/Hora</label><span>{{ $aula->datahora?->format('d/m/Y H:i') }}</span></div>
    <div class="detail-item"><label>Vagas</label><span>{{ $aula->vagas }}</span></div>
    <div class="detail-item"><label>Reservas ativas</label><span>{{ $aula->reservas->where('status','!=','cancelada')->count() }}</span></div>
    @if($aula->obs)<div class="detail-item" style="grid-column:span 2"><label>Obs</label><span>{{ $aula->obs }}</span></div>@endif
  </div>
</div>
<div class="tbl-wrap">
  <div class="tbl-head">
    <h3>Reservas ({{ $aula->reservas->count() }})</h3>
    <a href="{{ route('reserva-aulas-coletivas.create', ['aula_coletiva_id' => $aula->id]) }}" class="btn btn-sm"><i class="ti ti-plus"></i> Reservar</a>
  </div>
  @forelse($aula->reservas as $r)
  <table><tbody>
    <tr>
      <td><strong>{{ $r->aluno->name ?? '—' }}</strong></td>
      <td><span class="badge {{ $r->status === 'presenca_confirmada' ? 'b-ok' : ($r->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $r->status }}</span></td>
      <td>
        <div class="actions">
          <form method="POST" action="{{ route('reserva-aulas-coletivas.destroy', $r) }}" onsubmit="return confirm('Cancelar reserva?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn danger btn-sm"><i class="ti ti-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
  </tbody></table>
  @empty
    <div class="empty"><i class="ti ti-ticket"></i>Nenhuma reserva</div>
  @endforelse
</div>
@endsection
