@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <legend style="color:rgb(16, 19, 241); font-size:15px;">Editar Associado</legend>
    <div class="border border-primary" style="border-radius: 5px;">
        <div class="card">
            <div class="card-header">
                Dados Pessoais
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method='POST' action ="/atualizar-associado/{{ $edit_associado[0]->ida}}/{{ $edit_associado[0]->idp}}/{{ $edit_associado[0]->ide}}">
                    @csrf

                    <div class="container-fluid">
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4 col-sm-12">
                                <label for="1">Nome Completo</label>
                                <input type="text" class="form-control" name="nome_completo" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="{{ $edit_associado[0]->nome_completo }}">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <label for="2">CPF</label>
                                <input type="text" class="form-control" name="cpf" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="{{ $edit_associado[0]->cpf }}">
                            </div>
                            <div class="col-md-1 col-sm-12">
                                <label for="3">DDD</label>
                                <select id="19" class="form-select" name="ddd">
                                    <option value="{{ $edit_associado[0]->tpd }}">{{$edit_associado[0]->dddesc }}</option>
                                    @foreach ($tpddd as $tpddds)
                                    <option value="{{ $tpddds->id }}">{{ $tpddds->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="2">Telefone</label>
                                <input type="text" class="form-control" id="2" maxlength="12" name="telefone" value="{{ $edit_associado[0]->celular }}">
                            </div>
                            <div class="row d-flex justify-content-around">
                                <div class="col-md-4 col-sm-12">
                                    <label for="2">Email</label>
                                    <input type="text" class="form-control" id="2" maxlength="50" name="email" value="{{ $edit_associado[0]->email }}">
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="4">Data de Inicio</label>
                                    <input type="date" class="form-control" name="dt_inicio" id="4" value="{{ $edit_associado[0]->dt_inicio }}">
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="4">Data de Final</label>
                                    <input type="date" class="form-control" name="dt_fim" id="4" value="{{ $edit_associado[0]->dt_fim }}">
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
                    <input type="text" class="form-control" id="1" name="cep" value="{{ $edit_associado[0]->cep }}">
                </div>
                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                    <label for="id_uf">UF</label>
                    <select class="js-example-responsive form-select" id="iduf" name="uf_end">
                        <option value="{{ $edit_associado[0]->tuf }}">{{$edit_associado[0]->ufsgl}}</option>
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
                        <option value="{{ $edit_associado[0]->id_cidade }}">{{ $edit_associado[0]->nat }}</option>
                    </select>
                </div>
                <div class="form-group col-xl-3 col-md-4 mt-3 ">
                    <label for="1">Logradouro</label>
                    <input type="text" class="form-control" id="1" name="logradouro" value="{{ $edit_associado[0]->logradouro }}">
                </div>
                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                    <label for="1">Número</label>
                    <input type="text" class="form-control" id="1" name="numero" value="{{ $edit_associado[0]->numero }}">
                </div>
                <div class="row d-flex justify-content-around">
                    <div class="form-group col-xl-3 col-md-4 mt-3 ">
                        <label for="1">Complemento</label>
                        <input type="text" class="form-control" id="1" name="complemento" value="{{ $edit_associado[0]->complemento }}">
                    </div>
                    <div class="form-group col-xl-2 col-md-4 mt-3 ">
                        <label for="1">Bairro</label>
                        <input type="text" class="form-control" id="1" name="bairro" value="{{ $edit_associado[0]->bairro }}">
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <br>

    <div class="row d-flex justify-content-around">
        <div class="col-2"><a href="/gerenciar-associado" class="btn btn-danger" style="width:150%">Cancelar</a></div>
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
                $('#idcidade').empty();
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