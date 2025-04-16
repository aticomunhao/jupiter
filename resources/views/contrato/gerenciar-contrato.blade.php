@extends('layouts.app')
@section('head')
    <title>Gerenciar Contratos</title>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="row">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Contratos
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                    id="iddt_inicio" name="dt_inicio" required="required" disabled>
                            </div>
                            <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0">
                                <a href="/incluir-contrato/{{ $funcionario->id }}" class="col-6">
                                    <button type="button" class="btn btn-success col-md-8 col-12"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000;">Novo+</button>
                                </a>
                            </div>
                        </div>
                        <br />
                        <hr />
                        <div class="table-responsive">
                            <div class="table">
                                @php
                                    $temPrevisaoFim = collect($contrato)->contains('tp_contrato', 5);
                                @endphp
                                <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr class="align-middle"
                                            style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-2">Tipo de Contrato</th>
                                            <th class="col-2">Admissão</th>
                                            <th class="col-1">Matrícula</th>
                                            <th class="col-2">Demissão</th>
                                            @if ($temPrevisaoFim)
                                                <th class="col-2">Previsão de Fim</th>
                                            @endif
                                            <th class="col-3">Motivo Desligamento</th>
                                            <th class="col-2">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($contrato as $contratos)
                                            <tr>
                                                <td>{{ $contratos->nome }}</td>
                                                <td style="text-align: center">
                                                    {{ \Carbon\Carbon::parse($contratos->dt_inicio)->format('d/m/Y') }}
                                                </td>
                                                <tr style="text-align: center">{{ $contratos->matricula }}</tr>
                                                <tr style="text-align: center">
                                                    {{ $contratos->dt_fim ? \Carbon\Carbon::parse($contratos->dt_fim)->format('d/m/Y') : 'Em vigor' }}
                                                </tr>
                                                @if ($temPrevisaoFim)
                                                    <tr style="text-align: center">
                                                        @if ($contratos->tp_contrato == 5)
                                                            {{ $contratos->data_fim_prevista ? \Carbon\Carbon::parse($contratos->data_fim_prevista)->format('d/m/Y') : '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </tr>
                                                @endif
                                                <td style="text-align: center">{{ $contratos->motivo }}</td>
                                                <td style="text-align: center">
                                                    <a href="" class="btn  btn-outline-secondary" data-tt="tooltip"
                                                        data-placement="top" title="Visualizar">
                                                        <i class="bi bi-archive" style="font-size: 1rem; color:#303030"></i>
                                                    </a>
                                                    <a href="/editar-contrato/{{ $contratos->id }}"
                                                        class="btn btn-outline-warning" data-tt="tooltip"
                                                        data-placement="top" title="Editar">
                                                        <i class="bi bi-pencil" style="font-size: 1rem; color:#303030"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#A{{ $contratos->id }}" data-tt="tooltip"
                                                        data-placement="top" title="Excluir">
                                                        <i class="bi bi-trash" style="font-size: 1rem; color:#303030"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-placement="top" title="Finalizar contrato"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#situacao{{ $contratos->id }}">
                                                        <i class="bi bi-exclamation-circle"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>

                                                    <!-- Modal Inativar -->
                                                    <div class="modal fade" id="situacao{{ $contratos->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form class="form-horizontal" method="post"
                                                                action="{{ url('/inativar-contrato/' . $contratos->id) }}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="background-color:#DC4C64">
                                                                        <h5 class="modal-title" id="exampleModalLabel"
                                                                            style="color:rgb(255, 255, 255)">Confirmar
                                                                            Inativação</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body" style="text-align: center;">
                                                                        <label for="mi" class="form-label">Motivo da
                                                                            Inativação:</label>
                                                                        <select class="form-select" name="motivo_inativar"
                                                                            required id="mi">
                                                                            <option value=""></option>
                                                                            @foreach ($situacao as $situacaos)
                                                                                <option value="{{ $situacaos->id }}">
                                                                                    {{ $situacaos->motivo }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="dtf" class="form-label mt-2">Data
                                                                            de
                                                                            Inativação:</label>
                                                                        <input class="form-control" type="date"
                                                                            id="dtf" name="dt_fim_inativacao"
                                                                            required>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Confirmar</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Excluir -->
                                                    <div class="modal fade" id="A{{ $contratos->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color:rgba(202, 61, 61, 0.911);">
                                                                    <h2 style="color:white;">Excluir Contrato</h2>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="color:#e24444;">
                                                                    <p class="fw-bold alert  text-center">
                                                                        Você realmente deseja excluir<br>
                                                                        <span class="fw-bolder fs-5">
                                                                            {{ $contratos->nome }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <a href="/excluir-contrato/{{ $contratos->id }}">
                                                                        <button type="button"
                                                                            class="btn btn-danger">Excluir
                                                                            permanentemente</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                </script>

                <br>
                <div class="row d-flex justify-content-around">
                    <div class="col-4">
                        <a href="{{ route('gerenciar') }}">
                            <button class="btn btn-danger" style="width: 100%">Retornar</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
