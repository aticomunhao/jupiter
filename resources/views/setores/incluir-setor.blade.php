@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
    </div>
    <legend></legend>

        <form method = 'POST' action = "/incluir-setores">

                @csrf

                <div class="form-group row" style = "display:flex;
                justify-content:space-between center width: 60%;">
                <div class="form-group col-md-4">
                    <label for="1">Setor</label>
                    <input class="form-control" name= "nome" maxlength="60"  maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  id="1" value ="" >
                </div>
                    <div class="form-group col-md-2" style="padding-right:80px">
                        <label for="2">Sigla</label>
                        <input type="text" class="form-control" name = "sigla"   maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value ="" >
                    </div>



                <div class="form-group row" style = "display:flex;
                justify-content:space-between center">

                <div class="form-group col-md-2" style="padding-right:45px">
                    <label for="2">Subsetor</label>
                    <input type="text" class="form-control" name = "nome_subsetor"   maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value ="" >
                </div>
                <div class="form-group col-md-2" style="padding-right:70px">
                    <label for="3">Data de Inicio</label>
                    <input type="date" class="form-control" name = "dt_inicio" id = "3" value ="" >
                </div>
                    <div class="form-group col-md-2" style="padding-right:70px">
                        <label for="4">Data Final</label>
                        <input type="date" class="form-control" name = "dt_fim" id = "4" value ="" >
                    </div>
                    <div class="form-group row" style = "display:flex;
                    justify-content:space-between; width: 100%;">
                    <div class="form-group col-md-6" style="padding-right: 5%">
                        <label for="2">Usuário</label>
                        <input type="text" class="form-control" name = "usuario"   maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="2" value ="" >

                    <br>

            <a href="/gerenciar-setor" type = "button" value = "" class="btn btn-danger">Cancelar</a>
            <input type ="submit" value = "Confirmar" class="btn btn-primary">
            </form>


@endsection
