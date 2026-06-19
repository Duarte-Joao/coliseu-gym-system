@extends('layouts.gym')
@section('title', 'Treinos dos Alunos')
@section('content')
<x-page-header title="Treinos dos Alunos" subtitle="Atribuições de treinos">
  <a href="{{ route('treino-alunos.create') }}" class="btn"><i class="ti ti-plus"></i> Atribuir Treino</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg" style="flex:2;min-width:200px">
    <label>Buscar aluno</label>
    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do aluno...">
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $atribuicoes->total() }} atribuição(ões)</h3></div>
  @if($atribuicoes->isEmpty())
    <div class="empty"><i class="ti ti-clipboard-list"></i>Nenhuma atribuição encontrada</div>
  @else
  <table>
    <thead><tr>
      <th>Aluno</th><th>Treino</th>
      @if(!isset($meuInstrutor) || !$meuInstrutor)<th>Instrutor</th>@endif
      <th>Validade</th><th></th>
    </tr></thead>
    <tbody>
    @foreach($atribuicoes as $a)
    <tr>
      <td><strong>{{ $a->aluno->name ?? '—' }}</strong></td>
      <td>{{ $a->treino->nome ?? '—' }}</td>
      @if(!isset($meuInstrutor) || !$meuInstrutor)
        <td>{{ $a->treino->instrutor->usuario->name ?? '—' }}</td>
      @endif
      <td>{{ $a->validade?->format('d/m/Y') ?? '—' }}</td>
      <td>
        <div class="actions">
          <a href="{{ route('treino-alunos.edit', $a) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('treino-alunos.destroy', $a) }}" onsubmit="return confirm('Remover atribuição?')">
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
<div class="pag-wrap">{{ $atribuicoes->links() }}</div>
@endsection
