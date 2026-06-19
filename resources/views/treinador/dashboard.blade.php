@extends('layouts.gym')
@section('title', 'Painel do Treinador')

@push('styles')
<style>
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem}
  .stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;text-decoration:none;display:block;transition:border-color 0.2s}
  .stat-card:hover{border-color:rgba(139,92,246,0.4)}
  .stat-card .label{font-size:0.72rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);font-weight:700;margin-bottom:0.5rem}
  .stat-card .value{font-family:'Bebas Neue',sans-serif;font-size:2.8rem;letter-spacing:1px;line-height:1;color:var(--p2)}
  .stat-card .hint{font-size:0.72rem;color:var(--muted);margin-top:0.4rem}

  .tabs{display:flex;gap:4px;background:var(--card);border:1px solid var(--border);border-radius:10px;padding:6px;margin-bottom:2rem;flex-wrap:wrap}
  .tab-btn{flex:1;min-width:140px;padding:0.65rem 1rem;border-radius:7px;font-family:'Barlow',sans-serif;font-size:0.85rem;font-weight:600;color:var(--muted);background:transparent;border:none;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px}
  .tab-btn.active{background:var(--p1);color:#fff}
  .tab-btn:hover:not(.active){background:rgba(139,92,246,0.08);color:var(--txt)}
  .tab-pane{display:none}
  .tab-pane.active{display:block}

  .treino-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap}
  .tc-info h3{font-size:1rem;font-weight:700;margin-bottom:0.3rem}
  .tc-info p{font-size:0.8rem;color:var(--muted)}
  .tc-alunos{margin-top:0.75rem;display:flex;flex-wrap:wrap;gap:0.4rem}
  .aluno-chip{background:rgba(139,92,246,0.1);color:var(--p2);border:1px solid rgba(139,92,246,0.2);border-radius:20px;padding:3px 10px;font-size:0.75rem;font-weight:600}
  .tc-actions{display:flex;gap:0.5rem;flex-shrink:0}

  .aula-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:0.75rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}
  .aula-left{display:flex;align-items:center;gap:1rem}
  .aula-date{background:rgba(201,162,39,0.1);border:1px solid rgba(201,162,39,0.25);border-radius:8px;padding:0.5rem 0.75rem;text-align:center;min-width:60px}
  .aula-date .day{font-family:'Bebas Neue',sans-serif;font-size:1.8rem;line-height:1;color:var(--gold2)}
  .aula-date .mon{font-size:0.65rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted)}
  .aula-info h3{font-size:0.95rem;font-weight:700;margin-bottom:3px}
  .aula-info p{font-size:0.78rem;color:var(--muted)}
  .aula-right{display:flex;align-items:center;gap:1rem}
  .vagas-info{text-align:center}
  .vagas-info .num{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;color:var(--gold2);line-height:1}
  .vagas-info .sub-label{font-size:0.65rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted)}
</style>
@endpush

@section('content')
<x-page-header title="Painel do Treinador" :subtitle="auth()->user()->name">
  <a href="{{ route('treinos.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Ficha</a>
</x-page-header>

{{-- STATS --}}
<div class="stats">
  <a href="{{ route('treinos.index') }}" class="stat-card">
    <div class="label">Fichas criadas</div>
    <div class="value">{{ $totalTreinos }}</div>
    <div class="hint">Ver todas as fichas →</div>
  </a>
  <a href="{{ route('treinador.alunos') }}" class="stat-card">
    <div class="label">Alunos atendidos</div>
    <div class="value">{{ $totalAlunos }}</div>
    <div class="hint">Ver meus alunos →</div>
  </a>
  <a href="{{ route('aulas-coletivas.index') }}" class="stat-card">
    <div class="label">Aulas coletivas</div>
    <div class="value">{{ $totalAulas }}</div>
    <div class="hint">Ver todas as aulas →</div>
  </a>
</div>

{{-- TABS --}}
<div class="tabs">
  <button class="tab-btn active" onclick="showTab('fichas', this)"><i class="ti ti-barbell"></i> Fichas de Treino</button>
  <button class="tab-btn" onclick="showTab('aulas', this)"><i class="ti ti-calendar-event"></i> Aulas Coletivas</button>
</div>

{{-- TAB: FICHAS --}}
<div class="tab-pane active" id="tab-fichas">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
    <h3 style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted)">{{ $totalTreinos }} ficha(s) criada(s)</h3>
    <a href="{{ route('treinos.index') }}" class="btn ghost btn-sm"><i class="ti ti-list"></i> Ver todas</a>
  </div>

  @forelse($treinos as $treino)
  <div class="treino-card">
    <div class="tc-info">
      <h3>{{ $treino->nome }}</h3>
      <p>
        {{ count($treino->exercicios ?? []) }} exercício(s) ·
        {{ $treino->treinoAlunos->count() }} aluno(s)
        @if($treino->descricao)· {{ Str::limit($treino->descricao, 60) }}@endif
      </p>
      @if($treino->treinoAlunos->isNotEmpty())
      <div class="tc-alunos">
        @foreach($treino->treinoAlunos->take(5) as $ta)
          <span class="aluno-chip">{{ $ta->aluno->name ?? '—' }}</span>
        @endforeach
        @if($treino->treinoAlunos->count() > 5)
          <span class="aluno-chip">+{{ $treino->treinoAlunos->count() - 5 }}</span>
        @endif
      </div>
      @endif
    </div>
    <div class="tc-actions">
      <a href="{{ route('treinos.show', $treino) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
      <a href="{{ route('treinos.edit', $treino) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
      <a href="{{ route('treino-alunos.create', ['treino_id' => $treino->id]) }}" class="btn btn-sm"><i class="ti ti-user-plus"></i> Vincular</a>
    </div>
  </div>
  @empty
  <div class="tbl-wrap">
    <div class="empty">
      <i class="ti ti-barbell"></i>
      Nenhuma ficha criada ainda.
      <div style="margin-top:1rem">
        <a href="{{ route('treinos.create') }}" class="btn"><i class="ti ti-plus"></i> Criar Primeira Ficha</a>
      </div>
    </div>
  </div>
  @endforelse
</div>

{{-- TAB: AULAS --}}
<div class="tab-pane" id="tab-aulas">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
    <h3 style="font-size:0.78rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted)">{{ $totalAulas }} aula(s) cadastrada(s)</h3>
    <a href="{{ route('aulas-coletivas.create') }}" class="btn btn-sm"><i class="ti ti-plus"></i> Nova Aula</a>
  </div>

  @forelse($aulas as $aula)
  <div class="aula-card">
    <div class="aula-left">
      <div class="aula-date">
        <div class="day">{{ $aula->datahora?->format('d') ?? '—' }}</div>
        <div class="mon">{{ $aula->datahora?->translatedFormat('M') ?? '' }}</div>
      </div>
      <div class="aula-info">
        <h3>{{ $aula->modalidade }}</h3>
        <p>
          {{ $aula->datahora?->format('H:i') ?? '—' }} h ·
          <span class="badge {{ $aula->status === 'agendada' ? 'b-ok' : ($aula->status === 'realizada' ? 'b-pur' : 'b-err') }}">{{ $aula->status }}</span>
        </p>
        @if($aula->obs)<p style="margin-top:4px">{{ Str::limit($aula->obs, 60) }}</p>@endif
      </div>
    </div>
    <div class="aula-right">
      <div class="vagas-info">
        <div class="num">{{ $aula->reservas->count() }}/{{ $aula->vagas }}</div>
        <div class="sub-label">inscritos</div>
      </div>
      <div style="display:flex;gap:0.5rem">
        <a href="{{ route('aulas-coletivas.show', $aula) }}" class="btn ghost btn-sm"><i class="ti ti-eye"></i></a>
        <a href="{{ route('aulas-coletivas.edit', $aula) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
      </div>
    </div>
  </div>
  @empty
  <div class="tbl-wrap">
    <div class="empty">
      <i class="ti ti-calendar-event"></i>
      Nenhuma aula coletiva cadastrada.
      <div style="margin-top:1rem">
        <a href="{{ route('aulas-coletivas.create') }}" class="btn"><i class="ti ti-plus"></i> Criar Primeira Aula</a>
      </div>
    </div>
  </div>
  @endforelse
</div>
@endsection

@push('scripts')
<script>
function showTab(id, btn) {
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + id).classList.add('active');
  btn.classList.add('active');
}
</script>
@endpush
