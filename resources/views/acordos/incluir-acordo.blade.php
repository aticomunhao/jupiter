@extends('layouts.app')
@section('head')
    <title>Novo Acordo</title>
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Novo Acordo
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/armazenar-acordos/{{ $funcionario->id }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5">
                                        <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                            id="iddt_inicio" name="dt_inicio" required="required" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mt-2">
                                    <div class="form-group col-md-6 col-lg-3 mt-lg-0 mt-md-0 mt-2">Tipo de Acordo
                                        <select class="form-select" name="tipo_acordo" required="required">
                                            @foreach ($tipoacordo as $tiposacordos)
                                                <option value="{{ $tiposacordos->id }}">{{ $tiposacordos->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-2">Data de Início
                                        <input class="form-control" type="date" value="" id="iddt_inicio"
                                            name="dt_inicio" required="required">
                                    </div>
                                    <div class="form-group col-2">Data de Fim
                                        <input class="form-control" type="date" value="" id="iddt_fim"
                                            name="dt_fim">
                                    </div>
                                    <div class="form-group col-4">Arquivo de Anexo
                                        <input type="file" class="form-control form-control-sm mb-2" name="ficheiro"
                                            id="idficheiro" required="required">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="mb-3 mt-md-0 mt-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                                        <textarea class="form-control " id="idobservacao" rows="1" name="observacao" style="height:100px"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-danger col-md-3 col-2 mt-4 offset-md-1"
                                        href="/gerenciar-acordos/{{ $funcionario->id }}" role="button">
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
    </div>
@endsection
