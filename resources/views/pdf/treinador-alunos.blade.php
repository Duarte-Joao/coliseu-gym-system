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

  .stats-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 8px; margin: -8px 0 16px; }
  .stat-cell { display: table-cell; }
  .stat-box { border-radius: 4px; padding: 12px 14px; text-align: center; }
  .stat-box.total  { background: #f3f0ff; border: 1px solid #ddd6fe; }
  .stat-box.fichas { background: #ecfdf5; border: 1px solid #a7f3d0; }
  .stat-label { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 5px; }
  .stat-label.total  { color: #6d28d9; }
  .stat-label.fichas { color: #059669; }
  .stat-value { font-size: 18px; font-weight: bold; }
  .stat-value.total  { color: #6d28d9; }
  .stat-value.fichas { color: #059669; }

  .section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #8b5cf6; font-weight: bold; margin-bottom: 8px; margin-top: 16px; border-bottom: 1px solid #e0d7ff; padding-bottom: 5px; }

  .aluno-block { margin-bottom: 18px; page-break-inside: avoid; }
  .aluno-header { background: #f3f0ff; border: 1px solid #ddd6fe; border-radius: 4px 4px 0 0; padding: 8px 12px; display: table; width: 100%; }
  .aluno-header-left { display: table-cell; vertical-align: middle; }
  .aluno-header-right { display: table-cell; vertical-align: middle; text-align: right; }
  .aluno-name { font-size: 12px; font-weight: bold; color: #4c1d95; }
  .aluno-contact { font-size: 9px; color: #7c3aed; margin-top: 2px; }
  .badge-fichas { background: #8b5cf6; color: #fff; border-radius: 3px; padding: 2px 8px; font-size: 8px; font-weight: bold; }

  .fichas-table { width: 100%; border-collapse: collapse; border: 1px solid #e0d7ff; border-top: none; border-radius: 0 0 4px 4px; overflow: hidden; }
  .fichas-table thead tr { background: #ede9fe; }
  .fichas-table thead th { padding: 5px 10px; text-align: left; font-size: 8px; letter-spacing: 1px; text-transform: uppercase; color: #6d28d9; border-bottom: 1px solid #ddd6fe; }
  .fichas-table tbody tr { border-bottom: 1px solid #ede9fe; }
  .fichas-table tbody tr:last-child { border-bottom: none; }
  .fichas-table tbody tr:nth-child(even) { background: #faf8ff; }
  .fichas-table tbody td { padding: 5px 10px; font-size: 10px; }

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
        <div class="doc-title">Relatório de Alunos</div>
        <div class="doc-date">Instrutor: {{ $instrutorNome }} &bull; Emitido em {{ now()->format('d/m/Y H:i') }}</div>
      </div>
    </div>
  </div>

  @if($busca)
  <div class="filter-info">
    <strong>Filtro aplicado:</strong> Aluno contendo "{{ $busca }}"
  </div>
  @endif

  {{-- STATS --}}
  @php
    $totalFichas = $alunos->sum(fn($item) => $item['fichas']->count());
  @endphp
  <div class="stats-grid">
    <div class="stat-cell">
      <div class="stat-box total">
        <div class="stat-label total">Total de Alunos</div>
        <div class="stat-value total">{{ $alunos->count() }}</div>
      </div>
    </div>
    <div class="stat-cell">
      <div class="stat-box fichas">
        <div class="stat-label fichas">Total de Fichas</div>
        <div class="stat-value fichas">{{ $totalFichas }}</div>
      </div>
    </div>
  </div>

  {{-- ALUNOS --}}
  <div class="section-title">Detalhamento por Aluno</div>

  @forelse($alunos as $item)
  @php $usuario = $item['usuario']; $fichas = $item['fichas']; @endphp
  <div class="aluno-block">
    <div class="aluno-header">
      <div class="aluno-header-left">
        <div class="aluno-name">{{ $usuario->name }}</div>
        <div class="aluno-contact">{{ $usuario->email }}@if($usuario->numero_telefone) &bull; {{ $usuario->numero_telefone }}@endif</div>
      </div>
      <div class="aluno-header-right">
        <span class="badge-fichas">{{ $fichas->count() }} ficha(s)</span>
      </div>
    </div>
    <table class="fichas-table">
      <thead>
        <tr>
          <th>Ficha / Treino</th>
          <th>Exercícios</th>
          <th>Validade</th>
          <th>Descrição</th>
        </tr>
      </thead>
      <tbody>
        @foreach($fichas as $f)
        @php $ta = $f['ta']; $treino = $f['treino']; @endphp
        <tr>
          <td><strong>{{ $treino->nome }}</strong></td>
          <td>{{ count($treino->exercicios ?? []) }} exercício(s)</td>
          <td>{{ $ta->validade?->format('d/m/Y') ?? '—' }}</td>
          <td style="color:#666;font-size:9px">{{ $ta->descricao ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @empty
  <p style="font-size:10px;color:#aaa;padding:12px 0;">Nenhum aluno encontrado.</p>
  @endforelse

  <div class="footer">
    <div class="footer-left">COLISEU GYM &bull; Relatório gerado automaticamente</div>
    <div class="footer-right">{{ $alunos->count() }} aluno(s) &bull; {{ now()->format('d/m/Y') }}</div>
  </div>

</div>
</body>
</html>
