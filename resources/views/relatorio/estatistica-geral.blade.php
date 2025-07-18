@extends('layouts.app')

@section('title')
    Relatório de Estatística Geral
@endsection

@section('content')

<div class="container-fluid">
    <h4 class="card-title" style="font-size:20px; text-align: left; color: gray; font-family: calibri">
        RELATÓRIO DE ESTATÍSTICA GERAL
    </h4>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('rel.ger') }}">
        <div class="row mb-3">
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
                <a href="{{ url()->current() }}" class="btn btn-warning">Limpar</a>
            </div>
        </div>
    </form>

        <hr />

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
                </tbody>
            </table>
        </div>

        <!-- Coluna para a Tabela 2: -->
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
                        <td>{{  number_format($totalAssociados, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Isentos</td>
                        <td>{{  number_format($qtdeIsentos['Sim'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Parciais</td>
                        <td>{{  number_format($qtdeIsentos['Parcial'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Não Isentos</td>
                        <td>{{  number_format($qtdeIsentos['Não'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Coluna para a Tabela 3 -->
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
                        <td>{{  number_format($contribuicaoVsIdeal['zero'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Abaixo do Ideal</td>
                        <td>{{  number_format($contribuicaoVsIdeal['abaixo'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Igual ao Ideal</td>
                        <td>{{  number_format($contribuicaoVsIdeal['igual'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Acima do Ideal</td>
                        <td>{{  number_format($contribuicaoVsIdeal['acima'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div> <!-- Fim do ROW que contém as TRES tabelas -->
</div> <!-- Fim do totalGeralContainer (que fecha com o X) -->

@endsection