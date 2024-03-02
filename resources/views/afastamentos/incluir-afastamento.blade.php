@extends('layouts.app')
@section('head')
    <title>Novo Afastamento</title>
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Novo Afastamento
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/armazenar-afastamentos/{{ $funcionario->funcionario_id }}"
                            enctype="multipart/form-data">
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
                                <div class="form-group col-3 mb-3">Motivo do Afastamento
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" name="tipo_afastamento" required="required" value="">
                                        @foreach ($tipoafastamento as $tiposafastamentos)
                                            <option value="{{ $tiposafastamentos->id }}">{{ $tiposafastamentos->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-2">Data de Início
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" type="date" value="" id="iddt_inicio"
                                        name="dt_inicio" required="required">
                                </div>
                                <div class="form-group col-2">Data de Retorno
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" type="date" value="" id="iddt_fim" name="dt_fim"
                                        required="required">
                                </div>
                                <div class="form-group col-4">Arquivo de Anexo
                                    <input type="file" style="border: 1px solid #999999; padding: 5px;" class="form-control form-control-sm" name ="ficheiro"
                                        id="idficheiro">
                                </div>
                            </div>

                            <div class="form-check mb-2">
                                <input type="checkbox" style="border: 1px solid #999999; padding: 5px;" class="form-check-input" data-toggle="toggle" data-on="Enabled"
                                    data-off="Disabled" name="justificado" id="justificado"> Justificado?

                            </div>

                            <div class="row">
                                <div class="mb-3 mt-md-0 mt-3">
                                    <label for="exampleFormControlTextarea1"  class="form-label">Observação</label>
                                    <textarea class="form-control" style="border: 1px solid #999999; padding: 5px;" id="idobservacao" rows="3" name="observacao"></textarea>
                                </div>
                            </div>
                            <div>
                                <a class="btn btn-danger col-md-3 col-2 mt-4 offset-md-1"
                                    href="/gerenciar-afastamentos/{{ $funcionario->funcionario_id }}" role="button">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-3"
                                    id="sucesso">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
