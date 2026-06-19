@extends('layouts.gym')
@section('title', 'Meu Perfil')

@push('styles')
<style>
  .perfil-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem}
  .perfil-hero{background:linear-gradient(135deg,var(--p3) 0%,rgba(139,92,246,0.3) 100%);padding:2rem 2rem 1.5rem;display:flex;align-items:center;gap:1.5rem}
  .perfil-avatar{width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:2rem;color:#fff;flex-shrink:0;border:2px solid rgba(255,255,255,0.2)}
  .perfil-hero-info h2{font-family:'Bebas Neue',sans-serif;font-size:2.2rem;letter-spacing:1px;margin-bottom:4px}
  .perfil-hero-info p{font-size:0.85rem;color:rgba(255,255,255,0.6)}
  .perfil-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))}
  .perfil-item{padding:1.1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.04)}
  .perfil-item:last-child{border-bottom:none}
  .perfil-item label{font-size:0.7rem;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);display:block;margin-bottom:4px}
  .perfil-item span{font-size:0.92rem;font-weight:500}
  .perfil-section-title{font-size:0.7rem;text-transform:uppercase;letter-spacing:2px;color:var(--muted);font-weight:700;padding:1rem 1.5rem 0.25rem;border-top:1px solid var(--border)}
</style>
@endpush

@section('content')
<x-page-header title="Meu Perfil" subtitle="Informações da sua conta">
  <a href="{{ route('usuarios.edit', $usuario) }}" class="btn"><i class="ti ti-pencil"></i> Editar Perfil</a>
</x-page-header>

<div class="perfil-card">
  <div class="perfil-hero">
    <div class="perfil-avatar">{{ strtoupper(substr($usuario->name ?? '?', 0, 2)) }}</div>
    <div class="perfil-hero-info">
      <h2>{{ $usuario->name }}</h2>
      <p>{{ $usuario->email }} · Treinador</p>
    </div>
  </div>

  <div class="perfil-section-title">Dados Pessoais</div>
  <div class="perfil-grid">
    <div class="perfil-item"><label>RG</label><span>{{ $usuario->rg ?? '—' }}</span></div>
    <div class="perfil-item"><label>Telefone</label><span>{{ $usuario->numero_telefone ?? '—' }}</span></div>
    <div class="perfil-item"><label>Nascimento</label><span>{{ $usuario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
    <div class="perfil-item"><label>Status</label>
      <span class="badge {{ $usuario->status === 'ativo' ? 'b-ok' : 'b-err' }}">{{ $usuario->status }}</span>
    </div>
  </div>

  <div class="perfil-section-title">Endereço</div>
  <div class="perfil-grid">
    <div class="perfil-item"><label>CEP</label><span>{{ $usuario->cep ?? '—' }}</span></div>
    <div class="perfil-item"><label>Rua</label><span>{{ $usuario->rua ?? '—' }}</span></div>
    <div class="perfil-item"><label>Número</label><span>{{ $usuario->numero_rua ?? '—' }}</span></div>
  </div>

  @if($instrutor)
  <div class="perfil-section-title">Dados Profissionais</div>
  <div class="perfil-grid">
    <div class="perfil-item"><label>Especialidade</label><span>{{ $instrutor->especialidade ?? '—' }}</span></div>
    <div class="perfil-item"><label>Turno</label><span>{{ $instrutor->turno ?? '—' }}</span></div>
    <div class="perfil-item"><label>Carga Horária</label><span>{{ $instrutor->carga_hora ?? '—' }} h/semana</span></div>
    <div class="perfil-item"><label>Salário</label><span>R$ {{ $instrutor->salario ? number_format($instrutor->salario, 2, ',', '.') : '—' }}</span></div>
  </div>
  @endif
</div>
@endsection
