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
  <style>
    .ex-detalhes-row td { padding: 0; }
    .ex-detalhes-row img { display: block; }
  </style>
  <table>
    <thead><tr><th>#</th><th>Exercício</th><th>Séries</th><th>Repetições</th><th>Carga</th><th>Ações</th></tr></thead>
    <tbody>
    @foreach($treino->exercicios as $k => $ex)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td><strong>{{ $ex['nome'] }}</strong></td>
      <td>{{ $ex['series'] }}</td>
      <td>{{ $ex['repeticoes'] }}</td>
      <td>{{ $ex['carga'] }} kg</td>
      <td>
        <button type="button" class="btn ghost btn-sm" onclick="toggleDetalhes({{ $k }})">
          <i class="ti ti-eye"></i> Detalhes
        </button>
      </td>
    </tr>
    <tr id="detalhes-{{ $k }}" class="ex-detalhes-row" style="display:none;">
      <td colspan="6" style="padding:1rem;background:rgba(255,255,255,0.03);">
        <div class="detail-card" style="border:none;margin:0;padding:1rem;background:rgba(255,255,255,0.04);">
          <div style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-start;">
            <div style="flex:1 1 240px;min-width:240px;">
              <p><strong>Descrição:</strong> {{ $ex['obs'] ?? 'Nenhuma descrição' }}</p>
              <p><strong>Reps:</strong> {{ $ex['repeticoes'] }}</p>
              <p><strong>Séries:</strong> {{ $ex['series'] }}</p>
              <p><strong>Carga:</strong> {{ $ex['carga'] }} kg</p>
            </div>
            <div style="flex:1 1 240px;min-width:240px;">
              @if(!empty($ex['imagem']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($ex['imagem']))
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($ex['imagem']) }}" alt="Imagem do exercício" style="width:100%;max-width:360px;border-radius:12px;border:1px solid rgba(255,255,255,0.12);">
              @else
                <div style="padding:1rem;border:1px dashed rgba(255,255,255,0.2);border-radius:12px;color:var(--muted);text-align:center;">
                  Sem imagem disponível
                </div>
              @endif
            </div>
          </div>
        </div>
      </td>
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
<script>
  function toggleDetalhes(index) {
    const row = document.getElementById('detalhes-' + index);
    if (!row) return;
    row.style.display = row.style.display === 'table-row' ? 'none' : 'table-row';
  }
</script>
@endsection
