@extends('layouts.app')
@section('head')
<title>Editar Cadastro de Funcionário</title>
@endsection
@section('content')
<form method='POST' action="/atualizar-funcionario/{{ $editar[0]->idf }}/{{ $editar[0]->idp }}">
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
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;" name="matricula" maxlength="32" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="1" value="{{ $editar[0]->matricula }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Número da Matrícula.
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="2">
                                    Nome Completo
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_completo" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value="{{ $editar[0]->nome_completo }}">
                            </div>
                            <br>
                            <div class="form-group col-2">
                                <label for="3">
                                    Data de Nascimento
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_nascimento" id="3" value="{{ $editar[0]->dt_nascimento }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Nascimento.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="4">
                                    Sexo
                                </label>
                                <select id="4" class="form-select" style="border: 1px solid #999999; padding: 5px;" name="sexo" type="text">
                                    <option value="{{ $editar[0]->id_tps }}">{{ $editar[0]->tps }}</option>
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
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_ini" id="3" value="{{ $editar[0]->dt_inicio }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Inicio.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="5">
                                    Nacionalidade
                                </label>
                                <select id="5" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="pais">
                                    <option value="{{ $editar[0]->tpnac }}">
                                        {{ $editar[0]->tnl }}
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
                                <select id="6" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="uf_nat" type="numeric">
                                    <option value="{{ $editar[0]->tuf }}">
                                        {{ $editar[0]->ufsgl }}
                                    </option>
                                    @foreach ($tpufidt as $tpufidts)
                                    <option value="{{ $tpufidts->id }}">
                                        {{ $tpufidts->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um UF válido.
                                </div>
                            </div>
                            <div class="form-group col-3">
                                <label for="7">
                                    Naturalidade-Cidade
                                </label>
                                <select id="7" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="natura" type="numeric">
                                    <option value="{{ $editar[0]->id_cidade }}">
                                        {{ $editar[0]->nat }}
                                    </option>
                                    @foreach ($tpcidade as $tpcidades)
                                    <option value="{{ $tpcidades->id_cidade }}">
                                        {{ $tpcidades->descricao }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um UF válido.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="8">
                                    CPF
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="cpf" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="8" value="{{ $editar[0]->cpf }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um CPF válido.
                                </div>
                            </div>
                            <div class="form-group col-1">
                                <label for="9">
                                    PIS/PASEP
                                </label>
                                <select id="9" style="border: 1px solid #999999; padding: 5px;" name="programa" class="form-select">
                                    <option value="{{ $editar[0]->tpprog }}">
                                        {{ $editar[0]->prog }}
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
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label for="10">
                                    Identidade
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="identidade" name="matricula" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="10" value="{{ $editar[0]->idt }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um RG válido.
                                </div>
                                <br>
                            </div>
                            <div class="form-group col-2">
                                <label for="11">
                                    Orgão Exp
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="orgexp" name="matricula" maxlength="30" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="11" value="{{ $editar[0]->orgao_expedidor }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Orgão Exp válido.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="12">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_idt" id="12" value="{{ $editar[0]->dt_emissao_idt }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Emissão.
                                </div>
                            </div>
                            <div class="form-group col-3">
                                <label for="13">
                                    Cor Pele
                                </label>
                                <select id="13" style="border: 1px solid #999999; padding: 5px;" name="cor" class="form-select" type="bigint">
                                    <option value="{{ $editar[0]->tpcor }}">
                                        {{ $editar[0]->nmpele }}
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
                                    <option value="{{ $editar[0]->tpsang }}">
                                        {{ $editar[0]->nmsangue }}
                                    </option>
                                    @foreach ($tpsangue as $tpsangues)
                                    <option value="{{ $tpsangues->id }}">
                                        {{ $tpsangues->nome_sangue }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um DDD válido.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label for="15">
                                    Titulo eleitor Nr
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="titele" name="matricula" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="15" value="{{ $editar[0]->titulo_eleitor }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Titulo eleitor Nr válido.
                                </div>
                                <br>
                            </div>
                            <div class="form-group col-1">
                                <label for="16">
                                    Zona
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="zona" name="matricula" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="16" value="{{ $editar[0]->zona_tit }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Titulo eleitor Nr válido.
                                </div>
                            </div>
                            <div class="form-group col-1">
                                <label for="17">
                                    Seção
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="secao" name="matricula" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="17" value="{{ $editar[0]->secao_tit }}">
                                <div class="invalid-feedback">
                                    Por favor, informe uma Seção válida.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="18">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_titulo" id="18" value="{{ $editar[0]->dt_titulo }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Emissão.
                                </div>
                            </div>
                            <div class="form-group col-1">
                                <label for="19">
                                    DDD
                                </label>
                                <select id="19" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="ddd">
                                    <option value="{{ $editar[0]->tpd }}">
                                        {{ $editar[0]->dddesc }}
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
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="celular" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="20" value="{{ $editar[0]->celular }}">
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
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="ctps" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="21" value="{{ $editar[0]->ctps }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um CTPS Nr válido.
                                </div>
                                <br>
                            </div>
                            <div class="form-group col-2">
                                <label for="22">
                                    Data de Emissão
                                </label>
                                <input type="date" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="dt_ctps" id="22" value="{{ $editar[0]->dt_emissao_ctps }}">
                                <div class="invalid-feedback">
                                    Por favor, selecione a Data de Emissão.
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <label for="23">
                                    Série
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="serie_ctps" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="23" value="{{ $editar[0]->serie }}">
                                <div class="invalid-feedback">
                                    Por favor, informe um Nr Série válido.
                                </div>
                            </div>
                            <div class="form-group col-1">
                                <label for="24">
                                    UF
                                </label>
                                <select id="24" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="uf_idt">
                                    <option value="{{ $editar[0]->tuf }}">
                                        {{ $editar[0]->ufsgl }}
                                    </option>
                                    @foreach ($tpufidt as $tpufidts)
                                    <option value="{{ $tpufidts->id }}">
                                        {{ $tpufidts->sigla }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecione um UF válido.
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="25">
                                    Reservista
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="reservista" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="25" value="{{ $editar[0]->reservista }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-6">
                                <label for="26">
                                    Nome da Mãe
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_mae" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="26" value="{{ $editar[0]->nome_mae }}">
                                <div class="invalid-feedback">
                                    Por favor, informe o Nome da Mãe>
                                </div>
                                <br>
                            </div>
                            <div class="form-group col-6">
                                <label for="27">
                                    Nome do Pai
                                </label>
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="nome_pai" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="27" value="{{ $editar[0]->nome_pai }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-6 ">
                                <label for="28">
                                    Email
                                </label>
                                <input type="email" style="border: 1px solid #999999; padding: 5px;" class="form-control" name="email" maxlength="50" id="28" value="{{ $editar[0]->email }}">
                            </div>
                            <div class="form-group col-2">
                                <label for="validationCustomUsername">
                                    Cat CNH
                                </label>
                                <select id="validationCustomUsername" style="border: 1px solid #999999; padding: 5px;" class="form-select" name="cnh">
                                    <option value="{{ $editar[0]->tpcn }}">
                                        {{ $editar[0]->nmcnh }}
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
                                    <option value="{{ $editar[0]->ids}}">
                                        {{ $editar[0]->setnome }}
                                    </option>
                                    @foreach ($tpsetor as $tpsetores)
                                    <option value="{{ $tpsetores->id }}">
                                        {{ $tpsetores->nome}}
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
    <br>
    <div class="botões">
        <a href="/gerenciar-funcionario" type="button" value="" class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
        <input type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">
    </div>
    <br>
</form>

<script>
    // Exemplo de JavaScript inicial para desativar envios de formulário, se houver campos inválidos.
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
            var forms = document.getElementsByClassName('needs-validation');
            // Faz um loop neles e evita o envio
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection