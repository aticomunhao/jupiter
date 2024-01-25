@extends('layouts.app')
@section('head')
    <title>Editar Certificado</title>
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <br />
    <div class="container"> {{-- Container completo da página  --}}
        <div class="card" style="border-color: #5C7CB6;">
            <div class="card-header">
                Editar Certificado
            </div>
            <div class="card-body">
                <div class="row"> {{-- Linha com o nome e botão novo --}}
                    <div class="col-md-6 col-12">
                        <fieldset {{-- Gera a barra ao redor do nome do funcionario --}}
                            style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 7px; padding-left: 10px; background-color: #ebebeb;">
                            {{ $funcionario[0]->nome_completo }}</fieldset>
                    </div>
                </div>
                <hr />
                <form action="/atualizar-certificado/{{ $certificado->id }}">

                    @csrf
                                    
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
                </fieldset>
            </div>
        </div>
    </div>
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--
                            <script>
                                $(document).ready(function() {
                                            $('#idbanco').change(function() {
                                                    var banco = $(this).val();

                                                    $.ajax({
                                                            url: '/recebe-agencias/' + banco,
                                                            type: 'get',
                                                            success: function(data) {
                                                                $('#idagencia').removeAttr('disabled');
                                                                $('#idagencia').empty();;
                                                                $.each(data, function(index, agencia) {
                                                                    $('#idsetor').append('<option value="' + item.id + '">' +
                                                                        item.nome + '</option>');
                                                                });
                                                                {


                                                                },
                                                                error: function(xhr, status, error) {
                                                                    alert('Error occurred while fetching agencies');
                                                                }
                                                            });
                                                    });
                                            });
                            </script>
                        -->

    <script>
        $(document).ready(function() {
            $('#idbanco').change(function(e) {
                var idbanco = $(this).val();
                e.preventDefault();
                $('#idagencia').removeAttr('disabled');

                $.ajax({
                    type: "GET",
                    url: "/recebe-agencias/" + idbanco,
                    dataType: "json",
                    success: function(response) {
                        $('#idagencia').empty();
                        $.each(response, function(index, item) {
                            $('#idagencia').append("<option value =" + item.id + "> " +
                                item.agencia + " - " + item.desc_agen + "</option>");

                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
