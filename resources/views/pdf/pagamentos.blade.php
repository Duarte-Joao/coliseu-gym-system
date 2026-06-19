<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; background: #fff; }
  .page { padding: 28px 32px; }

  .header { border-bottom: 3px solid #8b5cf6; padding-bottom: 14px; margin-bottom: 20px; }
  .header-top { display: table; width: 100%; }
  .header-left { display: table-cell; vertical-align: middle; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; }
  .logo { font-size: 22px; font-weight: bold; color: #8b5cf6; letter-spacing: 2px; }
  .logo-sub { font-size: 7px; letter-spacing: 3px; color: #999; text-transform: uppercase; margin-top: 2px; }
  .doc-title { font-size: 14px; font-weight: bold; color: #333; text-transform: uppercase; letter-spacing: 1px; }
  .doc-date { font-size: 9px; color: #888; margin-top: 3px; }

  .filter-info { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; padding: 8px 12px; margin-bottom: 16px; font-size: 9px; color: #666; }
  .filter-info strong { color: #333; }

  .stats-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 8px; margin: -8px 0 10px; }
  .stat-cell { display: table-cell; }
  .stat-box { border-radius: 4px; padding: 12px 14px; text-align: center; }
  .stat-box.total  { background: #f3f0ff; border: 1px solid #ddd6fe; }
  .stat-box.pago   { background: #ecfdf5; border: 1px solid #a7f3d0; }
  .stat-box.pend   { background: #fffbeb; border: 1px solid #fde68a; }
  .stat-box.canc   { background: #fef2f2; border: 1px solid #fecaca; }
  .stat-label { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 5px; }
  .stat-label.total  { color: #6d28d9; }
  .stat-label.pago   { color: #059669; }
  .stat-label.pend   { color: #d97706; }
  .stat-label.canc   { color: #dc2626; }
  .stat-value { font-size: 18px; font-weight: bold; }
  .stat-value.total  { color: #6d28d9; }
  .stat-value.pago   { color: #059669; }
  .stat-value.pend   { color: #d97706; }
  .stat-value.canc   { color: #dc2626; }

  .section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #8b5cf6; font-weight: bold; margin-bottom: 8px; margin-top: 18px; border-bottom: 1px solid #e0d7ff; padding-bottom: 5px; }

  .pag-table { width: 100%; border-collapse: collapse; }
  .pag-table thead tr { background: #8b5cf6; color: #fff; }
  .pag-table thead th { padding: 7px 9px; text-align: left; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }
  .pag-table tbody tr { border-bottom: 1px solid #ede9fe; }
  .pag-table tbody tr:last-child { border-bottom: none; }
  .pag-table tbody tr:nth-child(even) { background: #faf8ff; }
  .pag-table tbody td { padding: 6px 9px; font-size: 10px; }
  .badge-pago     { background: #d1fae5; color: #065f46; border-radius: 3px; padding: 2px 6px; font-size: 8px; font-weight: bold; }
  .badge-pendente { background: #fef3c7; color: #92400e; border-radius: 3px; padding: 2px 6px; font-size: 8px; font-weight: bold; }
  .badge-cancelado{ background: #fee2e2; color: #991b1b; border-radius: 3px; padding: 2px 6px; font-size: 8px; font-weight: bold; }

  .footer { margin-top: 24px; border-top: 1px solid #e5e7eb; padding-top: 10px; display: table; width: 100%; }
  .footer-left { display: table-cell; font-size: 8px; color: #bbb; }
  .footer-right { display: table-cell; text-align: right; font-size: 8px; color: #bbb; }
</style>
</head>
<body>
<div class="page">

  {{-- HEADER --}}
  <div class="header">
    <div class="header-top">
      <div class="header-left">
        <div class="logo">COLISEU GYM</div>
        <div class="logo-sub">Arena de Performance</div>
      </div>
      <div class="header-right">
        <div class="doc-title">Relatório de Pagamentos</div>
        <div class="doc-date">Emitido em {{ now()->format('d/m/Y H:i') }}</div>
      </div>
    </div>
  </div>

  {{-- FILTERS APPLIED --}}
  @if($busca || $tipo || $status)
  <div class="filter-info">
    <strong>Filtros aplicados:</strong>
    @if($busca) Aluno: "{{ $busca }}" @endif
    @if($tipo) &bull; Método: {{ $tipo }} @endif
    @if($status) &bull; Status: {{ ucfirst($status) }} @endif
  </div>
  @endif

  {{-- SUMMARY STATS --}}
  <div class="stats-grid">
    <div class="stat-cell">
      <div class="stat-box total">
        <div class="stat-label total">Total</div>
        <div class="stat-value total">{{ $pagamentos->count() }}</div>
      </div>
    </div>
    <div class="stat-cell">
      <div class="stat-box pago">
        <div class="stat-label pago">Pagos</div>
        <div class="stat-value pago">{{ $pagamentos->where('status','pago')->count() }}</div>
      </div>
    </div>
    <div class="stat-cell">
      <div class="stat-box pend">
        <div class="stat-label pend">Pendentes</div>
        <div class="stat-value pend">{{ $pagamentos->where('status','pendente')->count() }}</div>
      </div>
    </div>
    <div class="stat-cell">
      <div class="stat-box canc">
        <div class="stat-label canc">Cancelados</div>
        <div class="stat-value canc">{{ $pagamentos->where('status','cancelado')->count() }}</div>
      </div>
    </div>
  </div>

  {{-- TABLE --}}
  <div class="section-title">Detalhamento</div>
  @if($pagamentos->isNotEmpty())
  <table class="pag-table">
    <thead>
      <tr>
        <th>Aluno</th>
        <th>Plano</th>
        <th>Método</th>
        <th>Data</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pagamentos as $pag)
      <tr>
        <td><strong>{{ $pag->plano->aluno->name ?? '—' }}</strong></td>
        <td>{{ $pag->plano->tipo ?? '—' }}</td>
        <td>{{ $pag->tipo }}</td>
        <td>{{ $pag->data?->format('d/m/Y') ?? '—' }}</td>
        <td>
          @if($pag->status === 'pago')
            <span class="badge-pago">Pago</span>
          @elseif($pag->status === 'pendente')
            <span class="badge-pendente">Pendente</span>
          @else
            <span class="badge-cancelado">Cancelado</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="font-size:10px;color:#aaa;padding:12px 0;">Nenhum pagamento encontrado para os filtros aplicados.</p>
  @endif

  <div class="footer">
    <div class="footer-left">COLISEU GYM &bull; Relatório gerado automaticamente</div>
    <div class="footer-right">{{ $pagamentos->count() }} registro(s) &bull; {{ now()->format('d/m/Y') }}</div>
  </div>

</div>
</body>
</html>
