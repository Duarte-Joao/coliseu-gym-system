{{-- resources/views/instrutor/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Painel do Instrutor — Coliseu Gym</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/instrutor-css.css') }}">
</head>
<body>
<div class="lay">

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

  <main class="main">

    @if(session('success'))
      <div class="alert-ok">✓ {{ session('success') }}</div>
    @endif

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
</div>

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
        <input type="hidden" name="data_inicio" value="{{ now()->toDateString() }}">
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
        {{-- CORREÇÃO 2: chama submitDelete() que aciona o form fora do modal --}}
        <button type="button" class="btn danger-btn" style="padding:0.55rem 1.1rem" onclick="submitDelete()">
          <i class="ti ti-trash"></i> Sim, remover
        </button>
      </div>
    </div>
  </div>
</div>

{{--
  CORREÇÃO 2: form de delete movido para FORA de qualquer overlay/modal.
  Antes estava dentro do modal (display:none), impedindo o submit em alguns
  navegadores. Aqui fica invisível mas sempre disponível para o JS submeter.
--}}
<form method="POST" id="form-delete" style="display:none">
  @csrf
  @method('DELETE')
</form>

<div class="toast" id="toast"><i class="ti ti-check"></i><span id="toast-msg"></span></div>

<script>
  function go(id, btn) {
    document.querySelectorAll('.sec').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
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

  // CORREÇÃO 2: seta a action e submete o form que está fora do modal
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

  @if(session('success'))
    window.addEventListener('DOMContentLoaded', () => { toast('{{ session('success') }}'); });
  @endif

  window.addEventListener('DOMContentLoaded', updatePreview);
</script>
</body>
</html>