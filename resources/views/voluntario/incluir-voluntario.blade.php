@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <form class="form-horizontal mt-4" method="POST" action="/cad-voluntario/inserir">
                @csrf
                    <div class="form-group row">
                        <div class="col">Matrícula
                            <input class="form-control" required="required" type="numeric" id="1" name="matricula">
                        </div>
                        <div class="col">Nome completo
                            <input class="form-control" required="required" type="text" id="2" name="nome">
                        </div>
                        <div class="col">Data nasicmento
                            <input class="form-control" type="date" value="" id="3" name="dt_nascimento">
                        </div>
                        <div class="col">Sexo
                            <select class="form-control select2" required="required"  id="4" name="sexo">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">Nacionalidade
                            <select class="form-control select2" required="required"  id="4" name="sexo">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">UF
                            <select class="form-control select2" required="required"  id="4" name="sexo">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">Naturalidade
                            <select class="form-control select2" required="required"  id="4" name="sexo">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">CPF
                            <input id="5" type="numeric" class="form-control mascara_cpf @error('cpf') is-invalid @enderror" name="cpf" placeholder="Ex.: 000.000.000-00"  value="">
                            @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col">PIS/PASEP
                            <input class="form-control" maxlength="11" type="numeric" value="" id="6" name="identidade">
                        </div>
                    <div class="form-group row">
                        <div class="col">Identidade
                            <input class="form-control" maxlength="11" type="numeric" value="" id="7" name="identidade">
                        </div>
                        <div class="col">Órgão expedidor
                            <select class="form-control select2" required="required"  id="8" name="orgexp">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">Data emissão
                            <input class="form-control" type="date" value="" id="9" name="dt_idt">
                        </div>
                        <div class="col">Cor pele
                            <select class="form-control select2" required="required"  id="8" name="orgexp">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">Tipo sangue
                            <select class="form-control select2" required="required"  id="8" name="orgexp">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                    <div class="form-group row">
                        <div class="col">Título eleitor
                            <input class="form-control" maxlength="11" type="numeric" value="" id="9" name="titele">
                        </div>
                        <div class="col">Zona
                            <input class="form-control" maxlength="2" type="numeric" value="" id="10" name="zona">
                        </div><div class="col">Seção
                            <input class="form-control" maxlength="3" type="numeric" value="" id=11 name="secao">
                        </div>
                        <div class="col">Data emissão
                            <input class="form-control" type="date" value="" id="12" name="dt_titulo">
                        </div>
                        <div class="col">DD
                            <input class="form-control mascara_ddd" placeholder="Ex.: (99)" type="numeric" value="" id="13" name="ddd">
                        </div>
                        <div class="col">Celular
                            <input class="form-control mascara_celular" placeholder="Ex.: (99) 99999-9999" type="text" value="" id="14" name="celular">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">CTPS
                            <input class="form-control" maxlength="20" type="numeric" value="" id="15" name="ctps">
                        </div>
                        <div class="col">Data emissão
                            <input class="form-control" type="date" value="" id="16" name="dt_ctps">
                        </div>
                        <div class="col">Série
                            <input class="form-control" maxlength="20" type="numeric" value="" id="17" name="serie_ctps">
                        </div>
                        <div class="col">UF
                            <select class="form-control select2" required="required"  id="18" name="uf_ctps">
                                <option value="">Selecione</option>
                                <!--@foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">Reservista
                            <input class="form-control" maxlength="20" type="numeric" value="" id="19" name="reservista">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">Nome mãe
                            <input class="form-control" required="required" type="text" id="20" name="nome_mae">
                        </div>
                        <div class="col">Nome pai
                            <input class="form-control" required="required" type="text" id="21" name="nome_pai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">e-mail
                            <input class="form-control" type="email" value="" id="22" name="email">
                        </div>
                        <div class="col">Cat CNH
                            <select class="form-control select2" id="23" name="cnh">
                                <option value="">Selecione</option>
                                @foreach($lista1 as $lista1s)
                                <option value="{{$lista1s->id}}">{{$lista1s->tipo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>

                    <h4 class="card-title" style="color: rgb(255, 0, 0);">Endereço</h4>
                    <br>


                    <div class="row mt-10">
                        <div class="col-md-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="numeric" class="form-control cep-mask"  id="24" name="cep" placeholder="Ex.:00000-000">
                        </div>
                        <div class="col-md-4">
                            <label for="logradouro" class="form-label">Logradouro</label>
                            <input type="text" class="form-control" id="28" name="logradouro">
                        </div>
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Número</label>
                            <input type="numeric" class="form-control" id="29" name="numero">
                        </div>
                        <div class="col-md-4">
                            <label for="apartamento" class="form-label">Apartamento</label>
                            <input type="numeric" class="form-control" id="26" name="apart">
                        </div>
                        <div class="col-md-4">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="27" name="bairro">
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="25" name="estado">
                        </div>
                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="25" name="cidade">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3" style="text-align: right;">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                            <a href="/gerenciar-pessoa">
                                <input class="btn btn-danger" type="button" value="Limpar">
                            </a>
                        </div>
                </form>

        </div>
    </div>
</div>
@endsection
