@extends('layouts.gym')
@section('title', 'Atribuir Treino')
@section('content')
<x-page-header title="Atribuir Treino a Aluno">
  <a href="{{ route('treino-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>
<div class="form-card">
  <form method="POST" action="{{ route('treino-alunos.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg">
        <label>Aluno *</label>
        <select name="usuario_id" required>
          <option value="">Selecione...</option>
          @foreach($usuarios as $u)
            <option value="{{ $u->id }}" {{ old('usuario_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Treino *</label>
        <select name="treino_id" required>
          <option value="">Selecione...</option>
          @foreach($treinos as $t)
            <option value="{{ $t->id }}" {{ old('treino_id', request('treino_id')) == $t->id ? 'selected' : '' }}>
              {{ $t->nome }} ({{ $t->instrutor->usuario->name ?? '?' }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Validade</label><input type="date" name="validade" value="{{ old('validade', date('Y-m-d', strtotime('+1 year'))) }}"></div>
      <div class="fg span2"><label>Descrição</label><input type="text" name="descricao" value="{{ old('descricao') }}" placeholder="Observações sobre a atribuição..."></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atribuir</button>
      <a href="{{ route('treino-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
