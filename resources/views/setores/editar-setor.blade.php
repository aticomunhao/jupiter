@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
    </div>
    <legend></legend>

        <form method = 'POST' action = "/atualizar-setor/{{$editar[0]->ids}}">

                @csrf

                <div class="form-group row" style = "display:flex;
                justify-content:space-between center width: 60%;">
                <div class="form-group col-md-4">
                    <label for="1">Setor</label>
                    <input class="form-control" name= "nome" maxlength="32"  maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  id="1" value ="{{$editar[0]->nome}}" >
                </div>
                    <div class="form-group col-md-2" style="padding-right:80px">
                        <label for="2">Sigla</label>
                        <input type="text" class="form-control" name = "sigla"   maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value ="{{$editar[0]->sigla}}" >
                    </div>



                <div class="form-group row" style = "display:flex;
                justify-content:space-between center">
                <div class="form-group col-md-2" style="padding-right:70px">
                    <label for="3">Data de Inicio</label>
                    <input type="date" class="form-control" name = "dt_inicio" id = "3" value ="{{$editar[0]->dt_inicio}}" >
                </div>
                    <div class="form-group col-md-2" style="padding-right:70px">
                        <label for="4">Data Final</label>
                        <input type="date" class="form-control" name = "dt_fim" id = "4" value ="{{$editar[0]->dt_fim}}" >
                    </div>
                    <div class="form-group row" style = "display:flex;
                    justify-content:space-between; width: 100%;">
                    <div class="form-group col-md-6" style="padding-right: 5%">
                        <label for="2">Nome Completo</label>
                        <input type="text" class="form-control" name = "nome_completo"   maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value ="{{$editar[0]->usuario}}" >

                    <br>

            <a href="/gerenciar-setor" type ="button" value = "" class="btn btn-danger">Cancelar</a>
            <input type ="submit" value= "Confirmar" class="btn btn-primary">
            </form>

@endsection
