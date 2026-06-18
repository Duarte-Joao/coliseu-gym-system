<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acesso à Arena — Coliseu Gym</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/coliseu.css') }}">
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

    /* LAYOUT  */
    body {
      background: var(--dark);
      color: var(--txt);
      font-family: 'Barlow', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Fundo com textura sutil de grade BIG DIVO  */
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

    /* NAVBAR  */
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

    /*  CARD PRINCIPAL */
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
    /* Faixa FOFA E  decorativa no topo DA PARTE DE CIMA do card */
    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--p3), var(--p1), var(--gold));
    }

    /*  CABEÇALHO DO CARD  */
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

    /* ABAS DE PERFIL (Aluno / Instrutor) */
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
    .tab-btn i-fake { font-size: 1rem; }

    /*SUB-ABAS (Entrar / Criar Conta) */
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

    /* PARTE DO FORMULÁRIO  */
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

    /* quadrado do campo da senha */
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
      font-size: 1rem;
      padding: 0;
      line-height: 1;
      transition: color 0.2s;
    }
    .pwd-toggle:hover { color: var(--txt); }

    /* Grade COM  2 colunas */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.9rem;
    }
    .form-row.cep { grid-template-columns: 1fr 2fr; }

    /* Separador de seção de cadastro */
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

    /* BOTÕES  */
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

    /* Rodapé do formulário (checkbox + link) */
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

    /* FORM BLOCKS  */
    .form-block {
      display: none;
      flex-direction: column;
      gap: 1.1rem;
    }
    .form-block.visible { display: flex; }

    /* FOOTER */
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

    /* ── RESPONSIVO */
    @media (max-width: 520px) {
      .navbar { padding: 0.85rem 1.25rem; }
      .navbar nav { gap: 1rem; }
      .navbar nav a:not(.btn-nav):not(.active) { display: none; }
      .card { padding: 1.75rem 1.25rem 1.5rem; border-radius: 12px; }
      .form-row { grid-template-columns: 1fr; }
      .form-row.cep { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <header class="navbar">
    <div class="logo">
      Coliseu <span>Gym</span>
      <small>Desde 2015 · Chapecó — SC</small>
    </div>
    <nav>
      <a href="{{ route('home') }}">Início</a>
      <a href="{{ route('planos') }}">Planos</a>
      <a href="{{ route('contato') }}">Contato</a>
      <a href="{{ route('login') }}" class="active">Login</a>
      <a href="{{ route('planos') }}" class="btn-nav">Matricule-se</a>
    </nav>
  </header>

  <main>
    <div class="card">

      <div class="card-eyebrow" id="form-eyebrow">Acesso Aluno</div>
      <h1 class="card-title" id="form-title">Acesse a Arena</h1>
      <p class="card-desc" id="form-desc">Entre para gerenciar seus treinos e planos.</p>

      <!-- Abas de perfil -->
      <div class="profile-tabs">
        <button type="button" class="tab-btn active" onclick="mudarPerfil('aluno')">🛡️ Sou Aluno</button>
        <button type="button" class="tab-btn" onclick="mudarPerfil('instrutor')">⚔️ Sou Instrutor</button>
      </div>

      <!-- Sub-abas (visíveis apenas para aluno) -->
      <div class="sub-tabs" id="aluno-sub-tabs">
        <button type="button" class="sub-tab-btn active" onclick="mudarAcao('login')">Entrar</button>
        <button type="button" class="sub-tab-btn" onclick="mudarAcao('cadastro')">Criar Conta</button>
      </div>

      <form id="auth-form" action="{{ route('login.post') }}" method="POST" autocomplete="off">
        @csrf

        <input type="hidden" name="tipo"             id="tipo_usuario"     value="aluno">
        <input type="hidden" name="status"                                  value="ativo">
        <input type="hidden" name="acao_formulario"   id="acao_formulario"  value="login">

        <!-- ── PARTE DO LOGIN ── -->
        <div id="bloco-login" class="form-block visible">

          <div class="fg">
            <label for="input-email">E-mail cadastrado</label>
            <input type="email" name="email" id="input-email"
                   placeholder="seu-email@provedor.com"
                   class="form-input" autocomplete="new-password" required>
          </div>

          <div class="fg">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.35rem;">
              <label for="password" style="margin-bottom:0;">Senha</label>
              <a href="#" id="link-esqueci" class="link-gold">Esqueceu a senha?</a>
            </div>
            <div class="pwd-wrap">
              <input type="password" name="password" id="password"
                     placeholder="••••••••" class="form-input"
                     autocomplete="new-password" required>
              <button type="button" class="pwd-toggle" onclick="togglePwd('password', this)">👁️</button>
            </div>
          </div>

          <div class="form-footer">
            <div class="remember-row">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Lembrar de mim</label>
            </div>
          </div>

          <button type="submit" id="btn-submit" class="btn btn-primary">
            Entrar na Batalha
          </button>

        </div>

        <!-- ── BLOCO CADASTRO — PASSO 1 ── -->
        <div id="cadastro-passo-1" class="form-block">

          <div class="step-header">
            <span class="step-name">Dados de Acesso</span>
            <span class="step-counter">Passo 1 de 2</span>
          </div>

          <div class="fg">
            <label for="input-name">Nome completo <span class="req">*</span></label>
            <input type="text" name="name" id="input-name"
                   placeholder="Ex: Maximus Decimus" class="form-input">
          </div>

          <div class="fg">
            <label for="input-email-cadastro">E-mail <span class="req">*</span></label>
            <input type="email" name="email" id="input-email-cadastro"
                   placeholder="guerreiro@email.com" class="form-input">
          </div>

          <div class="form-row">
            <div class="fg">
              <label for="password_cadastro">Definir senha <span class="req">*</span></label>
              <div class="pwd-wrap">
                <input type="password" name="password" id="password_cadastro"
                       placeholder="••••••••" class="form-input">
                <button type="button" class="pwd-toggle" onclick="togglePwd('password_cadastro', this)">👁️</button>
              </div>
            </div>
            <div class="fg">
              <label for="password_confirmation">Confirmar senha <span class="req">*</span></label>
              <div class="pwd-wrap">
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="••••••••" class="form-input">
                <button type="button" class="pwd-toggle" onclick="togglePwd('password_confirmation', this)">👁️</button>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-next" onclick="avancarPasso(2)">
            Próximo Passo →
          </button>

        </div>

        <!-- ── BLOCO CADASTRO — PARTE TWO 2 ── -->
        <div id="cadastro-passo-2" class="form-block">

          <div class="step-header">
            <span class="step-name">Perfil &amp; Localização</span>
            <span class="step-counter">Passo 2 de 2</span>
          </div>

          <div class="form-row">
            <div class="fg">
              <label for="input-cpf">CPF <span class="req">*</span></label>
              <input type="text" name="cpf" id="input-cpf"
                     placeholder="000.000.000-00" class="form-input">
            </div>
            <div class="fg">
              <label for="input-nascimento">Nascimento</label>
              <input type="date" name="data_nascimento" id="input-nascimento" class="form-input">
            </div>
          </div>

          <div class="fg">
            <label for="input-telefone">Celular / Telefone</label>
            <input type="text" name="numero_telefone" id="input-telefone"
                   placeholder="(49) 99999-9999" class="form-input">
          </div>

          <div class="form-row cep">
            <div class="fg">
              <label for="input-cep">CEP</label>
              <input type="text" name="cep" id="input-cep"
                     placeholder="89800-000" class="form-input">
            </div>
            <div class="fg">
              <label for="input-rua">Rua / Logradouro</label>
              <input type="text" name="rua" id="input-rua"
                     placeholder="Nome da rua ou avenida" class="form-input">
            </div>
          </div>

          <div class="fg">
            <label for="input-numero">Número</label>
            <input type="number" name="numero_rua" id="input-numero"
                   placeholder="Ex: 1420" class="form-input">
          </div>

          <div class="step-divider"></div>

          <div class="form-row">
            <button type="button" class="btn btn-ghost" onclick="avancarPasso(1)">
              ← Voltar
            </button>
            <button type="submit" class="btn btn-primary" style="width:auto; flex:1;">
              Concluir Matrícula
            </button>
          </div>

        </div>

      </form>
    </div>
  </main>

  <footer>
    <div class="footer-logo">Coliseu <span>Gym</span></div>
    <div class="footer-links">
      <a href="#">Instagram</a>
      <a href="#">WhatsApp</a>
      <a href="#">Localização</a>
    </div>
    <div class="footer-copy">© 2026 Coliseu Gym · Todos os direitos reservados</div>
  </footer>

  <script>
    // mostra ou some com a senha 
    function togglePwd(inputId, btn) {
      const input = document.getElementById(inputId);
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      btn.textContent = isHidden ? '🙈' : '👁️';
    }

    // Limpa/some todos os inputs do formulário
    function limparFormulario() {
      document.querySelectorAll('.form-input').forEach(el => el.value = '');
      const rem = document.getElementById('remember');
      if (rem) rem.checked = false;
    }

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

        document.getElementById('bloco-login').classList.add('visible');
        document.getElementById('btn-submit').textContent = 'Acessar Painel';
      }
    }

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

        ocultarTodos();
        document.getElementById('cadastro-passo-1').classList.add('visible');
      }
    }
  </script>
</body>
</html>