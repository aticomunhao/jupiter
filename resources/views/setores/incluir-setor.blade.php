@extends('layouts.app')


@section('content')
<br>

<div class="container">


    <div class="card">
        <div class="card-header">
            Criar Setor
        </div>
        <div class="card-body">

            <p class="card-text">
            <form method='POST' action="/incluir-setores">

                @csrf

                <div class="row">
                    <div class="col-5 ">
                        <label for="1">Nome</label>
                        <input type="text" class="form-control" id="1" name="nome_setor" value="{{ old('nome_setor') }}">
                    </div>
                    <div class="col-2">
                        <label for="2">Sigla</label>
                        <input type="text" class="form-control" id="2" name="sigla" value="{{ old('sigla') }}">
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-2">
                            <label for="3">Nivel</label>
                            <select class="form-select" name="nivel" id="3" value="{{ old('niv') }}">
                                <value="">
                                    <option value=""></option>
                                    @foreach ($nivel as $niveis)
                                    <option value="{{ $niveis->idset }}">{{ $niveis->nome}}</option>
                                    @endforeach

                            </select>
                        </div>

                        <div class="col-2 offset-3">
                            <label for="4">Data de Inicio</label>
                            <input type="date" class="form-control" name="dt_inicio" id="4">
                        </div>
                    </div>




        </div>
    </div>
</div>
<a href="/gerenciar-setor" class="btn btn-danger">Cancelar</a>
<button type = "submit" class="btn btn-primary offset-5">Confirmar</button>
</form>

@endsection