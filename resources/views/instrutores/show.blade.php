@extends('layouts.gym')
@section('title', $instrutor->usuario->name ?? 'Instrutor')
@section('content')
<div class="pg-header">
  <div><h1>{{ $instrutor->usuario->name ?? 'Instrutor' }}</h1><p>Perfil do instrutor</p></div>
  <div class="actions">
    <a href="{{ route('instrutores.edit', $instrutor) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('instrutores.destroy', $instrutor) }}" onsubmit="return confirm('Excluir este instrutor?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i> Excluir</button>
    </form>
    <a href="{{ route('instrutores.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>

<div class="detail-card">
  <div class="detail-header"><h2>{{ $instrutor->usuario->name ?? '—' }}</h2></div>
  <div class="detail-grid">
    <div class="detail-item"><label>E-mail</label><span>{{ $instrutor->usuario->email ?? '—' }}</span></div>
    <div class="detail-item"><label>Especialidade</label><span>{{ $instrutor->especialidade }}</span></div>
    <div class="detail-item"><label>Turno</label><span>{{ $instrutor->turno }}</span></div>
    <div class="detail-item"><label>Carga Horária</label><span>{{ $instrutor->carga_hora }}</span></div>
    <div class="detail-item"><label>Salário</label><span>R$ {{ number_format($instrutor->salario, 2, ',', '.') }}</span></div>
  </div>
</div>

<div class="tbl-wrap" style="margin-bottom:1.5rem">
  <div class="tbl-head">
    <h3>Treinos ({{ $instrutor->treinos->count() }})</h3>
    <a href="{{ route('treinos.create') }}" class="btn btn-sm"><i class="ti ti-plus"></i> Novo</a>
  </div>
  @forelse($instrutor->treinos as $t)
  <table><tbody>
    <tr>
      <td><strong>{{ $t->nome }}</strong></td>
      <td><span class="badge b-pur">{{ count($t->exercicios ?? []) }} exerc.</span></td>
      <td><a href="{{ route('treinos.show', $t) }}" class="btn ghost btn-sm">Ver</a></td>
    </tr>
  </tbody></table>
  @empty
    <div class="empty"><i class="ti ti-barbell"></i>Nenhum treino criado</div>
  @endforelse
</div>

<div class="tbl-wrap">
  <div class="tbl-head">
    <h3>Aulas Coletivas ({{ $instrutor->aulasColetivas->count() }})</h3>
    <a href="{{ route('aulas-coletivas.create') }}" class="btn btn-sm"><i class="ti ti-plus"></i> Nova</a>
  </div>
  @forelse($instrutor->aulasColetivas as $a)
  <table><tbody>
    <tr>
      <td><strong>{{ $a->modalidade }}</strong><span class="sub">{{ $a->datahora?->format('d/m/Y H:i') }}</span></td>
      <td><span class="badge {{ $a->status === 'agendada' ? 'b-ok' : ($a->status === 'cancelada' ? 'b-err' : 'b-pur') }}">{{ $a->status }}</span></td>
      <td><a href="{{ route('aulas-coletivas.show', $a) }}" class="btn ghost btn-sm">Ver</a></td>
    </tr>
  </tbody></table>
  @empty
    <div class="empty"><i class="ti ti-calendar-event"></i>Nenhuma aula cadastrada</div>
  @endforelse
</div>
@endsection
