@extends('layouts.app')
@section('head')
    <title>Gerenciar Férias</title>
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
                                Gerenciar Férias
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="row justify-content-around">
                            <div class="col-md-4 col-sm-12">
                                <p class="fs-4 fw-bolder">Pesquisar Periodo de Férias</p>
                                <form action="{{ route('AdministrarFerias') }}" method="get">
                                    <select class="form-select" aria-label="Ano" name="search">
                                        @foreach ($anos_possiveis as $ano_possivel)
                                            <option value="{{ $ano_possivel->ano_de_referencia }}">
                                                {{ $ano_possivel->ano_de_referencia+1 }}
                                                -{{ $ano_possivel->ano_de_referencia+2 }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-light col-md-3 col-12 mt-5 "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; width: 100%">
                                        Pesquisar
                                    </button>
                            </div>
                            <div class="col-md-8 col-12">
                                <br>

                            </div>
                            </form>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row justify-content-around">
                            <div class="col-md-3">
                                <form action="{{ route('AbreFerias') }}">
                                    @csrf
                                    <label for="ano" style=";">Período de Férias</label>
                                    <select class="form-select custom-select" aria-label="Ano" name="ano_referencia"
                                            id="ano" style="color: #355089">
                                        @foreach ($listaAnos as $ano)
                                            <option value="{{ $ano }}"
                                            >{{ $ano+1 }}
                                                - {{ $ano+2 }}</option>
                                        @endforeach
                                    </select>

                            </div>


                            <div class="col-md-3">
                                <a href="{{ route('AbreFerias') }}">
                                    <button type="submit" class="btn btn-success"
                                            style="width: 100%; box-shadow: 1px 2px 5px #000000;">Gerar Novo Período
                                    </button>
                                </a>
                            </div>
                            </form>

                        </div>
                        <br>
                        @if (!empty($periodo_aquisitivo))
                            <div class="table-responsive">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                    style="margin-top:10px;">
                                    <thead style="text-align: center;">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th scope="col">Nome do Funcionário</th>
                                        <th scope="col">Setor</th>
                                        <th scope="col">Periodo de Férias</th>
                                        <th scope="col">Início 1</th>
                                        <th scope="col">Fim 1</th>
                                        <th scope="col">Início 2</th>
                                        <th scope="col">Fim 2</th>
                                        <th scope="col">Início 3</th>
                                        <th scope="col">Fim 3</th>
                                        <th scope="col">Status</th>

                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($periodo_aquisitivo as $periodos_aquisitivos)
                                        <tr>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</td>
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->sigla_do_setor ?? 'N/A' }}</td>
                                            <td style="text-align: center">
                                                {{$periodos_aquisitivos->ano_de_referencia + 1}}
                                                - {{$periodos_aquisitivos->ano_de_referencia + 2}}
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


                                            <td style="text-align: center">

                                                @if ($periodos_aquisitivos->id_status_pedido_ferias == 4)
                                                    <a
                                                        href="{{ route('autorizarFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}">
                                                        <button class="btn btn-outline-success"
                                                                style="font-size: 1rem; color:#0e0b16;"
                                                                data-tt="tooltip"
                                                                data-placement="top" title="Autorizar Férias"><i
                                                                class="bi bi-check2"></i>
                                                        </button>
                                                    </a>
                                                    <a
                                                        href="{{ route('FormularioFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}">
                                                        <button class="btn btn-outline-danger"
                                                                style="font-size: 1rem; color:#0e0b16;"
                                                                data-tt="tooltip"
                                                                data-placement="top" title="Recusar Férias"><i
                                                                class="bi bi-x"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="#"
                                                       class="disabled" aria-disabled="true">
                                                        <button class="btn btn-outline-secondary" disabled
                                                                aria-label="Close">
                                                            <i class="bi bi-check2"></i>
                                                        </button>
                                                    </a>

                                                    <a href="#"
                                                       class="disabled" aria-disabled="true">
                                                        <button class="btn btn-outline-secondary" disabled
                                                                aria-label="Close"><i class="bi bi-x"></i>
                                                        </button>
                                                    </a>
                                                @endif

                                                <a href="{{route('HistoricoRecusaFerias', ['id' => $periodos_aquisitivos->id_ferias])}}"
                                                   class="disabled" aria-disabled="true">
                                                    <button class="btn btn-outline-secondary"
                                                            aria-label="Close" style="font-size: 1rem; color:#0e0b16;"
                                                            data-tt="tooltip"
                                                            data-placement="top" title="Histórico">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                </a>

                                                @if($periodos_aquisitivos->id_status_pedido_ferias == 6)
                                                    <!-- Button trigger modal -->

                                                    <button type="button" class="btn btn-outline-primary"
                                                            style="font-size: 1rem; color:#0e0b16;" data-tt="tooltip"
                                                            data-placement="top" title="Reabrir Formulário"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{$periodos_aquisitivos->id_ferias}}">
                                                        <i class="bi bi-folder2-open"></i>
                                                    </button>
                                                    <div class="modal fade"
                                                         id="exampleModal{{$periodos_aquisitivos->id_ferias}}"
                                                         tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="exampleModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Reabrir
                                                                        Formulário</h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close">

                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Deseja Reabrir as ferias do
                                                                    funcionario {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Fechar
                                                                    </button>
                                                                    <a href="{{route('ReabrirFormulario' , ['id' => $periodos_aquisitivos->id_ferias])}}">
                                                                        <button type="button" class="btn btn-primary">
                                                                            Reabrir Formulario
                                                                        </button>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
