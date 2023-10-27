@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="row justify-content-center">
            <form action="{{route('gerenciar')}}" class="form-horizontal mt-4" method="GET">
            <div class="row">
                <div class="col-2">Funcionário
                    <input class="form-control" maxlength="11" type="text" id="1" name="usuario">
                </div>
                <div class="col-2">Nome
                    <input class="form-control" maxlength="9" type="text" id="2" name="nome">
                </div>
                <div class="col-3">Sigla
                    <input class="form-control" maxlength="50" type="text" id="3" name="sigla">
                </div>
                <div class="col"><br>
                    <input class="btn btn-light btn-sm" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit" value="Pesquisar">

                    <a href=""><button class="btn btn-primary" type="button" value="" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;" >Limpar</button></a>
                </form>
                <a href=""><input class="btn btn-danger" type="button" name="6" value="Cancelar" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"></a>
                    <a href=""><input class="btn btn-success btn-sm" type="button" name="6" value="Novo Cadastro +" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"></a>

                </div>
            </div>
        </div>
    <hr>
    <div class="table">
        <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
            <thead style="text-align: center;">
                <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                    <th class="col-1">Setor</th>
                    <th class="col-1">Sigla</th>
                    <th class="col-4">Dt_inicio</th>
                    <th class="col-1">Dt_final</th>
                    <th class="col-4">Ações</th>
                </tr>
            </thead>
            <tbody style="font-size: 14px; color:#000000;">
                <tr>
                    @foreach ($lista as $listas)
                        <td scope="">{{$listas->setor}}</td>
                        <td scope="">{{$listas->sigla}}</td>
                        <td scope="">{{$listas->dt_incio}}</td>
                        <td scope="">{{$listas->dt_fim}}</td>
                        <td scope="">{{$listas->usuario}}</td>
                    @endforeach
    @endsection
