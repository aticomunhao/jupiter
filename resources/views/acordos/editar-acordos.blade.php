@extends('layouts.app')
@section('head')
    <title>Editar Acordos</title>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Editar Acordo
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/atualizar-acordo/{{ $acordo->id }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-5">
                                    <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                        id="iddt_inicio" name="dt_inicio" required="required" disabled>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="form-group row">
                                <div class="form-group col-2">Tipo de Acordo
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" name="tipo_acordo" required="required"
                                        value="{{ $acordo->id_tp_acordo }}">
                                        @foreach ($tipoacordo as $tiposacordos)
                                            <option value="{{ $tiposacordos->id }}">{{ $tiposacordos->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-2">Data de Inicio
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" type="date" value="{{ $acordo->data_inicio }}"
                                        id="iddt_inicio" name="dt_inicio" required="required">
                                </div>
                                <div class="form-group col-2">Data de Fim
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" type="date" value="{{ $acordo->data_fim }}"
                                        id="iddt_fim" name="dt_fim">
                                </div>
                                <div class="form-group col-2" style="text-align: center">Arquivo atual
                                    <p>
                                        <a href="{{ asset("$acordo->caminho") }}"><button type="button"
                                                class="btn btn-lg btn-outline-secondary"><i
                                                    class="bi bi-archive"></i></button>
                                        </a>
                                    </p>
                                </div>
                                <div class="form-group col-3">Novo Arquivo
                                    <input type="file" style="border: 1px solid #999999; padding: 5px;" class="form-control form-control-sm" name="ficheiroNovo"
                                        id="idficheiro">
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" type="text" maxlength="40"
                                        id="2"class="form-control " id="idobservacao" rows="1"
                                        name="observacao" value="{{ $acordo->observacao }}">

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="d-grid gap-1 col-2 mx-auto">
                                    <a class="btn btn-danger btn-sm" href="/gerenciar-acordos/{{ $funcionario->id }}"
                                        role="button">Cancelar</a>
                                </div>
                                <div class="d-grid gap-2 col-2 mx-auto">
                                    <button type="submit" class="btn btn-primary btn-sm" id="sucesso">Confirmar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
