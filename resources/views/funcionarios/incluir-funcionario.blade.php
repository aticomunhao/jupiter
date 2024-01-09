@extends('layouts.app')

@section('head')
    <title>Cadastrar Funcionário</title>
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
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">Matrícula
                                            <input class="form-control" type="numeric" maxlength="11"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="1" name="matricula" value="{{ old('matricula') }}"
                                                required="required">
                                        </div>
                                        <div class="col-md-3 col-sm-12">Data Início
                                            <input class="form-control" type="date" id="13" name="dt_ini"
                                                value="{{ old('dt_ini') }}" required="required">
                                        </div>
                                        <div class="col-md-4 col-sm-12">Nome completo
                                            <input class="form-control" type="text" maxlength="45"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="2" name="nome_completo" value="" required="required">
                                        </div>
                                        <div class="col-md-3 col-sm-12">Data nascimento
                                            <input class="form-control" type="date" value="{{ old('dt_nascimento') }}"
                                                id="3" name="dt_nascimento" required="required">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">Sexo
                                            <select class="form-select" id="4" name="sex" required="required">
                                                <option value=""></option>
                                                @foreach ($sexo as $sexos)
                                                    <option
                                                        @if (old('sex') == $sexos->id) {{ 'selected="selected"' }} @endif
                                                        value="{{ $sexos->id }}">{{ $sexos->tipo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12">Nacionalidade
                                            <select class="form-select" id="nacionalidade" name="pais"
                                                value="{{ old('pais') }}" required="required">
                                                <option value=""></option>
                                                @foreach ($nac as $nacs)
                                                    <option value="{{ $nacs->id }}">{{ $nacs->local }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">UF
                                            <select select class="form-select" data-placeholder="Choose one thing"
                                                name="uf_nat" value="{{ old('uf_nat') }}" required="required"
                                                id="uf1">
                                                <option value=""></option>
                                                @foreach ($tp_uf as $tp_ufs)
                                                    <option value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12">Naturalidade
                                            <select class="form-select" id="cidade1" name="natura"
                                                value="{{ old('natura') }}" required="required" disabled>

                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">CPF
                                            <input class="form-control" type="numeric" maxlength="11"
                                                placeholder="888.888.888-88"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="8" name="cpf" required="required">
                                        </div>
                                        <div class="col-md-2 col-sm-12">Tipo Programa
                                            <select class="form-select" id="9" name="tp_programa"
                                                value="{{ old('tp_programa') }}" required="required">
                                                <option value=""></option>
                                                @foreach ($programa as $programas)
                                                    <option value="{{ $programas->id }}">{{ $programas->programa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12">Nr PIS ou PASEP
                                            <input class="form-control" maxlength="11" type="numeric" id="10"
                                                name="nr_programa" value="{{ old('nr_programa') }}" required="required">
                                        </div>
                                        <div class="col-md-4 col-sm-12">Identidade
                                            <input class="form-control" maxlength="11" type="numeric" id="11"
                                                name="identidade" value="{{ old('identidade') }}" required="required">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">UF
                                            <select class="js-example-responsive form-select" id="uf-idt"
                                                name="uf_idt" value="{{ old('uf_idt') }}" required="required">
                                                <option value=""></option>
                                                @foreach ($tp_uf as $tp_ufs)
                                                    <option value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Órgão expedidor
                                            <select class="form-select" required="required" id="12"
                                                name="orgexp" value="{{ old('orgexp') }}" required="required">
                                                <option value=""></option>
                                                <@foreach ($org_exp as $org_exps)
                                                    <option value="{{ $org_exps->id }}">{{ $org_exps->sigla }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Data emissão
                                            <input class="form-control" type="date" id="13" name="dt_idt"
                                                value="{{ old('dt_idt') }}" required="required">
                                        </div>
                                        <div class="col-md-2 col-sm-12">Cor pele
                                            <select class="form-select" id="14" name="cor"
                                                value="{{ old('cor') }}" required="required">
                                                <option value=""></option>
                                                <@foreach ($cor as $cors)
                                                    <option value="{{ $cors->id }}">{{ $cors->nome_cor }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Tipo sangue
                                            <select class="form-select" id="15" name="tps"
                                                value="{{ old('tps') }}" required="required">
                                                <option value=""></option>
                                                <@foreach ($sangue as $sangues)
                                                    <option value="{{ $sangues->id }}">{{ $sangues->nome_sangue }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Fator RH
                                            <select class="form-select" id="16" name="frh"
                                                value="{{ old('frh') }}" required="required">
                                                <option value=""></option>
                                                <@foreach ($fator as $fators)
                                                    <option value="{{ $fators->id }}">{{ $fators->nome_fator }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">Título eleitor
                                            <input class="form-control" maxlength="12" type="numeric" id="17"
                                                name="titele" value="{{ old('titele') }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12">Zona
                                            <input class="form-control" maxlength="5" type="numeric" id="18"
                                                name="zona" value="{{ old('zona') }}">
                                        </div>
                                        <div class="col-md-1 col-sm-12">Seção
                                            <input class="form-control" maxlength="5" type="numeric" id="19"
                                                name="secao" value="{{ old('secao') }}">
                                        </div>
                                        <div class="col-md-3 col-sm-12">Data emissão
                                            <input class="form-control" type="date" id="20" name="dt_titulo"
                                                value="{{ old('dt_titulo') }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12">DDD
                                            <select class="form-select" id="16" name="ddd"
                                                required="required">
                                                <option value=""></option>
                                                <@foreach ($ddd as $ddds)
                                                    <option value="{{ $ddds->id }}">{{ $ddds->descricao }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Celular
                                            <input class="form-control" maxlength="9" type="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                placeholder="Ex.: 99999-9999" value="{{ old('celular') }}"
                                                id="22" name="celular">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">CTPS
                                            <input class="form-control" maxlength="8" type="numeric" id="23"
                                                name="ctps" value="{{ old('ctps') }}" required="required">
                                        </div>
                                        <div class="col-md-2 col-sm-12">Série
                                            <input class="form-control" maxlength="5" type="numeric" id="26"
                                                name="serie_ctps" value="{{ old('serie_ctps') }}" required="required">
                                        </div>
                                        <div class="col-md-2 col-sm-12">UF
                                            <select class="js-example-responsive form-select" required="required"
                                                id="uf_ctps" name="uf_ctps" value="{{ old('uf_tps') }}"
                                                required="required">
                                                <option value=""></option>
                                                @foreach ($tp_uf as $tp_ufs)
                                                    <option value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12">Data emissão
                                            <input class="form-control" type="date" id="24" name="dt_ctps"
                                                value="{{ old('dt_ctps') }}" required="required">
                                        </div>
                                        <div class="col-md-3 col-sm-12">Reservista
                                            <input class="form-control" maxlength="12" type="numeric" id="28"
                                                name="reservista" value="{{ old('reservista') }}">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12">Nome mãe
                                            <input class="form-control" type="text" maxlength="45"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="29" name="nome_mae" value="{{ old('nome_mae') }}"
                                                required="required">
                                        </div>
                                        <div class="col-md-5 col-sm-12">Nome pai
                                            <input class="form-control" type="text" maxlength="45"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="30" name="nome_pai" value="{{ old('nome_pai') }}"
                                                required="required">
                                        </div>
                                        <div class="col-md-2 col-sm-12">Cat CNH
                                            <select class="form-select" id="32" name="cnh"
                                                value="{{ old('cnh') }}">
                                                <option value=""></option>
                                                @foreach ($cnh as $cnhs)
                                                    <option value="{{ $cnhs->id }}">{{ $cnhs->nome_cat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">e-mail
                                            <input class="form-control" maxlength="45" type="email" id="31"
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>


                            <br>
                            <legend style="color:rgb(16, 19, 241); font-size:15px;">Dados Residenciais</legend>
                            <fieldset class="border rounded border-primary p-2">


                                <div class="row">
                                    <div class="col">CEP
                                        <input class="form-control" maxlength="8" type="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            id="35" name="cep" value="{{ old('cep') }}">
                                    </div>
                                    <div class="col">UF
                                        <br>
                                        <select class="js-example-responsive form-select" id="iduf"name="uf_end"
                                            value="{{ old('uf_end') }}">
                                            <option value=""></option>
                                            @foreach ($tp_uf as $tp_ufs)
                                                <option value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">Cidade
                                        <br>
                                        <select class="js-example-responsive form-select" id="idcidade" name="cidade"
                                            value="{{ old('cidade') }}" disabled>


                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Logradouro
                                        <input class="form-control" maxlength="45" type="text" id="36"
                                            name="logradouro" value="{{ old('logradouro') }}">
                                    </div>
                                    <div class="col-2">Número
                                        <input class="form-control" maxlength="10" type="text" id="35"
                                            name="numero" value="{{ old('numero') }}">
                                    </div>
                                    <div class="col">Complemento
                                        <input type="text" maxlength="45" class="form-control" id="36"
                                            name="comple" value="{{ old('comple') }}">
                                    </div>
                                    <div class="col">Bairro:
                                        <input type="text" maxlength="45" class="form-control" id="36"
                                            name="bairro" value="{{ old('bairro') }}">
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
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
        $(document).ready(function() {

            $('#idcidade').select2({
                theme: 'bootstrap-5',
                width: '100%',
            });
            $('#cidade1').select2({
                theme: 'bootstrap-5',
                width: '100%'
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
            $('#uf1').change(function(e) {
                var uf = $(this).val();
                $('#cidade1').removeAttr('disabled');
                $.ajax({
                    type: "get",
                    url: "/retorna-cidade-dados-residenciais/" + uf,
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(indexInArray, item) {
                            $('#cidade1').append('<option value = ' + item.id_cidade +
                                '>' + item.descricao + '</option>');
                        });
                    }
                });

            });

        });
    </script>
@endsection
