<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel do Instrutor — Coliseu Gym</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  :root{
    --dark:#0a0a0e;--card:#13131a;--sidebar:#0f0f15;
    --p1:#8b5cf6;--p2:#a78bfa;--p3:#6d28d9;
    --gold:#c9a227;--gold2:#e4bb4a;
    --txt:#f0f0f5;--muted:#7a7a8c;
    --border:rgba(139,92,246,0.12);
    --ok:#10b981;--warn:#f59e0b;--err:#ef4444;
    --ok-bg:rgba(16,185,129,0.1);--warn-bg:rgba(245,158,11,0.1);--err-bg:rgba(239,68,68,0.1);
  }
  body{background:var(--dark);color:var(--txt);font-family:'Barlow',sans-serif;display:flex;min-height:100vh;overflow:hidden}
  .lay{display:flex;width:100%;height:100vh}

  /* SIDEBAR */
  .sb{width:240px;background:var(--sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;padding:1.5rem 0.75rem;flex-shrink:0}
  .logo{font-family:'Bebas Neue',sans-serif;font-size:2rem;padding:0 0.5rem 2rem;letter-spacing:2px}
  .logo span{color:var(--p1)}
  .logo small{display:block;font-size:0.5rem;letter-spacing:4px;color:var(--muted);font-family:'Barlow',sans-serif;font-weight:500;margin-top:-4px}
  .nav{display:flex;flex-direction:column;gap:4px}
  .nav-btn{background:transparent;border:none;color:var(--muted);padding:0.75rem 0.85rem;text-align:left;font-family:'Barlow',sans-serif;font-size:0.9rem;font-weight:500;cursor:pointer;border-radius:8px;display:flex;align-items:center;gap:0.7rem;transition:all 0.2s;width:100%}
  .nav-btn:hover{background:rgba(139,92,246,0.08);color:var(--txt)}
  .nav-btn.active{background:rgba(139,92,246,0.15);color:var(--p2);border-left:3px solid var(--p1);border-radius:0 8px 8px 0;padding-left:calc(0.85rem - 3px)}
  .nav-btn i{font-size:18px}
  .nav-sep{height:1px;background:var(--border);margin:0.75rem 0}
  .sb-footer{margin-top:auto;padding-top:1rem}
  .user-pill{display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:8px;background:rgba(255,255,255,0.03);margin-bottom:1rem}
  .avatar{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--p3),var(--p1));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;color:#fff;flex-shrink:0}
  .user-info small{display:block;font-size:0.75rem;color:var(--muted)}
  .user-info strong{font-size:0.9rem}
  .logout{background:transparent;border:1px solid rgba(239,68,68,0.25);color:#f87171;padding:0.65rem;border-radius:8px;cursor:pointer;font-weight:600;font-size:0.85rem;width:100%;transition:all 0.2s;font-family:'Barlow',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none}
  .logout:hover{background:var(--err);color:#fff;border-color:var(--err)}

  /* MAIN */
  .main{flex:1;overflow-y:auto;padding:2rem 2.5rem}
  .sec{display:none}
  .sec.active{display:block}
  .pg-header{margin-bottom:2rem;display:flex;justify-content:space-between;align-items:center}
  .pg-header h1{font-family:'Bebas Neue',sans-serif;font-size:2.5rem;letter-spacing:1px;line-height:1}
  .pg-header p{color:var(--muted);font-size:0.9rem;margin-top:6px}

  /* STATS */
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

  /* SEC TITLE */
  .sec-title{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:1px;margin-bottom:1.25rem;display:flex;align-items:center;gap:12px}
  .sec-title span{font-size:0.75rem;font-family:'Barlow',sans-serif;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--p1);border:1px solid rgba(139,92,246,0.3);padding:3px 10px;border-radius:20px}

  /* BUTTONS */
  .btn{background:var(--p1);color:#fff;border:none;padding:0.55rem 1.1rem;border-radius:8px;font-weight:600;cursor:pointer;font-family:'Barlow',sans-serif;font-size:0.82rem;transition:all 0.2s;display:inline-flex;align-items:center;gap:6px;white-space:nowrap}
  .btn:hover{background:var(--p3);transform:translateY(-1px)}
  .btn.ghost{background:rgba(255,255,255,0.06);color:var(--txt);border:1px solid var(--border)}
  .btn.ghost:hover{background:rgba(255,255,255,0.1);transform:none}
  .btn.ok-btn{background:rgba(16,185,129,0.15);color:var(--ok);border:1px solid rgba(16,185,129,0.3)}
  .btn.ok-btn:hover{background:var(--ok);color:#fff}
  .btn.danger-btn{background:rgba(239,68,68,0.1);color:var(--err);border:1px solid rgba(239,68,68,0.25);padding:0.55rem 0.75rem}
  .btn.danger-btn:hover{background:var(--err);color:#fff;transform:translateY(-1px)}

  /* TABLES */
  .tbl-wrap{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1rem}
  .tbl-head{padding:1rem 1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
  .tbl-head h3{font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted)}
  table{width:100%;border-collapse:collapse}
  th{padding:0.75rem 1.5rem;font-size:0.75rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);text-align:left;border-bottom:1px solid var(--border);font-weight:600}
  td{padding:1rem 1.5rem;font-size:0.88rem;border-bottom:1px solid rgba(255,255,255,0.03);vertical-align:middle}
  tr:last-child td{border-bottom:none}
  tr:hover td{background:rgba(139,92,246,0.04)}
  td strong{color:var(--txt);font-weight:600}
  td .sub{display:block;font-size:0.75rem;color:var(--muted);margin-top:2px}
  .actions-cell{display:flex;gap:6px;align-items:center}

  /* BADGES */
  .badge{display:inline-block;padding:3px 10px;border-radius:4px;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px}
  .b-ok{background:var(--ok-bg);color:var(--ok)}
  .b-err{background:var(--err-bg);color:var(--err)}
  .b-pur{background:rgba(139,92,246,0.15);color:var(--p2)}

  /* FICHA CARDS */
  .ficha-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:1rem;transition:border-color 0.2s}
  .ficha-card:hover{border-color:rgba(139,92,246,0.35)}
  .ficha-card-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem}
  .ficha-card-header h3{font-size:1rem;font-weight:600}
  .ficha-tag{display:inline-block;background:rgba(139,92,246,0.15);color:var(--p2);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;padding:3px 10px;border-radius:4px;margin-bottom:6px}
  .ex-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:0}
  .ex-grid-head{font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);padding:0.4rem 0;border-bottom:1px solid var(--border);margin-bottom:0.25rem}
  .ex-row{display:contents}
  .ex-row div{padding:0.55rem 0;border-bottom:1px solid rgba(255,255,255,0.03);font-size:0.85rem;display:flex;align-items:center;gap:6px}
  .ex-row:last-child div{border-bottom:none}
  .ex-dot{width:5px;height:5px;border-radius:50%;background:var(--p1);flex-shrink:0}
  .ex-s{color:var(--muted)}
  .ex-c{color:var(--gold2);font-weight:600}

  /* CADASTRO FORM */
  .cadastro-wrap{max-width:600px}
  .cadastro-form{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:2rem;overflow:hidden}
  .form-section{margin-bottom:1.75rem}
  .form-section-title{display:flex;align-items:center;gap:8px;font-size:0.75rem;text-transform:uppercase;letter-spacing:2px;color:var(--p1);font-weight:700;margin-bottom:1.25rem}
  .form-section-title::before{content:'□';font-size:0.9rem}
  .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
  .form-row.single{grid-template-columns:1fr}
  .form-divider{height:1px;background:var(--border);margin:1.5rem 0}
  .form-actions{display:flex;gap:0.75rem;justify-content:flex-end;padding-top:0.5rem}
  .required-mark{color:var(--err);margin-left:2px}

  /* MODALS */
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

  /* FORM ELEMENTS */
  .fg{display:flex;flex-direction:column;gap:0.4rem;margin-bottom:1.2rem}
  .fg label{font-size:0.82rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);font-weight:600}
  .fg input,.fg select,.fg textarea{background:rgba(255,255,255,0.04);border:1px solid var(--border);padding:0.75rem 1rem;border-radius:8px;color:var(--txt);font-family:'Barlow',sans-serif;font-size:0.9rem;transition:border-color 0.2s;width:100%}
  .fg input:focus,.fg select:focus,.fg textarea:focus{border-color:var(--p1);outline:none}
  .fg select option{background:#16161e}

  /* PREVIEW BOX */
  .preview-box{background:rgba(0,0,0,0.25);border:1px solid var(--border);border-radius:10px;padding:1rem;margin-top:0.25rem}
  .preview-header{display:grid;grid-template-columns:2fr 1fr 1fr;font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted);padding-bottom:0.5rem;border-bottom:1px solid var(--border);margin-bottom:0.25rem}
  .preview-row{display:grid;grid-template-columns:2fr 1fr 1fr;padding:0.6rem 0;border-bottom:1px solid rgba(255,255,255,0.04);align-items:center;font-size:0.85rem}
  .preview-row:last-child{border-bottom:none}
  .preview-row .p-name{display:flex;align-items:center;gap:7px}
  .p-dot{width:5px;height:5px;border-radius:50%;background:var(--p1);flex-shrink:0}
  .preview-row .p-s{color:var(--muted)}
  .preview-row .p-c{color:var(--gold2);font-weight:600}
  .m-actions{display:flex;gap:0.75rem;justify-content:flex-end;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border)}

  /* MODAL CONFIRMAÇÃO DELETE */
  .modal-confirm{max-width:420px}
  .confirm-icon{width:56px;height:56px;border-radius:50%;background:var(--err-bg);border:1px solid rgba(239,68,68,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.5rem;color:var(--err)}
  .confirm-title{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;letter-spacing:1px;text-align:center;margin-bottom:0.5rem}
  .confirm-desc{font-size:0.88rem;color:var(--muted);text-align:center;line-height:1.6}
  .confirm-desc strong{color:var(--txt)}
  .confirm-warn{margin-top:1rem;background:var(--err-bg);border:1px solid rgba(239,68,68,0.2);border-radius:8px;padding:0.75rem 1rem;font-size:0.8rem;color:#f87171;display:flex;align-items:center;gap:8px}

  /* TOAST */
  .toast{position:fixed;bottom:1.5rem;right:1.5rem;background:#1e1e2a;border:1px solid rgba(139,92,246,0.3);border-radius:10px;padding:0.85rem 1.25rem;font-size:0.88rem;display:flex;align-items:center;gap:10px;z-index:9999;transform:translateY(20px);opacity:0;transition:all 0.3s;pointer-events:none;max-width:320px}
  .toast.show{transform:translateY(0);opacity:1}
  .toast.ok{border-color:rgba(16,185,129,0.4);color:var(--ok)}
  .toast.warn{border-color:rgba(245,158,11,0.4);color:var(--warn)}
  .toast i{font-size:18px;flex-shrink:0}

  /* EMPTY STATE */
  .empty-row td{text-align:center;color:var(--muted);padding:2rem;font-size:0.85rem}

  @media(max-width:768px){
    .lay{flex-direction:column;height:auto}
    .sb{width:100%;height:auto;padding:1rem}
    .logo{padding-bottom:0.5rem}
    .main{padding:1.25rem;overflow-y:unset}
    body{overflow:auto}
  }
</style>
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

    <!-- VISÃO GERAL -->
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
          <div class="val purple-c">Musculação</div>
          <sub>Principal</sub>
        </div>
        <div class="stat gold">
          <label>Carga Horária</label>
          <div class="val gold-c">8h / dia</div>
          <sub>Turno completo</sub>
        </div>
        <div class="stat amber">
          <label>Turno</label>
          <div class="val amber-c">Noite</div>
          <sub>Designado</sub>
        </div>
        <div class="stat">
          <label>Alunos sob tutela</label>
          <div class="val purple-c" id="stat-qtd-alunos">0</div>
          <sub id="stat-sub-pendencia">0 sem ficha ativa</sub>
        </div>
      </div>

      <div class="sec-title">Alunos com Pendência <span>Atenção</span></div>
      <div class="tbl-wrap">
        <table>
          <thead><tr><th>Aluno</th><th>Situação</th><th>Ação Rápida</th></tr></thead>
          <tbody id="tabela-pendencias"></tbody>
        </table>
      </div>
    </section>

    <!-- GERENCIAR ALUNOS -->
    <section class="sec" id="sec-alunos">
      <div class="pg-header">
        <div>
          <h1>Gladiadores sob sua Tutela</h1>
          <p>Visualize e vincule fichas de treino a cada aluno.</p>
        </div>
      </div>
      <div class="tbl-wrap">
        <div class="tbl-head"><h3>Alunos Ativos</h3><span style="font-size:0.8rem;color:var(--muted)" id="contador-alunos-lista">0 alunos</span></div>
        <table>
          <thead>
            <tr><th>Aluno</th><th>Última Ficha Vinculada</th><th>Situação</th><th>Ações</th></tr>
          </thead>
          <tbody id="tabela-alunos"></tbody>
        </table>
      </div>
    </section>

    <!-- CADASTRAR ALUNO -->
    <section class="sec" id="sec-cadastro">
      <div class="pg-header">
        <div>
          <h1>Cadastrar Novo Aluno</h1>
          <p>Matricule um novo gladiador na arena sob sua tutela.</p>
        </div>
      </div>
      <div class="cadastro-wrap">
        <div class="cadastro-form">

          <!-- DADOS PESSOAIS -->
          <div class="form-section">
            <div class="form-section-title">Dados Pessoais</div>
            <div class="form-row">
              <div class="fg">
                <label>Nome Completo <span class="required-mark">*</span></label>
                <input type="text" id="reg-nome" placeholder="Ex: Júlio César Oliveira">
              </div>
              <div class="fg">
                <label>E-mail <span class="required-mark">*</span></label>
                <input type="email" id="reg-email" placeholder="email@exemplo.com">
              </div>
            </div>
            <div class="form-row">
              <div class="fg">
                <label>Telefone</label>
                <input type="tel" id="reg-telefone" placeholder="(49) 99999-0000">
              </div>
              <div class="fg">
                <label>Data de Nascimento</label>
                <input type="date" id="reg-nascimento">
              </div>
            </div>
          </div>

          <div class="form-divider"></div>

          <!-- PLANO & CONTRATO -->
          <div class="form-section">
            <div class="form-section-title">Plano &amp; Contrato</div>
            <div class="form-row">
              <div class="fg">
                <label>Plano <span class="required-mark">*</span></label>
                <select id="reg-plano">
                  <option value="">Selecione um plano</option>
                  <option value="mensal">Mensal</option>
                  <option value="trimestral">Trimestral</option>
                  <option value="semestral">Semestral</option>
                  <option value="anual">Anual</option>
                </select>
              </div>
              <div class="fg">
                <label>Turno Preferencial</label>
                <select id="reg-turno">
                  <option value="manha">Manhã</option>
                  <option value="tarde">Tarde</option>
                  <option value="noite" selected>Noite</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-divider"></div>

          <!-- FICHA INICIAL -->
          <div class="form-section" style="margin-bottom:0">
            <div class="form-section-title">Ficha Inicial (Opcional)</div>
            <div class="form-row">
              <div class="fg">
                <label>Vincular Ficha</label>
                <select id="reg-ficha">
                  <option value="">Sem ficha no momento</option>
                  <option value="0">Pack A — Peito, Ombro e Tríceps</option>
                  <option value="1">Pack B — Coxas, Panturrilhas e Glúteos</option>
                  <option value="2">Pack C — Costas, Bíceps e Abdômen</option>
                </select>
              </div>
              <div class="fg">
                <label>Observações</label>
                <input type="text" id="reg-obs" placeholder="Lesões, restrições, objetivos...">
              </div>
            </div>
          </div>

        </div>

        <div class="form-actions" style="margin-top:1.25rem">
          <button class="btn ghost" onclick="limparCadastro()"><i class="ti ti-eraser"></i> Limpar</button>
          <button class="btn ok-btn" onclick="cadastrarAluno()"><i class="ti ti-user-check"></i> Cadastrar Gladiador</button>
        </div>
      </div>
    </section>

    <!-- FICHAS -->
    <section class="sec" id="sec-fichas">
      <div class="pg-header">
        <div>
          <h1>Grade de Fichas</h1>
          <p>Estrutura dos pacotes de treino disponíveis para vincular aos alunos.</p>
        </div>
      </div>

      <div class="ficha-card">
        <div class="ficha-card-header">
          <div>
            <span class="ficha-tag">Pack A</span>
            <h3>Peito, Ombro e Tríceps</h3>
          </div>
          <span style="font-size:0.8rem;color:var(--muted)">4 exercícios · 4 séries padrão</span>
        </div>
        <div class="ex-grid">
          <div class="ex-grid-head">Exercício</div><div class="ex-grid-head">Séries</div><div class="ex-grid-head">Carga</div>
          <div class="ex-row"><div><div class="ex-dot"></div>Supino Reto</div><div class="ex-s">4x 10</div><div class="ex-c">45kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Crucifixo Reto</div><div class="ex-s">3x 12</div><div class="ex-c">14kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Desenvolvimento c/ Halteres</div><div class="ex-s">4x 10</div><div class="ex-c">16kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Tríceps Corda</div><div class="ex-s">3x 15</div><div class="ex-c">25kg</div></div>
        </div>
      </div>

      <div class="ficha-card">
        <div class="ficha-card-header">
          <div>
            <span class="ficha-tag">Pack B</span>
            <h3>Coxas, Panturrilhas e Glúteos</h3>
          </div>
          <span style="font-size:0.8rem;color:var(--muted)">5 exercícios · 3–4 séries padrão</span>
        </div>
        <div class="ex-grid">
          <div class="ex-grid-head">Exercício</div><div class="ex-grid-head">Séries</div><div class="ex-grid-head">Carga</div>
          <div class="ex-row"><div><div class="ex-dot"></div>Agachamento Livre</div><div class="ex-s">4x 8</div><div class="ex-c">60kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Leg Press 45°</div><div class="ex-s">3x 10</div><div class="ex-c">160kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Cadeira Extensora</div><div class="ex-s">4x 12</div><div class="ex-c">40kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Cadeira Flexora</div><div class="ex-s">4x 12</div><div class="ex-c">35kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Gêmeos Sentado</div><div class="ex-s">4x 15</div><div class="ex-c">40kg</div></div>
        </div>
      </div>

      <div class="ficha-card">
        <div class="ficha-card-header">
          <div>
            <span class="ficha-tag">Pack C</span>
            <h3>Costas, Bíceps e Abdômen</h3>
          </div>
          <span style="font-size:0.8rem;color:var(--muted)">5 exercícios · 4 séries padrão</span>
        </div>
        <div class="ex-grid">
          <div class="ex-grid-head">Exercício</div><div class="ex-grid-head">Séries</div><div class="ex-grid-head">Carga</div>
          <div class="ex-row"><div><div class="ex-dot"></div>Puxada Frente</div><div class="ex-s">4x 10</div><div class="ex-c">50kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Remada Baixa</div><div class="ex-s">3x 12</div><div class="ex-c">45kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Crucifixo Invertido</div><div class="ex-s">3x 12</div><div class="ex-c">8kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Rosca Direta</div><div class="ex-s">4x 10</div><div class="ex-c">12kg</div></div>
          <div class="ex-row"><div><div class="ex-dot"></div>Rosca Martelo</div><div class="ex-s">3x 12</div><div class="ex-c">10kg</div></div>
        </div>
      </div>
    </section>

  </main>
</div>

<!-- MODAL VINCULAR FICHA -->
<div class="overlay" id="m-montar">
  <div class="modal">
    <div class="m-head">
      <h2>Vincular Nova Ficha</h2>
      <button class="close" onclick="closeM('m-montar')"><i class="ti ti-x"></i></button>
    </div>
    <div class="m-body">
      <p class="m-subtitle">Montando ficha para: <strong id="modal-nome-aluno">—</strong></p>

      <div class="fg">
        <label>Ficha de Treino</label>
        <select id="select-ficha" onchange="updatePreview()">
          <option value="0">Pack A — Peito, Ombro e Tríceps</option>
          <option value="1">Pack B — Coxas, Panturrilhas e Glúteos</option>
          <option value="2">Pack C — Costas, Bíceps e Abdômen</option>
        </select>
      </div>

      <div class="fg">
        <label>Prévia dos Exercícios</label>
        <div class="preview-box">
          <div class="preview-header"><span>Exercício</span><span>Séries</span><span>Carga</span></div>
          <div id="preview-list"></div>
        </div>
      </div>

      <div class="fg">
        <label>Observações do Instrutor <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--muted)">(opcional)</span></label>
        <textarea id="obs" rows="2" placeholder="Ex: Cadência 4020. Descanso estrito de 60 segundos..."></textarea>
      </div>

      <div class="m-actions">
        <button class="btn ghost" onclick="closeM('m-montar')"><i class="ti ti-x"></i> Cancelar</button>
        <button class="btn ok-btn" onclick="salvarFicha()"><i class="ti ti-check"></i> Salvar e Vincular</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL CONFIRMAÇÃO DELETE -->
<div class="overlay" id="m-confirmar-delete">
  <div class="modal modal-confirm">
    <div class="m-body" style="padding:2rem">
      <div class="confirm-icon"><i class="ti ti-trash"></i></div>
      <div class="confirm-title">Remover Aluno?</div>
      <p class="confirm-desc">Você tem certeza que deseja remover o gladiador <strong id="confirm-nome-aluno">—</strong> da arena?</p>
      <div class="confirm-warn">
        <i class="ti ti-alert-triangle"></i>
        Esta ação não poderá ser desfeita. Todos os dados do aluno serão perdidos.
      </div>
      <div class="m-actions" style="margin-top:1.5rem">
        <button class="btn ghost" onclick="closeM('m-confirmar-delete')"><i class="ti ti-x"></i> Cancelar</button>
        <button class="btn danger-btn" style="padding:0.55rem 1.1rem" onclick="confirmarDelete()"><i class="ti ti-trash"></i> Sim, remover</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"><i class="ti ti-check"></i><span id="toast-msg"></span></div>

<script>
  const DB = {
    0: [{n:'Supino Reto',s:'4x 10',c:'45kg'},{n:'Crucifixo Reto',s:'3x 12',c:'14kg'},{n:'Desenvolvimento c/ Halteres',s:'4x 10',c:'16kg'},{n:'Tríceps Corda',s:'3x 15',c:'25kg'}],
    1: [{n:'Agachamento Livre',s:'4x 8',c:'60kg'},{n:'Leg Press 45°',s:'3x 10',c:'160kg'},{n:'Cadeira Extensora',s:'4x 12',c:'40kg'},{n:'Cadeira Flexora',s:'4x 12',c:'35kg'},{n:'Gêmeos Sentado',s:'4x 15',c:'40kg'}],
    2: [{n:'Puxada Frente',s:'4x 10',c:'50kg'},{n:'Remada Baixa',s:'3x 12',c:'45kg'},{n:'Crucifixo Invertido',s:'3x 12',c:'8kg'},{n:'Rosca Direta',s:'4x 10',c:'12kg'},{n:'Rosca Martelo',s:'3x 12',c:'10kg'}]
  };

  let alunos = [
    { id: 1, nome: 'Marcus Aurelius', treino: 'Pack A — Peito, Ombro e Tríceps', temFicha: true },
    { id: 2, nome: 'Spartacus da Silva', treino: 'Pack B — Coxas, Panturrilhas e Glúteos', temFicha: true },
    { id: 3, nome: 'Athena Palas', treino: 'Nenhuma cadastrada', temFicha: false }
  ];

  let alunoSelecionadoId = null;
  let alunoParaDeletarId = null;

  // --- NAVEGAÇÃO ---
  function go(id, btn) {
    document.querySelectorAll('.sec').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('sec-' + id).classList.add('active');
    btn.classList.add('active');
  }

  // --- TOAST ---
  function toast(msg, tipo = 'ok') {
    const t = document.getElementById('toast');
    const icon = t.querySelector('i');
    document.getElementById('toast-msg').textContent = msg;
    t.className = 'toast ' + tipo;
    icon.className = tipo === 'ok' ? 'ti ti-check' : 'ti ti-alert-triangle';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  // --- RENDER PAINEL ---
  function renderizarPainel() {
    const tbodyAlunos = document.getElementById('tabela-alunos');
    const tbodyPendencias = document.getElementById('tabela-pendencias');
    tbodyAlunos.innerHTML = '';
    tbodyPendencias.innerHTML = '';

    let pendenciasQtd = 0;

    if (alunos.length === 0) {
      tbodyAlunos.innerHTML = '<tr class="empty-row"><td colspan="4">Nenhum aluno cadastrado ainda.</td></tr>';
    }

    alunos.forEach(aluno => {
      // Linha da aba "Gerenciar Alunos"
      const trAluno = document.createElement('tr');
      trAluno.innerHTML = `
        <td><strong>${aluno.nome}</strong></td>
        <td style="${!aluno.temFicha ? 'color:var(--muted)' : ''}">${aluno.treino}</td>
        <td><span class="badge ${aluno.temFicha ? 'b-ok' : 'b-err'}">${aluno.temFicha ? 'Atualizada' : 'Sem Ficha'}</span></td>
        <td>
          <div class="actions-cell">
            <button class="btn" onclick="openModalFicha(${aluno.id})">
              <i class="ti ${aluno.temFicha ? 'ti-edit' : 'ti-plus'}"></i> ${aluno.temFicha ? 'Nova Ficha' : 'Criar Ficha'}
            </button>
            <button class="btn danger-btn" onclick="deletarAluno(${aluno.id})" title="Remover Aluno">
              <i class="ti ti-trash"></i>
            </button>
          </div>
        </td>
      `;
      tbodyAlunos.appendChild(trAluno);

      // Parte da linha de pendência na "Visão Geral"
      if (!aluno.temFicha) {
        pendenciasQtd++;
        const trPendencia = document.createElement('tr');
        trPendencia.innerHTML = `
          <td><strong>${aluno.nome}</strong><span class="sub">Sem ficha cadastrada</span></td>
          <td><span class="badge b-err">Sem Ficha</span></td>
          <td><button class="btn" onclick="openModalFicha(${aluno.id})"><i class="ti ti-plus"></i> Criar Ficha</button></td>
        `;
        tbodyPendencias.appendChild(trPendencia);
      }
    });

    if (pendenciasQtd === 0 && alunos.length > 0) {
      tbodyPendencias.innerHTML = '<tr class="empty-row"><td colspan="3">✅ Todos os alunos estão com fichas ativas.</td></tr>';
    } else if (alunos.length === 0) {
      tbodyPendencias.innerHTML = '<tr class="empty-row"><td colspan="3">Nenhum aluno cadastrado ainda.</td></tr>';
    }

    document.getElementById('stat-qtd-alunos').textContent = alunos.length;
    document.getElementById('stat-sub-pendencia').textContent = `${pendenciasQtd} sem ficha ativa`;
    document.getElementById('contador-alunos-lista').textContent = `${alunos.length} aluno${alunos.length !== 1 ? 's' : ''}`;
  }

  // --- DELETAR ALUNO ---
  function deletarAluno(id) {
    const aluno = alunos.find(a => a.id === id);
    if (!aluno) return;
    alunoParaDeletarId = id;
    document.getElementById('confirm-nome-aluno').textContent = aluno.nome;
    document.getElementById('m-confirmar-delete').classList.add('on');
  }

  function confirmarDelete() {
    const aluno = alunos.find(a => a.id === alunoParaDeletarId);
    if (!aluno) return;
    alunos = alunos.filter(a => a.id !== alunoParaDeletarId);
    alunoParaDeletarId = null;
    closeM('m-confirmar-delete');
    renderizarPainel();
    toast(`${aluno.nome} foi removido com sucesso.`, 'warn');
  }

  // --- MODAL FICHA ---
  function openModalFicha(id) {
    alunoSelecionadoId = id;
    const aluno = alunos.find(a => a.id === id);
    if (!aluno) return;
    document.getElementById('modal-nome-aluno').textContent = aluno.nome;
    document.getElementById('obs').value = '';
    document.getElementById('select-ficha').value = 0;
    updatePreview();
    document.getElementById('m-montar').classList.add('on');
  }

  function closeM(modalId) {
    document.getElementById(modalId).classList.remove('on');
  }

  // Fecha modais clicando no fundo escuro 
  document.getElementById('m-montar').addEventListener('click', function(e) {
    if (e.target === this) closeM('m-montar');
  });
  document.getElementById('m-confirmar-delete').addEventListener('click', function(e) {
    if (e.target === this) closeM('m-confirmar-delete');
  });

  // --- PREVIEW ---
  function updatePreview() {
    const v = document.getElementById('select-ficha').value;
    document.getElementById('preview-list').innerHTML = DB[v].map(e => `
      <div class="preview-row">
        <div class="p-name"><div class="p-dot"></div>${e.n}</div>
        <div class="p-s">${e.s}</div>
        <div class="p-c">${e.c}</div>
      </div>
    `).join('');
  }

  // --- SALVAR FICHA ---
  function salvarFicha() {
    const sel = document.getElementById('select-ficha');
    const nomeFicha = sel.options[sel.selectedIndex].text;

    const aluno = alunos.find(a => a.id === alunoSelecionadoId);
    if (!aluno) return;

    aluno.treino = nomeFicha;
    aluno.temFicha = true;

    closeM('m-montar');
    renderizarPainel();
    toast(`Ficha vinculada com sucesso para ${aluno.nome}!`);
  }

  // --- CADASTRAR ALUNO ---
  function limparCadastro() {
    ['reg-nome','reg-email','reg-telefone','reg-nascimento','reg-obs'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('reg-plano').value = '';
    document.getElementById('reg-turno').value = 'noite';
    document.getElementById('reg-ficha').value = '';
  }

  function cadastrarAluno() {
    const nomeInput = document.getElementById('reg-nome').value.trim();
    const emailInput = document.getElementById('reg-email').value.trim();
    const planoInput = document.getElementById('reg-plano').value;

    if (!nomeInput) { toast('Por favor, insira o nome do aluno.', 'warn'); return; }
    if (!emailInput) { toast('Por favor, insira o e-mail do aluno.', 'warn'); return; }
    if (!planoInput) { toast('Por favor, selecione um plano.', 'warn'); return; }

    const fichaIdx = document.getElementById('reg-ficha').value;
    const fichaOpts = document.getElementById('reg-ficha').options;
    const temFicha = fichaIdx !== '';
    const nomeFicha = temFicha ? fichaOpts[document.getElementById('reg-ficha').selectedIndex].text : 'Nenhuma cadastrada';

    const novoAluno = {
      id: Date.now(),
      nome: nomeInput,
      email: emailInput,
      treino: nomeFicha,
      temFicha: temFicha
    };

    alunos.push(novoAluno);
    limparCadastro();
    renderizarPainel();
    toast(`${nomeInput} foi adicionado com sucesso!`);

    // Navega para Gerenciar Alunos
    const btnAlunos = document.querySelectorAll('.nav-btn')[1];
    go('alunos', btnAlunos);
  }

  // Inicialização
  renderizarPainel();
  updatePreview();
</script>
</body>
</html>