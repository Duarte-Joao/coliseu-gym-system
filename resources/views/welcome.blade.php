<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coliseu Gym - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/coliseu.css') }}">
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="logo">
            Coliseu <span>Gym</span>
            <small>Desde 2015 · Chapecó - SC</small>
        </div>
        <nav>
            <a href="{{ route('home') }}">Início</a>
            <a href="{{ route('planos') }}">Planos</a>
            <a href="{{ route('contato') }}">Contato</a>
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('planos') }}" class="btn-nav">Matricule-se</a>
        </nav>
    </header>

    <main class="hero">
        <div class="hero-bg"></div>
        <div class="hero-accent"></div>
        <div class="hero-number">I</div>

        <div class="hero-content">
            <div class="hero-badge">Academia Premium · Chapecó SC</div>

            <h1>
                Forja teu corpo,
                <span class="highlight">domina tua mente</span>
            </h1>

            <div class="hero-divider"></div>

            <p class="hero-desc">
                A melhor estrutura de treinamento para você alcançar a sua melhor versão.
                Equipamentos de elite, instrutores certificados e uma comunidade que te impulsiona.
            </p>

            <div class="hero-ctas">
                <a href="{{ route('planos') }}" class="btn-primary">Matricule-se Já</a>
                <a href="{{ route('contato') }}" class="btn-secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Fale Conosco
                </a>
            </div>
        </div>

        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-num">2.500+</div>
                <div class="stat-label">Alunos Ativos</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">8+</div>
                <div class="stat-label">Anos de Experiência</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">35+</div>
                <div class="stat-label">Instrutores</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">98%</div>
                <div class="stat-label">Satisfação</div>
            </div>
        </div>
    </main>

    <section class="features">
        <div class="section-label">Nossa Estrutura</div>
        <h2 class="section-title">Tudo que você precisa para evoluir</h2>

        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🏋️</span>
                <div class="feature-title">Musculação</div>
                <p class="feature-desc">Equipamentos de última geração para treinos de força e hipertrofia com máxima eficiência.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🥊</span>
                <div class="feature-title">Artes Marciais</div>
                <p class="feature-desc">Muay Thai, Jiu-Jitsu e Boxe com mestres certificados em espaço dedicado.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🔥</span>
                <div class="feature-title">Cross Training</div>
                <p class="feature-desc">Aulas funcionais de alta intensidade para queimar gordura e ganhar condicionamento.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🧘</span>
                <div class="feature-title">Yoga & Pilates</div>
                <p class="feature-desc">Equilíbrio entre corpo e mente com instrutoras especializadas em turmas reduzidas.</p>
            </div>
        </div>
    </section>

    <!-- Planos  -->
    <section class="plans">
        <div class="section-label">Planos</div>
        <h2 class="section-title">Escolha seu plano de batalha</h2>

        <div class="plans-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
            
            <!-- PLANO MENSAL -->
            <div class="plan-card">
                <div class="plan-name">Mensal</div>
                <div class="plan-price">R$ 119<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--white-60); margin-top: 0.3rem; margin-bottom: 1rem;">Adesão padrão de 1 mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left;">
                    <li>✓ Acesso total à musculação</li>
                    <li>✓ Livre escolha de horários</li>
                    <li>✓ Sem fidelidade ou contrato</li>
                    <li>✓ Renovação mensal opcional</li>
                </ul>
                <a href="{{ route('planos') }}" class="plan-btn">Matricular-se</a>
            </div>

            <!-- PLANO TRIMESTRAL -->
            <div class="plan-card">
                <div class="plan-name">Trimestral</div>
                <div class="plan-price">R$ 299<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--white-60); margin-top: 0.3rem; margin-bottom: 1rem;">Equivale a R$ 99,96/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left;">
                    <li>✓ Acesso total à musculação</li>
                    <li>✓ Válido por 3 meses corridos</li>
                    <li>✓ Avaliação física inclusa</li>
                    <li>✓ Economia garantida</li>
                </ul>
                <a href="{{ route('planos') }}" class="plan-btn">Matricular-se</a>
            </div>

            <!-- PLANO SEMESTRAL (DESTAQUE) o melhor dos planos -->
            <div class="plan-card featured">
                <div class="plan-badge">Melhor Custo-Benefício</div>
                <div class="plan-name">Semestral</div>
                <div class="plan-price">R$ 539<span>,90</span></div>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.8); margin-top: 0.3rem; margin-bottom: 1rem;">Equivale a R$ 89,98/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left;">
                    <li>✓ Acesso a todas as áreas (Geral)</li>
                    <li>✓ Válido por 6 meses corridos</li>
                    <li>✓ 2 avaliações físicas completas</li>
                    <li>✓ Suporte com instrutor de elite</li>
                    <li>✓ Brinde: Coqueteleira Coliseu</li>
                </ul>
                <a href="{{ route('planos') }}" class="plan-btn">Matricular-se</a>
            </div>

            <!-- PLANO ANUAL -->
            <div class="plan-card">
                <div class="plan-name">Anual</div>
                <div class="plan-price">R$ 959<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--white-60); margin-top: 0.3rem; margin-bottom: 1rem;">Equivale a R$ 79,99/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left;">
                    <li>✓ Acesso total 365 dias no ano</li>
                    <li>✓ Válido por 12 meses corridos</li>
                    <li>✓ Avaliações físicas bimestrais</li>
                    <li>✓ Acesso prioritário a eventos</li>
                    <li>✓ Maior desconto da casa</li>
                </ul>
                <a href="{{ route('planos') }}" class="plan-btn">Matricular-se</a>
            </div>

        </div>
    </section>

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