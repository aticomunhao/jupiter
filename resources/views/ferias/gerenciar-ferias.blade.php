@extends('layouts.app')
@section('head')
    <title>Periodo de Férias</title>
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
                                Periodo de Férias
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <form action="{{ route('IndexGerenciarFerias') }}" method="get">
                            <div class="row justify-content-around">
                                <div class="col-md-4 col-sm-12">
                                    <select class="form-select" aria-label="Ano" name="search">
                                        @foreach ($anos_possiveis as $ano_possivel)
                                            <option value="{{ $ano_possivel->ano_de_referencia }}">
                                                {{ $ano_possivel->ano_de_referencia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8 col-12">
                                    <button type="submit" class="btn btn-light col-md-3 col-12 mt-5 mt-md-0"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;">
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="row justify-content-around">
                        <div class="col-md-3">
                            <input class="form-control" type="text" value="{{ \Carbon\Carbon::now()->year - 1 }}"
                                aria-label="Disabled input example" disabled readonly
                                style="text-align: center; color: #355089; font-size: 16px; font-weight: bold;
                        border: 2px solid #355089; border-radius: 5px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('AbreFerias') }}">
                                <button class="btn btn-success" style="width: 100%; box-shadow: 1px 2px 5px #000000">
                                    Criar Ferias
                                </button>
                            </a>
                        </div>
                    </div>
                    <br>
                    @if (!empty($periodo_aquisitivo))
                        <div class="table-responsive">
                            <table
                                class="table table-sm table-striped table-bordered border-secondary table-hover align-middle" style="margin-top:10px;">
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
                                            <td style="text-align: center">
                                                {{ $periodos_aquisitivos->status_pedido_ferias }}
                                            </td>
                                            <td style="text-align: center">{{ $periodos_aquisitivos->motivo_retorno }}
                                            </td>
                                            <td>
                                                @if ($periodos_aquisitivos->id_status_pedido_ferias == 1)
                                                    <a
                                                        href="{{ route('CriarFerias', ['id' => $periodos_aquisitivos->id_funcionario]) }}">
                                                        <button class="btn btn-outline-success"><i
                                                                class="bi bi-plus-circle"></i>
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
    </div>
    </div>
@endsection
