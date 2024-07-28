@extends('layouts.app')
@section('head')
    <title>Editar Associado</title>
@endsection
@section('content')
    
    @csrf
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <legend style="color: #355089; font-size:25px;">Editar Associado</legend>
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Dados Pessoais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal mt-4" method='POST'
                            action="/atualizar-associado/{{ $edit_associado[0]->ida }}/{{ $edit_associado[0]->idp }}/{{ $edit_associado[0]->ide }}">
                            @csrf

                            <div class="container-fluid">
                                <div class="row d-flex justify-content-around">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="1">Nome Completo</label>
                                        <input type="text" class="form-control" name="nome_completo" maxlength="45"
                                            oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            value="{{ $edit_associado[0]->nome_completo }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">CPF</label>
                                        <input type="text" class="form-control" name="cpf" maxlength="11"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            value="{{ $edit_associado[0]->cpf }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">identidade</label>
                                        <input type="text" class="form-control" name="idt" maxlength="9"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            value="{{ $edit_associado[0]->idt }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Data de Nascimento
                                        <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                            class="form-control" name="dt_nascimento" id="3"
                                            value="{{ $edit_associado[0]->dt_nascimento }}" required="required">
                                        <div class="invalid-feedback">
                                            Por favor, selecione a Data de Nascimento.
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Sexo
                                        <select id="4" class="form-select"
                                            style="border: 1px solid #999999; padding: 5px;" name="sexo" type="text"
                                            required="required">
                                            <option value="{{ $edit_associado[0]->id_sexo }}">
                                                {{ $edit_associado[0]->nome_sexo }}</option>
                                            @foreach ($tpsexo as $tpsexos)
                                                <option value="{{ $tpsexos->id }}">
                                                    {{ $tpsexos->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, selecione um Campo
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">N.º Associado</label>
                                        <input type="text" class="form-control" name="nrAssociado" maxlength="11"
                                            value="{{ $edit_associado[0]->nrAssociado }}" required>
                                    </div>

                                    <div class="col-md-1 col-sm-12">
                                        <label for="3">DDD</label>
                                        <select id="19" class="form-select" name="ddd">
                                            <option value="{{ $edit_associado[0]->tpd }}">{{ $edit_associado[0]->dddesc }}
                                            </option>
                                            @foreach ($tpddd as $tpddds)
                                                <option value="{{ $tpddds->id }}">{{ $tpddds->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">Telefone</label>
                                        <input type="text" class="form-control" id="2" maxlength="12"
                                            name="telefone" value="{{ $edit_associado[0]->celular }}" required>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label for="2">Email</label>
                                        <input type="text" class="form-control" id="2" maxlength="50"
                                            name="email" value="{{ $edit_associado[0]->email }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="4">Data de Inicio</label>
                                        <input type="date" class="form-control" name="dt_inicio" id="4"
                                            value="{{ $edit_associado[0]->dt_inicio }}" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="4">Data de Final</label>
                                        <input type="date" class="form-control" name="dt_fim" id="4"
                                            value="{{ $edit_associado[0]->dt_fim }}">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="card" style="border-color: #355089">
            <div class="card-header">
                <div class="ROW">
                    <h5 class="col-12" style="color: #355089">
                        Dados Residenciais
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-around">
                    <div class="form-group col-md-3">
                        <label for="1">CEP</label>
                        <input type="text" class="form-control" id="1" name="cep"
                            value="{{ $edit_associado[0]->cep }}" required>
                    </div>
                    <div class="form-group col-md-1 ">
                        <label for="id_uf">UF</label>
                        <select class="js-example-responsive form-select" id="iduf" name="uf_end" required>
                            <option value="{{ $edit_associado[0]->tuf }}">{{ $edit_associado[0]->ufsgl }}</option>
                            @foreach ($tp_uf as $tp_ufs)
                                <option @if (old('uf_end') == $tp_ufs->id) {{ 'selected="selected"' }} @endif
                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ciadade">Cidade</label>
                        <select class="js-example-responsive form-select" id="idcidade" name="cidade"
                            value="{{ old('cidade') }}" disabled required>
                            <option value="{{ $edit_associado[0]->id_cidade }}">{{ $edit_associado[0]->nat }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="1">Logradouro</label>
                        <input type="text" class="form-control" id="1" name="logradouro"
                            value="{{ $edit_associado[0]->logradouro }}" required>
                    </div>

                        <div class="form-group col-md-5">
                            <label for="1">Complemento</label>
                            <input type="text" class="form-control" id="1" name="complemento"
                                value="{{ $edit_associado[0]->complemento }}" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="1">Número</label>
                            <input type="text" class="form-control" id="1" name="numero"
                                value="{{ $edit_associado[0]->numero }}" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="1">Bairro</label>
                            <input type="text" class="form-control" id="1" name="bairro"
                                value="{{ $edit_associado[0]->bairro }}" required>
                        </div>
                </div>
                <br>
            </div>
        </div>
        <br>


        <a class="btn btn-danger col-md-3 col-2 mt-5 offset-md-2" href="/gerenciar-associado"
            class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary col-md-3 col-2 mt-5 offset-md-2">Confirmar</button>
        </form>


    @endsection


    @section('footerScript')
        <!-- Scripts -->
        
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
