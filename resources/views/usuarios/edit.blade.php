@extends('layouts.gym')
@section('title', 'Editar Usuário')
@section('content')
<x-page-header title="Editar Usuário" :subtitle="$usuario->name">
  <a href="{{ route('usuarios.show', $usuario) }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>

<div class="form-card">
  <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg span2"><label>Nome *</label><input type="text" name="name" value="{{ old('name', $usuario->name) }}" required></div>
      <div class="fg"><label>E-mail *</label><input type="email" name="email" value="{{ old('email', $usuario->email) }}" required></div>
      <div class="fg"><label>RG *</label><input type="text" name="rg" value="{{ old('rg', $usuario->rg) }}" placeholder="00.000.000-0" required></div>
      <div class="fg"><label>Data de Nascimento *</label><input type="date" name="data_nascimento" value="{{ old('data_nascimento', $usuario->data_nascimento?->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Telefone *</label><input type="text" name="numero_telefone" value="{{ old('numero_telefone', $usuario->numero_telefone) }}" required></div>
      <div class="fg"><label>CEP *</label><input type="text" name="cep" value="{{ old('cep', $usuario->cep) }}" required></div>
      <div class="fg span2"><label>Rua *</label><input type="text" name="rua" value="{{ old('rua', $usuario->rua) }}" required></div>
      <div class="fg"><label>Número *</label><input type="number" name="numero_rua" value="{{ old('numero_rua', $usuario->numero_rua) }}" required></div>
      <div class="fg">
        <label>Tipo *</label>
        <select name="tipo" required>
          @foreach(['aluno','instrutor','admin'] as $t)
            <option value="{{ $t }}" {{ old('tipo', $usuario->tipo) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Status *</label>
        <select name="status" required>
          <option value="ativo" {{ old('status', $usuario->status) === 'ativo' ? 'selected' : '' }}>Ativo</option>
          <option value="inativo" {{ old('status', $usuario->status) === 'inativo' ? 'selected' : '' }}>Inativo</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('usuarios.show', $usuario) }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
