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
                <input type="text" class="form-control" name="anoFiltro" id="anoFiltro"
                    value="{{ request('anoFiltro', date('Y')) }}" placeholder="Ex: 2025">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Pesquisar</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

        <hr />

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
@endsection
