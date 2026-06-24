<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Coliseu Gym')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  :root{--dark:#0a0a0e;--card:#13131a;--sidebar:#0f0f15;--p1:#8b5cf6;--p2:#a78bfa;--p3:#6d28d9;--gold:#c9a227;--gold2:#e4bb4a;--txt:#f0f0f5;--muted:#7a7a8c;--border:rgba(139,92,246,0.12);--ok:#10b981;--warn:#f59e0b;--err:#ef4444;--ok-bg:rgba(16,185,129,0.1);--warn-bg:rgba(245,158,11,0.1);--err-bg:rgba(239,68,68,0.1)}
  body{background:var(--dark);color:var(--txt);font-family:'Barlow',sans-serif;display:flex;min-height:100vh}
  .lay{display:flex;width:100%;min-height:100vh}
  .sb{width:240px;background:var(--sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;padding:1.5rem 0.75rem;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
  .logo{font-family:'Bebas Neue',sans-serif;font-size:2rem;padding:0 0.5rem 1.75rem;letter-spacing:2px;text-decoration:none;color:var(--txt);display:block}
  .logo span{color:var(--p1)}
  .logo small{display:block;font-size:0.5rem;letter-spacing:4px;color:var(--muted);font-family:'Barlow',sans-serif;font-weight:500;margin-top:-4px}
  .nav{display:flex;flex-direction:column;gap:2px}
  .nav-label{font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--muted);padding:0.6rem 0.85rem 0.2rem;display:block;opacity:0.5}
  .nav-link{color:var(--muted);padding:0.6rem 0.85rem;font-family:'Barlow',sans-serif;font-size:0.875rem;font-weight:500;border-radius:8px;display:flex;align-items:center;gap:0.65rem;transition:all 0.2s;text-decoration:none}
  .nav-link:hover{background:rgba(139,92,246,0.08);color:var(--txt)}
  .nav-link.active{background:rgba(139,92,246,0.15);color:var(--p2);border-left:3px solid var(--p1);border-radius:0 8px 8px 0;padding-left:calc(0.85rem - 3px)}
  .nav-link i{font-size:17px;flex-shrink:0}
  .nav-sep{height:1px;background:var(--border);margin:0.5rem 0}
  .sb-footer{margin-top:auto;padding-top:1rem}
  .user-pill{display:flex;align-items:center;gap:0.7rem;padding:0.7rem;border-radius:8px;background:rgba(255,255,255,0.03);margin-bottom:0.75rem}
  .avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--p3),var(--p1));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;color:#fff;flex-shrink:0}
  .user-info strong{font-size:0.875rem;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:145px}
  .user-info small{font-size:0.72rem;color:var(--muted);display:block}
  .logout-link{background:transparent;border:1px solid rgba(239,68,68,0.25);color:#f87171;padding:0.65rem;border-radius:8px;font-weight:600;font-size:0.85rem;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;transition:all 0.2s;cursor:pointer;width:100%;font-family:'Barlow',sans-serif}
  .logout-link:hover{background:var(--err);color:#fff;border-color:var(--err)}
  .main{flex:1;overflow-y:auto;padding:2rem 2.5rem}
  .pg-header{margin-bottom:2rem;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem}
  .pg-header h1{font-family:'Bebas Neue',sans-serif;font-size:2.5rem;letter-spacing:1px;line-height:1}
  .pg-header p{color:var(--muted);font-size:0.9rem;margin-top:6px}
  .alert{padding:0.85rem 1.25rem;border-radius:8px;margin-bottom:1.5rem;font-size:0.9rem;font-weight:500;display:flex;align-items:flex-start;gap:8px}
  .alert-success{background:var(--ok-bg);color:var(--ok);border:1px solid rgba(16,185,129,0.25)}
  .alert-error{background:var(--err-bg);color:var(--err);border:1px solid rgba(239,68,68,0.25);flex-direction:column}
  .alert ul{margin:0.4rem 0 0;padding-left:1.25rem}
  .btn{background:var(--p1);color:#fff;border:none;padding:0.6rem 1.25rem;border-radius:8px;font-weight:600;cursor:pointer;font-family:'Barlow',sans-serif;font-size:0.85rem;transition:all 0.2s;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;text-decoration:none}
  .btn:hover{background:var(--p3);transform:translateY(-1px)}
  .btn.ghost{background:rgba(255,255,255,0.06);color:var(--txt);border:1px solid var(--border)}
  .btn.ghost:hover{background:rgba(255,255,255,0.1);transform:none}
  .btn.danger{background:rgba(239,68,68,0.1);color:var(--err);border:1px solid rgba(239,68,68,0.25)}
  .btn.danger:hover{background:var(--err);color:#fff}
  .btn.ok{background:rgba(16,185,129,0.15);color:var(--ok);border:1px solid rgba(16,185,129,0.3)}
  .btn.ok:hover{background:var(--ok);color:#fff}
  .btn-sm{padding:0.35rem 0.75rem;font-size:0.78rem}
  .tbl-wrap{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1rem}
  .tbl-head{padding:1rem 1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}
  .tbl-head h3{font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted)}
  table{width:100%;border-collapse:collapse}
  th{padding:0.75rem 1.5rem;font-size:0.75rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);text-align:left;border-bottom:1px solid var(--border);font-weight:600}
  td{padding:0.9rem 1.5rem;font-size:0.88rem;border-bottom:1px solid rgba(255,255,255,0.03);vertical-align:middle}
  tr:last-child td{border-bottom:none}
  tr:hover td{background:rgba(139,92,246,0.04)}
  .sub{display:block;font-size:0.75rem;color:var(--muted);margin-top:2px}
  .actions{display:flex;gap:6px;flex-wrap:wrap}
  .badge{display:inline-block;padding:3px 10px;border-radius:4px;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px}
  .b-ok{background:var(--ok-bg);color:var(--ok)}
  .b-warn{background:var(--warn-bg);color:var(--warn)}
  .b-err{background:var(--err-bg);color:var(--err)}
  .b-pur{background:rgba(139,92,246,0.15);color:var(--p2)}
  .form-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:2rem}
  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
  .fg{display:flex;flex-direction:column;gap:6px}
  .fg.span2{grid-column:span 2}
  label{font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:var(--muted)}
  input,select,textarea{background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:8px;color:var(--txt);padding:0.65rem 0.9rem;font-family:'Barlow',sans-serif;font-size:0.9rem;width:100%;transition:border-color 0.2s}
  input:focus,select:focus,textarea:focus{outline:none;border-color:var(--p1);background:rgba(139,92,246,0.05)}
  select option{background:#1a1a24;color:var(--txt)}
  textarea{resize:vertical;min-height:80px}
  .form-actions{display:flex;gap:0.75rem;margin-top:1.75rem;flex-wrap:wrap}
  .ex-list{display:flex;flex-direction:column;gap:0.6rem;margin-bottom:0.75rem}
  .ex-row{background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:8px;padding:0.85rem;display:grid;grid-template-columns:2fr 80px 80px 100px auto;gap:0.6rem;align-items:end}
  .ex-row .fg label{font-size:0.68rem}
  .ex-remove{background:rgba(239,68,68,0.1);color:var(--err);border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:0;cursor:pointer;display:flex;align-items:center;justify-content:center;height:38px;width:38px;flex-shrink:0}
  .ex-remove:hover{background:var(--err);color:#fff}
  .btn-add-ex{background:rgba(139,92,246,0.08);color:var(--p2);border:1px dashed rgba(139,92,246,0.3);border-radius:8px;padding:0.65rem 1rem;cursor:pointer;font-family:'Barlow',sans-serif;font-size:0.85rem;font-weight:600;width:100%;display:flex;align-items:center;justify-content:center;gap:6px;transition:all 0.2s}
  .btn-add-ex:hover{background:rgba(139,92,246,0.15);border-style:solid}
  .detail-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem}
  .detail-header{padding:1.25rem 1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem}
  .detail-header h2{font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:1px}
  .detail-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr))}
  .detail-item{padding:1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.03)}
  .detail-item label{font-size:0.72rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);display:block;margin-bottom:4px}
  .detail-item span{font-size:0.92rem;font-weight:500}
  .filter-bar{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:1rem 1.5rem;margin-bottom:1.25rem;display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end}
  .filter-bar .fg{min-width:150px;flex:1}
  .filter-bar label{font-size:0.72rem}
  .empty{padding:3rem;text-align:center;color:var(--muted)}
  .empty i{font-size:2.5rem;display:block;margin-bottom:0.75rem;opacity:0.4}
  .pag-wrap{margin-top:1rem}
  .pag-nav{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;padding:0.5rem 0}
  .pag-info{font-size:0.8rem;color:var(--muted)}
  .pag-links{display:flex;gap:4px;align-items:center;flex-wrap:wrap}
  .pag-btn{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:34px;padding:0 8px;border-radius:8px;font-size:0.85rem;font-family:'Barlow',sans-serif;font-weight:600;color:var(--muted);background:var(--card);border:1px solid var(--border);text-decoration:none;transition:all 0.2s}
  .pag-btn:hover:not(.disabled):not(.current):not(.dots){background:rgba(139,92,246,0.1);color:var(--txt);border-color:rgba(139,92,246,0.3)}
  .pag-btn.current{background:var(--p1);color:#fff;border-color:var(--p1)}
  .pag-btn.disabled{opacity:0.35;cursor:not-allowed}
  .pag-btn.dots{background:transparent;border-color:transparent;cursor:default;color:var(--muted)}
</style>
@stack('styles') 
</head>
<body>
<div class="lay">
  <aside class="sb">
    @php $userTipo = auth()->user()?->tipo; @endphp
    <a href="{{ $userTipo === 'instrutor' ? route('dashboard.treinador') : route('dashboard.admin') }}" class="logo">COLISEU<span>GYM</span><small>MANAGEMENT</small></a>
    <nav class="nav">
      @if($userTipo === 'instrutor')
        {{-- SIDEBAR DO TREINADOR --}}
        <a href="{{ route('dashboard.treinador') }}" class="nav-link {{ request()->routeIs('dashboard.treinador') ? 'active' : '' }}">
          <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Treinos</span>
        <a href="{{ route('treinos.index') }}" class="nav-link {{ request()->routeIs('treinos.*') ? 'active' : '' }}">
          <i class="ti ti-barbell"></i> Fichas
        </a>
        <a href="{{ route('treino-alunos.index') }}" class="nav-link {{ request()->routeIs('treino-alunos.*') ? 'active' : '' }}">
          <i class="ti ti-clipboard-list"></i> Fichas dos Alunos
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Aulas</span>
        <a href="{{ route('aulas-coletivas.index') }}" class="nav-link {{ request()->routeIs('aulas-coletivas.*') ? 'active' : '' }}">
          <i class="ti ti-calendar-event"></i> Aulas Coletivas
        </a>
        <div class="nav-sep"></div>
        <a href="{{ route('treinador.alunos') }}" class="nav-link {{ request()->routeIs('treinador.alunos') ? 'active' : '' }}">
          <i class="ti ti-users"></i> Meus Alunos
        </a>
        <div class="nav-sep"></div>
        <a href="{{ route('treinador.perfil') }}" class="nav-link {{ request()->routeIs('treinador.perfil') ? 'active' : '' }}">
          <i class="ti ti-user-circle"></i> Perfil
        </a>
      @else
        {{-- SIDEBAR DO ADMIN --}}
        <a href="{{ route('dashboard.admin') }}" class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
          <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Treinos</span>
        <a href="{{ route('treinos.index') }}" class="nav-link {{ request()->routeIs('treinos.*') ? 'active' : '' }}">
          <i class="ti ti-barbell"></i> Fichas
        </a>
        <a href="{{ route('treino-alunos.index') }}" class="nav-link {{ request()->routeIs('treino-alunos.*') ? 'active' : '' }}">
          <i class="ti ti-clipboard-list"></i> Fichas dos Alunos
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Usuários</span>
        <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
          <i class="ti ti-users"></i> Alunos
        </a>
        <a href="{{ route('instrutores.index') }}" class="nav-link {{ request()->routeIs('instrutores.*') ? 'active' : '' }}">
          <i class="ti ti-user-star"></i> Instrutores
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Aulas</span>
        <a href="{{ route('aulas-coletivas.index') }}" class="nav-link {{ request()->routeIs('aulas-coletivas.*') ? 'active' : '' }}">
          <i class="ti ti-calendar-event"></i> Aulas Coletivas
        </a>
        <a href="{{ route('reserva-aulas-coletivas.index') }}" class="nav-link {{ request()->routeIs('reserva-aulas-coletivas.*') ? 'active' : '' }}">
          <i class="ti ti-ticket"></i> Reservas
        </a>
        <div class="nav-sep"></div>
        <span class="nav-label">Financeiro</span>
        <a href="{{ route('plano-alunos.index') }}" class="nav-link {{ request()->routeIs('plano-alunos.*') ? 'active' : '' }}">
          <i class="ti ti-id-badge-2"></i> Planos
        </a>
        <a href="{{ route('pagamento-plano-alunos.index') }}" class="nav-link {{ request()->routeIs('pagamento-plano-alunos.*') ? 'active' : '' }}">
          <i class="ti ti-cash"></i> Pagamentos
        </a>
      @endif
    </nav>
    <div class="sb-footer">
      @auth
      <div class="user-pill">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? '??', 0, 2)) }}</div>
        <div class="user-info">
          <strong>{{ auth()->user()->name }}</strong>
          <small>{{ ucfirst(auth()->user()->tipo ?? 'Usuário') }}</small>
        </div>
      </div>
      @endauth
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-link">
          <i class="ti ti-door-exit"></i> Sair do Sistema
        </button>
      </form>
    </div>
  </aside>
  <main class="main">
    @if(session('success'))
      <div class="alert alert-success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-error">
        <strong>Corrija os erros abaixo:</strong>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif
    @yield('content')
  </main>
</div>
@stack('scripts')
</body>
</html>
