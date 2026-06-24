@extends('layouts.public')
@section('title', 'Acesso à Arena — Coliseu Gym')

@push('styles')
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --dark:    #0a0a0e;
    --dark-2:  #0f0f15;
    --dark-3:  #13131a;
    --dark-4:  #16161e;
    --border:  rgba(139, 92, 246, 0.14);
    --border-gold: rgba(89, 8, 139, 0.25);
    --p1:      #8b5cf6;
    --p2:      #a78bfa;
    --p3:      #6d28d9;
    --gold:    #47375a;
    --gold2:   #572994;
    --txt:     #f0f0f5;
    --muted:   #7a7a8c;
    --ok:      #0fccd5;
    --err:     #220ca1;
    --err-bg:  rgba(118, 130, 225, 0.08);
  }

  body {
    background: var(--dark);
    color: var(--txt);
    font-family: 'Barlow', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(139,92,246,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(139,92,246,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
  }

  main {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 7rem 1rem 3rem;
    position: relative;
    z-index: 1;
  }

  .navbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2.5rem;
    background: rgba(10,10,14,0.85);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
  }
  .logo {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.6rem;
    letter-spacing: 2px;
    line-height: 1;
    color: var(--txt);
  }
  .logo span { color: var(--p1); }
  .logo small {
    display: block;
    font-family: 'Barlow', sans-serif;
    font-size: 0.55rem;
    letter-spacing: 3px;
    color: var(--muted);
    font-weight: 500;
    margin-top: 2px;
  }
  .navbar nav {
    display: flex;
    align-items: center;
    gap: 1.75rem;
  }
  .navbar nav a {
    color: var(--muted);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    transition: color 0.2s;
  }
  .navbar nav a:hover { color: var(--txt); }
  .navbar nav a.active { color: var(--gold2); }
  .btn-nav {
    background: var(--gold) !important;
    color: var(--dark) !important;
    padding: 0.5rem 1.1rem;
    border-radius: 6px;
    font-weight: 700 !important;
    font-size: 0.82rem !important;
  }
  .btn-nav:hover { opacity: 0.88; }

  .card {
    background: var(--dark-4);
    border: 1px solid var(--border);
    border-radius: 16px;
    width: 100%;
    max-width: 460px;
    padding: 2.25rem 2.25rem 2rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.55), 0 0 0 1px rgba(139,92,246,0.06);
    position: relative;
    overflow: hidden;
  }
  .card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--p3), var(--p1), var(--gold));
  }

  .card-eyebrow {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: var(--p2);
    font-weight: 700;
    margin-bottom: 0.4rem;
  }
  .card-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.4rem;
    letter-spacing: 1px;
    line-height: 1;
    margin-bottom: 0.35rem;
  }
  .card-desc {
    font-size: 0.88rem;
    color: var(--muted);
    margin-bottom: 1.75rem;
  }

  .profile-tabs {
    display: flex;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 4px;
    gap: 4px;
    margin-bottom: 1.5rem;
  }
  .tab-btn {
    flex: 1;
    background: transparent;
    border: none;
    color: var(--muted);
    padding: 0.65rem 0.5rem;
    font-family: 'Barlow', sans-serif;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    border-radius: 5px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
  }
  .tab-btn:hover { color: var(--txt); background: rgba(255,255,255,0.04); }
  .tab-btn.active {
    background: linear-gradient(135deg, var(--p3), var(--p1));
    color: #fff;
    box-shadow: 0 2px 12px rgba(109,40,217,0.35);
  }

  .sub-tabs {
    display: flex;
    gap: 0;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
  }
  .sub-tab-btn {
    background: transparent;
    border: none;
    color: var(--muted);
    font-family: 'Barlow', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 0.5rem 1rem 0.65rem;
    position: relative;
    transition: color 0.2s;
  }
  .sub-tab-btn:hover { color: var(--txt); }
  .sub-tab-btn.active { color: var(--gold2); }
  .sub-tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 2px;
    background: var(--gold2);
    border-radius: 2px 2px 0 0;
  }

  .fg {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
  }
  .fg label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--muted);
    font-weight: 600;
  }
  .fg label .req { color: var(--err); margin-left: 2px; }
  .form-input {
    width: 100%;
    padding: 0.8rem 1rem;
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--txt);
    font-family: 'Barlow', sans-serif;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .form-input:focus {
    border-color: var(--p1);
    box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
  }
  .form-input::placeholder { color: rgba(122,122,140,0.6); }
  .form-input[type="date"] { color-scheme: dark; }
  select.form-input option { background: var(--dark-4); }

  .pwd-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .pwd-wrap .form-input { padding-right: 2.8rem; }
  .pwd-toggle {
    position: absolute;
    right: 0.85rem;
    background: transparent;
    border: none;
    color: var(--muted);
    cursor: pointer;
    padding: 0;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }
  .pwd-toggle:hover { color: var(--txt); }
  .pwd-toggle svg { display: block; }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.9rem;
  }
  .form-row.cep { grid-template-columns: 1fr 2fr; }

  .step-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.1rem;
  }
  .step-name {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--p2);
    font-weight: 700;
  }
  .step-counter {
    font-size: 0.72rem;
    color: var(--muted);
    letter-spacing: 0.5px;
  }
  .step-divider {
    height: 1px;
    background: var(--border);
    margin: 1.25rem 0;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border: none;
    border-radius: 8px;
    font-family: 'Barlow', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
  }
  .btn-primary {
    width: 100%;
    padding: 0.85rem;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold2) 100%);
    color: #0a0a0e;
  }
  .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(50, 5, 86, 0.3); }
  .btn-primary:active { transform: none; }
  .btn-ghost {
    padding: 0.8rem;
    background: rgba(255,255,255,0.04);
    color: var(--muted);
    border: 1px solid var(--border);
  }
  .btn-ghost:hover { background: rgba(255,255,255,0.08); color: var(--txt); }
  .btn-next {
    width: 100%;
    padding: 0.82rem;
    background: rgba(139,92,246,0.15);
    color: var(--p2);
    border: 1px solid rgba(139,92,246,0.3);
  }
  .btn-next:hover { background: var(--p1); color: #fff; transform: translateY(-1px); }

  .form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.1rem;
  }
  .remember-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .remember-row input[type="checkbox"] {
    accent-color: var(--p1);
    cursor: pointer;
    width: 15px;
    height: 15px;
  }
  .remember-row label {
    font-size: 0.83rem;
    color: rgba(240,240,245,0.55);
    cursor: pointer;
    user-select: none;
  }
  .link-gold {
    font-size: 0.83rem;
    color: var(--gold2);
    text-decoration: none;
    font-weight: 500;
    transition: opacity 0.2s;
  }
  .link-gold:hover { opacity: 0.75; }

  .alert {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 1.1rem;
    border: 1px solid;
  }
  .alert-error   { background: rgba(239,68,68,0.08);  border-color: rgba(239,68,68,0.3);  color: #fca5a5; }
  .alert-success { background: rgba(16,185,129,0.08); border-color: rgba(16,185,129,0.3); color: #6ee7b7; }
  .field-error { font-size: 0.75rem; color: #fca5a5; margin-top: 0.1rem; }
  .form-input.input-error { border-color: rgba(239,68,68,0.6); }
  .form-input.input-error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

  footer {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 1.5rem 1rem;
    border-top: 1px solid var(--border);
  }
  .footer-logo {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.1rem;
    letter-spacing: 2px;
    margin-bottom: 0.5rem;
  }
  .footer-logo span { color: var(--p1); }
  .footer-links {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    margin-bottom: 0.5rem;
  }
  .footer-links a {
    font-size: 0.8rem;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
  }
  .footer-links a:hover { color: var(--gold2); }
  .footer-copy { font-size: 0.75rem; color: rgba(122,122,140,0.5); }

  @media (max-width: 520px) {
    .navbar { padding: 0.85rem 1.25rem; }
    .navbar nav { gap: 1rem; }
    .navbar nav a:not(.btn-nav):not(.active) { display: none; }
    .card { padding: 1.75rem 1.25rem 1.5rem; border-radius: 12px; }
    .form-row { grid-template-columns: 1fr; }
    .form-row.cep { grid-template-columns: 1fr; }
  }
</style>
@endpush

@php
  $showCadastro = $errors->hasAny(['name', 'rg', 'data_nascimento', 'rua', 'numero_rua', 'cep', 'numero_telefone']);
  $cadastroStep = $errors->hasAny(['rg', 'data_nascimento', 'rua', 'numero_rua', 'cep', 'numero_telefone']) ? 2 : 1;
@endphp

@section('content')
  <main>
    <div class="card">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="card-eyebrow" id="form-eyebrow">Acesso Aluno</div>
      <h1 class="card-title" id="form-title">Acesse a Arena</h1>
      <p class="card-desc" id="form-desc">Entre para gerenciar seus treinos e planos.</p>

      <div class="sub-tabs" id="aluno-sub-tabs">
        <button type="button" class="sub-tab-btn active" onclick="mudarAcao('login')">Entrar</button>
        <button type="button" class="sub-tab-btn" onclick="mudarAcao('cadastro')">Criar Conta</button>
      </div>

      {{-- ── FORMULÁRIO DE LOGIN ─────────────────────────────── --}}
      <form id="form-login" action="{{ route('login.post') }}" method="POST">
        @csrf

<<<<<<< HEAD
        <input type="hidden" name="tipo"             id="tipo_usuario"     value="aluno">
        <input type="hidden" name="status"                                  value="ativo">
        <input type="hidden" name="acao_formulario"   id="acao_formulario"  value="login">

        {{-- MENSAGENS DE ERRO --}}
        @if ($errors->any())
        <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #f87171;">
            <strong>Erro:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                <li style="margin: 0.25rem 0;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- ── PARTE DO LOGIN ── -->
        <div id="bloco-login" class="form-block visible">
=======
        @if($errors->has('email') && !$showCadastro)
          <div class="alert alert-error">{{ $errors->first('email') }}</div>
        @endif
>>>>>>> cf6be7573f1fe6556d70cd887e9c0aedbfa13591

        <div style="display:flex; flex-direction:column; gap:1.1rem;">
          <div class="fg">
            <label for="login-email">E-mail cadastrado</label>
            <input type="email" name="email" id="login-email"
                   value="{{ !$showCadastro ? old('email') : '' }}"
                   placeholder="seu-email@provedor.com"
                   class="form-input{{ $errors->has('email') && !$showCadastro ? ' input-error' : '' }}"
                   autocomplete="username" required>
          </div>

          <div class="fg">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.35rem;">
              <label for="login-password" style="margin-bottom:0;">Senha</label>
              <a href="#" class="link-gold">Esqueceu a senha?</a>
            </div>
            <div class="pwd-wrap">
              <input type="password" name="password" id="login-password"
                     placeholder="••••••••" class="form-input"
                     autocomplete="current-password" required>
              <button type="button" class="pwd-toggle" onclick="togglePwd('login-password', this)">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="form-footer">
            <div class="remember-row">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Lembrar de mim</label>
            </div>
          </div>

          <button type="submit" id="btn-submit" class="btn btn-primary">Entrar na Batalha</button>
        </div>
      </form>

      {{-- ── FORMULÁRIO DE CADASTRO ──────────────────────────── --}}
      <form id="form-cadastro" action="{{ route('register.post') }}" method="POST" style="display:none;">
        @csrf

        {{-- PASSO 1 --}}
        <div id="cadastro-passo-1">
          <div class="step-header">
            <span class="step-name">Dados de Acesso</span>
            <span class="step-counter">Passo 1 de 2</span>
          </div>

          <div style="display:flex; flex-direction:column; gap:1.1rem;">
            <div class="fg">
              <label for="reg-name">Nome completo <span class="req">*</span></label>
              <input type="text" name="name" id="reg-name"
                     value="{{ old('name') }}"
                     placeholder="Ex: Jackson Five"
                     class="form-input{{ $errors->has('name') ? ' input-error' : '' }}">
              @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="fg">
              <label for="reg-email">E-mail <span class="req">*</span></label>
              <input type="email" name="email" id="reg-email"
                     value="{{ $showCadastro ? old('email') : '' }}"
                     placeholder="guerreiro@email.com"
                     class="form-input{{ $errors->has('email') && $showCadastro ? ' input-error' : '' }}">
              @if($showCadastro)
                @error('email')<span class="field-error">{{ $message }}</span>@enderror
              @endif
            </div>

            <div class="form-row">
              <div class="fg">
                <label for="reg-password">Definir senha <span class="req">*</span></label>
                <div class="pwd-wrap">
                  <input type="password" name="password" id="reg-password"
                         placeholder="••••••••"
                         class="form-input{{ $errors->has('password') ? ' input-error' : '' }}">
                  <button type="button" class="pwd-toggle" onclick="togglePwd('reg-password', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                  </button>
                </div>
                @error('password')<span class="field-error">{{ $message }}</span>@enderror
              </div>
              <div class="fg">
                <label for="reg-password-confirm">Confirmar senha <span class="req">*</span></label>
                <div class="pwd-wrap">
                  <input type="password" name="password_confirmation" id="reg-password-confirm"
                         placeholder="••••••••" class="form-input">
                  <button type="button" class="pwd-toggle" onclick="togglePwd('reg-password-confirm', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-next" onclick="avancarPasso(2)">Próximo Passo →</button>
          </div>
        </div>

        {{-- PASSO 2 --}}
        <div id="cadastro-passo-2" style="display:none;">
          <div class="step-header">
            <span class="step-name">Perfil &amp; Localização</span>
            <span class="step-counter">Passo 2 de 2</span>
          </div>

          <div style="display:flex; flex-direction:column; gap:1.1rem;">
            <div class="form-row">
              <div class="fg">
                <label for="reg-rg">RG <span class="req">*</span></label>
                <input type="text" name="rg" id="reg-rg"
                       value="{{ old('rg') }}"
                       placeholder="00.000.000-0" maxlength="12"
                       class="form-input{{ $errors->has('rg') ? ' input-error' : '' }}">
                @error('rg')<span class="field-error">{{ $message }}</span>@enderror
              </div>
              <div class="fg">
                <label for="reg-nascimento">Nascimento <span class="req">*</span></label>
                <input type="date" name="data_nascimento" id="reg-nascimento"
                       value="{{ old('data_nascimento') }}"
                       class="form-input{{ $errors->has('data_nascimento') ? ' input-error' : '' }}">
                @error('data_nascimento')<span class="field-error">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="fg">
              <label for="reg-telefone">Celular / Telefone <span class="req">*</span></label>
              <input type="text" name="numero_telefone" id="reg-telefone"
                     value="{{ old('numero_telefone') }}"
                     placeholder="(49) 99999-9999" maxlength="15"
                     class="form-input{{ $errors->has('numero_telefone') ? ' input-error' : '' }}">
              @error('numero_telefone')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row cep">
              <div class="fg">
                <label for="reg-cep">CEP <span class="req">*</span></label>
                <input type="text" name="cep" id="reg-cep"
                       value="{{ old('cep') }}"
                       placeholder="89800-000" maxlength="9"
                       class="form-input{{ $errors->has('cep') ? ' input-error' : '' }}">
                @error('cep')<span class="field-error">{{ $message }}</span>@enderror
              </div>
              <div class="fg">
                <label for="reg-rua">Rua / Logradouro <span class="req">*</span></label>
                <input type="text" name="rua" id="reg-rua"
                       value="{{ old('rua') }}"
                       placeholder="Nome da rua ou avenida"
                       class="form-input{{ $errors->has('rua') ? ' input-error' : '' }}">
                @error('rua')<span class="field-error">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="fg">
              <label for="reg-numero">Número <span class="req">*</span></label>
              <input type="number" name="numero_rua" id="reg-numero"
                     value="{{ old('numero_rua') }}"
                     placeholder="Ex: 1420"
                     class="form-input{{ $errors->has('numero_rua') ? ' input-error' : '' }}">
              @error('numero_rua')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="step-divider"></div>

            <div class="form-row">
              <button type="button" class="btn btn-ghost" onclick="avancarPasso(1)">← Voltar</button>
              <button type="submit" class="btn btn-primary" style="width:auto; flex:1;">Concluir Cadastro</button>
            </div>
          </div>
        </div>

      </form>

    </div>
  </main>
@endsection

@push('scripts')
<script>
  const ICON_SHOW = `<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor">
    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
  </svg>`;

  const ICON_HIDE = `<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor">
    <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
  </svg>`;

  function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.innerHTML = isHidden ? ICON_HIDE : ICON_SHOW;
  }

  function mostrarLoginForm() {
    document.getElementById('form-login').style.display    = '';
    document.getElementById('form-cadastro').style.display = 'none';
  }

  function mostrarCadastroForm() {
    document.getElementById('form-login').style.display    = 'none';
    document.getElementById('form-cadastro').style.display = '';
    avancarPasso(1);
  }

  function avancarPasso(passo) {
    document.getElementById('cadastro-passo-1').style.display = passo === 1 ? '' : 'none';
    document.getElementById('cadastro-passo-2').style.display = passo === 2 ? '' : 'none';
  }

  function mudarPerfil(perfil) {
    document.querySelectorAll('.tab-btn')
      .forEach((b, i) => b.classList.toggle('active', perfil === (i === 0 ? 'aluno' : 'instrutor')));

    const subTabs = document.getElementById('aluno-sub-tabs');

    if (perfil === 'instrutor') {
      subTabs.style.display = 'none';
      document.getElementById('form-eyebrow').textContent = 'Acesso Instrutor';
      document.getElementById('form-title').textContent   = 'Painel do Mestre';
      document.getElementById('form-desc').textContent    = 'Entre para gerenciar seus alunos e treinos.';
      document.getElementById('btn-submit').textContent   = 'Acessar Painel';
      mostrarLoginForm();
    } else {
      subTabs.style.display = 'flex';
      mudarAcao('login');
    }
  }

  function mudarAcao(acao) {
    document.querySelectorAll('.sub-tab-btn')
      .forEach((b, i) => b.classList.toggle('active', acao === (i === 0 ? 'login' : 'cadastro')));

    if (acao === 'login') {
      document.getElementById('form-eyebrow').textContent = 'Acesso Aluno';
      document.getElementById('form-title').textContent   = 'Acesse a Arena';
      document.getElementById('form-desc').textContent    = 'Entre para gerenciar seus treinos e planos.';
      document.getElementById('btn-submit').textContent   = 'Entrar na Batalha';
      mostrarLoginForm();
    } else {
      document.getElementById('form-eyebrow').textContent = 'Nova Matrícula';
      document.getElementById('form-title').textContent   = 'Crie sua Conta';
      document.getElementById('form-desc').textContent    = 'Cadastre-se para iniciar a sua jornada.';
      mostrarCadastroForm();
    }
  }

<<<<<<< HEAD
    // some com  todos os blocos do formulário
    function ocultarTodos() {
      ['bloco-login', 'cadastro-passo-1', 'cadastro-passo-2']
        .forEach(id => document.getElementById(id).classList.remove('visible'));
    }

    // vai e volta entre os passos do cadastro
    function avancarPasso(passo) {
      ocultarTodos();
      document.getElementById(passo === 2 ? 'cadastro-passo-2' : 'cadastro-passo-1')
              .classList.add('visible');
    }

    function setFormMode(acao) {
      const loginInputs = document.querySelectorAll('#bloco-login input');
      const cadastroInputs = document.querySelectorAll('#cadastro-passo-1 input, #cadastro-passo-2 input');
      const isLoginMode = acao === 'login';

      loginInputs.forEach(input => {
        if (input.type !== 'hidden') {
          input.disabled = !isLoginMode;
        }
      });

      cadastroInputs.forEach(input => {
        if (input.type !== 'hidden') {
          input.disabled = isLoginMode;
        }
      });
    }

    // muda entre os do  perfil Aluno e Instrutor
    function mudarPerfil(perfil) {
      limparFormulario();
      document.querySelectorAll('.tab-btn')
              .forEach((btn, i) => btn.classList.toggle('active', (perfil === 'aluno' ? i === 0 : i === 1)));
      document.getElementById('tipo_usuario').value = perfil;

      const subTabs = document.getElementById('aluno-sub-tabs');

      if (perfil === 'aluno') {
        subTabs.style.display = 'flex';
        mudarAcao('login');
      } else {
        subTabs.style.display = 'none';
        ocultarTodos();

        document.getElementById('form-eyebrow').textContent  = 'Acesso Instrutor';
        document.getElementById('form-title').textContent    = 'Painel do Mestre';
        document.getElementById('form-desc').textContent     = 'Entre para gerenciar seus alunos e treinos.';

        document.getElementById('acao_formulario').value = 'login';
        document.getElementById('auth-form').action     = "{{ route('login.post') }}";

        // coloca de novo o tal do  required para o bloco de login do instrutor
        document.getElementById('input-email').required  = true;
        document.getElementById('password').required     = true;
        setFormMode('login');

        document.getElementById('bloco-login').classList.add('visible');
        document.getElementById('btn-submit').textContent = 'Acessar Painel';
=======
  function mask(input, pattern) {
    input.addEventListener('input', function () {
      const digits = this.value.replace(/\D/g, '');
      let result = '', di = 0;
      for (let pi = 0; pi < pattern.length && di < digits.length; pi++) {
        result += pattern[pi] === '0' ? digits[di++] : pattern[pi];
>>>>>>> cf6be7573f1fe6556d70cd887e9c0aedbfa13591
      }
      this.value = result;
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    mask(document.getElementById('reg-rg'),        '00.000.000-0');
    mask(document.getElementById('reg-cep'),      '00000-000');
    mask(document.getElementById('reg-telefone'), '(00) 00000-0000');

    const showCadastro = {{ $showCadastro ? 'true' : 'false' }};
    const cadastroStep = {{ $cadastroStep }};
    if (showCadastro) {
      mudarAcao('cadastro');
      if (cadastroStep === 2) avancarPasso(2);
    }
<<<<<<< HEAD

    // Muda o negocio de Entrar e Criar Conta (somente para alunos)
    function mudarAcao(acao) {
      limparFormulario();
      document.querySelectorAll('.sub-tab-btn')
              .forEach((btn, i) => btn.classList.toggle('active', (acao === 'login' ? i === 0 : i === 1)));
      document.getElementById('acao_formulario').value = acao;

      if (acao === 'login') {
        document.getElementById('form-eyebrow').textContent = 'Acesso Aluno';
        document.getElementById('form-title').textContent   = 'Acesse a Arena';
        document.getElementById('form-desc').textContent    = 'Entre para gerenciar seus treinos e planos.';
        document.getElementById('auth-form').action         = "{{ route('login.post') }}";

        document.getElementById('input-email').required = true;
        document.getElementById('password').required    = true;
        setFormMode('login');

        ocultarTodos();
        document.getElementById('bloco-login').classList.add('visible');

      } else {
        document.getElementById('form-eyebrow').textContent = 'Nova Matrícula';
        document.getElementById('form-title').textContent   = 'Crie sua Conta';
        document.getElementById('form-desc').textContent    = 'Cadastre-se para iniciar a sua jornada.';
        document.getElementById('auth-form').action         = "{{ route('register.post') }}";

        // Desativa required dos campos de login para não bloquear o submit do cadastro
        document.getElementById('input-email').required = false;
        document.getElementById('password').required    = false;
        setFormMode('cadastro');

        ocultarTodos();
        document.getElementById('cadastro-passo-1').classList.add('visible');
      }
    }

    // inicializa o formulário no modo login, com campos de cadastro desabilitados
    setFormMode('login');
  </script>
</body>
</html>
=======
  });
</script>
@endpush
>>>>>>> cf6be7573f1fe6556d70cd887e9c0aedbfa13591
