@extends('layouts.gym')
@section('title', 'Registrar Pagamento')
@section('content')
<x-page-header title="Registrar Pagamento">
  <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>
<div class="form-card">
  <form method="POST" action="{{ route('pagamento-plano-alunos.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg span2">
        <label>Aluno *</label>
        <select name="plano_aluno_id" required>
          <option value="">Selecione...</option>
          @foreach($planos as $p)
            <option value="{{ $p->id }}" {{ (old('plano_aluno_id', $planoSelecionado?->id)) == $p->id ? 'selected' : '' }}>
              {{ $p->aluno->name ?? '?' }} — {{ $p->tipo }} ({{ $p->data_inicio?->format('d/m/Y') }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="fg span2">
        <label>Método de Pagamento *</label>
        <select name="tipo" required>
          <option value="">Selecione...</option>
          @foreach(['Pix', 'Cartão de Crédito', 'Cartão de Débito', 'Dinheiro', 'Boleto'] as $metodo)
            <option value="{{ $metodo }}" {{ old('tipo') === $metodo ? 'selected' : '' }}>{{ $metodo }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Data *</label><input type="date" name="data" value="{{ old('data', date('Y-m-d')) }}" required></div>
      <div class="fg">
        <label>Status</label>
        <select name="status">
          <option value="pendente" {{ old('status','pendente') === 'pendente' ? 'selected' : '' }}>Pendente</option>
          <option value="pago" {{ old('status') === 'pago' ? 'selected' : '' }}>Pago</option>
          <option value="cancelado" {{ old('status') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Registrar</button>
      <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
