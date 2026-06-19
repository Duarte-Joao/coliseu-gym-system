@extends('layouts.gym')
@section('title', $usuario->name)
@section('content')
<div class="pg-header">
  <div><h1>{{ $usuario->name }}</h1><p>Perfil do usuário</p></div>
  <div class="actions">
    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('Excluir este usuário?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i> Excluir</button>
    </form>
    <a href="{{ route('usuarios.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</div>
<div class="detail-card">
  <div class="detail-header">
    <h2>{{ $usuario->name }}</h2>
    <span class="badge {{ $usuario->status === 'ativo' ? 'b-ok' : 'b-err' }}">{{ $usuario->status }}</span>
  </div>
  <div class="detail-grid">
    <div class="detail-item"><label>E-mail</label><span>{{ $usuario->email }}</span></div>
    <div class="detail-item"><label>CPF</label><span>{{ $usuario->cpf ?? '—' }}</span></div>
    <div class="detail-item"><label>Nascimento</label><span>{{ $usuario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
    <div class="detail-item"><label>Telefone</label><span>{{ $usuario->numero_telefone ?? '—' }}</span></div>
    <div class="detail-item"><label>Tipo</label><span>{{ $usuario->tipo ?? '—' }}</span></div>
    <div class="detail-item"><label>CEP</label><span>{{ $usuario->cep ?? '—' }}</span></div>
    <div class="detail-item"><label>Endereço</label><span>{{ $usuario->rua ?? '—' }}, {{ $usuario->numero_rua ?? '' }}</span></div>
  </div>
</div>
@if($usuario->instrutor)
<div class="detail-card">
  <div class="detail-header"><h2>Perfil de Instrutor</h2></div>
  <div class="detail-grid">
    <div class="detail-item"><label>Especialidade</label><span>{{ $usuario->instrutor->especialidade }}</span></div>
    <div class="detail-item"><label>Turno</label><span>{{ $usuario->instrutor->turno }}</span></div>
    <div class="detail-item"><label>Salário</label><span>R$ {{ number_format($usuario->instrutor->salario, 2, ',', '.') }}</span></div>
  </div>
</div>
@endif
@if($usuario->planoAlunos->isNotEmpty())
<div class="tbl-wrap">
  <div class="tbl-head"><h3>Planos ({{ $usuario->planoAlunos->count() }})</h3></div>
  <table>
    <thead><tr><th>Tipo</th><th>Valor</th><th>Início</th><th>Fim</th><th></th></tr></thead>
    <tbody>
    @foreach($usuario->planoAlunos as $p)
    <tr>
      <td>{{ $p->tipo }}</td>
      <td>R$ {{ number_format($p->valor, 2, ',', '.') }}</td>
      <td>{{ $p->data_inicio?->format('d/m/Y') }}</td>
      <td>{{ $p->data_fim?->format('d/m/Y') }}</td>
      <td><a href="{{ route('plano-alunos.show', $p) }}" class="btn ghost btn-sm">Ver</a></td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
@endif
@endsection
