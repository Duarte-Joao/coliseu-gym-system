@extends('layouts.gym')
@section('title', 'Nova Aula Coletiva')
@section('content')
<x-page-header title="Nova Aula Coletiva">
  <a href="{{ route('aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</x-page-header>
<div class="form-card">
  <form method="POST" action="{{ route('aulas-coletivas.store') }}">
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
      <div class="fg"><label>Modalidade *</label><input type="text" name="modalidade" value="{{ old('modalidade') }}" placeholder="Ex: Zumba, Spinning, Yoga" required></div>
      <div class="fg"><label>Data e Hora *</label><input type="datetime-local" name="datahora" value="{{ old('datahora') }}" required></div>
      <div class="fg"><label>Vagas *</label><input type="number" name="vagas" value="{{ old('vagas', 20) }}" min="1" required></div>
      <div class="fg span2"><label>Observações</label><textarea name="obs" placeholder="Informações adicionais...">{{ old('obs') }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn"><i class="ti ti-device-floppy"></i> Salvar</button>
      <a href="{{ route('aulas-coletivas.index') }}" class="btn ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
