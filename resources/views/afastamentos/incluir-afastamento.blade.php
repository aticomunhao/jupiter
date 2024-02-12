@extends('layouts.app')

<title>Novo Afastamento</title>

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card">
                    <div class="card-header">
                        <DIV class="ROW">
                            <div class="col-12">
                                <span style="color: rgb(16, 19, 241); font-size:15px;">Novo Afastamento</span>
                            </div>
                        </DIV>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/armazenar-afastamentos/{{ $funcionario->funcionario_id }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-5">
                                    <div class="card" style="padding: 0px">
                                        <div class="card-body bg-body-secondary" value="{{ $funcionario->funcionario_id }}">
                                            <span style="color: rgb(16, 19, 241)">{{ $funcionario->nome_completo }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="form-group col-3 mb-2">Motivo do Afastamento
                                    <select class="form-select" name="tipo_afastamento" required="required" value="">
                                        @foreach ($tipoafastamento as $tiposafastamentos)
                                            <option value="{{ $tiposafastamentos->id }}">{{ $tiposafastamentos->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-2">Data de Início
                                    <input class="form-control" type="date" value="" id="iddt_inicio"
                                        name="dt_inicio" required="required">
                                </div>
                                <div class="form-group col-2">Data de Retorno
                                    <input class="form-control" type="date" value="" id="iddt_fim" name="dt_fim"
                                        required="required">
                                </div>
                                <div class="form-group col-4">Arquivo de Anexo
                                    <input type="file" class="form-control form-control-sm" name ="ficheiro"
                                        id="idficheiro" required="required">
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" name="justificado"> Justificado?
                            </div>

                            <div class="row">
                                <div class="mb-5">
                                    <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                                    <textarea class="form-control " id="idobservacao" rows="3" name="observacao"></textarea>
                                </div>
                                <div class="row">
                                    <div class="d-grid gap-1 col-2 mx-auto">
                                        <a class="btn btn-danger btn-sm"
                                            href="/gerenciar-afastamentos/{{ $funcionario->funcionario_id }}"
                                            role="button">Cancelar</a>
                                    </div>
                                    <div class="d-grid gap-2 col-2 mx-auto">
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            id="sucesso">Confirmar</button>
                                    </div>
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
@endsection
