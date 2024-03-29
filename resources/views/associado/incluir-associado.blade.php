@extends('layouts.app')

@section('content')
<br>
<div class="container">
<legend style="color:rgb(16, 19, 241); font-size:15px;">Criar Associado</legend>
    <div class="border border-primary" style="border-radius: 5px;">
        <div class="card">
            <div class="card-header">
                Dados Pessoais
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method='POST' action="/incluir-associado">
                    @csrf

                    <div class="container-fluid">
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4 col-sm-12">
                                <label for="1">Nome Completo</label>
                                <input type="text" class="form-control" name="nome_completo" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <label for="2">CPF</label>
                                <input type="text" class="form-control" name="cpf" maxlength="11" >
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <label for="2">Identidade</label>
                                <input type="text" class="form-control" name="idt" maxlength="9" >
                            </div>
                            <div class="row d-flex justify-content-around">
                            <div class="col-md-1 col-sm-12">
                                <label for="3">DDD</label>
                                <select class="form-select" name="ddd" id="3" value="">
                                    <option></option>
                                    @foreach ($ddd as $ddds)
                                    <option value="{{ $ddds->id }}">{{ $ddds->descricao }}</option>
                                    @endforeach
                                </select>

                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="2">Telefone</label>
                                <input type="text" class="form-control" id="2"  maxlength="12" name="telefone" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="2">Email</label>
                                    <input type="text" class="form-control" id="2"  maxlength="50"name="email" value="">
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="4">Data de Inicio</label>
                                    <input type="date" class="form-control" name="dt_inicio" id="4">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <br>

    <div class="border border-primary" style="border-radius: 5px;">

        <div class="card">
            <div class="card-header">
                Dados Residenciais
            </div>
            <div class="row d-flex justify-content-around">
                <div class="form-group col-xl-2 col-md-4 mt-3 ">
                    <label for="1">CEP</label>
                    <input type="text" class="form-control" id="1" name="cep" value="">
                </div>
                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                    <label for="id_uf">UF</label>
                    <select class="js-example-responsive form-select" id="iduf" name="uf_end">
                        <option value=""></option>
                        @foreach ($tp_uf as $tp_ufs)
                        <option @if (old('uf_end')==$tp_ufs->id) {{ 'selected="selected"' }} @endif
                            value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xl-2 col-md-4 mt-3 ">
                    <label for="ciadade">Cidade</label>
                    <select class="js-example-responsive form-select" id="idcidade" name="cidade" value="{{ old('cidade') }}" disabled>
                    </select>
                </div>
                <div class="form-group col-xl-3 col-md-4 mt-3 ">
                    <label for="1">Logradouro</label>
                    <input type="text" class="form-control" id="1" name="logradouro" value="">
                </div>
                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                    <label for="1">Número</label>
                    <input type="text" class="form-control" id="1" name="numero" value="">
                </div>
                <div class="row d-flex justify-content-around">
                    <div class="form-group col-xl-3 col-md-4 mt-3 ">
                        <label for="1">Complemento</label>
                        <input type="text" class="form-control" id="1" name="complemento" value="">
                    </div>
                    <div class="form-group col-xl-2 col-md-4 mt-3 ">
                        <label for="1">Bairro</label>
                        <input type="text" class="form-control" id="1" name="bairro" value="">
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <br>

    <div class="row d-flex justify-content-around">
        <div class="col-2"><a href="/gerenciar-setor" class="btn btn-danger" style="width:150%">Cancelar</a></div>
        <div class="col-2"><button type="submit" class="btn btn-primary" style="width: 150%;">Confirmar</button></div>
    </div>
    </form>


    @endsection


    @section('footerScript')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#idcidade').select2({
                theme: 'bootstrap-5',
                width: '100%',
            });


            $('#iduf').change(function(e) {
                e.preventDefault();

                $('#idcidade').removeAttr('disabled');
                var cidadeDadosResidenciais = $(this).val();

                $.ajax({
                    type: "get",
                    url: "/retorna-cidade-dados-residenciais/" + cidadeDadosResidenciais,
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(indexInArray, item) {
                            $('#idcidade').append('<option value = ' + item.id_cidade +
                                '>' + item.descricao + '</option>');
                        });
                    },
                });
            });

        });
    </script>