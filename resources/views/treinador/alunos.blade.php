@extends('layouts.gym')
@section('title', 'Meus Alunos')

@push('styles')
<style>
  .aluno-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1rem}
  .aluno-head{padding:1rem 1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}
  .aluno-head h3{font-size:0.95rem;font-weight:700;margin:0}
  .aluno-head p{font-size:0.78rem;color:var(--muted);margin:2px 0 0}
  .aluno-fichas{padding:0}
  .ficha-bloco{padding:1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.03)}
  .ficha-bloco:last-child{border-bottom:none}
  .ficha-titulo{font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--p2);margin-bottom:0.75rem;display:flex;align-items:center;gap:0.5rem}
  .ex-table{width:100%;border-collapse:collapse;font-size:0.82rem}
  .ex-table th{font-size:0.68rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);padding:0.4rem 0.75rem;text-align:left;border-bottom:1px solid var(--border)}
  .ex-table td{padding:0.5rem 0.75rem;border-bottom:1px solid rgba(255,255,255,0.03)}
  .ex-table tr:last-child td{border-bottom:none}
  .ex-table tr:hover td{background:rgba(139,92,246,0.04)}
  .carga-badge{background:rgba(201,162,39,0.1);color:var(--gold2);border:1px solid rgba(201,162,39,0.2);border-radius:4px;padding:2px 8px;font-weight:700;font-size:0.75rem}
</style>
@endpush

@section('content')
<x-page-header title="Meus Alunos" subtitle="{{ $totalAlunos }} aluno(s) vinculado(s)">
  <a href="{{ route('treino-alunos.create') }}" class="btn"><i class="ti ti-user-plus"></i> Vincular Aluno</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg" style="flex:2;min-width:220px">
    <label>Buscar aluno</label>
    <input type="text" name="busca" value="{{ $busca ?? '' }}" placeholder="Nome do aluno..." autofocus>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Buscar</button>
  @if($busca ?? false)
    <a href="{{ route('treinador.alunos') }}" class="btn ghost"><i class="ti ti-x"></i> Limpar</a>
  @endif
</form>

@if(($busca ?? false) && $alunos->isEmpty())
<div class="tbl-wrap">
  <div class="empty">
    <i class="ti ti-search"></i>
    Nenhum aluno encontrado para "{{ $busca }}".
    <div style="margin-top:1rem">
      <a href="{{ route('treinador.alunos') }}" class="btn ghost">Ver todos</a>
    </div>
  </div>
</div>
@else
@forelse($alunos as $item)
@php $usuario = $item['usuario']; $fichas = $item['fichas']; @endphp
<div class="aluno-card">
  <div class="aluno-head">
    <div>
      <h3>{{ $usuario->name }}</h3>
      <p>{{ $usuario->email }} · {{ $usuario->numero_telefone ?? '—' }}</p>
    </div>
    <div style="display:flex;gap:0.5rem;align-items:center">
      <span class="badge b-pur">{{ $fichas->count() }} ficha(s)</span>
      <a href="{{ route('treino-alunos.create', ['usuario_id' => $usuario->id]) }}" class="btn ghost btn-sm"><i class="ti ti-plus"></i> Nova Ficha</a>
    </div>
  </div>
  <div class="aluno-fichas">
    @foreach($fichas as $f)
    @php $ta = $f['ta']; $treino = $f['treino']; @endphp
    <div class="ficha-bloco">
      <div class="ficha-titulo">
        <i class="ti ti-barbell"></i> {{ $treino->nome }}
        <span style="font-weight:400;font-size:0.7rem;color:var(--muted);text-transform:none;letter-spacing:0;margin-left:auto">
          Validade: {{ $ta->validade?->format('d/m/Y') ?? '—' }}
        </span>
        <a href="{{ route('treino-alunos.edit', $ta) }}" class="btn ghost btn-sm" style="margin-left:0.5rem;font-size:0.7rem;padding:2px 8px"><i class="ti ti-pencil"></i></a>
      </div>
      @if(!empty($treino->exercicios))
      <table class="ex-table">
        <thead>
          <tr><th>#</th><th>Exercício</th><th>Séries</th><th>Reps</th><th>Carga</th></tr>
        </thead>
        <tbody>
          @foreach($treino->exercicios as $k => $ex)
          <tr>
            <td style="color:var(--muted)">{{ $k + 1 }}</td>
            <td><strong>{{ $ex['nome'] }}</strong></td>
            <td>{{ $ex['series'] }}x</td>
            <td>{{ $ex['repeticoes'] }}</td>
            <td><span class="carga-badge">{{ $ex['carga'] }} kg</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <p style="font-size:0.8rem;color:var(--muted);padding:0.5rem 0">Nenhum exercício cadastrado nesta ficha.</p>
      @endif
      @if($ta->descricao)
      <p style="font-size:0.78rem;color:var(--muted);margin-top:0.5rem"><i class="ti ti-note" style="font-size:13px"></i> {{ $ta->descricao }}</p>
      @endif
    </div>
    @endforeach
  </div>
</div>
@empty
<div class="tbl-wrap">
  <div class="empty">
    <i class="ti ti-users"></i>
    Nenhum aluno vinculado ainda.
    <div style="margin-top:1rem">
      <a href="{{ route('treino-alunos.create') }}" class="btn"><i class="ti ti-user-plus"></i> Vincular Primeiro Aluno</a>
    </div>
  </div>
</div>
@endforelse
@endif
@endsection
