<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Contribuições</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .setor-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            background: #f0f0f0;
            padding: 6px;
        }
        .reuniao-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: left;
        }
        th {
            background: #e0e0e0;
        }
    </style>
</head>
<body>

    <h2>Relatório de Contribuições - Ano {{ $anoFiltro }}</h2>

    @foreach ($paginatedResult as $year => $setores)
        <h3>Ano: {{ $year }}</h3>

        @foreach ($setores as $siglaSetor => $setorData)
            <div class="setor-title">Setor: {{ $siglaSetor }}</div>

            @foreach ($setorData['reunions'] as $reuniao)
                <div class="reuniao-title">{{ $reuniao['display_name'] }}</div>

                <table>
                    <thead>
                        <tr>
                            <th>Associado</th>
                            <th>Função</th>
                            @foreach ($reuniao['members'][0]['contribuicoes'][$year] as $mes => $valor)
                                <th>{{ $mes }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reuniao['members'] as $membro)
                            <tr>
                                <td>{{ $membro['nome_completo'] }}</td>
                                <td>{{ $membro['membro_funcao'] }}</td>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($membro['contribuicoes'][$year] as $valor)
                                    <td>R$ {{ number_format($valor, 2, ',', '.') }}</td>
                                    @php $total += $valor; @endphp
                                @endforeach
                                <td><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endforeach
    @endforeach

</body>
</html>