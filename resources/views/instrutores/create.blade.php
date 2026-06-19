@extends('layouts.gym')
@section('title', 'Novo Instrutor')
@section('content')
<x-page-header title="Novo Instrutor" subtitle="Vincule um usuário como instrutor">
  <a href="{{ route('instrutores.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>

<div class="form-card">
  <form method="POST" action="{{ route('instrutores.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg span2">
        <label>Usuário *</label>
        <select name="usuario_id" required>
          <option value="">Selecione um usuário com tipo "instrutor"...</option>
          @forelse($usuarios as $u)
            <option value="{{ $u->id }}" {{ old('usuario_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} — {{ $u->email }}</option>
          @empty
            <option disabled>Nenhum usuário disponível (cadastre um usuário com tipo "instrutor" primeiro)</option>
          @endforelse
        </select>
      </div>
      <div class="fg span2">
        <label>Especialidade *</label>
        <input type="text" name="especialidade" value="{{ old('especialidade') }}" placeholder="Ex: Musculação, CrossFit, Yoga..." required>
      </div>
      <div class="fg">
        <label>Salário (R$) *</label>
        <input type="number" name="salario" value="{{ old('salario') }}" min="0" step="0.01" placeholder="0.00" required>
      </div>
      <div class="fg">
        <label>Carga Horária (HH:MM:SS) *</label>
        <input type="text" name="carga_hora" value="{{ old('carga_hora', '08:00:00') }}" placeholder="08:00:00" required>
      </div>
      <div class="fg">
        <label>Turno *</label>
        <select name="turno" required>
          <option value="">Selecione...</option>
          <option value="Manhã" {{ old('turno') === 'Manhã' ? 'selected' : '' }}>Manhã</option>
          <option value="Tarde" {{ old('turno') === 'Tarde' ? 'selected' : '' }}>Tarde</option>
          <option value="Noite" {{ old('turno') === 'Noite' ? 'selected' : '' }}>Noite</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Salvar</button>
      <a href="{{ route('instrutores.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
