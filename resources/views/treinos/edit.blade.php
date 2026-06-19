@extends('layouts.gym')
@section('title', 'Editar Treino')
@section('content')
<x-page-header title="Editar Treino" :subtitle="$treino->nome">
  <a href="{{ route('treinos.show', $treino) }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>

<div class="form-card">
  <form method="POST" action="{{ route('treinos.update', $treino) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="fg">
        <label>Instrutor</label>
        @if($meuInstrutor)
          <input type="text" value="{{ auth()->user()->name }}" disabled>
        @else
          <select name="instrutor_id" disabled>
            @foreach($instrutores as $i)
              <option value="{{ $i->id }}" {{ $treino->instrutor_id == $i->id ? 'selected' : '' }}>{{ $i->usuario->name }}</option>
            @endforeach
          </select>
          <small style="color:var(--muted);font-size:0.78rem">O instrutor não pode ser alterado</small>
        @endif
      </div>
      <div class="fg">
        <label>Nome do Treino *</label>
        <input type="text" name="nome" value="{{ old('nome', $treino->nome) }}" required>
      </div>
      <div class="fg span2">
        <label>Descrição</label>
        <textarea name="descricao">{{ old('descricao', $treino->descricao) }}</textarea>
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
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Atualizar Treino</button>
      <a href="{{ route('treinos.show', $treino) }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
let idx = 0;
const existentes = @json($treino->exercicios ?? []);

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

existentes.forEach(e => addExercicio(e.nome, e.series, e.repeticoes, e.carga));
if (existentes.length === 0) addExercicio();
</script>
@endpush
