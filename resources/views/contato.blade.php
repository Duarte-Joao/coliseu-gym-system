<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fale Conosco — Coliseu Gym</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/coliseu.css') }}">
  <style>
    /* TOKENS ─────────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --dark:        #0a0a0e;
      --dark-2:      #0f0f15;
      --dark-3:      #13131a;
      --dark-4:      #16161e;
      --border:      rgba(139, 92, 246, 0.14);
      --border-hi:   rgba(139, 92, 246, 0.32);
      --p1:          #8b5cf6;
      --p2:          #a78bfa;
      --p3:          #6d28d9;
      --gold:        #6215c5;
      --txt:         #f0f0f5;
      --muted:       #7a7a8c;
      --ok:          #10b981;
      --wa:          #25D366;
    }

    /* ── BASE ────────────────────────────────────────────── */
    body {
      background: var(--dark);
      color: var(--txt);
      font-family: 'Barlow', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Grade sutil de fundo */
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

    /* NAVBAR */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 2.5rem;
      background: rgba(10,10,14,0.88);
      backdrop-filter: blur(14px);
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
    .navbar nav { display: flex; align-items: center; gap: 1.75rem; }
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
      color: #0a0a0e !important;
      padding: 0.5rem 1.1rem;
      border-radius: 6px;
      font-weight: 700 !important;
      font-size: 0.82rem !important;
    }
    .btn-nav:hover { opacity: 0.88; }

    /*  MAIN  */
    main {
      flex: 1;
      position: relative;
      z-index: 1;
      padding: 8rem 2.5rem 5rem;
      max-width: 1100px;
      margin: 0 auto;
      width: 100%;
    }

    /* CABEÇALHO */
    .page-eyebrow {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: var(--p2);
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    .page-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2.2rem, 5vw, 3.2rem);
      letter-spacing: 1px;
      line-height: 1;
      margin-bottom: 0.6rem;
    }
    .page-desc {
      font-size: 0.95rem;
      color: var(--muted);
      margin-bottom: 3rem;
      max-width: 480px;
    }

    /*  GRADE PRINCIPAL */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1.3fr;
      gap: 1.5rem;
      align-items: start;
    }

    /* QUADRADO BASE*/
    .card {
      background: var(--dark-4);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--p3), var(--p1));
    }
    .card.featured::before {
      background: linear-gradient(90deg, var(--p3), var(--p1), var(--gold));
    }

    /* QUADRADO DOS CANAIS DIRETOS*/
    .card-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.6rem;
      letter-spacing: 1px;
      margin-bottom: 1.75rem;
    }

    .info-block { margin-bottom: 1.5rem; }
    .info-label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--p2);
      font-weight: 700;
      margin-bottom: 0.4rem;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .info-label::before {
      content: '';
      display: inline-block;
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: var(--p1);
      flex-shrink: 0;
    }
    .info-text {
      font-size: 0.92rem;
      color: var(--txt);
      line-height: 1.7;
      padding-left: 11px;
    }
    .info-text a {
      color: var(--txt);
      text-decoration: none;
      transition: color 0.2s;
    }
    .info-text a:hover { color: var(--gold2); }

    .divider {
      height: 1px;
      background: var(--border);
      margin: 1.5rem 0;
    }

    /* Botão WhatsApp */
    .btn-wa {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 0.85rem;
      background: #1aad54;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-family: 'Barlow', sans-serif;
      font-weight: 700;
      font-size: 0.9rem;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-wa:hover { background: #25D366; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(37,211,102,0.3); }

    /* QUADRADO FORMULÁRIO*/
    .contact-form {
      display: flex;
      flex-direction: column;
      gap: 1.1rem;
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
    .fg label .req { color: #ef4444; margin-left: 2px; }

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
    .form-input::placeholder { color: rgba(122,122,140,0.55); }

    textarea.form-input {
      resize: vertical;
      min-height: 130px;
      font-family: 'Barlow', sans-serif;
      line-height: 1.6;
    }

    .form-input option {
      color: var(--txt);
      background-color: #1f1f27ff;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.9rem;
    }

    /* Botão de envio */
    .btn-submit {
      width: 100%;
      padding: 0.85rem;
      background: linear-gradient(135deg, var(--p3) 0%, var(--p1) 100%);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-family: 'Barlow', sans-serif;
      font-weight: 700;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 0.2rem;
    }
    .btn-submit:hover {
      filter: brightness(1.12);
      transform: translateY(-1px);
      box-shadow: 0 4px 18px rgba(109,40,217,0.4);
    }
    .btn-submit:active { transform: none; }

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

    /*RESPONSIVO  */
    @media (max-width: 820px) {
      .contact-grid { grid-template-columns: 1fr; }
      main { padding: 7rem 1.25rem 4rem; }
    }
    @media (max-width: 520px) {
      .navbar { padding: 0.85rem 1.25rem; }
      .navbar nav { gap: 1rem; }
      .navbar nav a:not(.btn-nav):not(.active) { display: none; }
      .form-row { grid-template-columns: 1fr; }
      .card { padding: 1.5rem; }
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
      <a href="{{ route('contato') }}" class="active">Contato</a>
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('planos') }}" class="btn-nav">Matricule-se</a>
    </nav>
  </header>

  <main>

    <div class="page-eyebrow">Atendimento</div>
    <h1 class="page-title">Entre em contato com a arena</h1>
    <p class="page-desc">Tire dúvidas, solicite informações ou mande uma mensagem direta para nossa equipe.</p>

    <div class="contact-grid">

      <!-- ── QUADRADO DOS CANAIS ── -->
      <div class="card featured">
        <h2 class="card-title">Canais Diretos</h2>

        <div class="info-block">
          <div class="info-label">Onde estamos</div>
          <p class="info-text">
            Av. Getúlio Vargas, 1000-N — Centro<br>
            Chapecó — SC, 89801-000
          </p>
        </div>

        <div class="info-block">
          <div class="info-label">Horário de batalha</div>
          <p class="info-text">
            Segunda a Sexta: 05h às 23h<br>
            Sábados: 08h às 16h<br>
            Domingos e Feriados: 09h às 13h
          </p>
        </div>

        <div class="info-block" style="margin-bottom: 0">
          <div class="info-label">Contatos</div>
          <p class="info-text">
            <a href="tel:4933334444">(49) 3333-4444</a><br>
            <a href="mailto:contato@coliseugym.com.br">contato@coliseugym.com.br</a>
          </p>
        </div>

        <div class="divider"></div>

        <a href="https://wa.me/554933334444" target="_blank" rel="noopener" class="btn-wa">
          💬 Chamar no WhatsApp
        </a>
      </div>

      <!-- ── QUADRADO DO FORMULÁRIO ── -->
      <div class="card">
        <h2 class="card-title">Envie uma mensagem</h2>

        <form action="#" method="POST" class="contact-form">
          @csrf

          <div class="form-row">
            <div class="fg">
              <label for="nome">Nome completo <span class="req">*</span></label>
              <input type="text" name="nome" id="nome"
                     placeholder="Ex: Maximus Decimus"
                     class="form-input" required>
            </div>
            <div class="fg">
              <label for="telefone">Telefone</label>
              <input type="tel" name="telefone" id="telefone"
                     placeholder="(49) 99999-9999"
                     class="form-input">
            </div>
          </div>

          <div class="fg">
            <label for="email">E-mail <span class="req">*</span></label>
            <input type="email" name="email" id="email"
                   placeholder="seu-email@provedor.com"
                   class="form-input" required>
          </div>

          <div class="fg">
            <label for="assunto">Assunto</label>
            <select name="assunto" id="assunto" class="form-input">
              <option value="" disabled selected>Selecione um assunto</option>
              <option value="planos">Planos e mensalidades</option>
              <option value="aulas">Aulas e modalidades</option>
              <option value="horarios">Horários de funcionamento</option>
              <option value="outros">Outro assunto</option>
            </select>
          </div>

          <div class="fg">
            <label for="mensagem">Mensagem <span class="req">*</span></label>
            <textarea name="mensagem" id="mensagem" rows="5"
                      placeholder="Como podemos te ajudar a forjar o teu corpo?"
                      class="form-input" required></textarea>
          </div>

          <button type="submit" class="btn-submit">
            ✉️ Enviar Mensagem
          </button>
        </form>
      </div>

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

</body>
</html>