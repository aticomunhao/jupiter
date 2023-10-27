@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="container">
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <fieldset class="border rounded border-primary ">
                        <div class="card">
                            <div class="card-header">
                                <DIV class="ROW">
                                    <div class="col-12">
                                        <span style="color: rgb(16, 19, 241); font-size:15px;">Editar Certificado</span>
                                    </div>
                                </DIV>
                            </div>
                            <div class="card-body">
                                <form method="post" action="/atualizar-certificado/{{ $certificado->id }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="card" style="padding: 0px">
                                                <div class="card-body bg-body-secondary" value="">
                                                    <span
                                                        style="color: rgb(16, 19, 241)">{{ $funcionario[0]->nome_completo }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-2">Grau Acadêmico
                                            <select class="form-select" id="4" name="grau_academico"
                                                required="required" value="{{ $certificado->id_grau_acad}}">

                                                @foreach ($graus_academicos as $grau_academico)
                                                    <option value="{{ $grau_academico->id }}">
                                                        {{ $grau_academico->nome_grauacad }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-7">Nome do Certificado
                                            <input class="form-control" type="text" maxlength="40" name="nome_curso"    value="{{ $certificado->nome }}"
                                             required="required">
                                        </div>
                                        <div class="col-3">Data de Conclusão
                                            <input class="form-control" type="date" value="{{ $certificado->dt_conclusao }}" id="3"
                                                name="dtconc_cert" required="required">
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group row">
                                            <div class="col-4">
                                                Nivel de Ensino
                                                <select class="form-select" id="4" name="nivel_ensino"
                                                    required="required" value="{{ $certificado->id_nivel_ensino }}">

                                                    @foreach ($tp_niveis_ensino as $nivel_ensino)
                                                        <option value="{{ $nivel_ensino->id }}">
                                                            {{ $nivel_ensino->nome_tpne }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-4">Etapa de Ensino
                                                <select class="form-select" id="4" name="etapa_ensino"
                                                    required="required" value>

                                                    @foreach ($tp_etapas_ensino as $etapas_ensino)
                                                        <option value="{{ $etapas_ensino->id }}">
                                                            {{ $etapas_ensino->nome_tpee }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">Entidade de Ensino
                                                <select class="form-select" id="4" name="entidade_ensino"
                                                    required="required"  value="{{$certificado->id_entidade_ensino}}" >

                                                    @foreach ($tp_entidades_ensino as $entidade_ensino)
                                                        <option value="{{ $entidade_ensino->id }}">
                                                            {{ $entidade_ensino->nome_tpentensino }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="d-grid gap-1 col-2 mx-auto">
                                            <a class="btn btn-danger btn-sm" href="/gerenciar-certificados/{{ $funcionario[0]->id }}"
                                                role="button">Cancelar</a>
                                        </div>
                                        <div class="d-grid gap-2 col-2 mx-auto">
                                            <button type="submit" class="btn btn-warning btn-sm"
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
