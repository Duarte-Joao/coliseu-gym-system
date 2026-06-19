@extends('layouts.gym')

<<<<<<< HEAD
  <aside class="sb">
    <div class="logo">Coliseu <span>Gym</span><small>INSTRUTOR</small></div>
    <nav class="nav">
      <button class="nav-btn active" onclick="go('visao',this)"><i class="ti ti-layout-dashboard"></i> Visão Geral</button>
      <button class="nav-btn" onclick="go('alunos',this)"><i class="ti ti-users"></i> Gerenciar Alunos</button>
      <button class="nav-btn" onclick="go('cadastro',this)"><i class="ti ti-user-plus"></i> Cadastrar Aluno</button>
      <button class="nav-btn" onclick="go('fichas',this)"><i class="ti ti-clipboard-list"></i> Fichas</button>
    </nav>
    <div class="sb-footer">
      <div class="nav-sep"></div>
      <div class="user-pill">
        <div class="avatar">IN</div>
        <div class="user-info"><strong>Instrutor</strong><small>Musculação · Turno Noite</small></div>
      </div>
      <a href="/login" class="logout"><i class="ti ti-door-exit"></i> Sair do Sistema</a>
    </div>
  </aside>
=======
@section('title', 'Painel do Instrutor — Coliseu Gym')
>>>>>>> cf6be7573f1fe6556d70cd887e9c0aedbfa13591

@push('styles')
<style>
  .sec{display:none}
  .sec.active{display:block}
  .dash-tabs{display:flex;border-bottom:1px solid var(--border);margin-bottom:2rem;overflow-x:auto}
  .dash-tab{background:transparent;border:none;border-bottom:2px solid transparent;color:var(--muted);padding:0.65rem 1.1rem;font-family:'Barlow',sans-serif;font-size:0.875rem;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:7px;transition:all 0.2s;white-space:nowrap;margin-bottom:-1px}
  .dash-tab:hover{color:var(--txt)}
  .dash-tab.active{color:var(--p2);border-bottom-color:var(--p1)}
  .dash-tab i{font-size:16px}
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:2rem}
  .stat{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;position:relative;overflow:hidden}
  .stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--p1)}
  .stat.gold::before{background:var(--gold)}
  .stat.amber::before{background:var(--warn)}
  .stat label{display:block;font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-bottom:8px}
  .stat .val{font-family:'Bebas Neue',sans-serif;font-size:2rem;line-height:1;margin-bottom:6px}
  .stat .val.gold-c{color:var(--gold2)}
  .stat .val.purple-c{color:var(--p2)}
  .stat .val.amber-c{color:var(--warn)}
  .stat sub{font-size:0.8rem;color:var(--muted)}
  .sec-title{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:1px;margin-bottom:1.25rem;display:flex;align-items:center;gap:12px}
  .sec-title span{font-size:0.75rem;font-family:'Barlow',sans-serif;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--p1);border:1px solid rgba(139,92,246,0.3);padding:3px 10px;border-radius:20px}
  .actions-cell{display:flex;gap:6px;align-items:center}
  td strong{color:var(--txt);font-weight:600}
  td .sub{display:block;font-size:0.75rem;color:var(--muted);margin-top:2px}
  .empty-row td{text-align:center;color:var(--muted);padding:2rem;font-size:0.85rem}
  .btn.ok-btn{background:rgba(16,185,129,0.15);color:var(--ok);border:1px solid rgba(16,185,129,0.3)}
  .btn.ok-btn:hover{background:var(--ok);color:#fff}
  .btn.danger-btn{background:rgba(239,68,68,0.1);color:var(--err);border:1px solid rgba(239,68,68,0.25);padding:0.55rem 0.75rem}
  .btn.danger-btn:hover{background:var(--err);color:#fff;transform:translateY(-1px)}
  .ficha-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:1rem;transition:border-color 0.2s}
  .ficha-card:hover{border-color:rgba(139,92,246,0.35)}
  .ficha-card-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem}
  .ficha-card-header h3{font-size:1rem;font-weight:600}
  .ficha-tag{display:inline-block;background:rgba(139,92,246,0.15);color:var(--p2);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;padding:3px 10px;border-radius:4px;margin-bottom:6px}
  .ex-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:0}
  .ex-grid-head{font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);padding:0.4rem 0;border-bottom:1px solid var(--border);margin-bottom:0.25rem}
  .ex-row-d{display:contents}
  .ex-row-d div{padding:0.55rem 0;border-bottom:1px solid rgba(255,255,255,0.03);font-size:0.85rem;display:flex;align-items:center;gap:6px}
  .ex-row-d:last-child div{border-bottom:none}
  .ex-dot{width:5px;height:5px;border-radius:50%;background:var(--p1);flex-shrink:0}
  .ex-s{color:var(--muted)}
  .ex-c{color:var(--gold2);font-weight:600}
  .cadastro-wrap{max-width:600px}
  .cadastro-form{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:2rem;overflow:hidden}
  .form-section{margin-bottom:1.75rem}
  .form-section-title{display:flex;align-items:center;gap:8px;font-size:0.75rem;text-transform:uppercase;letter-spacing:2px;color:var(--p1);font-weight:700;margin-bottom:1.25rem}
  .form-section-title::before{content:'□';font-size:0.9rem}
  .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
  .form-row.single{grid-template-columns:1fr}
  .form-divider{height:1px;background:var(--border);margin:1.5rem 0}
  .required-mark{color:var(--err);margin-left:2px}
  .fg{display:flex;flex-direction:column;gap:0.4rem;margin-bottom:1.2rem}
  .fg label{font-size:0.82rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);font-weight:600}
  .overlay{position:fixed;inset:0;background:rgba(0,0,0,0.8);display:none;align-items:center;justify-content:center;z-index:999;padding:1rem}
  .overlay.on{display:flex}
  .modal{background:#16161e;border:1px solid rgba(139,92,246,0.2);border-radius:16px;width:100%;max-width:600px;max-height:88vh;overflow-y:auto;animation:pop 0.25s ease}
  @keyframes pop{from{transform:scale(0.95) translateY(10px);opacity:0}to{transform:scale(1) translateY(0);opacity:1}}
  .m-head{padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;background:#16161e;z-index:1}
  .m-head h2{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;color:var(--gold2);letter-spacing:1px}
  .close{background:transparent;border:none;color:var(--muted);font-size:1.3rem;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:all 0.2s}
  .close:hover{background:var(--err-bg);color:var(--err)}
  .m-body{padding:1.5rem}
  .m-subtitle{font-size:0.85rem;color:var(--muted);margin-bottom:1.5rem}
  .m-subtitle strong{color:var(--p2)}
  .m-actions{display:flex;gap:0.75rem;justify-content:flex-end;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border)}
  .modal-confirm{max-width:420px}
  .confirm-icon{width:56px;height:56px;border-radius:50%;background:var(--err-bg);border:1px solid rgba(239,68,68,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.5rem;color:var(--err)}
  .confirm-title{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;letter-spacing:1px;text-align:center;margin-bottom:0.5rem}
  .confirm-desc{font-size:0.88rem;color:var(--muted);text-align:center;line-height:1.6}
  .confirm-desc strong{color:var(--txt)}
  .confirm-warn{margin-top:1rem;background:var(--err-bg);border:1px solid rgba(239,68,68,0.2);border-radius:8px;padding:0.75rem 1rem;font-size:0.8rem;color:#f87171;display:flex;align-items:center;gap:8px}
  .preview-box{background:rgba(0,0,0,0.25);border:1px solid var(--border);border-radius:10px;padding:1rem;margin-top:0.25rem}
  .preview-header{display:grid;grid-template-columns:2fr 1fr 1fr;font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);padding-bottom:0.5rem;border-bottom:1px solid var(--border);margin-bottom:0.25rem}
  .preview-row{display:grid;grid-template-columns:2fr 1fr 1fr;padding:0.6rem 0;border-bottom:1px solid rgba(255,255,255,0.04);align-items:center;font-size:0.85rem}
  .preview-row:last-child{border-bottom:none}
  .preview-row .p-name{display:flex;align-items:center;gap:7px}
  .p-dot{width:5px;height:5px;border-radius:50%;background:var(--p1);flex-shrink:0}
  .preview-row .p-s{color:var(--muted)}
  .preview-row .p-c{color:var(--gold2);font-weight:600}
  .toast{position:fixed;bottom:1.5rem;right:1.5rem;background:#1e1e2a;border:1px solid rgba(139,92,246,0.3);border-radius:10px;padding:0.85rem 1.25rem;font-size:0.88rem;display:flex;align-items:center;gap:10px;z-index:9999;transform:translateY(20px);opacity:0;transition:all 0.3s;pointer-events:none;max-width:320px}
  .toast.show{transform:translateY(0);opacity:1}
  .toast.ok{border-color:rgba(16,185,129,0.4);color:var(--ok)}
  .toast.warn{border-color:rgba(245,158,11,0.4);color:var(--warn)}
  .toast i{font-size:18px;flex-shrink:0}
  @media(max-width:768px){.form-row{grid-template-columns:1fr}.dash-tabs{overflow-x:auto}}
</style>
@endpush

@section('content')

<<<<<<< HEAD
    {{-- VISÃO GERAL --}}
    <section class="sec active" id="sec-visao">
      <div class="pg-header">
        <div>
          <h1>Painel do Mestre de Armas</h1>
          <p>Gerencie os treinos da arena e controle suas atribuições táticas.</p>
        </div>
      </div>
      <div class="stats">
        <div class="stat">
          <label>Especialidade</label>
          <div class="val purple-c">{{ optional($instrutorData)->especialidade ?? 'Não definida' }}</div>
          <sub>Principal</sub>
        </div>
        <div class="stat gold">
          <label>Carga Horária</label>
          <div class="val gold-c">{{ optional($instrutorData)->carga_hora ?? '0' }}h / dia</div>
          <sub>Turno completo</sub>
        </div>
        <div class="stat amber">
          <label>Turno</label>
          <div class="val amber-c">{{ optional($instrutorData)->turno ?? 'Indefinido' }}</div>
          <sub>Designado</sub>
        </div>
        <div class="stat">
          <label>Fichas de Treino</label>
          <div class="val purple-c" id="stat-qtd-treinos">{{ $treinos ? count($treinos) : 0 }}</div>
          <sub>Prescrições ativas</sub>
        </div>
      </div>
      <div class="sec-title">Alunos com Pendência <span>Atenção</span></div>
      <div class="tbl-wrap">
        <table>
          <thead><tr><th>Aluno</th><th>Situação</th><th>Ação Rápida</th></tr></thead>
          <tbody>
            @forelse($alunosSemFicha as $aluno)
              <tr>
                <td><strong>{{ $aluno->name }}</strong><span class="sub">{{ $aluno->email }}</span></td>
                <td><span class="badge b-err">Sem Ficha</span></td>
                <td><button class="btn" onclick="openModalFicha({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')"><i class="ti ti-plus"></i> Criar Ficha</button></td>
              </tr>
            @empty
              <tr class="empty-row"><td colspan="3">✅ Todos os alunos estão com fichas ativas.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    {{-- GERENCIAR ALUNOS --}}
    <section class="sec" id="sec-alunos">
      <div class="pg-header">
        <div><h1>Gladiadores sob sua Tutela</h1><p>Visualize e vincule fichas de treino a cada aluno.</p></div>
      </div>
      <div class="tbl-wrap">
        <div class="tbl-head">
          <h3>Alunos Ativos</h3>
          <span style="font-size:0.8rem;color:var(--muted)">{{ $totalAlunos }} aluno{{ $totalAlunos !== 1 ? 's' : '' }}</span>
        </div>
        <table>
          <thead>
            <tr><th>Aluno</th><th>Última Ficha Vinculada</th><th>Situação</th><th>Ações</th></tr>
          </thead>
          <tbody>
            @forelse($alunos as $aluno)
              @php
                $ultimoTreino = $aluno->treinoAlunos->first();
                $temFicha     = !is_null($ultimoTreino);
              @endphp
              <tr>
                <td><strong>{{ $aluno->name }}</strong><span class="sub">{{ $aluno->email }}</span></td>
                <td style="{{ !$temFicha ? 'color:var(--muted)' : '' }}">{{ $temFicha ? $ultimoTreino->treino->nome : 'Nenhuma cadastrada' }}</td>
                <td><span class="badge {{ $temFicha ? 'b-ok' : 'b-err' }}">{{ $temFicha ? 'Atualizada' : 'Sem Ficha' }}</span></td>
                <td>
                  <div class="actions-cell">

                    {{-- CORREÇÃO 1: botão de editar dados do aluno --}}
                    <a href="{{ route('usuarios.edit', $aluno->id) }}" class="btn ghost" title="Editar dados do aluno">
                      <i class="ti ti-pencil"></i>
                    </a>

                    <button class="btn" onclick="openModalFicha({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')">
                      <i class="ti ti-{{ $temFicha ? 'edit' : 'plus' }}"></i> {{ $temFicha ? 'Nova Ficha' : 'Criar Ficha' }}
                    </button>

                    <button class="btn danger-btn" onclick="confirmarDelete({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')" title="Remover Aluno">
                      <i class="ti ti-trash"></i>
                    </button>

                  </div>
                </td>
              </tr>
            @empty
              <tr class="empty-row"><td colspan="4">Nenhum aluno cadastrado ainda.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    {{-- CADASTRAR ALUNO --}}
    <section class="sec" id="sec-cadastro">
      <div class="pg-header"><div><h1>Cadastrar Novo Aluno</h1><p>Matricule um novo gladiador na arena sob sua tutela.</p></div></div>
      @if($errors->any())
        <div class="alert-err">@foreach($errors->all() as $erro)<span>• {{ $erro }}</span>@endforeach</div>
      @endif
      <div class="cadastro-wrap">
        <form method="POST" action="{{ route('usuarios.store') }}" id="form-cadastro">
          @csrf
          <input type="hidden" name="tipo" value="aluno">
          <input type="hidden" name="status" value="ativo">
          <div class="cadastro-form">
            <div class="form-section">
              <div class="form-section-title">Dados Pessoais</div>
              <div class="form-row">
                <div class="fg"><label>Nome Completo <span class="required-mark">*</span></label><input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Júlio César Oliveira" required></div>
                <div class="fg"><label>E-mail <span class="required-mark">*</span></label><input type="email" name="email" value="{{ old('email') }}" placeholder="email@exemplo.com" required></div>
              </div>
              <div class="form-row">
                <div class="fg"><label>CPF <span class="required-mark">*</span></label><input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14" required></div>
                <div class="fg"><label>Data de Nascimento <span class="required-mark">*</span></label><input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required></div>
              </div>
              <div class="form-row">
                <div class="fg"><label>Telefone <span class="required-mark">*</span></label><input type="text" name="numero_telefone" value="{{ old('numero_telefone') }}" placeholder="(49) 99999-0000" required></div>
                <div class="fg"><label>Senha provisória <span class="required-mark">*</span></label><input type="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required></div>
              </div>
            </div>
            <div class="form-divider"></div>
            <div class="form-section">
              <div class="form-section-title">Endereço</div>
              <div class="form-row">
                <div class="fg"><label>CEP <span class="required-mark">*</span></label><input type="text" name="cep" value="{{ old('cep') }}" placeholder="89800-000" maxlength="9" required></div>
                <div class="fg"><label>Rua <span class="required-mark">*</span></label><input type="text" name="rua" value="{{ old('rua') }}" placeholder="Nome da rua ou avenida" required></div>
              </div>
              <div class="form-row">
                <div class="fg"><label>Número <span class="required-mark">*</span></label><input type="number" name="numero_rua" value="{{ old('numero_rua') }}" placeholder="Ex: 1420" required></div>
              </div>
            </div>
            <div class="form-divider"></div>
            <div class="form-section" style="margin-bottom:0">
              <div class="form-section-title">Plano Inicial (Opcional)</div>
              <div class="form-row">
                <div class="fg">
                  <label>Tipo de Plano</label>
                  <select name="plano_tipo">
                    <option value="">Sem plano no momento</option>
                    <option value="Mensal" {{ old('plano_tipo')==='Mensal' ? 'selected' : '' }}>Mensal</option>
                    <option value="Trimestral" {{ old('plano_tipo')==='Trimestral' ? 'selected' : '' }}>Trimestral</option>
                    <option value="Semestral" {{ old('plano_tipo')==='Semestral' ? 'selected' : '' }}>Semestral</option>
                    <option value="Anual" {{ old('plano_tipo')==='Anual' ? 'selected' : '' }}>Anual</option>
                  </select>
                </div>
                <div class="fg">
                  <label>Vincular Ficha de Treino</label>
                  <select name="treino_id">
                    <option value="">Sem ficha no momento</option>
                    @foreach($treinos as $treino)
                      <option value="{{ $treino->id }}" {{ old('treino_id')==$treino->id ? 'selected' : '' }}>{{ $treino->nome }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions" style="margin-top:1.25rem">
            <button type="button" class="btn ghost" onclick="limparCadastro()"><i class="ti ti-eraser"></i> Limpar</button>
            <button type="submit" class="btn ok-btn"><i class="ti ti-user-check"></i> Cadastrar Gladiador</button>
          </div>
        </form>
      </div>
    </section>

    {{-- FICHAS --}}
    <section class="sec" id="sec-fichas">
      <div class="pg-header">
        <div><h1>Grade de Fichas</h1><p>Estrutura dos treinos disponíveis para vincular aos alunos.</p></div>
        <a href="{{ route('treinos.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Ficha</a>
      </div>
      @forelse($treinos as $treino)
        <div class="ficha-card">
          <div class="ficha-card-header">
            <div>
              <span class="ficha-tag">{{ $treino->instrutor->usuario->name ?? 'Instrutor' }}</span>
              <h3>{{ $treino->nome }}</h3>
            </div>
            <div style="display:flex;gap:8px;align-items:center">
              <span style="font-size:0.8rem;color:var(--muted)">{{ count($treino->exercicios ?? []) }} exercício(s)</span>
              <a href="{{ route('treinos.edit', $treino) }}" class="btn ghost" style="font-size:0.78rem;padding:0.4rem 0.8rem"><i class="ti ti-edit"></i> Editar</a>
            </div>
          </div>
          @if(!empty($treino->exercicios))
            <div class="ex-grid">
              <div class="ex-grid-head">Exercício</div><div class="ex-grid-head">Séries × Reps</div><div class="ex-grid-head">Carga</div>
              @foreach($treino->exercicios as $ex)
                <div class="ex-row">
                  <div><div class="ex-dot"></div>{{ $ex['nome'] }}</div>
                  <div class="ex-s">{{ $ex['series'] }}x {{ $ex['repeticoes'] }}</div>
                  <div class="ex-c">{{ $ex['carga'] }}kg</div>
                </div>
              @endforeach
            </div>
          @else
            <p style="font-size:0.82rem;color:var(--muted)">Nenhum exercício cadastrado nesta ficha.</p>
          @endif
          @if($treino->obs)
            <p style="font-size:0.8rem;color:var(--gold2);margin-top:0.75rem"><i class="ti ti-alert-circle" style="font-size:13px"></i> {{ $treino->obs }}</p>
          @endif
        </div>
      @empty
        <div class="tbl-wrap">
          <div class="empty-row" style="padding:2rem;text-align:center;color:var(--muted);font-size:0.85rem">
            Nenhuma ficha cadastrada ainda.
            <a href="{{ route('treinos.create') }}" class="btn" style="margin-left:1rem"><i class="ti ti-plus"></i> Criar Primeira Ficha</a>
          </div>
        </div>
      @endforelse
    </section>

  </main>
=======
<div class="dash-tabs">
  <button class="dash-tab active" data-tab="visao" onclick="go('visao',this)"><i class="ti ti-layout-dashboard"></i> Visão Geral</button>
  <button class="dash-tab" data-tab="alunos" onclick="go('alunos',this)"><i class="ti ti-users"></i> Gerenciar Alunos</button>
  <button class="dash-tab" data-tab="cadastro" onclick="go('cadastro',this)"><i class="ti ti-user-plus"></i> Cadastrar Aluno</button>
  <button class="dash-tab" data-tab="fichas" onclick="go('fichas',this)"><i class="ti ti-clipboard-list"></i> Fichas</button>
>>>>>>> cf6be7573f1fe6556d70cd887e9c0aedbfa13591
</div>

{{-- VISÃO GERAL --}}
<section class="sec active" id="sec-visao">
  <x-page-header title="Painel do Mestre de Armas" subtitle="Gerencie os treinos da arena e controle suas atribuições táticas." />
  <div class="stats">
    <div class="stat"><label>Total de Alunos</label><div class="val purple-c">{{ $totalAlunos }}</div><sub>{{ $semFicha }} sem ficha ativa</sub></div>
    <div class="stat gold"><label>Instrutores</label><div class="val gold-c">{{ $totalInstrutores }}</div><sub>Cadastrados</sub></div>
    <div class="stat"><label>Fichas de Treino</label><div class="val purple-c">{{ $totalTreinos }}</div><sub>Templates criados</sub></div>
    <div class="stat amber"><label>Pag. Pendentes</label><div class="val amber-c">{{ $totalPendentes }}</div><sub>Aguardando pagamento</sub></div>
  </div>
  <div class="sec-title">Alunos com Pendência <span>{{ $alunosComPendencia->count() }} alerta(s)</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Aluno</th><th>Situação</th><th>Ação Rápida</th></tr></thead>
      <tbody>
        @forelse($alunosComPendencia as $item)
          @php $aluno = $item['usuario']; @endphp
          <tr>
            <td><strong>{{ $aluno->name }}</strong><span class="sub">{{ $aluno->email }}</span></td>
            <td>
              @if($item['tipo'] === 'sem_ficha')
                <span class="badge b-err">Sem Ficha</span>
              @else
                <span class="badge b-warn">Pagamento Pendente</span>
              @endif
            </td>
            <td>
              @if($item['tipo'] === 'sem_ficha')
                <button class="btn" onclick="openModalFicha({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')"><i class="ti ti-plus"></i> Criar Ficha</button>
              @else
                <a href="{{ route('pagamento-plano-alunos.index', ['busca' => $aluno->name]) }}" class="btn" style="background:rgba(245,158,11,0.1);color:var(--warn,#f59e0b);border:1px solid rgba(245,158,11,0.3)"><i class="ti ti-cash"></i> Ver Pagamentos</a>
              @endif
            </td>
          </tr>
        @empty
          <tr class="empty-row"><td colspan="3">✅ Nenhuma pendência encontrada.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

{{-- GERENCIAR ALUNOS --}}
<section class="sec" id="sec-alunos">
  <x-page-header title="Gladiadores sob sua Tutela" subtitle="Visualize e vincule fichas de treino a cada aluno." />
  <div class="tbl-wrap">
    <div class="tbl-head">
      <h3>Alunos Ativos</h3>
      <span style="font-size:0.8rem;color:var(--muted)">{{ $totalAlunos }} aluno{{ $totalAlunos !== 1 ? 's' : '' }}</span>
    </div>
    <table>
      <thead><tr><th>Aluno</th><th>Última Ficha Vinculada</th><th>Situação</th><th>Ações</th></tr></thead>
      <tbody>
        @forelse($alunos as $aluno)
          @php $ultimoTreino = $aluno->treinoAlunos->first(); $temFicha = !is_null($ultimoTreino); @endphp
          <tr>
            <td><strong>{{ $aluno->name }}</strong><span class="sub">{{ $aluno->email }}</span></td>
            <td style="{{ !$temFicha ? 'color:var(--muted)' : '' }}">{{ $temFicha ? $ultimoTreino->treino->nome : 'Nenhuma cadastrada' }}</td>
            <td><span class="badge {{ $temFicha ? 'b-ok' : 'b-err' }}">{{ $temFicha ? 'Atualizada' : 'Sem Ficha' }}</span></td>
            <td>
              <div class="actions-cell">
                <a href="{{ route('usuarios.edit', $aluno->id) }}" class="btn ghost" title="Editar dados do aluno"><i class="ti ti-pencil"></i></a>
                <button class="btn" onclick="openModalFicha({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')">
                  <i class="ti ti-{{ $temFicha ? 'edit' : 'plus' }}"></i> {{ $temFicha ? 'Nova Ficha' : 'Criar Ficha' }}
                </button>
                <button class="btn danger-btn" onclick="confirmarDelete({{ $aluno->id }}, '{{ addslashes($aluno->name) }}')" title="Remover Aluno"><i class="ti ti-trash"></i></button>
              </div>
            </td>
          </tr>
        @empty
          <tr class="empty-row"><td colspan="4">Nenhum aluno cadastrado ainda.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

{{-- CADASTRAR ALUNO --}}
<section class="sec" id="sec-cadastro">
  <x-page-header title="Cadastrar Novo Aluno" subtitle="Matricule um novo gladiador na arena sob sua tutela." />
  <div class="cadastro-wrap">
    <form method="POST" action="{{ route('usuarios.store') }}" id="form-cadastro">
      @csrf
      <input type="hidden" name="tipo" value="aluno">
      <input type="hidden" name="status" value="ativo">
      <div class="cadastro-form">
        <div class="form-section">
          <div class="form-section-title">Dados Pessoais</div>
          <div class="form-row">
            <div class="fg"><label>Nome Completo <span class="required-mark">*</span></label><input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Júlio César Oliveira" required></div>
            <div class="fg"><label>E-mail <span class="required-mark">*</span></label><input type="email" name="email" value="{{ old('email') }}" placeholder="email@exemplo.com" required></div>
          </div>
          <div class="form-row">
            <div class="fg"><label>RG <span class="required-mark">*</span></label><input type="text" name="rg" value="{{ old('rg') }}" placeholder="00.000.000-0" maxlength="12" required></div>
            <div class="fg"><label>Data de Nascimento <span class="required-mark">*</span></label><input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required></div>
          </div>
          <div class="form-row">
            <div class="fg"><label>Telefone <span class="required-mark">*</span></label><input type="text" name="numero_telefone" value="{{ old('numero_telefone') }}" placeholder="(49) 99999-0000" required></div>
            <div class="fg"><label>Senha provisória <span class="required-mark">*</span></label><input type="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required></div>
          </div>
        </div>
        <div class="form-divider"></div>
        <div class="form-section">
          <div class="form-section-title">Endereço</div>
          <div class="form-row">
            <div class="fg"><label>CEP <span class="required-mark">*</span></label><input type="text" name="cep" value="{{ old('cep') }}" placeholder="89800-000" maxlength="9" required></div>
            <div class="fg"><label>Rua <span class="required-mark">*</span></label><input type="text" name="rua" value="{{ old('rua') }}" placeholder="Nome da rua ou avenida" required></div>
          </div>
          <div class="form-row single">
            <div class="fg"><label>Número <span class="required-mark">*</span></label><input type="number" name="numero_rua" value="{{ old('numero_rua') }}" placeholder="Ex: 1420" required></div>
          </div>
        </div>
        <div class="form-divider"></div>
        <div class="form-section" style="margin-bottom:0">
          <div class="form-section-title">Plano Inicial (Opcional)</div>
          <div class="form-row">
            <div class="fg">
              <label>Tipo de Plano</label>
              <select name="plano_tipo">
                <option value="">Sem plano no momento</option>
                <option value="Mensal" {{ old('plano_tipo')==='Mensal' ? 'selected' : '' }}>Mensal</option>
                <option value="Trimestral" {{ old('plano_tipo')==='Trimestral' ? 'selected' : '' }}>Trimestral</option>
                <option value="Semestral" {{ old('plano_tipo')==='Semestral' ? 'selected' : '' }}>Semestral</option>
                <option value="Anual" {{ old('plano_tipo')==='Anual' ? 'selected' : '' }}>Anual</option>
              </select>
            </div>
            <div class="fg">
              <label>Vincular Ficha de Treino</label>
              <select name="treino_id">
                <option value="">Sem ficha no momento</option>
                @foreach($treinos as $treino)
                  <option value="{{ $treino->id }}" {{ old('treino_id')==$treino->id ? 'selected' : '' }}>{{ $treino->nome }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions" style="margin-top:1.25rem;justify-content:flex-end">
        <button type="button" class="btn ghost" onclick="limparCadastro()"><i class="ti ti-eraser"></i> Limpar</button>
        <button type="submit" class="btn ok-btn"><i class="ti ti-user-check"></i> Cadastrar Gladiador</button>
      </div>
    </form>
  </div>
</section>

{{-- FICHAS --}}
<section class="sec" id="sec-fichas">
  <x-page-header title="Grade de Fichas" subtitle="Estrutura dos treinos disponíveis para vincular aos alunos.">
    <a href="{{ route('treinos.create') }}" class="btn"><i class="ti ti-plus"></i> Nova Ficha</a>
  </x-page-header>
  @forelse($treinos as $treino)
    <div class="ficha-card">
      <div class="ficha-card-header">
        <div>
          <span class="ficha-tag">{{ $treino->instrutor->usuario->name ?? 'Instrutor' }}</span>
          <h3>{{ $treino->nome }}</h3>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
          <span style="font-size:0.8rem;color:var(--muted)">{{ count($treino->exercicios ?? []) }} exercício(s)</span>
          <a href="{{ route('treinos.edit', $treino) }}" class="btn ghost" style="font-size:0.78rem;padding:0.4rem 0.8rem"><i class="ti ti-edit"></i> Editar</a>
        </div>
      </div>
      @if(!empty($treino->exercicios))
        <div class="ex-grid">
          <div class="ex-grid-head">Exercício</div><div class="ex-grid-head">Séries × Reps</div><div class="ex-grid-head">Carga</div>
          @foreach($treino->exercicios as $ex)
            <div class="ex-row-d">
              <div><div class="ex-dot"></div>{{ $ex['nome'] }}</div>
              <div class="ex-s">{{ $ex['series'] }}x {{ $ex['repeticoes'] }}</div>
              <div class="ex-c">{{ $ex['carga'] }}kg</div>
            </div>
          @endforeach
        </div>
      @else
        <p style="font-size:0.82rem;color:var(--muted)">Nenhum exercício cadastrado nesta ficha.</p>
      @endif
      @if($treino->descricao)
        <p style="font-size:0.8rem;color:var(--gold2);margin-top:0.75rem"><i class="ti ti-alert-circle" style="font-size:13px"></i> {{ $treino->descricao }}</p>
      @endif
    </div>
  @empty
    <div class="tbl-wrap">
      <div style="padding:2rem;text-align:center;color:var(--muted);font-size:0.85rem">
        Nenhuma ficha cadastrada ainda.
        <a href="{{ route('treinos.create') }}" class="btn" style="margin-left:1rem"><i class="ti ti-plus"></i> Criar Primeira Ficha</a>
      </div>
    </div>
  @endforelse
</section>

{{-- MODAL VINCULAR FICHA --}}
<div class="overlay" id="m-montar">
  <div class="modal">
    <div class="m-head">
      <h2>Vincular Nova Ficha</h2>
      <button class="close" onclick="closeM('m-montar')"><i class="ti ti-x"></i></button>
    </div>
    <div class="m-body">
      <p class="m-subtitle">Montando ficha para: <strong id="modal-nome-aluno">—</strong></p>
      <form method="POST" action="{{ route('treino-alunos.store') }}" id="form-ficha">
        @csrf
        <input type="hidden" name="usuario_id" id="modal-usuario-id">
        <input type="hidden" name="validade" value="{{ now()->addYear()->toDateString() }}">
        <div class="fg">
          <label>Ficha de Treino</label>
          <select name="treino_id" id="select-ficha" onchange="updatePreview()">
            @foreach($treinos as $treino)
              <option value="{{ $treino->id }}" data-exercicios='@json($treino->exercicios ?? [])'>{{ $treino->nome }}</option>
            @endforeach
          </select>
        </div>
        <div class="fg">
          <label>Prévia dos Exercícios</label>
          <div class="preview-box">
            <div class="preview-header"><span>Exercício</span><span>Séries × Reps</span><span>Carga</span></div>
            <div id="preview-list"></div>
          </div>
        </div>
        <div class="fg">
          <label>Observações do Instrutor <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--muted)">(opcional)</span></label>
          <textarea name="descricao" id="obs" rows="2" placeholder="Ex: Cadência 4020. Descanso estrito de 60 segundos..."></textarea>
        </div>
        <div class="m-actions">
          <button type="button" class="btn ghost" onclick="closeM('m-montar')"><i class="ti ti-x"></i> Cancelar</button>
          <button type="submit" class="btn ok-btn"><i class="ti ti-check"></i> Salvar e Vincular</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MODAL CONFIRMAÇÃO DELETE --}}
<div class="overlay" id="m-confirmar-delete">
  <div class="modal modal-confirm">
    <div class="m-body" style="padding:2rem">
      <div class="confirm-icon"><i class="ti ti-trash"></i></div>
      <div class="confirm-title">Remover Aluno?</div>
      <p class="confirm-desc">Você tem certeza que deseja remover o gladiador <strong id="confirm-nome-aluno">—</strong> da arena?</p>
      <div class="confirm-warn"><i class="ti ti-alert-triangle"></i> Esta ação não poderá ser desfeita. Todos os dados do aluno serão perdidos.</div>
      <div class="m-actions" style="margin-top:1.5rem">
        <button class="btn ghost" onclick="closeM('m-confirmar-delete')"><i class="ti ti-x"></i> Cancelar</button>
        <button type="button" class="btn danger-btn" style="padding:0.55rem 1.1rem" onclick="submitDelete()"><i class="ti ti-trash"></i> Sim, remover</button>
      </div>
    </div>
  </div>
</div>

<form method="POST" id="form-delete" style="display:none">
  @csrf
  @method('DELETE')
</form>

<div class="toast" id="toast"><i class="ti ti-check"></i><span id="toast-msg"></span></div>

@endsection

@push('scripts')
<script>
  function go(id, btn) {
    document.querySelectorAll('.sec').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.dash-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('sec-' + id).classList.add('active');
    btn.classList.add('active');
  }

  function toast(msg, tipo = 'ok') {
    const t = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    t.className = 'toast ' + tipo;
    t.querySelector('i').className = tipo === 'ok' ? 'ti ti-check' : 'ti ti-alert-triangle';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  function closeM(id) { document.getElementById(id).classList.remove('on'); }

  ['m-montar', 'm-confirmar-delete'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
      if (e.target === this) closeM(id);
    });
  });

  function openModalFicha(usuarioId, nomeAluno) {
    document.getElementById('modal-usuario-id').value = usuarioId;
    document.getElementById('modal-nome-aluno').textContent = nomeAluno;
    document.getElementById('obs').value = '';
    updatePreview();
    document.getElementById('m-montar').classList.add('on');
  }

  function updatePreview() {
    const sel = document.getElementById('select-ficha');
    if (!sel || !sel.options.length) return;
    let exercicios = [];
    try { exercicios = JSON.parse(sel.options[sel.selectedIndex].dataset.exercicios || '[]'); } catch(e) {}
    const lista = document.getElementById('preview-list');
    if (!exercicios.length) {
      lista.innerHTML = '<p style="font-size:0.8rem;color:var(--muted);padding:0.5rem 0">Nenhum exercício nesta ficha.</p>';
      return;
    }
    lista.innerHTML = exercicios.map(ex => `
      <div class="preview-row">
        <div class="p-name"><div class="p-dot"></div>${ex.nome}</div>
        <div class="p-s">${ex.series}x ${ex.repeticoes}</div>
        <div class="p-c">${ex.carga}kg</div>
      </div>`).join('');
  }

  function confirmarDelete(usuarioId, nomeAluno) {
    document.getElementById('confirm-nome-aluno').textContent = nomeAluno;
    document.getElementById('form-delete').action = '/usuarios/' + usuarioId;
    document.getElementById('m-confirmar-delete').classList.add('on');
  }

  function submitDelete() {
    closeM('m-confirmar-delete');
    document.getElementById('form-delete').submit();
  }

  function limparCadastro() { document.getElementById('form-cadastro').reset(); }

  window.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
      const tab = document.querySelector('.dash-tab[data-tab="cadastro"]');
      if (tab) go('cadastro', tab);
    @endif
    updatePreview();
  });
</script>
@endpush
