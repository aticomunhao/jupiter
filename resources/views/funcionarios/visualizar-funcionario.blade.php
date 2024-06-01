@extends('layouts.app')

@section('head')
    <title>Visualizar Funcionário</title>
@endsection

@section('content')

    @csrf
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Visualizar Dados Pessoais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">Nome Completo
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="nome_completo" maxlength="45"
                                       oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="2" value="{{ $pessoa[0]->nome_completo }}" required="required" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">Nome resumido
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       type="text" maxlength="20"
                                       oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="" name="nome_resumido" value="{{ $pessoa[0]->nome_resumido }}"
                                       required="required" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">CPF
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="cpf" maxlength="11"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="8" value="{{ $pessoa[0]->cpf }}" required="required" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">Data de Nascimento
                                <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="dt_nascimento" id="3"
                                       value="{{ $pessoa[0]->dt_nascimento }}" required="required" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">Sexo
                                <select id="4" class="form-select"
                                        style="border: 1px solid #999999; padding: 5px;" name="sexo" type="text"
                                        required="required" disabled>
                                    <option value="{{ $pessoa[0]->id_sexo }}">{{ $pessoa[0]->nome_sexo }}</option>
                                    @foreach ($tpsexo as $tpsexos)
                                        <option value="{{ $tpsexos->id }}">
                                            {{ $tpsexos->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5 col-sm-12">Nacionalidade
                                <select id="5" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="pais" required="required" disabled>
                                    <option value="{{ $pessoa[0]->nacionalidade }}">
                                        {{ $pessoa[0]->nome_nacionalidade }}</option>
                                    @foreach ($tpnacionalidade as $tpnacionalidades)
                                        <option value="{{ $tpnacionalidades->id }}">{{ $tpnacionalidades->local }}
                                        </option>
                                    @endforeach
                                </select>
                                <br>
                            </div>
                            <div class="col-md-2 col-sm-12">UF de Nascimento
                                <select select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                        data-placeholder="Choose one thing" name="uf_nat" required="required" disabled
                                        id="uf1">
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
                            <div class="col-md-5 col-sm-12">Naturalidade
                                <select class="form-select" id="cidade1" name="natura" required="required" disabled>
                                    <option value="{{ $pessoa[0]->naturalidade }}">
                                        {{ $pessoa[0]->descricao_cidade }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">Número de Identidade
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="identidade" maxlength="8"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="10" value="{{ $pessoa[0]->identidade }}" required="required" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">UF da Identidade
                                <select id="24" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="uf_idt" required="required" disabled>
                                    <option value="{{ $identidade[0]->uf_idt }}">
                                        {{ $identidade[0]->sigla_identidade }}
                                    </option>
                                    @foreach ($tp_ufi as $tp_ufis)
                                        <option value="{{ $tp_ufis->id }}">
                                            {{ $tp_ufis->sigla }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12">Órgão Expedidor
                                <select id="9" style="border: 1px solid #999999; padding: 5px;"
                                        name="orgexp" class="form-select" required="required" disabled>
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
                            <div class="col-md-3 col-sm-12">Data de Emissão
                                <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="dt_idt" id="12"
                                       value="{{ $pessoa[0]->dt_emissao_identidade }}" required="required" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">Email
                                <input type="email" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="email" maxlength="50" id="28"
                                       value="{{ $pessoa[0]->email }}" disabled>
                            </div>
                            <div class="col-md-2 col-sm-12">DDD
                                <select id="19" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="ddd" disabled>
                                    <option value="{{ $pessoa[0]->ddd }}">
                                        {{ $pessoa[0]->numero_ddd }}
                                    </option>
                                    @foreach ($tpddd as $tpddds)
                                        <option value="{{ $tpddds->id }}">
                                            {{ $tpddds->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12">Telefone/Celular
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="celular" maxlength="9" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="20" value="{{ $pessoa[0]->celular }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Visualizar Dados do Funcionário
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">Número da Matrícula
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       name="matricula" maxlength="32" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="1" value="{{ $funcionario[0]->matricula }}" required="required">
                            </div>
                            <div class="col-md-3 col-sm-12">Data de Ingresso
                                <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="dt_ini" id="3"
                                       value="{{ $funcionario[0]->dt_inicio }}" required="required" disabled>
                            </div>
                            <div class="col-md-5">Setor Alocado
                                <select id="validationCustomUsername" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="setor" disabled>
                                    <option value="{{ $funcionario[0]->id_setor }}" required="required">
                                        {{ $funcionario[0]->nome_setor }}
                                    </option>
                                    @foreach ($tpsetor as $tpsetores)
                                        <option value="{{ $tpsetores->id }}">
                                            {{ $tpsetores->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">CTPS
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="ctps" maxlength="6"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="21" value="{{ $funcionario[0]->ctps }}" disabled>
                                <div class="invalid-feedback">
                                    Por favor, informe um CTPS Nr válido.
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">Série
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="serie_ctps" maxlength="4" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="23" value="{{ $funcionario[0]->serie_ctps }}">
                            </div>
                            <div class="col-md-2 col-sm-12">UF
                                <select id="24" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="uf_ctps" disabled>
                                    <option value="{{ $funcionario[0]->uf_ctps }}">
                                        {{ $funcionario[0]->sigla_ctps }}
                                    </option>
                                    @foreach ($tp_uff as $tp_uffs)
                                        <option value="{{ $tp_uffs->id }}">
                                            {{ $tp_uffs->sigla }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12">Data de Emissão
                                <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="dt_ctps" id="22" disabled
                                       value="{{ $funcionario[0]->emissao_ctps }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">Titulo Eleitor
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="titele" maxlength="12" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="15" value="{{ $funcionario[0]->titulo_eleitor }}">
                                <br>
                            </div>
                            <div class="col-md-3 col-sm-12">Zona
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="zona" maxlength="3" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="16" value="{{ $funcionario[0]->zona_titulo }}">
                            </div>
                            <div class="col-md-3 col-sm-12">Seção
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="secao" maxlength="4" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="17" value="{{ $funcionario[0]->secao_titulo }}">
                            </div>
                            <div class="col-md-2 col-sm-12">Data de Emissão
                                <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="dt_titulo" id="18" disabled
                                       value="{{ $funcionario[0]->dt_titulo }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">Tipo Programa
                                <select id="9" style="border: 1px solid #999999; padding: 5px;"
                                        name="tp_programa" class="form-select" required="required" disabled>
                                    <option value="{{ $funcionario[0]->tp_programa }}">
                                        {{ $funcionario[0]->nome_programa }}
                                    </option>
                                    @foreach ($tpprograma as $tpprogramas)
                                        <option value="{{ $tpprogramas->id }}">
                                            {{ $tpprogramas->programa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12">Número do PIS ou PASEP
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       maxlength="11" type="numeric" id="10" name="nr_programa" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="15" value="{{ $funcionario[0]->nr_programa }}" required="required">
                            </div>
                            <div class="col-md-3 col-sm-12">Cor Pele
                                <select id="13" style="border: 1px solid #999999; padding: 5px;"
                                        name="cor" class="form-select" type="bigint" disabled>
                                    <option value="{{ $funcionario[0]->tp_cor }}">
                                        {{ $funcionario[0]->nome_cor }}
                                    </option>
                                    @foreach ($tppele as $tppeles)
                                        <option value="{{ $tppeles->id }}">
                                            {{ $tppeles->nome_cor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">Ascendente 1
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="nome_mae" maxlength="45" disabled
                                       oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="26" value="{{ $funcionario[0]->nome_mae }}">
                                <br>
                            </div>
                            <div class="col-md-6 col-sm-12">Ascendente 2
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="nome_pai" maxlength="45" disabled
                                       oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="27" value="{{ $funcionario[0]->nome_pai }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5 col-sm-12">Número de Reservista
                                <input type="text" style="border: 1px solid #999999; padding: 5px;"
                                       class="form-control" name="reservista" maxlength="12" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="25" value="{{ $funcionario[0]->reservista }}">
                            </div>
                            <div class="col-md-2 col-sm-12">Cat CNH
                                <select id="validationCustomUsername" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-select" name="cnh" disabled>
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
                            <div class="col-md-2 col-sm-12">Tipo Sanguíneo
                                <select id="14" style="border: 1px solid #999999; padding: 5px;"
                                        name="tps" class="form-select" disabled>
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
                            <div class="col-md-3 col-sm-12">Fator RH
                                <select id="14" style="border: 1px solid #999999; padding: 5px;"
                                        name="fator" class="form-select" disabled>
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
                                Visualizar Dados Residenciais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-4 col-sm-12">CEP
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       maxlength="8" type="numeric" disabled
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                       id="35" name="cep" value="{{ $endereco[0]->cep }}">
                            </div>

                            <div class="col-md-4 col-sm-12">UF
                                <br>
                                <select class="js-example-responsive form-select"
                                        style="border: 1px solid #999999; padding: 5px;" id="iduf" name="uf_end"
                                        disabled>
                                    <option value="{{ $endereco[0]->uf_endereco }}">
                                        {{ $endereco[0]->sigla_uf_endereco }}
                                    </option>
                                    @foreach ($tp_ufe as $tp_ufes)
                                        <option value="{{ $tp_ufes->id }}">
                                            {{ $tp_ufes->sigla }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12">Cidade
                                <br>
                                <select class="js-example-responsive form-select"
                                        style="border: 1px solid #999999; padding: 5px;" id="idcidade" name="cidade"
                                        disabled>
                                    <option value="{{ $endereco[0]->cidade }}">
                                        {{ $endereco[0]->nome_cidade }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">Logradouro
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       maxlength="45" type="text" id="36" name="logradouro" disabled
                                       value="{{ $endereco[0]->logradouro }}">
                            </div>

                            <div class="col-md-3 col-sm-12">Número
                                <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                       maxlength="10" type="text" id="35" name="numero" disabled
                                       value="{{ $endereco[0]->numero }}">
                            </div>
                            <div class="col-md-3 col-sm-12">Complemento
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45"
                                       class="form-control" id="36" name="comple" disabled
                                       value="{{ $endereco[0]->complemento }}">
                            </div>
                            <div class="col-md-3 col-sm-12">Bairro:
                                <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45"
                                       class="form-control" id="36" name="bairro" disabled
                                       value="{{ $endereco[0]->bairro }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row d-flex justify-content-around">
        <div class="col-4">
            <a href="{{ route('gerenciar') }}">
                <button class="btn btn-primary" style="width: 100%;">Retornar</button>
            </a>
        </div>
    </div>
    <br>

@endsection
