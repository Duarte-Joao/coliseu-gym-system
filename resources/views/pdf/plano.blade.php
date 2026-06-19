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

  .section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #8b5cf6; font-weight: bold; margin-bottom: 8px; margin-top: 18px; border-bottom: 1px solid #e0d7ff; padding-bottom: 5px; }

  .two-col { display: table; width: 100%; border-collapse: separate; border-spacing: 10px; margin: -10px; }
  .col { display: table-cell; width: 50%; padding: 10px; vertical-align: top; }
  .info-card { background: #f8f6ff; border: 1px solid #e0d7ff; border-left: 4px solid #8b5cf6; border-radius: 4px; padding: 12px 14px; }
  .info-label { font-size: 8px; text-transform: uppercase; letter-spacing: 1.5px; color: #8b5cf6; font-weight: bold; margin-bottom: 3px; }
  .info-value { font-size: 13px; font-weight: bold; color: #222; }
  .info-value-sm { font-size: 10px; color: #555; margin-top: 2px; }

  .summary-grid { display: table; width: 100%; }
  .summary-cell { display: table-cell; width: 33.33%; text-align: center; padding: 14px 8px; }
  .summary-cell.pago { background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 4px; }
  .summary-cell.pendente { background: #fffbeb; border: 1px solid #fde68a; border-radius: 4px; }
  .summary-cell.cancelado { background: #fef2f2; border: 1px solid #fecaca; border-radius: 4px; }
  .summary-label { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 6px; }
  .summary-label.pago { color: #059669; }
  .summary-label.pendente { color: #d97706; }
  .summary-label.cancelado { color: #dc2626; }
  .summary-value { font-size: 16px; font-weight: bold; }
  .summary-value.pago { color: #059669; }
  .summary-value.pendente { color: #d97706; }
  .summary-value.cancelado { color: #dc2626; }

  .pag-table { width: 100%; border-collapse: collapse; }
  .pag-table thead tr { background: #8b5cf6; color: #fff; }
  .pag-table thead th { padding: 7px 10px; text-align: left; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }
  .pag-table tbody tr { border-bottom: 1px solid #ede9fe; }
  .pag-table tbody tr:last-child { border-bottom: none; }
  .pag-table tbody tr:nth-child(even) { background: #faf8ff; }
  .pag-table tbody td { padding: 7px 10px; font-size: 11px; }
  .badge-pago { background: #d1fae5; color: #065f46; border-radius: 3px; padding: 2px 7px; font-size: 9px; font-weight: bold; }
  .badge-pendente { background: #fef3c7; color: #92400e; border-radius: 3px; padding: 2px 7px; font-size: 9px; font-weight: bold; }
  .badge-cancelado { background: #fee2e2; color: #991b1b; border-radius: 3px; padding: 2px 7px; font-size: 9px; font-weight: bold; }

  .footer { margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; }
  .footer p { font-size: 8px; color: #bbb; }
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
        <div class="doc-title">Extrato de Plano</div>
        <div class="doc-date">Emitido em {{ now()->format('d/m/Y H:i') }}</div>
      </div>
    </div>
  </div>

  {{-- ALUNO + PLANO --}}
  <div class="two-col">
    <div class="col">
      <div class="info-card">
        <div class="info-label">Aluno</div>
        <div class="info-value">{{ $plano->aluno->name ?? '—' }}</div>
        <div class="info-value-sm">{{ $plano->aluno->email ?? '' }}</div>
        @if($plano->aluno->numero_telefone ?? false)
        <div class="info-value-sm">{{ $plano->aluno->numero_telefone }}</div>
        @endif
      </div>
    </div>
    <div class="col">
      <div class="info-card">
        <div class="info-label">Plano</div>
        <div class="info-value">{{ $plano->tipo }}</div>
        <div class="info-value-sm">
          {{ $plano->data_inicio?->format('d/m/Y') ?? '—' }} até {{ $plano->data_fim?->format('d/m/Y') ?? '—' }}
          &bull; {{ $plano->duracao_meses }} mês(es)
        </div>
        <div class="info-value-sm" style="margin-top:4px;font-size:12px;font-weight:bold;color:#8b5cf6">
          R$ {{ number_format($plano->valor, 2, ',', '.') }}
        </div>
      </div>
    </div>
  </div>

  {{-- PAYMENT SUMMARY --}}
  @php
    $pago     = $plano->pagamentos->where('status','pago')->sum(fn($p) => 0);
    $pagos    = $plano->pagamentos->where('status','pago');
    $pendentes = $plano->pagamentos->where('status','pendente');
    $cancelados = $plano->pagamentos->where('status','cancelado');
  @endphp

  <div class="section-title">Resumo de Pagamentos</div>
  <div class="summary-grid">
    <div class="summary-cell pago" style="margin-right:6px">
      <div class="summary-label pago">Pago</div>
      <div class="summary-value pago">{{ $pagos->count() }}</div>
      <div style="font-size:9px;color:#059669">parcela(s)</div>
    </div>
    <div class="summary-cell pendente" style="margin:0 3px">
      <div class="summary-label pendente">Pendente</div>
      <div class="summary-value pendente">{{ $pendentes->count() }}</div>
      <div style="font-size:9px;color:#d97706">parcela(s)</div>
    </div>
    <div class="summary-cell cancelado" style="margin-left:6px">
      <div class="summary-label cancelado">Cancelado</div>
      <div class="summary-value cancelado">{{ $cancelados->count() }}</div>
      <div style="font-size:9px;color:#dc2626">parcela(s)</div>
    </div>
  </div>

  {{-- PAYMENT HISTORY --}}
  <div class="section-title">Histórico de Pagamentos</div>
  @if($plano->pagamentos->isNotEmpty())
  <table class="pag-table">
    <thead>
      <tr>
        <th>Data</th>
        <th>Método</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($plano->pagamentos->sortByDesc('data') as $pag)
      <tr>
        <td>{{ $pag->data?->format('d/m/Y') ?? '—' }}</td>
        <td>{{ $pag->tipo }}</td>
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
  <p style="font-size:10px;color:#aaa;padding:10px 0">Nenhum pagamento registrado neste plano.</p>
  @endif

  <div class="footer">
    <p>COLISEU GYM &bull; Extrato gerado automaticamente &bull; {{ now()->format('d/m/Y') }}</p>
  </div>

</div>
</body>
</html>
