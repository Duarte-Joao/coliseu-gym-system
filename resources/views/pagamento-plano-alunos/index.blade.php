@extends('layouts.gym')
@section('title', 'Pagamentos')

@push('styles')
<style>
  .chart-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:1.25rem}
  .chart-card h3{font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-bottom:1rem}
  .chart-wrap{position:relative;height:220px}
</style>
@endpush

@section('content')
<x-page-header title="Pagamentos" subtitle="Registros de pagamentos de planos">
  <a href="{{ route('pagamento-plano-alunos.pdf', request()->query()) }}" class="btn ghost" target="_blank"><i class="ti ti-file-type-pdf"></i> Exportar PDF</a>
  <a href="{{ route('pagamento-plano-alunos.create') }}" class="btn"><i class="ti ti-plus"></i> Registrar Pagamento</a>
</x-page-header>

<form class="filter-bar" method="GET">
  <div class="fg" style="flex:2;min-width:200px">
    <label>Buscar aluno</label>
    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome do aluno...">
  </div>
  <div class="fg">
    <label>Método</label>
    <select name="tipo">
      <option value="">Todos</option>
      @foreach(['Pix','Cartão de Crédito','Cartão de Débito','Dinheiro','Boleto'] as $m)
        <option value="{{ $m }}" {{ request('tipo') === $m ? 'selected' : '' }}>{{ $m }}</option>
      @endforeach
    </select>
  </div>
  <div class="fg">
    <label>Status</label>
    <select name="status">
      <option value="">Todos</option>
      @foreach(['pago','pendente','cancelado'] as $s)
        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn ghost"><i class="ti ti-search"></i> Filtrar</button>
  <a href="{{ route('pagamento-plano-alunos.index') }}" class="btn ghost"><i class="ti ti-x"></i></a>
</form>

<div class="chart-card">
  <h3><i class="ti ti-chart-bar"></i> Entradas Financeiras — Últimos 6 Meses</h3>
  <div class="chart-wrap">
    <canvas id="chartFinanceiro"></canvas>
  </div>
</div>

<div class="tbl-wrap">
  <div class="tbl-head"><h3>{{ $pagamentos->total() }} pagamento(s)</h3></div>
  @if($pagamentos->isEmpty())
    <div class="empty"><i class="ti ti-cash"></i>Nenhum pagamento registrado</div>
  @else
  <table>
    <thead><tr><th>Aluno</th><th>Plano</th><th>Método</th><th>Data</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($pagamentos as $pag)
    <tr>
      <td>{{ $pag->plano->aluno->name ?? '—' }}</td>
      <td>{{ $pag->plano->tipo ?? '—' }}</td>
      <td>{{ $pag->tipo }}</td>
      <td>{{ $pag->data?->format('d/m/Y') }}</td>
      <td><span class="badge {{ $pag->status === 'pago' ? 'b-ok' : ($pag->status === 'cancelado' ? 'b-err' : 'b-warn') }}">{{ $pag->status }}</span></td>
      <td>
        <div class="actions">
          <a href="{{ route('pagamento-plano-alunos.edit', $pag) }}" class="btn ghost btn-sm"><i class="ti ti-pencil"></i></a>
          <form method="POST" action="{{ route('pagamento-plano-alunos.destroy', $pag) }}" onsubmit="return confirm('Excluir este pagamento?')">
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
<div class="pag-wrap">{{ $pagamentos->links() }}</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
(function () {
  var labels   = @json($chartLabels);
  var receita  = @json($chartReceita);
  var pendente = @json($chartPendente);

  new Chart(document.getElementById('chartFinanceiro'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Confirmado (R$)',
          data: receita,
          backgroundColor: 'rgba(139,92,246,0.75)',
          borderColor: '#8b5cf6',
          borderWidth: 1,
          borderRadius: 4,
        },
        {
          label: 'Pendente (R$)',
          data: pendente,
          backgroundColor: 'rgba(245,158,11,0.5)',
          borderColor: '#f59e0b',
          borderWidth: 1,
          borderRadius: 4,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: '#f0f0f5', font: { family: 'Barlow', size: 12 } }
        },
        tooltip: {
          callbacks: {
            label: function (ctx) {
              return ' ' + ctx.dataset.label + ': R$ ' + ctx.parsed.y.toFixed(2).replace('.', ',');
            }
          }
        }
      },
      scales: {
        x: {
          ticks: { color: '#7a7a8c', font: { family: 'Barlow' } },
          grid:  { color: 'rgba(139,92,246,0.08)' },
        },
        y: {
          ticks: {
            color: '#7a7a8c',
            font: { family: 'Barlow' },
            callback: function (v) { return 'R$ ' + v.toLocaleString('pt-BR'); }
          },
          grid: { color: 'rgba(139,92,246,0.08)' },
        },
      },
    },
  });
})();
</script>
@endpush
