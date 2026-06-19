@extends('layouts.gym')
@section('title', 'Plano')
@section('content')
<x-page-header :title="'Plano ' . $plano->tipo" :subtitle="$plano->aluno->name ?? '—'">
  <div class="actions">
    <a href="{{ route('plano-alunos.pdf', $plano) }}" class="btn ghost" target="_blank"><i class="ti ti-file-type-pdf"></i> Exportar PDF</a>
    <a href="{{ route('plano-alunos.edit', $plano) }}" class="btn ghost"><i class="ti ti-pencil"></i> Editar</a>
    <form method="POST" action="{{ route('plano-alunos.destroy', $plano) }}" onsubmit="return confirm('Excluir este plano?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn danger"><i class="ti ti-trash"></i></button>
    </form>
    <a href="{{ route('plano-alunos.index') }}" class="btn ghost"><i class="ti ti-arrow-left"></i> Voltar</a>
  </div>
</x-page-header>
<div class="detail-card">
  <div class="detail-header"><h2>{{ $plano->tipo }}</h2></div>
  <div class="detail-grid">
    <div class="detail-item"><label>Aluno</label><span>{{ $plano->aluno->name ?? '—' }}</span></div>
    <div class="detail-item"><label>Valor</label><span>R$ {{ number_format($plano->valor, 2, ',', '.') }}</span></div>
    <div class="detail-item"><label>Duração</label><span>{{ $plano->duracao_meses }} mês(es)</span></div>
    <div class="detail-item"><label>Início</label><span>{{ $plano->data_inicio?->format('d/m/Y') }}</span></div>
    <div class="detail-item"><label>Fim</label><span>{{ $plano->data_fim?->format('d/m/Y') }}</span></div>
  </div>
</div>
<div class="tbl-wrap">
  <div class="tbl-head">
    <h3>Pagamentos ({{ $plano->pagamentos->count() }})</h3>
    <a href="{{ route('pagamento-plano-alunos.create', ['plano_aluno_id' => $plano->id]) }}" class="btn btn-sm"><i class="ti ti-plus"></i> Registrar</a>
  </div>
  @if($plano->pagamentos->isEmpty())
    <div class="empty"><i class="ti ti-cash"></i>Nenhum pagamento registrado</div>
  @else
  <table>
    <thead>
      <tr><th>Método</th><th>Data</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
    @foreach($plano->pagamentos as $pag)
    <tr>
      <td><strong>{{ $pag->tipo }}</strong></td>
      <td>{{ $pag->data?->format('d/m/Y') ?? '—' }}</td>
      <td><span class="badge {{ $pag->status === 'pago' ? 'b-ok' : ($pag->status === 'cancelado' ? 'b-err' : 'b-warn') }}">{{ $pag->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('pagamento-plano-alunos.edit', $pag) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('pagamento-plano-alunos.destroy', $pag) }}" onsubmit="return confirm('Excluir?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn danger btn-sm"><i class="ti ti-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @endif
</div>
@endsection
