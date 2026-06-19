@extends('layouts.gym')
@section('title', 'Novo Treino')
@section('content')
<x-page-header title="Novo Treino" subtitle="Preencha os dados do template de treino">
  <a href="{{ route('treinos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>

<div class="form-card">
  <form method="POST" action="{{ route('treinos.store') }}">
    @csrf
    <div class="form-grid">
      @if($meuInstrutor)
        <input type="hidden" name="instrutor_id" value="{{ $meuInstrutor->id }}">
        <div class="fg">
          <label>Instrutor</label>
          <input type="text" value="{{ auth()->user()->name }}" disabled>
        </div>
      @else
      <div class="fg">
        <label>Instrutor *</label>
        <select name="instrutor_id" required>
          <option value="">Selecione...</option>
          @foreach($instrutores as $i)
            <option value="{{ $i->id }}" {{ old('instrutor_id') == $i->id ? 'selected' : '' }}>{{ $i->usuario->name }}</option>
          @endforeach
        </select>
      </div>
      @endif
      <div class="fg">
        <label>Nome do Treino *</label>
        <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex: Treino A - Peito e Tríceps" required>
      </div>
      <div class="fg span2">
        <label>Descrição</label>
        <textarea name="descricao" placeholder="Descrição geral sobre o treino...">{{ old('descricao') }}</textarea>
      </div>
    </div>

    <div style="margin-top:1.5rem">
      <label style="display:block;margin-bottom:0.75rem">Exercícios *</label>
      <div class="ex-list" id="ex-list"></div>
      <button type="button" class="btn-add-ex" onclick="addExercicio()">
        <i class="ti ti-plus"></i> Adicionar Exercício
      </button>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Salvar Treino</button>
      <a href="{{ route('treinos.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
let idx = 0;
function addExercicio(nome='', series=3, reps=10, carga=0) {
  const row = document.createElement('div');
  row.className = 'ex-row';
  row.innerHTML = `
    <div class="fg"><label>Exercício</label>
      <input type="text" name="exercicios[${idx}][nome]" placeholder="Ex: Supino Reto" value="${nome}" required></div>
    <div class="fg"><label>Séries</label>
      <input type="number" name="exercicios[${idx}][series]" min="1" value="${series}" required></div>
    <div class="fg"><label>Reps</label>
      <input type="number" name="exercicios[${idx}][repeticoes]" min="1" value="${reps}" required></div>
    <div class="fg"><label>Carga (kg)</label>
      <input type="number" name="exercicios[${idx}][carga]" min="0" step="0.5" value="${carga}" required></div>
    <button type="button" class="ex-remove" onclick="this.parentElement.remove()"><i class="ti ti-x"></i></button>`;
  document.getElementById('ex-list').appendChild(row);
  idx++;
}
addExercicio();
</script>
@endpush
