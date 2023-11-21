@extends('layouts.app')

<title>Incluir Dependentes</title>

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
                                    <span style="color: rgb(16, 19, 241); font-size:15px;">Novo Acordo</span>
                                </div>
                            </DIV>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/armazenar-acordos/{{ $funcionario[0]->id }}">
                                @csrf
                                <div class="row">
                                    <div class="col-5">
                                        <div class="card" style="padding: 0px">
                                            <div class="card-body bg-body-secondary" value="{{ $funcionario[0]->id }}">
                                                <span
                                                    style="color: rgb(16, 19, 241)">{{ $funcionario[0]->nome_completo }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-2">Tipo de Acordo
                                        <select class="form-select" id="4" name="tipo_acordo" required="required">
                                            @foreach ($tipoacordo as $tiposacordos)
                                                <option value="{{ $tiposacordos->id }}">{{ $tiposacordos->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--<div class="col-5">Nome completo
                                            <input class="form-control" type="text" maxlength="40" id="2"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                name="nomecomp_dep" value="" required="required">
                                        </div>-->
                                    <div class="col-3">Data de Inicio
                                        <input class="form-control" type="date" value="" id="3"
                                            name="dt_inicio" required="required">
                                    </div>
                                    <div class="col-3">Data de Fim
                                        <input class="form-control" type="date" value="" id="3"
                                            name="dtnasc_dep">
                                    </div>
                                    <div class="col-3">Arquivo
                                        <input class="form-control form-control-sm" type="file" id="formFileSm">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="d-grid gap-1 col-2 mx-auto">
                                        <a class="btn btn-danger btn-sm" href="/gerenciar-acordos/{{ $funcionario[0]->id }}"
                                            role="button">Cancelar</a>
                                    </div>
                                    <div class="d-grid gap-2 col-2 mx-auto">
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            id="sucesso">Confirmar</button>
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
