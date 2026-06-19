@extends('layouts.gym')
@section('title', 'Nova Aula Coletiva')
@section('content')
<div class="pg-header">
  <div><h1>Nova Aula Coletiva</h1></div>
  <a href="{{ route('aulas-coletivas.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ route('aulas-coletivas.store') }}">
    @csrf
    <div class="form-grid">
      <div class="fg">
        <label>Instrutor *</label>
        <select name="instrutor_id" required>
          <option value="">Selecione...</option>
          @foreach($instrutores as $i)
            <option value="{{ $i->id }}" {{ old('instrutor_id') == $i->id ? 'selected' : '' }}>{{ $i->usuario->name }}</option>
          @endforeach
        </select>
      </div>
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
