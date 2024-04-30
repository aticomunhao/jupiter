@extends('layouts.app')

@section('head')
    <title>Cadastrar Funcionário</title>
@endsection

@section('content')
    <form class="form-horizontal" method="post" action="/incluir-funcionario">
        @csrf
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Dados Básicos
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 col-sm-12">Matrícula
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="numeric" maxlength="11"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="1" name="matricula" value="{{ old('matricula') }}" required="required">
                                </div>
                                <div class="col-md-3 col-sm-12">Data Início
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="date" id="13" name="dt_ini" value="{{ old('dt_ini') }}"
                                           required="required">
                                </div>
                                <div class="col-md-4 col-sm-12">Nome completo
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="text" maxlength="45"
                                           oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="idnome_completo" name="nome_completo" value="{{ old('nome_completo') }}"
                                           required="required">
                                </div>
                                <div class="col-md-3 col-sm-12">Data nascimento
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="date" value="{{ old('dt_nascimento') }}" id="3" name="dt_nascimento"
                                           required="required">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2 col-sm-12">Sexo
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="4"
                                            name="sex" required="required">
                                        <option value=""></option>
                                        @foreach ($sexo as $sexos)
                                            <option @if (old('sex')==$sexos->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $sexos->id }}">{{ $sexos->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">Nacionalidade
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                            id="nacionalidade" name="pais" value="{{ old('pais') }}"
                                            required="required">
                                        <option value=""></option>
                                        @foreach ($nac as $nacs)
                                            <option @if (old('pais')==$nacs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $nacs->id }}">{{ $nacs->local }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">UF
                                    <select select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                            data-placeholder="Choose one thing" name="uf_nat" required="required"
                                            id="uf1">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_nat')==$tp_ufs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">Naturalidade
                                    <select class="form-select" id="cidade1" name="natura" value="{{ old('natura') }}"
                                            required="required" disabled>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">CPF
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="numeric" maxlength="11" placeholder="888.888.888-88"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="8" name="cpf" required="required">
                                </div>
                                <div class="col-md-2 col-sm-12">Tipo Programa
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="9"
                                            name="tp_programa" required="required">
                                        <option value=""></option>
                                        @foreach ($programa as $programas)
                                            <option @if (old('tp_programa')==$programas->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $programas->id }}">{{ $programas->programa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12">Nr PIS ou PASEP
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="11" type="numeric" id="10" name="nr_programa"
                                           value="{{ old('nr_programa') }}" required="required">
                                </div>
                                <div class="col-md-4 col-sm-12">Identidade
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="11" type="numeric" id="11" name="identidade"
                                           value="{{ old('identidade') }}" required="required">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2 col-sm-12">UF
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" id="uf-idt" name="uf_idt"
                                            required="required">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_idt')==$tp_ufs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Órgão expedidor
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                            required="required" id="12" name="orgexp" required="required">
                                        <option value=""></option>
                                        <@foreach ($org_exp as $org_exps)
                                            <option @if (old('orgexp')==$org_exps->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $org_exps->id }}">{{ $org_exps->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Data emissão
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="date" id="13" name="dt_idt" value="{{ old('dt_idt') }}"
                                           required="required">
                                </div>
                                <div class="col-md-2 col-sm-12">Cor pele
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="14"
                                            name="cor" required="required">
                                        <option value=""></option>
                                        <@foreach ($cor as $cors)
                                            <option @if (old('cor')==$cors->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $cors->id }}">{{ $cors->nome_cor }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Tipo sangue
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="15"
                                            name="tps">
                                        <option value=""></option>
                                        <@foreach ($sangue as $sangues)
                                            <option @if (old('tps')==$sangues->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $sangues->id }}">{{ $sangues->nome_sangue }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Fator RH
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="16"
                                            name="frh">
                                        <option value=""></option>
                                        <@foreach ($fator as $fators)
                                            <option @if (old('frh')==$fators->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $fators->id }}">{{ $fators->nome_fator }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2 col-sm-12">Título eleitor
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="12" type="numeric" id="17" name="titele"
                                           value="{{ old('titele') }}">
                                </div>
                                <div class="col-md-2 col-sm-12">Zona
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="5" type="numeric" id="18" name="zona" value="{{ old('zona') }}">
                                </div>
                                <div class="col-md-1 col-sm-12">Seção
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="5" type="numeric" id="19" name="secao" value="{{ old('secao') }}">
                                </div>
                                <div class="col-md-3 col-sm-12">Data emissão
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="date" id="20" name="dt_titulo" value="{{ old('dt_titulo') }}">
                                </div>
                                <div class="col-md-2 col-sm-12">DDD
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="16"
                                            name="ddd" required="required">
                                        <option value=""></option>
                                        <@foreach ($ddd as $ddds)
                                            <option @if (old('ddd')==$ddds->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $ddds->id }}">{{ $ddds->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Celular
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="9" type="numeric"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           placeholder="Ex.: 99999-9999" value="{{ old('celular') }}" id="22"
                                           name="celular">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2 col-sm-12">CTPS
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="8" type="numeric" id="23" name="ctps" value="{{ old('ctps') }}"
                                           required="required">
                                </div>
                                <div class="col-md-2 col-sm-12">Série
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="5" type="numeric" id="26" name="serie_ctps"
                                           value="{{ old('serie_ctps') }}" required="required">
                                </div>
                                <div class="col-md-2 col-sm-12">UF
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" required="required"
                                            id="uf_ctps" name="uf_ctps" required="required">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_ctps')==$tp_ufs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12">Data emissão
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="date" id="24" name="dt_ctps" value="{{ old('dt_ctps') }}"
                                           required="required">
                                </div>
                                <div class="col-md-3 col-sm-12">Reservista
                                    <input class="form-control" maxlength="12" type="numeric" id="28" name="reservista"
                                           value="{{ old('reservista') }}">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-5 col-sm-12">Ascedente 1
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="text" maxlength="45"
                                           oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="29" name="nome_mae" value="{{ old('nome_mae') }}" required="required">
                                </div>
                                <div class="col-md-5 col-sm-12">Ascedente 2
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           type="text" maxlength="45"
                                           oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="30" name="nome_pai" value="{{ old('nome_pai') }}">
                                </div>
                                <div class="col-md-2 col-sm-12">Cat CNH
                                    <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="32"
                                            name="cnh">
                                        <option value=""></option>
                                        @foreach ($cnh as $cnhs)
                                            <option @if (old('cnh')==$cnhs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $cnhs->id }}">{{ $cnhs->nome_cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-10">E-mail
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="45" type="email" id="31" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="col-md-2 col-sm-12">Setor
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" required="required"
                                            id="setor" name="setor" required="required">
                                        <option value=""></option>
                                        @foreach ($setor as $setores)
                                            <option @if (old('setor')==$setores->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $setores->id }}">{{ $setores->nome}}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
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
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="8" type="numeric"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                           id="35" name="cep" value="{{ old('cep') }}">
                                </div>
                                <div class="col-md-4 col-sm-12">UF
                                    <br>
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" id="iduf" name="uf_end">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_end')==$tp_ufs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">Cidade
                                    <br>
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" id="idcidade" name="cidade"
                                            value="{{ old('cidade') }}" disabled>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">Logradouro
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="45" type="text" id="36" name="logradouro"
                                           value="{{ old('logradouro') }}">
                                </div>
                                <div class="col-md-3 col-sm-12">Número
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                           maxlength="10" type="text" id="35" name="numero" value="{{ old('numero') }}">
                                </div>
                                <div class="col-md-3 col-sm-12">Complemento
                                    <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45"
                                           class="form-control" id="36" name="comple" value="{{ old('comple') }}">
                                </div>
                                <div class="col-md-3 col-sm-12">Bairro:
                                    <input type="text" style="border: 1px solid #999999; padding: 5px;" maxlength="45"
                                           class="form-control" id="36" name="bairro" value="{{ old('bairro') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="botões">
            <a href="/gerenciar-funcionario" type="button" value=""
               class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <input type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">
        </div>
        <br>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
    </script>
@endpush

@section('footerScript')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#idcidade, #cidade1').select2({
                theme: 'bootstrap-5',
                width: '100%',
            });

            function populateCities(selectElement, stateValue) {
                $.ajax({
                    type: "get",
                    url: "/retorna-cidade-dados-residenciais/" + stateValue,
                    dataType: "json",
                    success: function (response) {
                        selectElement.empty();
                        $.each(response, function (indexInArray, item) {
                            selectElement.append('<option value="' + item.id_cidade + '">' +
                                item.descricao + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("An error occurred:", error);
                    }
                });
            }


            $('#iduf').change(function (e) {
                var stateValue = $(this).val();
                $('#idcidade').removeAttr('disabled');
                populateCities($('#idcidade'), stateValue);
            });

            $('#uf1').change(function (e) {
                var stateValue = $(this).val();
                $('#cidade1').removeAttr('disabled');
                populateCities($('#cidade1'), stateValue);
            });

            $('#idlimpar').click(function (e) {
                $('#idnome_completo').val("");
            });
        });
    </script>
@endsection
