@extends('layouts.gym')
@section('title', $treino->nome)
@section('content')
<x-page-header :title="$treino->nome" subtitle="Detalhes do treino">
  <div class="actions">
    <a href="{{ route('treinos.pdf', $treino) }}" class="btn ghost" target="_blank"><i class="ti ti-file-type-pdf"></i> Imprimir</a>
    <a href="{{ route('treinos.edit', $treino) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('treinos.destroy', $treino) }}" onsubmit="return confirm('Excluir este treino?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i> Excluir</button>
    </form>
    <a href="{{ route('treinos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</x-page-header>

<div class="detail-card">
  <div class="detail-header"><h2>{{ $treino->nome }}</h2></div>
  <div class="detail-grid">
    <div class="detail-item"><label>Instrutor</label><span>{{ $treino->instrutor->usuario->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Criado em</label><span>{{ $treino->created_at->format('d/m/Y') }}</span></div>
    @if($treino->descricao)
    <div class="detail-item" style="grid-column:span 2"><label>Descrição</label><span>{{ $treino->descricao }}</span></div>
    @endif
  </div>
</div>

<div class="tbl-wrap" style="margin-bottom:1.5rem">
  <div class="tbl-head"><h3>Exercícios ({{ count($treino->exercicios ?? []) }})</h3></div>
  @if(empty($treino->exercicios))
    <div class="empty"><i class="ti ti-barbell"></i>Nenhum exercício</div>
  @else
  <table>
    <thead><tr><th>#</th><th>Exercício</th><th>Séries</th><th>Repetições</th><th>Carga</th></tr></thead>
    <tbody>
    @foreach($treino->exercicios as $k => $ex)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td><strong>{{ $ex['nome'] }}</strong></td>
      <td>{{ $ex['series'] }}</td>
      <td>{{ $ex['repeticoes'] }}</td>
      <td>{{ $ex['carga'] }} kg</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @endif
</div>

<div class="tbl-wrap">
  <div class="tbl-head">
    <h3>Alunos com este treino ({{ $treino->treinoAlunos->count() }})</h3>
    <a href="{{ route('treino-alunos.create', ['treino_id' => $treino->id]) }}" class="btn btn-sm"><i class="ti ti-plus"></i> Atribuir Aluno</a>
  </div>
  @if($treino->treinoAlunos->isEmpty())
    <div class="empty"><i class="ti ti-users"></i>Nenhum aluno com este treino</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Validade</th><th>Descrição</th></tr></thead>
    <tbody>
    @foreach($treino->treinoAlunos as $ta)
    <tr>
      <td>{{ $ta->aluno->name ?? '—' }}</td>
      <td>{{ $ta->validade?->format('d/m/Y') ?? '—' }}</td>
      <td>{{ $ta->descricao ?? '—' }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @endif
</div>
@endsection
