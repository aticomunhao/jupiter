@extends('layouts.app')

@section('title')
    Relatório de Estatística por Grupo
@endsection

@section('content')
<div class="container-fluid">
    <h4 class="card-title" style="font-size:20px; text-align: left; color: gray; font-family: calibri">
        RELATÓRIO DE ESTATÍSTICA POR GRUPO
    </h4>

    {{-- Filtros --}}
    <form method="GET">
        <div class="row justify-content-md-start mb-3">
            <div class="col-md-3">
                <label for="setor" class="form-label">Setor</label>
                <select class="form-select select2" name="setor" id="setor">
                    <option value="">Todos</option>
                    @foreach ($setores as $set)
                        <option value="{{ $set->sid }}" {{ request('setor') == $set->sid ? 'selected' : '' }}>
                            {{ $set->sigla }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="reuniao" class="form-label">Grupo (Reunião)</label>
                <select class="form-select select2" name="reuniao" id="reuniao">
                    <option value="">Todos</option>
                    @foreach ($reunioes as $gr)
                        <option value="{{ $gr->cid }}" {{ request('reuniao') == $gr->cid ? 'selected' : '' }}>
                            {{ $gr->g_nome }} - {{ $gr->s_sigla }} | {{ $gr->d_sigla }} | {{ $gr->h_inicio }}
                        </option>
                    @endforeach
                </select>
            </div>
             <div class="col-md-2">
                <label for="anoFiltro" class="form-label">Ano</label>
                    <select class="form-select" name="anoFiltro" id="anoFiltro">
                        @php
                            // Obtém o ano atual
                            $currentYear = date('Y');

                            // Obtém o valor de 'anoFiltro' da requisição.
                            // Se não estiver presente, será null. Usamos null/'' para "Todos".
                            $selectedAnoFiltro = request('anoFiltro');

                            // Determina qual ano deve ser pré-selecionado no loop para os anos numéricos.
                            // Se $selectedAnoFiltro for um número, usa ele. Caso contrário (se for null, '', ou string não numérica),
                            // usa o ano atual como padrão para a seleção *dos anos específicos*.
                            $preselectedYearForNumericOptions = is_numeric($selectedAnoFiltro) ? (int)$selectedAnoFiltro : $currentYear;
                        @endphp

                        {{-- Opção "Todos" --}}
                        {{-- Esta opção deve ser selecionada se 'anoFiltro' não estiver na requisição (null) ou for uma string vazia '' --}}
                        <option value="" @if ($selectedAnoFiltro === '' || $selectedAnoFiltro === null) selected @endif>Todos</option>

                        {{-- Loop para gerar as opções de ano --}}
                        {{-- Você pode ajustar o range de anos (ex: $currentYear - 10 até $currentYear + 2) --}}
                        @for ($year = $currentYear - 5; $year <= $currentYear + 2; $year++)
                            <option value="{{ $year }}" @if ($year == $preselectedYearForNumericOptions) selected @endif>{{ $year }}</option>
                        @endfor
                    </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Pesquisar</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

        <hr />

        <!-- O container principal que será fechado pelo botão X -->
<div id="totalGeralContainer" style="position: relative; border: 1px solid #ccc; padding: 15px;">
    <button
        onclick="document.getElementById('totalGeralContainer').style.display = 'none';"
        style="position: absolute; top: 5px; right: 5px; border: none; background: transparent; font-weight: bold; font-size: 20px; cursor: pointer;"
        aria-label="Fechar Container de Tabelas"
        title="Fechar Container de Tabelas"
    >&times;
    </button>

    <!-- Este é o ROW que conterá as TRÊS tabelas lado a lado -->
    <div class="row mb-4">

        <!-- Coluna para a Tabela 1: SOMA GERAL (já está no formato) -->
        <div class="col-md-4">
            <h5 class="text-muted">Total Geral</h5>
            <table class="table table-bordered table-sm text-center" style="width: 100%;">
                <thead class="table-info">
                    <tr>
                        <th>TIPO</th>
                        <th>VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Arrecadado</td>
                        <td>R$ {{ number_format($totalGeralArrecadado, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Ideal</td>
                        <td>R$ {{ number_format($totalGeralIdeal, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Previsto</td>
                        <td>R$ {{ number_format($totalGeralPrevisto, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>% Ideal</td>
                        <td>{{ $percentualGeralIdeal !== null ? $percentualGeralIdeal.'%' : '—' }}</td>
                    </tr>
                    <tr>
                        <td>% Previsto</td>
                        <td>{{ $percentualGeralPrevisto !== null ? $percentualGeralPrevisto.'%' : '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Coluna para a Tabela 2: Resumo de Isentos (agora com TIPO e QUANTIDADE) -->
        <div class="col-md-4">
            <h5 class="text-muted">Resumo de Isentos</h5>
            <table class="table table-bordered table-sm text-center">
                <thead class="table-info">
                    <tr>
                        <th>TIPO</th>
                        <th>QUANTIDADE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total de Associados</td>
                        <td>{{ $totalAssociados }}</td>
                    </tr>
                    <tr>
                        <td>Isentos</td>
                        <td>{{ $qtdeIsentos['Sim'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Parciais</td>
                        <td>{{ $qtdeIsentos['Parcial'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Não Isentos</td>
                        <td>{{ $qtdeIsentos['Não'] ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Coluna para a Tabela 3: Faixa de Contribuição (agora com TIPO e QUANTIDADE) -->
        <div class="col-md-4">
            <h5 class="text-muted">Faixa de Contribuição</h5>
            <table class="table table-bordered table-sm text-center">
                <thead class="table-info">
                    <tr>
                        <th>TIPO</th>
                        <th>QUANTIDADE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Valor Zero</td>
                        <td>{{ $contribuicaoVsIdeal['zero'] }}</td>
                    </tr>
                    <tr>
                        <td>Abaixo do Ideal</td>
                        <td>{{ $contribuicaoVsIdeal['abaixo'] }}</td>
                    </tr>
                    <tr>
                        <td>Igual ao Ideal</td>
                        <td>{{ $contribuicaoVsIdeal['igual'] }}</td>
                    </tr>
                    <tr>
                        <td>Acima do Ideal</td>
                        <td>{{ $contribuicaoVsIdeal['acima'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div> <!-- Fim do ROW que contém as TRES tabelas -->
</div> <!-- Fim do totalGeralContainer (que fecha com o X) -->

        {{-- Conteúdo --}}
        @forelse($paginatedResult as $setorData)
        <h4 class="text-primary">Ano: {{ $setorData['ano'] }}</h4>
        <h5 class="text-success ms-3">Setor: {{ $setorData['setor'] }}</h5>

        <div class="accordion mb-3" id="{{ $setorData['container_id'] }}">
            @foreach($setorData['reunions'] as $reuniaoData)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $reuniaoData['key'] }}">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $reuniaoData['key'] }}"
                            aria-expanded="false"
                            aria-controls="collapse{{ $reuniaoData['key'] }}">
                            Reunião: {{ $reuniaoData['display_name'] }}
                        </button>
                    </h2>

                    <div id="collapse{{ $reuniaoData['key'] }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $reuniaoData['key'] }}"
                        data-bs-parent="#{{ $setorData['container_id'] }}">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <div class="mt-3 text-center">
                                        <button class="btn btn-outline-primary btn-sm"
                                                id="btn_grafico_{{ $reuniaoData['key'] }}"
                                                onclick="toggleGrafico('{{ $reuniaoData['key'] }}')">
                                            Ver Gráfico
                                        </button>
                                    </div>
                                    <div class="grafico-container text-center mt-2"
                                        id="container_grafico_{{ $reuniaoData['key'] }}"
                                        style="display: none;">
                                        <canvas id="grafico_{{ $reuniaoData['key'] }}"
                                                height="200"
                                            style="width: 600px; margin: auto;"></canvas>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="text-align:center;">Nr sócio</th>
                                            @foreach(['01'=>'Jan','02'=>'Fev','03'=>'Mar','04'=>'Abr','05'=>'Mai','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Set','10'=>'Out','11'=>'Nov','12'=>'Dez'] as $num => $nome)
                                                <th style="text-align:center;">{{ $nome }}</th>
                                            @endforeach
                                            <th style="text-align:center;">Total</th>
                                            <th style="text-align:center;">Isento</th>
                                            <th style="text-align:center;">Ideal</th>
                                            <th style="text-align:center;">Previsto</th>
                                            <th style="text-align:center;">Atrasos</th>
                                            <th style="text-align:center;">% Ideal</th>
                                            <th style="text-align:center;">% Prev.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reuniaoData['members'] as $trab)
                                            <tr>
                                                <td style="text-align:right;">{{ $trab['codigo_associado'] }}</td>
                                                @php
                                                    $resumo = $trab['resumo_ano'];
                                                @endphp
                                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $mes)
                                                    @php
                                                        $valor = $trab['contribuicoes'][$setorData['ano']][$mes] ?? 0;
                                                    @endphp
                                                    <td style="text-align:right; {{ $valor == 0 ? 'background-color: #FFFF61;' : '' }}">
                                                        {{ number_format($valor, 2, ',', '.') }}
                                                    </td>
                                                @endforeach
                                                <td style="text-align:right; font-weight:bold;">
                                                    {{ number_format($resumo['total_arrecadado'], 2, ',', '.') }}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $trab['isento'] }}
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format($valorIdealParcial, 2, ',', '.') }}
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format($resumo['valor_previsto'], 2, ',', '.') }}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $resumo['meses_atrasados'] }}
                                                </td>
                                                <td class="{{ $resumo['percentual_ideal'] < 100 ? 'text-danger' : 'text-success' }}" style="text-align:center;font-weight:bold;">
                                                    {{ $resumo['percentual_ideal'] }}%
                                                </td>
                                                <td class="{{ $resumo['percentual_previsto'] < 100 ? 'text-danger' : 'text-success' }}" style="text-align:center; font-weight:bold;">
                                                    {{ $resumo['percentual_previsto'] }}%
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="21" class="text-center">Nenhum membro com contribuições registradas.</td>
                                            </tr>
                                        @endforelse
                                        <!--AQUI É A ÚLTIMA LINHA COM A SOMA GERAL-->
                                        @php
                                            $grupoTotalArrecadado = 0;
                                            $grupoTotalIdeal = 0;
                                            $grupoTotalPrevisto = 0;
                                            $grupoTotalAtrasos = 0;
                                            $grupoQtdMembros = count($reuniaoData['members']);
                                        @endphp

                                        @foreach($reuniaoData['members'] as $trab)
                                            @php
                                                $resumo = $trab['resumo_ano'];
                                                $grupoTotalArrecadado += $resumo['total_arrecadado'];
                                                $grupoTotalIdeal += $resumo['valor_ideal'];
                                                $grupoTotalPrevisto += $resumo['valor_previsto'] ?? 0;
                                                $grupoTotalAtrasos += $resumo['meses_atrasados'];
                                            @endphp
                                        @endforeach

                                        @if($grupoQtdMembros > 0)
                                            <tr style="background-color: #e9ecef; font-weight: bold;">
                                                <td style="text-align:right;">Totais:</td>
                                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $mes)
                                                    @php
                                                        $somaMes = 0;
                                                        foreach($reuniaoData['members'] as $trab) {
                                                            $somaMes += $trab['contribuicoes'][$setorData['ano']][$mes] ?? 0;
                                                        }
                                                    @endphp
                                                    <td style="text-align:right;">{{ number_format($somaMes, 2, ',', '.') }}</td>
                                                @endforeach
                                                <td style="text-align:right;">{{ number_format($grupoTotalArrecadado, 2, ',', '.') }}</td>
                                                <td style="text-align:center;">—</td>
                                                <td style="text-align:right;">{{ number_format($grupoTotalIdeal, 2, ',', '.') }}</td>
                                                <td style="text-align:right;">{{ number_format($grupoTotalPrevisto, 2, ',', '.') }}</td>
                                                <td style="text-align:center;">{{ $grupoTotalAtrasos }}</td>
                                                <td style="text-align:center;">
                                                    {{ $grupoTotalIdeal > 0 ? round(($grupoTotalArrecadado / $grupoTotalIdeal) * 100, 1) . '%' : '—' }}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $grupoTotalPrevisto > 0 ? round(($grupoTotalArrecadado / $grupoTotalPrevisto) * 100, 1) . '%' : '—' }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center">Nenhum dado encontrado para os filtros selecionados.</p>
    @endforelse
    
        <div style="margin-right:10px; margin-left:10px;">
            {{ $paginatedResult->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

</div>

<script>
    const chartsCriados = {};

    function toggleGrafico(key) {
        const container = document.getElementById('container_grafico_' + key);
        const btn = document.getElementById('btn_grafico_' + key);

        if (!container || !btn) return;

        // Alternar visibilidade
        const visivel = container.style.display === 'block';

        if (visivel) {
            container.style.display = 'none';
            btn.textContent = 'Ver Gráfico';
            return;
        }

        container.style.display = 'block';
        btn.textContent = 'Ocultar Gráfico';

        if (chartsCriados[key]) return;

        const ctx = document.getElementById('grafico_' + key)?.getContext('2d');
        if (!ctx) return;

        @foreach($paginatedResult as $setorData)
            @foreach($setorData['reunions'] as $reuniaoData)
                if (key === '{{ $reuniaoData['key'] }}') {
                    @php
                        $arrecadado = 0;
                        $previsto = 0;
                        $ideal = 0;

                        foreach($reuniaoData['members'] as $membro) {
                            $resumo = $membro['resumo_ano'];
                            $arrecadado += $resumo['total_arrecadado'];
                            $previsto += $resumo['valor_previsto'] ?? 0;
                            $ideal += $resumo['valor_ideal'] ?? 0;
                        }

                        $percentPrev = $arrecadado > 0 ? ($previsto / $arrecadado) * 100 : 0;
                        $percentIdeal = $arrecadado > 0 ? ($ideal / $arrecadado) * 100 : 0;

                        $colorPrev = $percentPrev < 80
                            ? 'rgba(255, 69, 58, 0.9)'       // vermelho
                            : ($percentPrev < 100
                                ? 'rgba(255, 193, 7, 0.9)'    // amarelo
                                : 'rgba(40, 167, 69, 0.9)');  // verde

                        $colorIdeal = $percentIdeal < 80
                            ? 'rgba(255, 69, 58, 0.9)'
                            : ($percentIdeal < 100
                                ? 'rgba(255, 193, 7, 0.9)'
                                : 'rgba(40, 167, 69, 0.9)');
                    @endphp

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Arrecadado', 'Previsto', 'Ideal'],
                            datasets: [{
                                label: 'R$',
                                data: [
                                    {{ round($arrecadado, 2) }},
                                    {{ round($previsto, 2) }},
                                    {{ round($ideal, 2) }}
                                ],
                                backgroundColor: [
                                    'rgba(0, 123, 255, 0.9)', // azul forte
                                    '{{ $colorPrev }}',
                                    '{{ $colorIdeal }}'
                                ],
                                borderColor: [
                                    'rgba(0, 123, 255, 1)',
                                    '{{ str_replace("0.9", "1", $colorPrev) }}',
                                    '{{ str_replace("0.9", "1", $colorIdeal) }}'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: ctx => {
                                            const valor = ctx.raw;
                                            return ctx.label + ': R$ ' + parseFloat(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: val => 'R$ ' + val.toLocaleString('pt-BR')
                                    }
                                }
                            }
                        }
                    });

                    chartsCriados[key] = true;
                }
            @endforeach
        @endforeach
    }
</script>




@endsection
