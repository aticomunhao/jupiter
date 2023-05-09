@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <form class="form-horizontal mt-4" method="POST" action="/cad-funcionario/inserir">
                @csrf
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Dados básicos
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="form-group row">
                                    <div class="col-1">Matrícula
                                        <input  class="form-control" type="numeric" id="1" name="matricula" required="required" >
                                    </div>
                                    <div class="col">Nome completo
                                        <input class="form-control"  type="text" id="2" name="nome" value="" required="required">
                                    </div>
                                    <div class="col-2">Data nascimento
                                        <input class="form-control" type="date" value="" id="3" name="dt_nascimento" required="required">
                                    </div>
                                    <div class="col-2">Sexo
                                        <select class="form-select" id="4" name="sexo" required="required">
                                            <option value=""></option>
                                            @foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br>
                                <div class="form-group row">
                                    <div class="col">Nacionalidade
                                    <select class="form-select" id="4" name="nacionalidade" required="required">
                                        <option value=""></option>
                                        @foreach($lista1 as $lista1s)
                                        <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-1">UF
                                        <select class="form-select"   id="6" name="uf_nac" required="required">
                                            <option value=""></option>
                                            @foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">Naturalidade
                                        <select class="form-select" id="7" name="sexo" required="required"  >
                                            <option value=""></option>
                                            @foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">CPF
                                        <input  type="numeric" class="form-control mascara_cpf @error('cpf') is-invalid @enderror"  placeholder="Ex.: 000.000.000-00"  value="" id="8" name="cpf" required="required">
                                        @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col">PIS/PASEP
                                        <input class="form-control" maxlength="11" type="numeric" value="" id="9" name="identidade" required="required">
                                    </div>
                                </div>
                                    <br>
                                <div class="form-group row">
                                    <div class="col">Identidade
                                        <input class="form-control" maxlength="11" type="numeric" value="" id="10" name="identidade" required="required">
                                    </div>
                                    <div class="col">Órgão expedidor
                                        <select class="form-select" required="required"  id="11" name="orgexp" required="required">
                                            <option value=""></option>
                                            <@foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">Data emissão
                                        <input class="form-control" type="date" value="" id="12" name="dt_idt" required="required">
                                    </div>
                                    <div class="col-2">Cor pele
                                        <select class="form-select" id="13" name="cor" required="required">
                                            <option value=""></option>
                                            <@foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">Tipo sangue
                                        <select class="form-select" id="14" name="tps" required="required">
                                            <option value=""></option>
                                            <@foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">Fator RH
                                        <select class="form-select" id="14" name="frh" required="required">
                                            <option value=""></option>
                                            <@foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <br>
                                <div class="form-group row">
                                    <div class="col">Título eleitor
                                        <input class="form-control" maxlength="11" type="numeric" value="" id="15" name="titele">
                                    </div>
                                    <div class="col-1">Zona
                                        <input class="form-control" maxlength="2" type="numeric" value="" id="16" name="zona">
                                    </div><div class="col-1">Seção
                                        <input class="form-control" maxlength="3" type="numeric" value="" id="17" name="secao">
                                    </div>
                                    <div class="col-2">Data emissão
                                        <input class="form-control" type="date" value="" id="18" name="dt_titulo">
                                    </div>
                                    <div class="col-1">DD
                                        <input class="form-control mascara_ddd" placeholder="Ex.: (99)" type="numeric" value="" id="19" name="ddd">
                                    </div>
                                    <div class="col-2">Celular
                                        <input class="form-control mascara_celular" placeholder="Ex.: 99999-9999" type="text" value="" id="20" name="celular">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col">CTPS
                                        <input class="form-control" maxlength="20" type="numeric" value="" id="21" name="ctps" required="required">
                                    </div>
                                    <div class="col-2">Data emissão
                                        <input class="form-control" type="date" value="" id="22" name="dt_ctps" required="required">
                                    </div>
                                    <div class="col">Série
                                        <input class="form-control" maxlength="20" type="numeric" value="" id="23" name="serie_ctps" required="required">
                                    </div>
                                    <div class="col-1">UF
                                        <select class="form-select" required="required"  id="24" name="uf_ctps" required="required">
                                            <option value=""></option>
                                            @foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">Reservista
                                        <input class="form-control" maxlength="20" type="numeric" value="" id="25" name="reservista">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col">Nome mãe
                                        <input class="form-control" required="required" type="text" id="26" name="nome_mae" required="required">
                                    </div>
                                    <div class="col">Nome pai
                                        <input class="form-control" required="required" type="text" id="27" name="nome_pai">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col">e-mail
                                        <input class="form-control" type="email" value="" id="28" name="email">
                                    </div>
                                    <div class="col-2">Cat CNH
                                        <select class="form-select" id="29" name="cnh">
                                            <option value=""></option>
                                            @foreach($lista1 as $lista1s)
                                            <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            Endereço:
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">
                                    <div class="row mt-10">
                                        <div class="col-2">CEP
                                            <select class="form-select" id="30" name="cep">
                                                <option value=""></option>
                                                @foreach($lista1 as $lista1s)
                                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">Logradouro
                                            <input class="form-control" type="text" id="31" name="logradouro">
                                        </div>
                                        <div class="col-2">Número
                                            <input class="form-control" type="numeric"  id="32" name="numero">
                                        </div>
                                        <div class="col-2">Apartamento
                                            <input type="numeric" class="form-control" id="33" name="apart">
                                        </div>
                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-1">UF
                                            <select class="form-select" id="34" name="uf">
                                                <option value=""></option>
                                                @foreach($lista1 as $lista1s)
                                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">Cidade
                                            <select class="form-select" id="35" name="cidade">
                                                <option value=""></option>
                                                @foreach($lista1 as $lista1s)
                                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5">Bairro
                                            <select class="form-select" id="36" name="bairro">
                                                <option value=""></option>
                                                @foreach($lista1 as $lista1s)
                                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3" style="text-align: right;">
                    <a href="/gerenciar-pessoa">
                        <input class="btn btn-danger" type="button" value="Limpar">
                    </a>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
  {{--        <label for="exampleDataList" class="form-label"></label>
                            <input class="form-control" list="datalistOptions"  id="datalistOptions" name="datalistOptions"  placeholder="Type to search..." required="required">
                                <datalist id="datalistOptions">
                                <option value="">Selecione</option>
                                @foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach
                                </datalist>--}}
