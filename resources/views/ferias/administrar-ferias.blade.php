@extends('layouts.app')

@section('content')
    <br>

    <div class="container-fluid">
        <div class="card" style="border-color: #355089">
            <h5 class="card-header" style="color: #355089">Gerenciar Férias</h5>
            <div class="card-body">
                <hr>

                <div class="row justify-content-around">
                    <div class="col-md-3">

                        <form action="{{route('AdministrarFerias')}}" method="get">
                            <select class="form-select" aria-label="Ano" name="search">

                                @foreach($anos_possiveis as $ano_possivel)
                                    <option
                                        value="{{ $ano_possivel->ano_de_referencia }}">{{$ano_possivel->ano_de_referencia}}</option>
                                @endforeach
                            </select>
                    </div>


                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-success" style="width: 100%">Enviar</button>
                </div>
                </form>
            </div>
            <hr>
            <div class="row justify-content-around">
                <div class="col-md-3">
                    <input class="form-control" type="text" value="{{ \Carbon\Carbon::now()->year - 1 }}"
                           aria-label="Disabled input example" disabled readonly
                           style="text-align: center; color: #355089; font-size: 16px; font-weight: bold;
                        border: 2px solid #355089; border-radius: 5px; background-color: #f8f9fa;">
                </div>
                <div class="col-md-3">

                </div>
            </div>
            <br>
            @if (!empty($periodo_aquisitivo))
                <div class="table-responsive">
                    <table
                        class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;">
                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                            <th scope="col">Nome do Funcionário</th>
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
                                    {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</td>

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
                                <td style="text-align: center">{{ $periodos_aquisitivos->status_pedido_ferias }}
                                </td>
                                <td style="text-align: center">{{ $periodos_aquisitivos->motivo_retorno }}</td>

                                <td style="text-align: center">

                                    @if ($periodos_aquisitivos->id_status_pedido_ferias == 3)
                                        <a
                                            href="{{ route('autorizarFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}">
                                            <button class="btn btn-outline-success"><i class="bi bi-check2"></i>
                                            </button>
                                        </a>
                                        <a
                                            href="{{ route('FormularioFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}">
                                            <button class="btn btn-outline-danger"><i class="bi bi-x"></i>
                                            </button>
                                        </a>
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
@endsection
