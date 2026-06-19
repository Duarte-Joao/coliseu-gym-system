<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; background: #fff; }

  .page { padding: 28px 32px; }

  /* Header */
  .header { border-bottom: 3px solid #8b5cf6; padding-bottom: 14px; margin-bottom: 20px; }
  .header-top { display: table; width: 100%; }
  .header-left { display: table-cell; vertical-align: middle; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; }
  .logo { font-size: 22px; font-weight: bold; color: #8b5cf6; letter-spacing: 2px; }
  .logo-sub { font-size: 7px; letter-spacing: 3px; color: #999; text-transform: uppercase; margin-top: 2px; }
  .doc-title { font-size: 14px; font-weight: bold; color: #333; text-transform: uppercase; letter-spacing: 1px; }
  .doc-date { font-size: 9px; color: #888; margin-top: 3px; }

  /* Info box */
  .info-box { background: #f8f6ff; border: 1px solid #e0d7ff; border-left: 4px solid #8b5cf6; border-radius: 4px; padding: 12px 16px; margin-bottom: 20px; }
  .info-grid { display: table; width: 100%; }
  .info-col { display: table-cell; width: 33.33%; vertical-align: top; }
  .info-label { font-size: 8px; text-transform: uppercase; letter-spacing: 1.5px; color: #8b5cf6; font-weight: bold; margin-bottom: 3px; }
  .info-value { font-size: 12px; font-weight: bold; color: #222; }
  .info-value-sm { font-size: 10px; color: #555; }

  /* Section title */
  .section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #8b5cf6; font-weight: bold; margin-bottom: 8px; margin-top: 18px; border-bottom: 1px solid #e0d7ff; padding-bottom: 5px; }

  /* Exercise table */
  .ex-table { width: 100%; border-collapse: collapse; }
  .ex-table thead tr { background: #8b5cf6; color: #fff; }
  .ex-table thead th { padding: 7px 10px; text-align: left; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }
  .ex-table tbody tr { border-bottom: 1px solid #ede9fe; }
  .ex-table tbody tr:last-child { border-bottom: none; }
  .ex-table tbody tr:nth-child(even) { background: #faf8ff; }
  .ex-table tbody td { padding: 8px 10px; font-size: 11px; }
  .num-col { color: #9ca3af; font-size: 10px; }
  .carga { font-weight: bold; color: #c9a227; }
  .series { color: #6d28d9; font-weight: bold; }

  /* Notes */
  .notes-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 4px; padding: 10px 14px; margin-top: 8px; }
  .notes-box p { font-size: 10px; color: #555; line-height: 1.5; }

  /* Progress table */
  .prog-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  .prog-table tr { border-bottom: 1px solid #ede9fe; }
  .prog-table td { padding: 6px 8px; font-size: 11px; }
  .prog-empty { padding: 6px 4px; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #bbb; }

  /* Footer */
  .footer { margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; }
  .footer p { font-size: 8px; color: #bbb; letter-spacing: 0.5px; }
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
        <div class="doc-title">Ficha de Treino</div>
        <div class="doc-date">Emitida em {{ now()->format('d/m/Y H:i') }}</div>
      </div>
    </div>
  </div>

  {{-- INFO --}}
  <div class="info-box">
    <div class="info-grid">
      <div class="info-col">
        <div class="info-label">Ficha</div>
        <div class="info-value">{{ $treino->nome }}</div>
      </div>
      <div class="info-col">
        <div class="info-label">Instrutor</div>
        <div class="info-value">{{ $treino->instrutor->usuario->name ?? '—' }}</div>
        <div class="info-value-sm">{{ $treino->instrutor->especialidade ?? '' }}</div>
      </div>
      <div class="info-col">
        <div class="info-label">Exercícios</div>
        <div class="info-value">{{ count($treino->exercicios ?? []) }}</div>
        <div class="info-value-sm">nesta ficha</div>
      </div>
    </div>
    @if($treino->descricao)
    <div style="margin-top:10px; border-top:1px solid #e0d7ff; padding-top:8px;">
      <div class="info-label">Descrição</div>
      <div style="font-size:10px;color:#555;margin-top:3px;">{{ $treino->descricao }}</div>
    </div>
    @endif
  </div>

  {{-- EXERCISE TABLE --}}
  <div class="section-title">Exercícios</div>
  @if(!empty($treino->exercicios))
  <table class="ex-table">
    <thead>
      <tr>
        <th style="width:30px">#</th>
        <th>Exercício</th>
        <th style="width:70px">Séries</th>
        <th style="width:70px">Repetições</th>
        <th style="width:70px">Carga</th>
        @if(collect($treino->exercicios)->contains(fn($e) => !empty($e['descanso'])))
        <th style="width:70px">Descanso</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($treino->exercicios as $k => $ex)
      <tr>
        <td class="num-col">{{ $k + 1 }}</td>
        <td><strong>{{ $ex['nome'] }}</strong></td>
        <td class="series">{{ $ex['series'] }}x</td>
        <td>{{ $ex['repeticoes'] }}</td>
        <td class="carga">{{ $ex['carga'] }} kg</td>
        @if(collect($treino->exercicios)->contains(fn($e) => !empty($e['descanso'])))
        <td style="color:#888">{{ $ex['descanso'] ?? '—' }}</td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="font-size:10px;color:#aaa;padding:12px 0;">Nenhum exercício cadastrado nesta ficha.</p>
  @endif

  {{-- ALUNOS QUE USAM ESTA FICHA --}}
  @if(isset($treino->treinoAlunos) && $treino->treinoAlunos->isNotEmpty())
  <div class="section-title">Alunos com esta Ficha</div>
  <table class="prog-table">
    @foreach($treino->treinoAlunos as $ta)
    <tr>
      <td style="width:50%"><strong>{{ $ta->aluno->name ?? '—' }}</strong></td>
      <td style="color:#888;font-size:10px">Validade: {{ $ta->validade?->format('d/m/Y') ?? '—' }}</td>
      <td style="font-size:10px;color:#aaa">{{ $ta->descricao ?? '' }}</td>
    </tr>
    @endforeach
  </table>
  @endif

  {{-- FOOTER --}}
  <div class="footer">
    <p>COLISEU GYM &bull; Ficha gerada automaticamente pelo sistema &bull; {{ now()->format('d/m/Y') }}</p>
  </div>

</div>
</body>
</html>
