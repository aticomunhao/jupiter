@extends('layouts.app')

@section('head')

<title>Cadastrar Funcionário</title>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="path/to/select2.min.css" rel="stylesheet" />


@endsection

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="post" action="/incluir-funcionario">
                        @csrf
                    <legend style="color:rgb(16, 19, 241); font-size:15px;">Dados básicos</legend>
                    <fieldset class="border rounded border-primary p-2">

                        <div class="form-group row">
                            <div class="col-2">Matrícula
                                <input  class="form-control" type="numeric" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  id="1" name="matricula" required="required" >
                            </div>
                            <div class="col-2">Data Início
                                <input class="form-control" type="date" value="" id="13" name="dt_ini" required="required">
                            </div>
                            <div class="col">Nome completo
                                <input class="form-control"  type="text" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" name="nome_completo" value="" required="required">
                            </div>
                            <div class="col-2">Data nascimento
                                <input class="form-control" type="date" value="" id="3" name="dt_nascimento" required="required">
                            </div>
                            <div class="col-2">Sexo
                                <select class="form-select" id="4" name="sex" required="required">
                                    <option value=""></option>
                                    @foreach($sexo as $sexos)
                                    <option value="{{$sexos->id}}">{{$sexos->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <div class="col">Nacionalidade
                            <select class="form-select" id="4" name="pais" required="required">
                                <option value=""></option>
                                @foreach($nac as $nacs)
                                <option value="{{$nacs->id}}">{{$nacs->local}}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="col-1">UF
                                <select class="js-example-responsive form-select" id="uf-nat" name="uf_nat" required="required">
                                    <option value=""></option>
                                    @foreach($tp_uf as $tp_ufs)
                                    <option value="{{$tp_ufs->id}}">{{$tp_ufs->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">Naturalidade
                                <select class="js-example-responsive form-select" id="cidade1" name="natura" required="required"  >
                                    <option value=""></option>
                                    @foreach($cidade as $cidades)
                                    <option value="{{$cidades->id_cidade}}">{{$cidades->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">CPF
                                <input class="form-control" type="numeric" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="8" name="cpf" required="required">
                            </div>
                            <div class="col">Tipo Programa
                                <select class="form-select" id="9" name="tp_programa" required="required"  >
                                    <option value=""></option>
                                    @foreach($programa as $programas)
                                    <option value="{{$programas->id}}">{{$programas->programa}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <br>
                        <div class="form-group row">
                            <div class="col">Nr PIS ou PASEP
                                <input class="form-control" maxlength="11" type="numeric" value="" id="10" name="nr_programa" required="required">
                            </div>
                            <div class="col">Identidade
                                <input class="form-control" maxlength="11" type="numeric" value="" id="11" name="identidade" required="required">
                            </div>
                            <div class="col-1">UF
                                <select class="js-example-responsive form-select" id="uf-idt" name="uf_idt" required="required">
                                    <option value=""></option>
                                    @foreach($tp_uf as $tp_ufs)
                                    <option value="{{$tp_ufs->id}}">{{$tp_ufs->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">Órgão expedidor
                                <select class="form-select" required="required"  id="12" name="orgexp" required="required">
                                    <option value=""></option>
                                    <@foreach($org_exp as $org_exps)
                                    <option value="{{$org_exps->id}}">{{$org_exps->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">Data emissão
                                <input class="form-control" type="date" value="" id="13" name="dt_idt" required="required">
                            </div>
                            <div class="col-2">Cor pele
                                <select class="form-select" id="14" name="cor" required="required">
                                    <option value=""></option>
                                    <@foreach($cor as $cors)
                                    <option value="{{$cors->id}}">{{$cors->nome_cor}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1">Tipo sangue
                                <select class="form-select" id="15" name="tps" required="required">
                                    <option value=""></option>
                                    <@foreach($sangue as $sangues)
                                    <option value="{{$sangues->id}}">{{$sangues->nome_sangue}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <br>
                        <div class="form-group row">
                            <div class="col-2">Fator RH
                                <select class="form-select" id="16" name="frh" required="required">
                                    <option value=""></option>
                                    <@foreach($fator as $fators)
                                    <option value="{{$fators->id}}">{{$fators->nome_fator}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">Título eleitor
                                <input class="form-control" maxlength="12" type="numeric" value="" id="17" name="titele">
                            </div>
                            <div class="col-1">Zona
                                <input class="form-control" maxlength="5" type="numeric" value="" id="18" name="zona">
                            </div><div class="col-1">Seção
                                <input class="form-control" maxlength="5" type="numeric" value="" id="19" name="secao">
                            </div>
                            <div class="col-2">Data emissão
                                <input class="form-control" type="date" value="" id="20" name="dt_titulo">
                            </div>
                            <div class="col-1">DDD
                                <select class="form-select" id="16" name="ddd" required="required">
                                    <option value=""></option>
                                    <@foreach($ddd as $ddds)
                                    <option value="{{$ddds->id}}">{{$ddds->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">Celular
                                <input class="form-control" maxlength="9" type="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Ex.: 99999-9999" value="" id="22" name="celular">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col">CTPS
                                <input class="form-control" maxlength="8" type="numeric" value="" id="23" name="ctps" required="required">
                            </div>
                            <div class="col">Série
                                <input class="form-control" maxlength="5" type="numeric" value="" id="26" name="serie_ctps" required="required">
                            </div>
                            <div class="col-1">UF
                                <select class="js-example-responsive form-select" required="required"  id="uf_ctps" name="uf_ctps" required="required">
                                    <option value=""></option>
                                    @foreach($tp_uf as $tp_ufs)
                                    <option value="{{$tp_ufs->id}}">{{$tp_ufs->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">Data emissão
                                <input class="form-control" type="date" value="" id="24" name="dt_ctps" required="required">
                            </div>
                            <div class="col">Reservista
                                <input class="form-control" maxlength="12" type="numeric" value="" id="28" name="reservista">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col">Nome mãe
                                <input class="form-control" type="text" maxlength="45" pattern="[a-zA-Z\s]+$"  required="required"  id="29" name="nome_mae">
                            </div>
                            <div class="col">Nome pai
                                <input class="form-control" type="text" maxlength="45" pattern="[a-zA-Z\s]+$" required="required" id="30" name="nome_pai">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col">e-mail
                                <input class="form-control" maxlength="45" type="email" value="" id="31" name="email">
                            </div>
                            <div class="col-2">Cat CNH
                                <select class="form-select" id="32" name="cnh">
                                    <option value=""></option>
                                    @foreach($cnh as $cnhs)
                                    <option value="{{$cnhs->id}}">{{$cnhs->nome_cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                        <br>
                        <legend style="color:rgb(16, 19, 241); font-size:15px;">Dados bancários</legend>
                    <fieldset class="border rounded border-primary p-2">
                        <div class="row">

                            <div class="col">CEP
                                <input class="form-control" maxlength="8" type="numeric"  id="35" name="cep">
                            </div>
                            <div class="col-3">UF
                                <br>
                                <select class="js-example-responsive form-select" id="37" name="uf_end">
                                    <option value=""></option>
                                    @foreach($tp_uf as $tp_ufs)
                                    <option value="{{$tp_ufs->id}}">{{$tp_ufs->sigla}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">Cidade
                                <br>
                                <select class="js-example-responsive form-select" id="38" name="cidade">
                                    <option value=""></option>
                                    @foreach($cidade as $cidades)
                                    <option value="{{$cidades->id_cidade}}">{{$cidades->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">Logradouro
                                <input class="form-control" maxlength="45" type="text"  id="36" name="logradouro">
                            </div>
                            <div class="col-2">Número
                                <input class="form-control" maxlength="10" type="text"  id="35" name="numero">
                            </div>
                            <div class="col-2">Complemento
                                <input type="text" maxlength="45" class="form-control" id="36" name="comple">
                            </div>
                        </div>
                        <div class="row  h-90">

                            <div class="col">Bairro:
                                <input type="text" maxlength="45" class="form-control" id="36" name="bairro">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <div class="row">
                        <div class="d-grid gap-1 col-5 mx-auto">
                            <a class="btn btn-danger" href="/gerenciar-funcionario" role="button">Cancelar</a>
                        </div>
                        <div class="d-grid gap-2 col-5 mx-auto">
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </div>
                    </form>

                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.js-example-responsive').select2({
        height: 'resolve'
});
</script>


@endsection

@section('footerScript')

<script src="{{ URL::asset('/js/pages/mascaras.init.js')}}"></script>
<script src="vendor/select2/dist/js/select2.min.js"></script>
<script src="path/to/select2.min.js"></script>

@endsection

