@extends('layouts.gym')
@section('title', 'Novo Usuário')
@section('content')
<div class="pg-header">
  <div><h1>Novo Usuário</h1><p>Cadastrar usuário pelo painel administrativo</p></div>
  <a href="{{ route('usuarios.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>

<div class="form-card">
  <form method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg span2"><label>Nome *</label><input type="text" name="name" value="{{ old('name') }}" required></div>
      <div class="fg"><label>E-mail *</label><input type="email" name="email" value="{{ old('email') }}" required></div>
      <div class="fg"><label>Senha *</label><input type="password" name="password" required></div>
      <div class="fg"><label>CPF *</label><input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" required></div>
      <div class="fg"><label>Data de Nascimento *</label><input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required></div>
      <div class="fg"><label>Telefone *</label><input type="text" name="numero_telefone" value="{{ old('numero_telefone') }}" placeholder="(49) 99999-9999" required></div>
      <div class="fg"><label>CEP *</label><input type="text" name="cep" value="{{ old('cep') }}" placeholder="89800-000" required></div>
      <div class="fg span2"><label>Rua *</label><input type="text" name="rua" value="{{ old('rua') }}" required></div>
      <div class="fg"><label>Número *</label><input type="number" name="numero_rua" value="{{ old('numero_rua') }}" required></div>
      <div class="fg">
        <label>Tipo *</label>
        <select name="tipo" required>
          <option value="">Selecione...</option>
          @foreach(['aluno','instrutor','admin'] as $t)
            <option value="{{ $t }}" {{ old('tipo') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Status *</label>
        <select name="status" required>
          <option value="ativo" {{ old('status','ativo') === 'ativo' ? 'selected' : '' }}>Ativo</option>
          <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Salvar</button>
      <a href="{{ route('usuarios.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
