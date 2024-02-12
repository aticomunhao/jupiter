@extends('layouts.app')

<title>Editar Afastamento</title>

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <fieldset class="border rounded border-primary ">
                    <div class="card">
                        <div class="card-header">
                            <DIV class="ROW">
                                <div class="col-12">
                                    <span style="color: rgb(16, 19, 241); font-size:15px;">Editar Afastamento</span>
                                </div>
                            </DIV>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/atualizar-afastamento/{{ $afastamentos->id }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5">
                                        <div class="card" style="padding: 0px">
                                            <div class="card-body bg-body-secondary" value="{{ $funcionario->id }}">
                                                <span
                                                    style="color: rgb(16, 19, 241)">{{ $funcionario->nome_completo }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="form-group col-3">Motivo do Afastamento
                                        <select class="form-select" name="tipo_afastamento" required="required">
                                            <option value="{{ $afastamentos->id_tp_afastamento }}">{{ $afastamentos->nome }}

                                            </option>
                                            @foreach ($tipoafastamentos as $tipoafastamentos)
                                                <option value="{{ $tipoafastamentos->id }}">{{ $tipoafastamentos->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-2">Data de Inicio
                                        <input class="form-control" type="date" value="{{ $afastamentos->dt_inicio }}"
                                            id="iddt_inicio" name="dt_inicio" required="required">
                                    </div>
                                    <div class="form-group col-2">Data de Retorno
                                        <input class="form-control" type="date" value="{{ $afastamentos->dt_fim }}"
                                            id="iddt_fim" name="dt_fim" required="required">
                                    </div>
                                    <div class="form-group col-2">Arquivo Anexado
                                        <p>
                                            <a href="{{ asset("storage/$afastamentos->caminho") }}"><button type="button"
                                                    class="btn btn-lg btn-outline-secondary"><i
                                                        class="bi bi-archive"></i></button>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="form-group col-3">Novo Arquivo
                                        <input type="file" class="form-control form-control-sm" name="ficheiroNovo"
                                            id="idficheiro">
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled"
                                            name="justificado"> Justificado?
                                    </div>

                                </div>
                                <br>
                                <div class="row mb-2">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                                        <input class="form-control" type="text" maxlength="40"
                                            id="2"class="form-control " id="idobservacao" rows="1"
                                            name="observacao" value="{{ $afastamentos->observacao }}">

                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="d-grid gap-1 col-2 mx-auto">
                                        <a class="btn btn-danger btn-sm"
                                            href="/gerenciar-afastamentos/{{ $funcionario->id }}"
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
    </div>
@endsection
