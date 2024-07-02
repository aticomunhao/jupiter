@php use Carbon\Carbon; @endphp
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
                            <div class="col-md-3 col-sm-12">
                                <h5>Nome do Funcionário</h5>
                                <input type="text" name="nomefuncionario" id="idnomefuncionario" class="form-control">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <h5>Selecione o Período Aquisitivo</h5>
                                <select class="form-select" aria-label="Ano" name="anoconsulta" id="idanoconsulta">
                                    <option value=""> </option>
                                    @foreach ($anos_possiveis as $ano_possivel)
                                        <option value="{{ $ano_possivel->ano_de_referencia }}">
                                            {{ $ano_possivel->ano_de_referencia + 1 }}
                                            -{{ $ano_possivel->ano_de_referencia + 2 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <br>
                    <hr>
                    <br>
                    @if (!empty($periodo_aquisitivo))
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <form action="{{ route('enviar-ferias') }}" method="post">
                                    <table
                                        class="table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                        style="margin-top:10px;">
                                        <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th scope="col">Selecionar Para Envio</th>
                                            <th scope="col">Nome do Funcionário</th>
                                            <th scope="col">Periodo de Férias</th>
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
                                        <tbody id="idtable">
                                        @foreach ($periodo_aquisitivo as $periodos_aquisitivos)
                                            <tr>
                                                <td style="text-align: center">
                                                    @if (
                                                        $periodos_aquisitivos->id_status_pedido_ferias == 3 or
                                                            $periodos_aquisitivos->id_status_pedido_ferias == 5 or
                                                            $periodos_aquisitivos->id_status_pedido_ferias == 1)
                                                        <input class="form-check-input checkbox-trigger" type="checkbox"
                                                               id="flexCheckDefault" name="checkbox[]"
                                                               value="{{ $periodos_aquisitivos->id_ferias }}">
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->ano_de_referencia + 1 }}
                                                    - {{ $periodos_aquisitivos->ano_de_referencia + 2 }}
                                                </td>

                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_a ? Carbon::parse($periodos_aquisitivos->dt_ini_a)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_a ? Carbon::parse($periodos_aquisitivos->dt_fim_a)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_b ? Carbon::parse($periodos_aquisitivos->dt_ini_b)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_b ? Carbon::parse($periodos_aquisitivos->dt_fim_b)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_c ? Carbon::parse($periodos_aquisitivos->dt_ini_c)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_c ? Carbon::parse($periodos_aquisitivos->dt_fim_c)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->status_pedido_ferias }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->motivo_retorno }}
                                                </td>

                                                <td>
                                                    @if (
                                                        $periodos_aquisitivos->id_status_pedido_ferias == 1 or
                                                            $periodos_aquisitivos->id_status_pedido_ferias == 3 or
                                                            $periodos_aquisitivos->id_status_pedido_ferias == 5)
                                                        <a href="{{ route('CriarFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                           class="btn btn-outline-success">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('HistoricoRecusaFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                       class="btn btn-outline-secondary" data-tt="tooltip"
                                                       data-placement="top" title="Histórico Férias"
                                                       style="font-size: 1rem; color:#0e0b16;">

                                                        <i class="bi bi-search"></i>

                                                    </a>
                                                    @if ($periodos_aquisitivos->id_status_pedido_ferias == 6)
                                                        <!-- Button trigger modal -->

                                                        <button type="button" class="btn btn-outline-primary"
                                                                style="font-size: 1rem; color:#0e0b16;"
                                                                data-tt="tooltip"
                                                                data-placement="top" title="Reabrir Formulário"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal{{ $periodos_aquisitivos->id_ferias }}">
                                                            <i class="bi bi-folder2-open"></i>
                                                        </button>
                                                        <div class="modal fade"
                                                             id="exampleModal{{ $periodos_aquisitivos->id_ferias }}"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                         style="background-color: rgb(88, 149, 242)">
                                                                        <h2 class="modal-title" id="exampleModalLabel"
                                                                            style="color: #ffffff">
                                                                            Reabrir
                                                                            Formulário</h2>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">

                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Deseja Reabrir as férias do
                                                                        funcionario:
                                                                        <br>
                                                                        <span
                                                                            style="font-size: 20px; color: rgb(48, 121, 231)">
                                                                        {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}
                                                                        </span>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer"
                                                                         style="background-color: #ffffff">
                                                                        <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Cancelar
                                                                        </button>
                                                                        <a
                                                                            href="{{ route('ReabrirFormulario', ['id' => $periodos_aquisitivos->id_ferias]) }}">
                                                                            <button type="button"
                                                                                    class="btn btn-primary">
                                                                                Confirmar
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
                        </div>
                    @endif
                    <div class="row d-flex justify-content-center">
                        @csrf
                        <br>
                        <div class="col-sm-12 col-md-4">
                            <button type="submit" class="btn btn-success col-md-3 col-12 mt-5 mt-md-0"
                                    style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px; width:100%">
                                Enviar Férias
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

@endsection
