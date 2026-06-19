@extends('layouts.public')
@section('title', 'Planos de Batalha — Coliseu Gym')
@section('content')

    <main class="plans" style="padding-top: 8rem;">
        <div class="section-label">Matrícula Online</div>
        <h2 class="section-title">Escolha o seu período de treino</h2>
        <p style="text-align: center; color: var(--gray); max-width: 600px; margin: -1rem auto 3rem auto; font-size: 1.1rem;">
            Selecione o plano ideal para os seus objetivos. Sem taxas ocultas, acesso total à nossa estrutura de elite.
        </p>

        <div class="plans-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">

            <div class="plan-card">
                <div class="plan-name">Mensal</div>
                <div class="plan-price">R$ 119<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--gold); margin-top: 0.3rem;">Adesão padrão de 1 mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left; font-size: 0.95rem;">
                    <li>Acesso total à musculação</li>
                    <li>Livre escolha de horários</li>
                    <li>Sem fidelidade ou contrato</li>
                    <li>Renovação mensal opcional</li>
                </ul>
                <a href="{{ route('login') }}" class="plan-btn" style="margin-top: 2rem;">Matricular-se</a>
            </div>

            <div class="plan-card">
                <div class="plan-name">Trimestral</div>
                <div class="plan-price">R$ 299<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--white-60); margin-top: 0.3rem;">Equivale a R$ 99,96/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left; font-size: 0.95rem;">
                    <li>Acesso total à musculação</li>
                    <li>Válido por 3 meses corridos</li>
                    <li>Avaliação física inclusa</li>
                    <li>Economia garantida</li>
                </ul>
                <a href="{{ route('login') }}" class="plan-btn" style="margin-top: 2rem;">Matricular-se</a>
            </div>

            <div class="plan-card featured">
                <div class="plan-badge">Melhor Custo-Benefício</div>
                <div class="plan-name">Semestral</div>
                <div class="plan-price">R$ 539<span>,90</span></div>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.8); margin-top: 0.3rem;">Equivale a R$ 89,98/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left; font-size: 0.95rem;">
                    <li>Acesso a todas as áreas (Geral)</li>
                    <li>Válido por 6 meses corridos</li>
                    <li>2 avaliações físicas completas</li>
                    <li>Suporte com instrutor de elite</li>
                    <li>Brinde: Coqueteleira Coliseu</li>
                </ul>
                <a href="{{ route('login') }}" class="plan-btn" style="margin-top: 2rem;">Matricular-se</a>
            </div>

            <div class="plan-card">
                <div class="plan-name">Anual</div>
                <div class="plan-price">R$ 959<span>,90</span></div>
                <p style="font-size: 0.85rem; color: var(--white-60); margin-top: 0.3rem;">Equivale a R$ 79,99/mês</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left; font-size: 0.95rem;">
                    <li>Acesso total 365 dias no ano</li>
                    <li>Válido por 12 meses corridos</li>
                    <li>Avaliações físicas bimestrais</li>
                    <li>Acesso prioritário a eventos</li>
                    <li>Maior desconto da casa</li>
                </ul>
                <a href="{{ route('login') }}" class="plan-btn" style="margin-top: 2rem;">Matricular-se</a>
            </div>

        </div>
    </main>

@endsection
