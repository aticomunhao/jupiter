@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
    </div>
    <legend></legend>

    <form method='POST' action="/atualizar-setor/{{$editar[0]->ids}}">

        @csrf

        <div class="form-group row" style="display:flex;
                justify-content:space-between center width: 60%;">
            <div class="form-group col-md-4">
                <label for="1">Setor</label>
                <input class="form-control" name="nome" maxlength="60" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="1" value="{{$editar[0]->nome}}">
            </div>
            <div class="form-group col-md-2" style="padding-right:80px">
                <label for="2">Sigla</label>
                <input type="text" class="form-control" name="sigla" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value="{{$editar[0]->sigla}}">
            </div>



            <div class="form-group row" style="display:flex;
                justify-content:space-between center">

                <div class="form-group col-md-2" style="padding-right:70px">
                    <label for="3">Data de Inicio</label>
                    <input type="date" class="form-control" name="dt_inicio" id="3" value="{{$editar[0]->dt_inicio}}">
                </div>
                <div class="form-group col-md-2" style="padding-right:70px">
                    <label for="4">Data Final</label>
                    <input type="date" class="form-control" name="dt_fim" id="4" value="{{$editar[0]->dt_fim}}">
                </div>

                <div class="row">
                    <div class="col-2">
                        <label for="3">Nivel</label>
                        <select class="form-select" name="nivel" id="3">
                            <option value="{{ $editar[0]->id_nivel }}">{{$editar[0]->nome_nivel }}</option>
                            @foreach ($nivel as $niveis)
                            <option value="{{ $niveis->idset }}">{{ $niveis->nome}}</option>
                            @endforeach

                        </select>
                    </div>

                    <a href="/gerenciar-setor" type="button" value="" class="btn btn-danger">Cancelar</a>
                    <input type="submit" value="Confirmar" class="btn btn-primary">
    </form>

    @endsection