@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="form-horizontal mt-4" method="POST" action="/cad-funcionario/inserir">
                @csrf
                    <div class="form-group row">

                        <div class="col">NOME*
                            <input class="form-control" required="required" type="text" id="nome" name="nome">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">IDENTIDADE
                            <input class="form-control" maxlength="11" type="text" value="" id="identidade" name="identidade">
                        </div>

                        <div class="col">CPF
                            <input id="cpf" type="numeric" class="form-control mascara_cpf @error('cpf') is-invalid @enderror" name="cpf" placeholder="Ex.: 000.000.000-00"  value="">
                            @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col">GÊNERO*
                            <select class="form-control select2" required="required"  id="genero" name="genero">
                                <option value="">Selecione</option>
                                <!--@foreach($result as $results)
                                <option value="{{$results->pk_}}">{{$results->nome}}</option>
                                @endforeach-->
                            </select>
                        </div>
                        <div class="col">DATA NASCIMENTO
                            <input class="form-control" type="date" value="" id="dt_nascimento" name="dt_nascimento">
                        </div>

                        <div class="col">CELULAR
                            <input class="form-control mascara_celular" placeholder="Ex.: (99) 99999-9999" type="text" value="" id="celular" name="celular">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">E-MAIL
                            <input class="form-control" type="email" value="" id="emial" name="email">
                        </div>

                        <div class="col">ENTIDADE
                            <select class="form-control select2" id="entidade" name="entidade">
                                <option value="">Selecione</option>
                                @foreach($resultEntidade as $resultEntidades)
                                <option value="{{$resultEntidades->id}}">{{$resultEntidades->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h4 class="card-title" style="color: rgb(255, 0, 0);">ENDEREÇO</h4><hr>
                    <div class="row mt-10">
                        <div class="col-md-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep-mask"  id="cep" name="cep" placeholder="Ex.:00000-000">
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-4">
                            <label for="estado" class="form-label">ESTADO</label>
                            <input type="text" class="form-control" id="estado" name="estado">
                        </div>
                            <div class="col-md-4">
                            <label for="cidade" class="form-label">LOCALIDADE</label>
                            <input type="text" class="form-control" id="cidade" name="cidade">
                        </div>
                        <div class="col-md-4">
                            <label for="bairro" class="form-label">BAIRRO</label>
                            <input type="text" class="form-control" id="bairro" name="bairro">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="logradouro" class="form-label">LOGRADOURO</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro">
                        </div>
                        <div class="col-md-4">
                            <label for="numero" class="form-label">NÚMERO</label>
                            <input type="text" class="form-control" id="numero" name="numero">
                        </div>
                        <div class="col-md-4">
                            <label for="complemento" class="form-label">COMPLEMENTO</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                        </div>
                        <input type="hidden"  id="ibge" name="ibge" value="">
                        <input type="hidden"  id="gia" name="gia" value="">
                    </div>

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
