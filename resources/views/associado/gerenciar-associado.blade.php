@extends('layouts.app')

@section('content')
<div class="container-fluid">
     <div class="card">
        <div class="card-header">
            Gerenciar Associado
        </div>
        <div class="card-body">
          <form action="{{route('pesquisar')}}" class="form-horizontal mt-4" method="GET">
            <div class="row" style="padding-left:5%">
                <div class="col-1">Nr Associado
                    <input class="form-control" maxlength="50" type="text" id="2" name="nr_associado" value="{{$nr_associado}}">
                </div>
                <div class="col-3">Nome
                    <input class="form-control" maxlength="30" type="text" id="3" name="nome_completo" value="{{$nome_completo}}">
                </div>
                <div class="col-1">Data de Início
                    <input class="form-control" maxlength="30" type="date" id="3" name="dt_inicio" value="{{$dt_inicio}}">
                </div>
                <div class="col-1">Data de Fim
                    <input class="form-control" maxlength="30" type="date" id="3" name="dt_fim" value="{{$dt_fim}}">
                </div>
                <div class="col-1">Status   
                <select class="form-select" id="4" name="status" type="number">
                                <option value="">Todos</option>
                                <option value="1">Ativo</option>
                                <option value="2">Inativo</option>
                            </select>
                </div>
                <div class="col" style="padding-left:20%"><br>
                    <input class="btn btn-light btn-sm" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit" value="Pesquisar">

                    <a href="/gerenciar-associado"><button class="btn btn-light btn-sm" type="button" value="" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Limpar</button></a>
                    </form>

                    <a href="/informar-dados-associado"><input class="btn btn-success btn-sm" type="button" name="6" value="Novo Cadastro +" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"></a>

                </div>
            </div>
        </div>
        <hr>
        <div class="table">
            <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                <thead style="text-align: center;">
                    <tr style="background-color: #365699; font-size:19px; color:#ffffff">
                        <th class="col-1">Nr associado</th>
                        <th class="col-3">Nome</th>
                        <th class="col-1">Voluntário</th>
                        <th class="col-1">Votante</th>
                        <th class="col-1">Data Inicio</th>
                        <th class="col-1">Data Final</th>
                        <th class="col-1">Status</th>
                        <th class="col-2">Ações</th>

                    </tr>
                </thead>
                <tbody style="font-size: 16px; color:#000000;">
                    
                    @foreach ($lista_associado as $lista_associados)
                    <tr>    
                        <td scope="">
                            <center>{{ $lista_associados->nr_associado }}</center>
                        </td>
                        <td scope="">
                            <center>{{ $lista_associados->nome_completo }}</center>
                        </td>
                        <td scope="">
                            <center></center>
                        </td>
                       <td scope="">
                            <center></center>
                        </td>
                        <td scope="">
                            <center>{{ $lista_associados->dt_inicio }}</center>
                        </td>
                        <td scope="">
                            <center>{{ $lista_associados->dt_fim }}</center>
                        </td>
                        <td scope="">
                            <center>{{ $lista_associados->status}}</center>
                        </td>

                        <td scope="">
                            <center>

                                <a href="/editar-associado/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-warning btn-sm"><i class="bi-pencil" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href="/capture-photo/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi-search" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href=""><button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-archive" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href="/gerenciar-dados_bancarios/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi bi-currency-dollar" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="" class="btn btn-outline-danger btn-sm"><i class="bi-trash" style="font-size: 1rem; color:#303030;"></i></button>
                        </td>
                        
                    </tr>
                        @endforeach

                </tbody>

                        @endsection