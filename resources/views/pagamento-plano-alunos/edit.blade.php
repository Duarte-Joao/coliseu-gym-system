@extends('layouts.gym')
@section('title', 'Editar Pagamento')
@section('content')
<div class="pg-header">
  <div><h1>Editar Pagamento</h1><p>{{ $pagamento->plano->aluno->name ?? '' }} — {{ $pagamento->plano->tipo ?? '' }}</p></div>
  <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('pagamento-plano-alunos.update', $pagamento) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg span2"><label>Método de Pagamento *</label><input type="text" name="metodo_pagamento" value="{{ old('metodo_pagamento', $pagamento->metodo_pagamento) }}" required></div>
      <div class="fg"><label>Data *</label><input type="date" name="data" value="{{ old('data', $pagamento->data?->format('Y-m-d')) }}" required></div>
      <div class="fg">
        <label>Status *</label>
        <select name="status" required>
          @foreach(['pago','pendente','cancelado'] as $s)
            <option value="{{ $s }}" {{ old('status', $pagamento->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar</button>
      <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
