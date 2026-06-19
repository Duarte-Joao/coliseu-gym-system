@extends('layouts.gym')
@section('title', 'Treinos dos Alunos')
@section('content')
<div class="pg-header">
  <div><h1>Treinos dos Alunos</h1><p>Atribuições de treinos</p></div>
  <a href="{{ route('treino-alunos.create') }}" class="btn"><i class="ti ti-plus"></i> Atribuir Treino</a>
</div>
<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $atribuicoes->total() }} atribuição(ões)</h3></div>
  @if($atribuicoes->isEmpty())
    <div class="empty"><i class="ti ti-clipboard-list"></i>Nenhuma atribuição cadastrada</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Treino</th><th>Instrutor</th><th>Início</th><th>Fim</th><th>PDF</th><th>Ações</th></tr></thead>
    <tbody>
    @foreach($atribuicoes as $a)
    <tr>
      <td><strong>{{ $a->aluno->name ?? '—' }}</strong></td>
      <td>{{ $a->treino->nome ?? '—' }}</td>
      <td>{{ $a->treino->instrutor->usuario->name ?? '—' }}</td>
      <td>{{ $a->data_inicio?->format('d/m/Y') }}</td>
      <td>{{ $a->data_fim?->format('d/m/Y') ?? '—' }}</td>
      <td>
        <a href="{{ route('treino-alunos.pdf', $a) }}" class="btn primary btn-sm" target="_blank">PDF</a>
      </td>
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
