@extends('layouts.app')
@section('head')
<title>Editar Cadastro de Funcionário</title>
@endsection
@section('content')
<form method='POST' action="/atualizar-funcionario/{{ $pessoa[0]->idp }}">
    @csrf
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Editar Cadastro do Funcionário
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-2 mb-3">
                                <label for="1">Matrícula</label>
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;" name="matricula"
                                maxlength="32" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="1"
                                value="{{ $funcionario[0]->matricula }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Número da Matrícula.
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label for="2">
                                    Nome Completo
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_completo"
                                maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2"
                                value="{{ $pessoa[0]->nome_completo }}">
                            </div>

                            <br>

                            <div class="form-group col-2">
                                <label for="3">
                                    Data de Nascimento
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_nascimento"
                                 id="3" value="{{ $pessoa[0]->dt_nascimento }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Nascimento.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="4">
                                    Sexo
                                </label>
                                <select id="4" class="form-select" style="border: 1px solid #999999; padding: 5px;" name="sexo" type="text">
                                    <option value="{{ $pessoa[0]->id_sexo }}">{{ $pessoa[0]->nome_sexo }}</option>
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

                        </div>

                        <div class="form-group row">
                            <div class="form-group col-2">
                                <label for="3">
                                    Data de Inicio
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_ini"
                                 id="3" value="{{ $funcionario[0]->dt_inicio }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Inicio.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="5">
                                    Nacionalidade
                                </label>
                                <select id="5" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="pais">
                                    <option value="{{ $pessoa[0]->nacionalidade }}">
                                        {{ $pessoa[0]->nome_nacionalidade }}
                                    </option>
                                    @foreach ($tpnacionalidade as $tpnacionalidades)
                                    <option value="{{ $tpnacionalidades->id }}">
                                        {{ $tpnacionalidades->local }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione uma Nacionalidade.
                                </div>
                                <br>
                            </div>

                            <div class="form-group col-2">
                                <label for="6">
                                    Naturalidade UF
                                </label>
                                <select select class="form-select" style="border: 1px solid #999999; padding: 5px;" data-placeholder="Choose one thing"
                                 name="uf_nat" required="required" id="uf1">
                                    <option value="{{ $pessoa[0]->uf_naturalidade }}">
                                        {{ $pessoa[0]->sigla_naturalidade }}
                                    </option>
                                    @foreach ($tp_uf as $tp_ufs)
                                    <option value="{{ $tp_ufs->id }}">
                                        {{ $tp_ufs->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label for="7">
                                    Naturalidade-Cidade
                                </label>
                                <select class="form-select" id="cidade1" name="natura" required="required" disabled>
                                    <option value="{{ $pessoa[0]->naturalidade }}">
                                        {{ $pessoa[0]->descricao_cidade }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-2">
                                <label for="8">
                                    CPF
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="cpf"
                                 maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                 id="8" value="{{ $pessoa[0]->cpf }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um CPF válido.
                                </div>
                            </div>

                            <div class="form-group col-1">
                                <label for="9">
                                    PIS/PASEP
                                </label>
                                <select id="9" style="border: 1px solid #999999; padding: 5px;" name="tp_programa" class="form-select">
                                    <option value="{{ $funcionario[0]->tp_programa }}">
                                        {{ $funcionario[0]->nome_programa }}
                                    </option>
                                    @foreach ($tpprograma as $tpprogramas)
                                    <option value="{{ $tpprogramas->id }}">
                                        {{ $tpprogramas->programa }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, informe um PIS/PASEP válido.
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">Número do PIS ou PASEP
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                    maxlength="11" type="numeric" id="10" name="nr_programa" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="15"
                                    value="{{ $funcionario[0]->nr_programa }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-2">
                                <label for="10">
                                    Identidade
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="identidade"
                                name="matricula" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="10"
                                value="{{ $pessoa[0]->identidade }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um RG válido.
                                </div>
                                <br>
                            </div>

                            <div class="form-group col-1">
                                <label for="24">
                                    UF
                                </label>
                                <select id="24" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="uf_idt">
                                    <option value="{{ $identidade[0]->uf_idt }}">
                                        {{ $identidade[0]->sigla_identidade }}
                                    </option>
                                    @foreach ($tp_ufi as $tp_ufis)
                                    <option value="{{ $tp_ufis->id }}">
                                        {{ $tp_ufis->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um UF válido.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="11">
                                    Orgão Exp
                                </label>
                                <select id="9" style="border: 1px solid #999999; padding: 5px;" name="orgexp" class="form-select">
                                    <option value="{{ $pessoa[0]->id_orgao_expedidor }}">
                                        {{ $pessoa[0]->sigla_orgao_expedidor }}
                                    </option>
                                    @foreach ($tporg_exp as $tporg_exps)
                                    <option value="{{ $tporg_exps->id }}">
                                        {{ $tporg_exps->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-2">
                                <label for="12">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_idt" id="12"
                                value="{{ $pessoa[0]->dt_emissao_identidade }}">
                            </div>

                            <div class="form-group col-2">
                                <label for="13">
                                    Cor Pele
                                </label>
                                <select id="13" style="border: 1px solid #999999; padding: 5px;" name="cor" class="form-select" type="bigint">
                                    <option value="{{ $funcionario[0]->tp_cor }}">
                                        {{ $funcionario[0]->nome_cor }}
                                    </option>
                                    @foreach ($tppele as $tppeles)
                                    <option value="{{ $tppeles->id }}">
                                        {{ $tppeles->nome_cor }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione a Cor da Pele.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="14">
                                    Tipo Sanguineo
                                </label>
                                <select id="14" style="border: 1px solid #999999; padding: 5px;" name="tps" class="form-select">
                                    <option value="{{ $funcionario[0]->tp_sangue }}">
                                        {{ $funcionario[0]->nome_sangue }}
                                    </option>
                                    @foreach ($tpsangue as $tpsangues)
                                    <option value="{{ $tpsangues->id }}">
                                        {{ $tpsangues->nome_sangue }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-2">
                                <label for="14">
                                    Fator RH
                                </label>
                                <select id="14" style="border: 1px solid #999999; padding: 5px;" name="fator" class="form-select">
                                    <option value="{{ $funcionario[0]->id_fator_rh }}">
                                        {{ $funcionario[0]->nome_fator }}
                                    </option>
                                    @foreach ($fator as $fators)
                                    <option value="{{ $fators->id }}">
                                        {{ $fators->nome_fator }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label for="15">
                                    Titulo eleitor Nr
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control"
                                name="titele" name="matricula" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="15"
                                value="{{ $funcionario[0]->titulo_eleitor }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Titulo eleitor Nr válido.
                                </div>
                                <br>
                            </div>

                            <div class="form-group col-1">
                                <label for="16">
                                    Zona
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="zona"
                                name="matricula" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="16"
                                value="{{ $funcionario[0]->zona_titulo }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Titulo eleitor Nr válido.
                                </div>
                            </div>

                            <div class="form-group col-1">
                                <label for="17">
                                    Seção
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control"
                                name="secao" name="matricula" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="17"
                                value="{{ $funcionario[0]->secao_titulo }}">
                                <div class="invalid-feedback">
                                    Por favor, informe uma Seção válida.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="18">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_titulo" id="18"
                                value="{{ $funcionario[0]->dt_titulo }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Emissão.
                                </div>
                            </div>

                            <div class="form-group col-1">
                                <label for="19">
                                    DDD
                                </label>
                                <select id="19" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="ddd">
                                    <option value="{{ $pessoa[0]->ddd }}">
                                        {{ $pessoa[0]->numero_ddd }}
                                    </option>
                                    @foreach ($tpddd as $tpddds)
                                    <option value="{{ $tpddds->id }}">
                                        {{ $tpddds->descricao }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um DDD válido.
                                </div>
                            </div>

                            <div class="form-group col-4">
                                <label for="20">
                                    Celular
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="celular"
                                maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="20"
                                value="{{ $pessoa[0]->celular }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Número de Celular.
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label for="21">
                                    CTPS Nr
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="ctps"
                                maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="21"
                                value="{{ $funcionario[0]->ctps }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um CTPS Nr válido.
                                </div>
                                <br>
                            </div>

                            <div class="form-group col-2">
                                <label for="22">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_ctps" id="22"
                                value="{{ $funcionario[0]->emissao_ctps }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Emissão.
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <label for="23">
                                    Série
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="serie_ctps"
                                maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="23"
                                value="{{ $funcionario[0]->serie_ctps }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Nr Série válido.
                                </div>
                            </div>

                            <div class="form-group col-1">
                                <label for="24">
                                    UF do CTPS
                                </label>
                                <select id="24" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="uf_ctps">
                                    <option value="{{ $funcionario[0]->uf_ctps }}">
                                        {{ $funcionario[0]->sigla_ctps }}
                                    </option>
                                    @foreach ($tp_uff as $tp_uffs)
                                    <option value="{{ $tp_uffs->id }}">
                                        {{ $tp_uffs->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um UF válido.
                                </div>
                            </div>

                            <div class="form-group col-4">
                                <label for="25">
                                    Número de Reservista
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="reservista"
                                maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="25"
                                value="{{ $funcionario[0]->reservista }}">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="form-group col-6">
                                <label for="26">
                                    Nome da Mãe
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_mae"
                                maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="26"
                                value="{{ $funcionario[0]->nome_mae }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Nome da Mãe>
                                </div>
                                <br>
                            </div>

                            <div class="form-group col-6">
                                <label for="27">
                                    Nome do Pai
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_pai"
                                maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="27"
                                value="{{ $funcionario[0]->nome_pai }}">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="form-group col-6 ">
                                <label for="28">
                                    Email
                                </label>
                                <input type="email" style="border: 1px solid #999999; padding: 5px;" class="form-control"
                                name="email" maxlength="50" id="28" value="{{ $pessoa[0]->email }}">
                            </div>

                            <div class="form-group col-2">
                                <label for="validationCustomUsername">
                                    Cat CNH
                                </label>
                                <select id="validationCustomUsername" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="cnh">
                                    <option value="{{ $funcionario[0]->id_tp_cnh }}">
                                        {{ $funcionario[0]->tp_cnh }}
                                    </option>
                                    @foreach ($tpcnh as $tpcnhs)
                                    <option value="{{ $tpcnhs->id }}">
                                        {{ $tpcnhs->nome_cat }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-4">
                                <label for="validationCustomUsername">
                                    Setor
                                </label>
                                <select id="validationCustomUsername" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="setor">
                                    <option value="{{ $funcionario[0]->id_setor }}">
                                        {{ $funcionario[0]->nome_setor }}
                                    </option>
                                    @foreach ($tpsetor as $tpsetores)
                                    <option value="{{ $tpsetores->id }}">
                                        {{ $tpsetores->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione uma Cat CNH válida.
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Dados Residenciais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-4 col-sm-12">CEP
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="8"
                                type="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="35" name="cep"
                                value="{{ $endereco[0]->cep }}">
                            </div>

                            <div class="col-md-4 col-sm-12">UF
                                <br>
                                <select class="js-example-responsive form-select" style="border: 1px solid #999999; padding: 5px;" id="iduf" name="uf_end">
                                    <option value=""></option>
                                    @foreach ($tp_uf as $tp_ufs)
                                    <option @if (old('uf_end')==$tp_ufs->id) {{ 'selected="selected"' }} @endif
                                        value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12">Cidade
                                <br>
                                <select class="js-example-responsive form-select" style="border: 1px solid #999999; padding: 5px;" id="idcidade"
                                name="cidade" value="{{ old('cidade') }}" disabled>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">Logradouro
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="45" type="text" id="36"
                                name="logradouro" value="{{ $endereco[0]->logradouro }}">
                            </div>

                            <div class="col-md-3 col-sm-12">Número
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="10" type="text" id="35"
                                name="numero" value="{{ $endereco[0]->numero }}">
                            </div>
                            <div class="col-md-3 col-sm-12">Complemento
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45" class="form-control" id="36"
                                name="comple" value="{{ $endereco[0]->complemento }}">
                            </div>
                            <div class="col-md-3 col-sm-12">Bairro:
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45" class="form-control" id="36"
                                 name="bairro" value="{{ $endereco[0]->bairro }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="botões">
        <a href="/gerenciar-funcionario" type="button" value="" class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
        <input type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">
    </div>
    <br>
</form>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script>
    $(document).ready(function() {

        $('#idcidade, #cidade1').select2({
            theme: 'bootstrap-5',
            width: '100%',
        });

        function populateCities(selectElement, stateValue) {
            $.ajax({
                type: "get",
                url: "/retorna-cidade-dados-residenciais/" + stateValue,
                dataType: "json",
                success: function(response) {
                    selectElement.empty();
                    $.each(response, function(indexInArray, item) {
                        selectElement.append('<option value="' + item.id_cidade + '">' +
                            item.descricao + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", error);
                }
            });
        }


        $('#iduf').change(function(e) {
            var stateValue = $(this).val();
            $('#idcidade').removeAttr('disabled');
            populateCities($('#idcidade'), stateValue);
        });

        $('#uf1').change(function(e) {
            var stateValue = $(this).val();
            $('#cidade1').removeAttr('disabled');
            populateCities($('#cidade1'), stateValue);
        });

        $('#idlimpar').click(function(e) {
            $('#idnome_completo').val("");
        });
    });
</script>
@endsection
