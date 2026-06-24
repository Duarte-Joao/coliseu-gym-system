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

            @foreach($planosDisponiveis as $plano)
            <div class="plan-card @if($plano->featured) featured @endif">
                @if($plano->featured)
                <div class="plan-badge">Melhor Custo-Benefício</div>
                @endif
                <div class="plan-name">{{ $plano->tipo }}</div>
                <div class="plan-price">R$ {{ number_format($plano->valor, 0, '', '') }}<span>,{{ sprintf('%02d', ($plano->valor * 100) % 100) }}</span></div>
                <p style="font-size: 0.85rem; color: @if($plano->featured) rgba(255,255,255,0.8) @else var(--gold) @endif; margin-top: 0.3rem;">{{ $plano->descricao }}</p>
                <div class="plan-divider"></div>
                <ul class="plan-features" style="text-align: left; font-size: 0.95rem;">
                    @foreach($plano->beneficios as $beneficio)
                    <li>{{ $beneficio }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('login') }}" class="plan-btn" style="margin-top: 2rem;">Matricular-se</a>
            </div>
            @endforeach

        </div>
    </main>

@endsection
