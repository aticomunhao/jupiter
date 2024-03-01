@extends('layouts.app')
@section('head')
<title>Gerenciar Dados Bancarios Associado</title>
@endsection
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<br />
<div class="container"> {{-- Container completo da página  --}}
    <div class="card" style="border-color: #5C7CB6;">
        <div class="card-header">
            Gerenciar Dados Bancarios Associado
        </div>
        <div class="card-body">
            <div class="row"> {{-- Linha com o nome e botão novo --}}
                <div class="col-md-4 col-10">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}} style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 30px; padding-left: 10px; background-color: #ebebeb;">
                    </fieldset>
                </div>
                <div class="col-md-1 col-6">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}} style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 30px; padding-left: 50px; background-color: #ebebeb;">
                    </fieldset>
                </div>
                <div class="col-md-3 offset-md-4 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                    <a href="/incluir-dados-bancarios/" class="col-6"><button type="button" class="btn btn-success col-md-8 col-12">+Novo Cadastro</button></a>
                </div>
            </div>
        </div>
        <hr />

        <div class="row d-flex justify-content-around">
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Tesouraria</h5>
                            <center>
                                <hr>
                                <div class="col-md-5 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Boleto Bancário</h5>
                            <center>
                                <hr>
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Autorização de Débito</h5>
                            <center>
                                <hr>
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Ações</h5>
                       
                        <hr>
                        <a href="/editar-associado/"><button type="button" class="btn btn-outline-warning btn-sm"><i class="bi-pencil" style="font-size: 1rem; color:#303030;"></i></button></a>
                        <a href=""><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi-search" style="font-size: 1rem; color:#303030;"></i></button></a>
                        <a href=""><button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-archive" style="font-size: 1rem; color:#303030;"></i></button></a>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="" class="btn btn-outline-danger btn-sm"><i class="bi-trash" style="font-size: 1rem; color:#303030;"></i></button>
                        </center>
                    </div>
               </div>
            </div>
        </div>
        <div class="row d-flex justify-content-start">
        <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Ultima Contribuição</h5>
                            <center>
                                <hr>
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Dia de Vencimento</h5>
                            <center>
                                <hr>
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">Valor</h5>
                            <center>
                                <hr>
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" name="">
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection