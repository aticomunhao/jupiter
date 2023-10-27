@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="row justify-content-center">
            <form action="{{route('gerenciar')}}" class="form-horizontal mt-4" method="GET">
            <div class="row"  style="padding-left:5%">
                <div class="col-2">Usuário
                    <input class="form-control" maxlength="11" type="text" id="1" name="usuario" value="{{$usuario}}">
                </div>
                <div class="col-3">Setor
                    <input class="form-control" maxlength="9" type="text" id="2" name="nome" value="{{$nome}}">
                </div>
                <div class="col-1">Sigla
                    <input class="form-control" maxlength="50" type="text" id="3" name="sigla" value="{{$lista[0]->sigla}}">
                </div>

                <div class="col" style="padding-left:20%"><br>
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
                <tr style="background-color: #365699; font-size:19px; color:#000000">
                    <th class="col-3">Setor</th>
                    <th class="col-1">Sigla</th>
                    <th class="col-1">Dt_inicio</th>
                    <th class="col-1">Dt_final</th>
                    <th class="col-4">Usuário</th>
                    <th class="col-2">Ações</th>

                </tr>
            </thead>
            <tbody style="font-size: 16px; color:#000000;">
                <tr>
                    @foreach ($lista as $listas)
                        <td scope="">{{$listas->nome}}</td>
                        <td scope=""><center>{{$listas->sigla}}</center></td>
                        <td scope=""><center>{{$listas->dt_inicio}}</center></td>
                        <td scope=""><center>{{$listas->dt_fim}}</center></td>
                        <td scope="">{{$listas->usuario}}</td>


                        <td scope="">

                            <a href=""><button type="button" class="btn btn-outline-warning btn-sm"><i class="bi-pencil" style="font-size: 1rem; color:#303030;"></i></button></a>
                            <a href=""><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi-search" style="font-size: 1rem; color:#303030;"></i></button></a>
                            <button type="button" class="btn btn-outline-primary btn-sm"><i class="bi-people-fill" style="font-size: 1rem;color:#303030; "></i></button></a>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" class="btn btn-outline-danger btn-sm"><i class="bi-trash" style="font-size: 1rem; color:#303030;"></i></button>


                            </td>



                    </td>
            </tr>

                </tr>
                @endforeach
    @endsection
