@extends('layouts.app')


@section('content')
<br>

<div class="container">

    <div class="card">
        <div class="card-header">
            <div class="row" action="{{route('gerenciar')}}" method="GET">>
                <div class="col-2">
                    <label for="1">Nivel</label>
                    <select id="1" class="form-select" name="nivel" value="{{$nome_nivel}}" type="text">
                       <option></option> 
                        @foreach($nivel as $niveis)
                        <option value="{{$niveis->id_nivel}}">{{$niveis->nome_nivel}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <label for="1">Setor</label>
                    <select id="2" class="form-select" name="setor" type="text" value="{{$nome_setor}}">
                    <option></option>     
                    @foreach($setor as $setores)
                        <option value="{{$setores->id_setor}}">{{$setores->nome_setor}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col">
                    <a href="" type="button" value="" class="btn btn-danger">Cancelar</a>
                    <a href="" type="button" class="btn btn-primary" value="">Limpar</a>
                    <input type="submit" value="Confirmar" class="btn btn-primary">
                </div>
            </div>
            <div class="card-body">
                </div   border-radius: 5px;>
            <div class="border border-primary" style=" border-radius: 5px;">
                <h5 class="card-title">Hierarquia de Setores</h5>
               
                <div class="row">
                    <div class="col-2">
                        <label for="3">ordenar</label>
                        <select id="3" class="form-select" name="nivel" type="text">
                            <option></option>
                        </select>
                    </div>
                            <div class="col-2">
                                <label for="4">Data de Inicio</label>
                                <input type="date" class="form-control" name="dt_inicio" id="4" value="">
                            </div>
                            <div class="col-2">
                                <label for="5">Nivel</label>
                                <input id="5" type="select" class="form-control">
                                
                            </div>
                            <div class="col">
                            <a href="" type="button" class="btn btn-primary" value="">Confirmar</a>
                            </div>
                <hr>    
                </div>
                                <div class="table">
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center;">
                        <tr style="background-color: #365699; font-size:19px; color:#ffffff">
                            <th class="col-2">Nome</th>
                            <th class="col-1">Sigla</th>
                            <th class="col-1">Data Inicio</th>
                            <th class="col-1">Status</th>
                            <th class="col-1">Substituto</th>

                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">
                        <tr>
                          
                                <td scope="">
                                    <center></center>
                                </td>
                                <td scope="">
                                    <center></center>
                                </td>
                                <td scope="">
                                    <center></center>
                                </td>
                                <td scope="">
                                    <center></center>
                                </td>
                                <td scope="">
                                    <center></center>
                                </td>

              </div>
            </div>
        </div>

            @endsection