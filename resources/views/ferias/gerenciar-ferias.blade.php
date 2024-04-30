@extends('layouts.app')
@section('head')
    <title>Período de Férias</title>
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Período de Férias
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="row justify-content-around">
                            <div class="col-sm-12 col-md-4">
                                <p class="fs-4 fw-bolder">Pesquisar Periodo de Férias</p>
                                <form action="{{ route('IndexGerenciarFerias') }}" method="get">
                                    <select class="form-select" aria-label="Ano" name="search">
                                        @foreach ($anos_possiveis as $ano_possivel)
                                            <option value="{{ $ano_possivel->ano_de_referencia }}">
                                                {{ $ano_possivel->ano_de_referencia +1}}
                                                -{{ $ano_possivel->ano_de_referencia +2}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <button type="submit" class="btn btn-light mt-5 mt-md-0"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-top:5px; width: 100%">
                                        Pesquisar
                                    </button>
                                </form>


                            </div>

                            <div class="col-sm-12 col-md-4">
                                <form action="{{ route('enviar-ferias') }}" method="get">
                                    @csrf
                                    <p class="fs-4 fw-bolder">Periodo de Férias A Ser Enviado</p>
                                    <select class="form-select" aria-label="Ano" name="search">
                                        @foreach ($anos_possiveis as $ano_possivel)
                                            <option value="{{ $ano_possivel->ano_de_referencia }}">
                                                {{ $ano_possivel->ano_de_referencia +1}}
                                                - {{ $ano_possivel->ano_de_referencia +2}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <button type="submit" class="btn btn-success col-md-3 col-12 mt-5 mt-md-0"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px; width:100%">
                                        Enviar Ferias
                                    </button>


                            </div>
                        </div>

                    </div>
                    <br>
                    <hr>
                    <br>

                    <br>
                    @if (!empty($periodo_aquisitivo))
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <table
                                        class="table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                        style="margin-top:10px;">
                                    <thead style="text-align: center;">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th scope="col">Selecionar Para Envio</th>
                                        <th scope="col">Nome do Funcionário</th>
                                        <th scope="col">Periodo de Ferias</th>
                                        <th scope="col">Início 1</th>
                                        <th scope="col">Fim 1</th>
                                        <th scope="col">Início 2</th>
                                        <th scope="col">Fim 2</th>
                                        <th scope="col">Início 3</th>
                                        <th scope="col">Fim 3</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Motivo</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($periodo_aquisitivo as $periodos_aquisitivos)
                                        <tr>

                                            <td style="text-align: center">
                                                @if($periodos_aquisitivos->id_status_pedido_ferias == 3
                                                    or $periodos_aquisitivos->id_status_pedido_ferias == 5
                                                or $periodos_aquisitivos->id_status_pedido_ferias == 1)
                                                    <input class="form-check-input checkbox-trigger" type="checkbox"
                                                           id="flexCheckDefault" name="checkbox[]"
                                                           value="{{$periodos_aquisitivos->id_ferias}}">
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</td>
                                            <td style="text-align: center">
                                                {{$periodos_aquisitivos->ano_de_referencia + 1}}
                                                -{{$periodos_aquisitivos->ano_de_referencia + 2}}
                                            </td>

                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_ini_a ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_ini_a)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_fim_a ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_fim_a)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_ini_b ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_ini_b)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_fim_b ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_fim_b)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_ini_c ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_ini_c)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->dt_fim_c ? \Carbon\Carbon::parse($periodos_aquisitivos->dt_fim_c)->format('d/m/y') : '--' }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->status_pedido_ferias }}
                                            </td>
                                            <td style="text-align: center">{{ $periodos_aquisitivos->motivo_retorno }}
                                            </td>

                                            <td>
                                                @if ($periodos_aquisitivos->id_status_pedido_ferias != 4 or $periodos_aquisitivos->id_status_pedido_ferias == 6)
                                                    <a href="{{ route('CriarFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                       class="btn btn-outline-success">
                                                        <i class="bi bi-pencil-square"></i>

                                                    </a>
                                                @endif
                                                <a href="{{ route('HistoricoRecusaFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                   class="btn btn-outline-secondary">

                                                    <i class="bi bi-search"></i>

                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
