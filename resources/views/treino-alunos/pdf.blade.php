<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Plano Semanal</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1, h2, p { margin: 0 0 0.5rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Plano de Treino Semanal</h1>
    <p><strong>Aluno:</strong> {{ $atribuicao->aluno->name }}</p>
    <p><strong>Treino:</strong> {{ $atribuicao->treino->nome }}</p>
    <p><strong>Instrutor:</strong> {{ $atribuicao->treino->instrutor->usuario->name ?? '—' }}</p>
    <p><strong>Período:</strong>
        {{ $atribuicao->data_inicio->format('d/m/Y') }}
        @if($atribuicao->data_fim)
            até {{ $atribuicao->data_fim->format('d/m/Y') }}
        @endif
    </p>
    <p><strong>Observações:</strong> {{ $atribuicao->descricao ?? $atribuicao->treino->obs ?? 'Nenhuma' }}</p>

    <h2>Exercícios</h2>
    <table>
        <thead>
            <tr>
                <th>Exercício</th>
                <th>Descrição / Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($atribuicao->treino->exercicios as $exercicio)
                <tr>
                    <td>{{ $exercicio['nome'] ?? 'Exercício' }}</td>
                    <td>
                        @if(is_array($exercicio))
                            {{ join(' · ', array_filter([
                                $exercicio['series'] ?? null,
                                $exercicio['repeticoes'] ?? null,
                                $exercicio['carga'] ?? null,
                                $exercicio['obs'] ?? null,
                            ])) }}
                        @else
                            {{ $exercicio }}
                        @endif
                    </td>
                </tr>
                @if(!empty($exercicio['imagem']))
                    @php
                        $imagePath = public_path('storage/'.$exercicio['imagem']);
                        $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : null;
                        $imageExt = pathinfo($imagePath, PATHINFO_EXTENSION);
                    @endphp
                    @if($imageData)
                        <tr>
                            <td colspan="2" style="padding:0.25rem;">
                                <img src="data:image/{{ $imageExt }};base64,{{ $imageData }}" alt="Imagem do exercício" style="max-width:100%; max-height:200px; display:block; margin-top:0.5rem;">
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>