<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel do Gladiador — Coliseu Gym</title>
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
  .logout{background:transparent;border:1px solid rgba(239,68,68,0.25);color:#f87171;padding:0.65rem;border-radius:8px;cursor:pointer;font-weight:600;font-size:0.85rem;width:100%;transition:all 0.2s;font-family:'Barlow',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px}
  .logout:hover{background:var(--err);color:#fff;border-color:var(--err)}

  /* MAIN */
  .main{flex:1;overflow-y:auto;padding:2rem 2.5rem}
  .sec{display:none}
  .sec.active{display:block}
  .pg-header{margin-bottom:2rem}
  .pg-header h1{font-family:'Bebas Neue',sans-serif;font-size:2.5rem;letter-spacing:1px;line-height:1}
  .pg-header p{color:var(--muted);font-size:0.9rem;margin-top:6px}

  /* STATS */
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:2rem}
  .stat{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;position:relative;overflow:hidden}
  .stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--p1);border-radius:3px 0 0 3px}
  .stat.gold::before{background:var(--gold)}
  .stat.ok::before{background:var(--ok)}
  .stat label{display:block;font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-bottom:8px}
  .stat .val{font-family:'Bebas Neue',sans-serif;font-size:2rem;line-height:1;margin-bottom:6px}
  .stat .val.gold-c{color:var(--gold2)}
  .stat .val.purple-c{color:var(--p2)}
  .stat sub{font-size:0.8rem;color:var(--muted)}
  .stat sub.ok{color:var(--ok)}

  /* SECTION TITLE */
  .sec-title{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:1px;margin-bottom:1.25rem;display:flex;align-items:center;gap:12px}
  .sec-title span{font-size:0.75rem;font-family:'Barlow',sans-serif;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--p1);border:1px solid rgba(139,92,246,0.3);padding:3px 10px;border-radius:20px}

  /* TRAINING CARDS */
  .treino-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;transition:border-color 0.2s}
  .treino-card:hover{border-color:rgba(139,92,246,0.35)}
  .treino-card .tc-left{flex:1}
  .treino-card .tc-tag{display:inline-block;background:rgba(139,92,246,0.15);color:var(--p2);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;padding:3px 10px;border-radius:4px;margin-bottom:8px}
  .treino-card h3{font-size:1.05rem;font-weight:600;margin-bottom:4px}
  .treino-card p{font-size:0.82rem;color:var(--muted)}
  .treino-card .obs{font-size:0.8rem;color:var(--gold2);margin-top:6px;display:flex;align-items:center;gap:6px}

  /* BUTTONS */
  .btn{background:var(--p1);color:#fff;border:none;padding:0.6rem 1.25rem;border-radius:8px;font-weight:600;cursor:pointer;font-family:'Barlow',sans-serif;font-size:0.85rem;transition:all 0.2s;display:inline-flex;align-items:center;gap:6px;white-space:nowrap}
  .btn:hover{background:var(--p3);transform:translateY(-1px)}
  .btn.gold-btn{background:rgba(201,162,39,0.15);color:var(--gold2);border:1px solid rgba(201,162,39,0.3)}
  .btn.gold-btn:hover{background:var(--gold);color:#000}
  .btn.ok-btn{background:rgba(16,185,129,0.15);color:var(--ok);border:1px solid rgba(16,185,129,0.3)}
  .btn.ok-btn:hover{background:var(--ok);color:#fff}

  /* TABLE */
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

  /* BADGE */
  .badge{display:inline-block;padding:3px 10px;border-radius:4px;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px}
  .b-ok{background:var(--ok-bg);color:var(--ok)}
  .b-warn{background:var(--warn-bg);color:var(--warn)}
  .b-err{background:var(--err-bg);color:var(--err)}
  .b-pur{background:rgba(139,92,246,0.15);color:var(--p2)}

  /* PESO CHART */
  .peso-blk{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:2rem}
  .peso-blk-head{padding:1rem 1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
  .peso-blk-title{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;letter-spacing:1px;color:var(--gold2)}
  .peso-blk-sub{font-size:0.75rem;color:var(--muted);margin-top:2px}
  .peso-metrics{display:flex;gap:10px;flex-wrap:wrap}
  .peso-metric{background:rgba(255,255,255,0.04);border-radius:8px;padding:8px 14px;min-width:90px}
  .peso-metric label{display:block;font-size:0.68rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);margin-bottom:4px}
  .peso-metric .pmv{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;line-height:1}
  .pmv.up{color:var(--err)}
  .pmv.down{color:var(--ok)}
  .pmv.neutral{color:var(--p2)}
  .peso-chart-area{padding:1rem 1.5rem 0.5rem}
  .peso-legend{display:flex;gap:16px;font-size:11px;color:var(--muted);margin-bottom:10px}
  .peso-leg-line{width:18px;height:2px;display:inline-block;vertical-align:middle;margin-right:4px}
  .peso-form-row{padding:1rem 1.5rem;border-top:1px solid var(--border);display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end}
  .peso-field{display:flex;flex-direction:column;gap:4px}
  .peso-field label{font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--muted)}
  .peso-field input[type=number],.peso-field input[type=month]{background:#1c1c26;border:1px solid rgba(139,92,246,0.25);border-radius:6px;color:var(--txt);padding:8px 10px;font-size:0.85rem;font-family:'Barlow',sans-serif;outline:none;height:38px}
  .peso-field input:focus{border-color:var(--p1)}
  .peso-add-btn{background:var(--p1);color:#fff;border:none;border-radius:8px;padding:0 18px;height:38px;font-weight:600;font-size:0.85rem;cursor:pointer;font-family:'Barlow',sans-serif;display:flex;align-items:center;gap:6px;transition:background 0.2s,transform 0.1s;white-space:nowrap}
  .peso-add-btn:hover{background:var(--p3);transform:translateY(-1px)}
  .peso-history{border-top:1px solid var(--border)}
  .peso-hist-row{display:flex;justify-content:space-between;align-items:center;padding:0.65rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.03);font-size:0.83rem}
  .peso-hist-row:last-child{border-bottom:none}
  .peso-hist-row .hdate{color:var(--muted)}
  .peso-hist-row .hval{font-weight:600;font-family:'Bebas Neue',sans-serif;font-size:1rem}
  .hdiff{font-size:0.75rem;font-weight:600;padding:2px 8px;border-radius:4px}
  .hdiff.up{background:rgba(239,68,68,0.12);color:var(--err)}
  .hdiff.down{background:rgba(16,185,129,0.12);color:var(--ok)}
  .hdiff.zero{background:rgba(139,92,246,0.12);color:var(--p2)}
  .peso-del-btn{background:none;border:none;color:var(--muted);cursor:pointer;padding:4px;border-radius:4px;font-size:14px;line-height:1}
  .peso-del-btn:hover{background:rgba(239,68,68,0.15);color:var(--err)}
  .peso-empty{color:var(--muted);font-size:0.82rem;padding:1rem 1.5rem}
  .peso-toast{position:fixed;bottom:24px;right:24px;background:var(--ok);color:#fff;padding:10px 18px;border-radius:8px;font-size:0.82rem;font-weight:600;opacity:0;pointer-events:none;transition:opacity 0.3s;z-index:9999}
  .peso-toast.show{opacity:1}

  /* MODAL */
  .overlay{position:fixed;inset:0;background:rgba(0,0,0,0.8);display:none;align-items:center;justify-content:center;z-index:999;padding:1rem}
  .overlay.on{display:flex}
  .modal{background:#16161e;border:1px solid rgba(139,92,246,0.2);border-radius:16px;width:100%;max-width:580px;max-height:85vh;overflow-y:auto;animation:pop 0.25s ease}
  @keyframes pop{from{transform:scale(0.95) translateY(10px);opacity:0}to{transform:scale(1) translateY(0);opacity:1}}
  .m-head{padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;background:#16161e;z-index:1}
  .m-head h2{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;color:var(--gold2);letter-spacing:1px}
  .close{background:transparent;border:none;color:var(--muted);font-size:1.3rem;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:all 0.2s}
  .close:hover{background:var(--err-bg);color:var(--err)}
  .m-body{padding:1.5rem}

  /* EXERCISE LIST */
  .ex-header{display:grid;grid-template-columns:2fr 1fr 1fr;padding:0 0 0.5rem;font-size:0.75rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);border-bottom:1px solid var(--border);margin-bottom:0.5rem}
  .ex-row{display:grid;grid-template-columns:2fr 1fr 1fr;padding:0.75rem 0;border-bottom:1px solid rgba(255,255,255,0.04);align-items:center}
  .ex-row:last-child{border-bottom:none}
  .ex-row .ex-n{display:flex;align-items:center;gap:8px;font-size:0.88rem}
  .ex-dot{width:6px;height:6px;border-radius:50%;background:var(--p1);flex-shrink:0}
  .ex-row .ex-s{font-size:0.88rem;color:var(--muted)}
  .ex-row .ex-c{font-size:0.88rem;color:var(--gold2);font-weight:600}

  /* SCHEDULE CARD */
  .sch-card{background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:10px;padding:1rem 1.25rem;margin-bottom:0.75rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;transition:border-color 0.2s}
  .sch-card:hover{border-color:rgba(16,185,129,0.3)}
  .sch-card strong{font-size:1rem}
  .sch-card .sch-meta{font-size:0.8rem;color:var(--muted);margin-top:3px}
  .sch-card .sch-time{background:rgba(139,92,246,0.1);color:var(--p2);font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:4px;display:inline-block;margin-top:4px}

  /* RESPONSIVE */
  @media(max-width:768px){
    .lay{flex-direction:column;height:auto}
    .sb{width:100%;height:auto;flex-direction:row;flex-wrap:wrap;padding:1rem;gap:0.5rem}
    .logo{padding-bottom:0;margin-right:auto}
    .sb-footer{margin-top:0;padding-top:0;display:flex;gap:0.5rem;align-items:center}
    .nav{flex-direction:row;flex-wrap:wrap;width:100%}
    .nav-btn.active{border-left:none;border-bottom:3px solid var(--p1);border-radius:8px 8px 0 0;padding-left:0.85rem}
    .main{padding:1.25rem;overflow-y:unset}
    body{overflow:auto}
  }
</style>
</head>
<body>
<div class="lay">
  <aside class="sb">
    <div class="logo">Coliseu <span>Gym</span><small>ARENA PAINEL</small></div>
    <nav class="nav">
      <button class="nav-btn active" onclick="go('inicio',this)"><i class="ti ti-home"></i> Início</button>
      <button class="nav-btn" onclick="go('treinos',this)"><i class="ti ti-barbell"></i> Fichas de Treino</button>
      <button class="nav-btn" onclick="go('aulas',this)"><i class="ti ti-calendar-event"></i> Aulas Coletivas</button>
      <button class="nav-btn" onclick="go('financeiro',this)"><i class="ti ti-receipt"></i> Financeiro</button>
    </nav>
    <div class="sb-footer">
      <div class="nav-sep"></div>
      <div class="user-pill">
        <div class="avatar">GL</div>
        <div class="user-info"><strong>Gladiador</strong><small>Plano Anual · Ativo</small></div>
      </div>
      <button class="logout" onclick="window.location.href='/login'"><i class="ti ti-door-exit"></i> Sair da Arena</button>
    </div>
  </aside>

  <main class="main">

    <!-- INÍCIO -->
    <section class="sec active" id="sec-inicio">
      <div class="pg-header">
        <h1>Saudações, Gladiador!</h1>
        <p>Acompanhe sua evolução, treinos e agendamentos para o combate de hoje.</p>
      </div>

      <div class="stats">
        <div class="stat gold">
          <label>Plano Ativo</label>
          <div class="val gold-c">Anual</div>
          <sub>Vence em 15/12/2026</sub>
        </div>
        <div class="stat">
          <label>Investimento</label>
          <div class="val purple-c">R$ 959,90</div>
          <sub class="ok">● Adimplente</sub>
        </div>
        <div class="stat ok">
          <label>Aulas este mês</label>
          <div class="val" style="color:var(--ok)">3</div>
          <sub>+1 agendada</sub>
        </div>
        <div class="stat">
          <label>Fichas Ativas</label>
          <div class="val purple-c">2</div>
          <sub>Expira 10/08/2026</sub>
        </div>
      </div>

      <!-- GRÁFICO DE EVOLUÇÃO DE PESO MENSAL -->
      <div class="sec-title">Evolução de Peso <span>Mensal</span></div>
      <div class="peso-blk">
        <div class="peso-blk-head">
          <div>
            <div class="peso-blk-title">Controle de Peso</div>
            <div class="peso-blk-sub">Registre mensalmente e acompanhe sua jornada</div>
          </div>
          <div class="peso-metrics">
            <div class="peso-metric">
              <label>Peso Atual</label>
              <div class="pmv neutral" id="m-atual">—</div>
            </div>
            <div class="peso-metric">
              <label>Variação Total</label>
              <div class="pmv neutral" id="m-total">—</div>
            </div>
            <div class="peso-metric">
              <label>Registros</label>
              <div class="pmv neutral" id="m-count">0</div>
            </div>
          </div>
        </div>

        <div class="peso-chart-area">
          <div class="peso-legend">
            <span>
              <span style="width:10px;height:10px;border-radius:50%;background:#8b5cf6;display:inline-block;vertical-align:middle;margin-right:4px"></span>
              Peso (kg)
            </span>
            <span>
              <span class="peso-leg-line" style="background:#10b981;border-top:2px dashed #10b981;width:18px;height:0;display:inline-block;vertical-align:middle;margin-right:4px"></span>
              Meta
            </span>
          </div>
          <div style="position:relative;width:100%;height:220px">
            <canvas id="pesoChart" role="img" aria-label="Gráfico de linha com evolução de peso mensal do aluno">Dados de peso mensais registrados pelo aluno.</canvas>
          </div>
        </div>

        <div class="peso-form-row">
          <div class="peso-field">
            <label><i class="ti ti-calendar" style="font-size:13px"></i> Mês</label>
            <input type="month" id="inp-mes" />
          </div>
          <div class="peso-field">
            <label><i class="ti ti-weight" style="font-size:13px"></i> Peso (kg)</label>
            <input type="number" id="inp-peso" step="0.1" min="30" max="300" placeholder="Ex: 82.5" style="width:120px" />
          </div>
          <div class="peso-field">
            <label><i class="ti ti-target" style="font-size:13px"></i> Meta (kg)</label>
            <input type="number" id="inp-meta" step="0.1" min="30" max="300" placeholder="Ex: 78.0" style="width:110px" />
          </div>
          <button class="peso-add-btn" onclick="addRegistro()">
            <i class="ti ti-plus"></i> Registrar
          </button>
        </div>

        <div class="peso-history" id="history-list">
          <div class="peso-empty">Nenhum registro ainda. Adicione seu primeiro peso acima! 💪</div>
        </div>
      </div>

      <!-- PRÓXIMAS AULAS -->
      <div class="sec-title">Próximas Aulas <span>Agenda</span></div>
      <div class="tbl-wrap">
        <table>
          <thead>
            <tr><th>Aula</th><th>Data &amp; Hora</th><th>Status</th></tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Spinning</strong><span class="sub">Mestre Kirk Douglas</span></td>
              <td>09/06 · 19:30</td>
              <td><span class="badge b-ok">Confirmada</span></td>
            </tr>
            <tr>
              <td><strong>Cross Combat</strong><span class="sub">Instrutora Athena</span></td>
              <td>11/06 · 07:00</td>
              <td><span class="badge b-warn">Aguardando</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- TREINOS -->
    <section class="sec" id="sec-treinos">
      <div class="pg-header">
        <h1>Fichas de Treino</h1>
        <p>Suas prescrições ativas para o período atual.</p>
      </div>
      <div class="treino-card">
        <div class="tc-left">
          <span class="tc-tag">Ficha A</span>
          <h3>Membros Superiores — Hipertrofia</h3>
          <p>Iniciou em 10/05/2026 · Expira em 10/08/2026</p>
          <div class="obs"><i class="ti ti-alert-circle" style="font-size:14px"></i> Focar na cadência e controle de carga no supino.</div>
        </div>
        <button class="btn" onclick="openTreino('A','Membros Superiores — Hipertrofia')"><i class="ti ti-list-details"></i> Visualizar</button>
      </div>
      <div class="treino-card">
        <div class="tc-left">
          <span class="tc-tag">Ficha B</span>
          <h3>Membros Inferiores &amp; Core</h3>
          <p>Iniciou em 10/05/2026 · Expira em 10/08/2026</p>
        </div>
        <button class="btn" onclick="openTreino('B','Membros Inferiores &amp; Core')"><i class="ti ti-list-details"></i> Visualizar</button>
      </div>
    </section>

    <!-- AULAS -->
    <section class="sec" id="sec-aulas">
      <div class="pg-header">
        <h1>Aulas Coletivas</h1>
        <p>Suas reservas e histórico de participação.</p>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <div class="sec-title" style="margin-bottom:0">Suas Reservas <span>3 ativas</span></div>
        <button class="btn gold-btn" onclick="openAgendar()"><i class="ti ti-calendar-plus"></i> Agendar Aula</button>
      </div>
      <div class="tbl-wrap">
        <table id="tbl-aulas">
          <thead>
            <tr><th>Modalidade</th><th>Instrutor</th><th>Data &amp; Hora</th><th>Vagas</th><th>Status</th></tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Spinning</strong></td>
              <td>Mestre Kirk Douglas</td>
              <td>09/06 · 19:30</td>
              <td>14</td>
              <td><span class="badge b-ok">Confirmada</span></td>
            </tr>
            <tr>
              <td><strong>Cross Combat</strong></td>
              <td>Instrutora Athena</td>
              <td>11/06 · 07:00</td>
              <td>5</td>
              <td><span class="badge b-warn">Aguardando</span></td>
            </tr>
            <tr>
              <td><strong>Zumba</strong></td>
              <td>Prof. Alan</td>
              <td>05/06 · 18:00</td>
              <td>—</td>
              <td><span class="badge b-pur">Presença OK</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- FINANCEIRO -->
    <section class="sec" id="sec-financeiro">
      <div class="pg-header">
        <h1>Histórico Financeiro</h1>
        <p>Todas as transações e faturas do seu plano.</p>
      </div>
      <div class="tbl-wrap">
        <div class="tbl-head">
          <h3>Faturas</h3>
          <span style="font-size:0.8rem;color:var(--ok)">● Adimplente</span>
        </div>
        <table>
          <thead>
            <tr><th>Fatura</th><th>Método</th><th>Data</th><th>Valor</th><th>Status</th></tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>#9834</strong></td>
              <td>Pix</td>
              <td>05/05/2026</td>
              <td style="font-weight:600;color:var(--gold2)">R$ 959,90</td>
              <td><span class="badge b-ok">Pago</span></td>
            </tr>
            <tr>
              <td><strong>#8432</strong></td>
              <td>Cartão de Crédito</td>
              <td>05/05/2025</td>
              <td style="font-weight:600;color:var(--gold2)">R$ 539,90</td>
              <td><span class="badge b-ok">Pago</span></td>
            </tr>
            <tr>
              <td><strong>#7112</strong></td>
              <td>Boleto Bancário</td>
              <td>12/02/2025</td>
              <td style="font-weight:600;color:var(--muted)">R$ 119,90</td>
              <td><span class="badge b-err">Cancelado</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

  </main>
</div>

<!-- MODAL TREINO -->
<div class="overlay" id="m-treino" onclick="closeIf(event,'m-treino')">
  <div class="modal">
    <div class="m-head">
      <h2 id="m-treino-title">Ficha</h2>
      <button class="close" onclick="closeM('m-treino')"><i class="ti ti-x"></i></button>
    </div>
    <div class="m-body">
      <div class="ex-header"><span>Exercício</span><span>Séries</span><span>Carga</span></div>
      <div id="ex-list"></div>
    </div>
  </div>
</div>

<!-- MODAL AGENDAR -->
<div class="overlay" id="m-agendar" onclick="closeIf(event,'m-agendar')">
  <div class="modal">
    <div class="m-head">
      <h2>Grade Disponível</h2>
      <button class="close" onclick="closeM('m-agendar')"><i class="ti ti-x"></i></button>
    </div>
    <div class="m-body">
      <p style="font-size:0.85rem;color:var(--muted);margin-bottom:1.25rem">Selecione uma batalha disponível esta semana na arena:</p>
      <div id="sch-list">
        <div class="sch-card" id="sc1">
          <div>
            <strong>Yoga Integral</strong>
            <div class="sch-meta">Mestre Shifu</div>
            <span class="sch-time"><i class="ti ti-clock" style="font-size:11px"></i> Amanhã · 08:00</span>
          </div>
          <button class="btn ok-btn" onclick="book('Yoga Integral','Mestre Shifu','Amanhã · 08:00','sc1')"><i class="ti ti-check"></i> Reservar</button>
        </div>
        <div class="sch-card" id="sc2">
          <div>
            <strong>Pilates Solo</strong>
            <div class="sch-meta">Instrutora Diana</div>
            <span class="sch-time"><i class="ti ti-clock" style="font-size:11px"></i> Quinta · 17:00</span>
          </div>
          <button class="btn ok-btn" onclick="book('Pilates Solo','Instrutora Diana','Quinta · 17:00','sc2')"><i class="ti ti-check"></i> Reservar</button>
        </div>
        <div class="sch-card" id="sc3">
          <div>
            <strong>Functional Fit</strong>
            <div class="sch-meta">Professor Thor</div>
            <span class="sch-time"><i class="ti ti-clock" style="font-size:11px"></i> Sexta · 19:00</span>
          </div>
          <button class="btn ok-btn" onclick="book('Functional Fit','Professor Thor','Sexta · 19:00','sc3')"><i class="ti ti-check"></i> Reservar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MENSAGEM DE SALVO-->
<div class="peso-toast" id="peso-toast">Registro salvo com sucesso!</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
  /*  NAVEGAÇÃO */
  const DB = {
    A: [
      {n:'Supino Reto com Barra', s:'4x 10', c:'35kg/lado'},
      {n:'Puxada Alta no Pulley', s:'4x 12', c:'50kg'},
      {n:'Desenvolvimento c/ Halteres', s:'3x 10', c:'16kg/lado'},
      {n:'Rosca Direta na Barra W', s:'3x 12', c:'12kg/lado'},
      {n:'Tríceps Corda', s:'4x 10', c:'25kg'}
    ],
    B: [
      {n:'Agachamento Livre', s:'4x 8', c:'40kg/lado'},
      {n:'Leg Press 45°', s:'4x 12', c:'180kg'},
      {n:'Cadeira Extensora', s:'3x Drop-Set', c:'45kg'},
      {n:'Mesa Flexora', s:'4x 10', c:'30kg'},
      {n:'Abdominal Supra na Polia', s:'4x 15', c:'35kg'}
    ]
  };

  function go(id, btn) {
    document.querySelectorAll('.sec').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('sec-' + id).classList.add('active');
    btn.classList.add('active');
  }

  function openTreino(f, nm) {
    document.getElementById('m-treino-title').textContent = 'Ficha ' + f + ' — ' + nm;
    document.getElementById('ex-list').innerHTML = DB[f].map(e =>
      `<div class="ex-row">
        <div class="ex-n"><div class="ex-dot"></div>${e.n}</div>
        <div class="ex-s">${e.s}</div>
        <div class="ex-c">${e.c}</div>
      </div>`
    ).join('');
    document.getElementById('m-treino').classList.add('on');
  }

  function openAgendar() {
    document.getElementById('m-agendar').classList.add('on');
  }

  function closeM(id) {
    document.getElementById(id).classList.remove('on');
  }

  function closeIf(e, id) {
    if (e.target.id === id) closeM(id);
  }

  function book(mod, inst, dt, cardId) {
    const c = document.getElementById(cardId);
    c.style.opacity = '0';
    c.style.transition = 'opacity 0.3s';
    setTimeout(() => c.remove(), 300);
    const tb = document.querySelector('#tbl-aulas tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><strong>${mod}</strong></td>
      <td>${inst}</td>
      <td>${dt}</td>
      <td>19</td>
      <td><span class="badge b-ok">Confirmada</span></td>
    `;
    tb.insertBefore(tr, tb.firstChild);
    closeM('m-agendar');
  }

  /* GRÁFICO MENSAL DO PESO*/
  let registros = JSON.parse(localStorage.getItem('coliseu_peso') || '[]');
  let metaPeso  = parseFloat(localStorage.getItem('coliseu_meta') || '0');

  const pesoCtx = document.getElementById('pesoChart').getContext('2d');
  const pesoChart = new Chart(pesoCtx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [
        {
          label: 'Peso (kg)',
          data: [],
          borderColor: '#8b5cf6',
          backgroundColor: 'rgba(139,92,246,0.1)',
          tension: 0.4,
          fill: true,
          pointBackgroundColor: '#a78bfa',
          pointRadius: 5,
          pointHoverRadius: 7,
          borderWidth: 2,
          pointBorderColor: '#13131a',
          pointBorderWidth: 2
        },
        {
          label: 'Meta',
          data: [],
          borderColor: '#10b981',
          borderDash: [6, 4],
          borderWidth: 1.5,
          pointRadius: 0,
          fill: false,
          tension: 0
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1c1c26',
          borderColor: 'rgba(139,92,246,0.3)',
          borderWidth: 1,
          titleColor: '#a78bfa',
          bodyColor: '#f0f0f5',
          padding: 10,
          callbacks: {
            label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y.toFixed(1) + ' kg'
          }
        }
      },
      scales: {
        x: {
          grid: { color: 'rgba(255,255,255,0.04)' },
          ticks: { color: '#7a7a8c', font: { size: 11 }, maxRotation: 30, autoSkip: false }
        },
        y: {
          grid: { color: 'rgba(255,255,255,0.06)' },
          ticks: { color: '#7a7a8c', font: { size: 11 }, callback: v => v.toFixed(1) + 'kg' }
        }
      }
    }
  });

  function fmtMes(ym) {
    const [y, m] = ym.split('-');
    const nomes = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    return nomes[parseInt(m) - 1] + '/' + y.slice(2);
  }

  function renderPeso() {
    const sorted = [...registros].sort((a, b) => a.mes.localeCompare(b.mes));

    pesoChart.data.labels = sorted.map(r => fmtMes(r.mes));
    pesoChart.data.datasets[0].data = sorted.map(r => r.peso);
    pesoChart.data.datasets[1].data = metaPeso > 0 ? sorted.map(() => metaPeso) : [];
    pesoChart.update();

    const ul = document.getElementById('history-list');

    if (sorted.length === 0) {
      ul.innerHTML = '<div class="peso-empty">Nenhum registro ainda. Adicione seu primeiro peso acima! 💪</div>';
      document.getElementById('m-atual').textContent = '—';
      document.getElementById('m-atual').className = 'pmv neutral';
      document.getElementById('m-total').textContent = '—';
      document.getElementById('m-total').className = 'pmv neutral';
      document.getElementById('m-count').textContent = '0';
      return;
    }

    const ultimo  = sorted[sorted.length - 1];
    const primeiro = sorted[0];
    const diff = +(ultimo.peso - primeiro.peso).toFixed(1);
    const diffStr = (diff > 0 ? '+' : '') + diff + 'kg';

    const mAtual = document.getElementById('m-atual');
    mAtual.textContent = ultimo.peso.toFixed(1) + 'kg';
    mAtual.className = 'pmv neutral';

    const mTotal = document.getElementById('m-total');
    mTotal.textContent = diffStr;
    mTotal.className = 'pmv ' + (diff > 0 ? 'up' : diff < 0 ? 'down' : 'neutral');

    document.getElementById('m-count').textContent = sorted.length;

    ul.innerHTML = [...sorted].reverse().map((r, i, arr) => {
      const prev = arr[i + 1];
      let difHtml = '';
      if (prev) {
        const d = +(r.peso - prev.peso).toFixed(1);
        const cls = d > 0 ? 'up' : d < 0 ? 'down' : 'zero';
        difHtml = `<span class="hdiff ${cls}">${(d > 0 ? '+' : '') + d}kg</span>`;
      } else {
        difHtml = '<span></span>';
      }
      return `<div class="peso-hist-row">
        <span class="hdate">${fmtMes(r.mes)}</span>
        <span class="hval">${r.peso.toFixed(1)} kg</span>
        ${difHtml}
        <button class="peso-del-btn" onclick="removeReg('${r.mes}')" title="Remover">
          <i class="ti ti-trash"></i>
        </button>
      </div>`;
    }).join('');
  }

  function addRegistro() {
    const mes  = document.getElementById('inp-mes').value;
    const peso = parseFloat(document.getElementById('inp-peso').value);
    const mt   = parseFloat(document.getElementById('inp-meta').value);

    if (!mes || isNaN(peso) || peso < 30) {
      alert('Informe o mês e um peso válido (mínimo 30 kg).');
      return;
    }

    registros = registros.filter(r => r.mes !== mes);
    registros.push({ mes, peso });

    if (!isNaN(mt) && mt > 0) {
      metaPeso = mt;
      localStorage.setItem('coliseu_meta', metaPeso);
    }

    localStorage.setItem('coliseu_peso', JSON.stringify(registros));
    document.getElementById('inp-peso').value = '';

    renderPeso();

    const toast = document.getElementById('peso-toast');
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2500);
  }

  function removeReg(mes) {
    registros = registros.filter(r => r.mes !== mes);
    localStorage.setItem('coliseu_peso', JSON.stringify(registros));
    renderPeso();
  }

  /* Define mês atual como padrão */
  const hoje = new Date();
  document.getElementById('inp-mes').value = hoje.toISOString().slice(0, 7);

  renderPeso();
</script>
</body>
</html>