<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Coliseu Gym')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/coliseu.css') }}">
  @stack('styles')
</head>
<body>

  <header class="navbar">
    <div class="logo">
      Coliseu <span>Gym</span>
      <small>Desde 2026 · Chapecó - SC</small>
    </div>
    <nav>
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Início</a>
      <a href="{{ route('planos') }}" class="{{ request()->routeIs('planos') ? 'active' : '' }}">Planos</a>
      <a href="{{ route('contato') }}" class="{{ request()->routeIs('contato') ? 'active' : '' }}">Contato</a>
      <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
    </nav>
  </header>

  @yield('content')

  <footer>
    <div class="footer-logo">Coliseu <span>Gym</span></div>
    <div class="footer-links">
      <a href="#">Instagram</a>
      <a href="#">WhatsApp</a>
      <a href="#">Localização</a>
    </div>
    <div class="footer-copy">© 2026 Coliseu Gym · Todos os direitos reservados</div>
  </footer>

  @stack('scripts')
</body>
</html>
