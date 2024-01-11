@extends('layouts.app')
@section('head')
    <title>Cadastrar Funcionário</title>
@endsection
@section('content')
    <br />
    <div class="container"> {{-- Container completo da página  --}}
        <div class="card" style="border-color: #5C7CB6;">
            <div class="card-header">
                Gerenciar dependentes
            </div>
            <div class="card-body">
                <div class="row"> {{-- Linha com o nome e botão novo --}}
                    <div class="col-md-6 col-12">
                        <fieldset {{-- Gera a barra ao redor do nome do funcionario --}}
                            style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 7px; padding-left: 10px; background-color: #ebebeb;">
                            {{ $funcionario->nome_completo }}</fieldset>
                    </div>
                    <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                        <a href="/incluir-dependentes/{{ $funcionario->id }}" class="col-6"><button type="button"
                                class="btn btn-success col-md-8 col-12">Novo+</button></a>
                    </div>
                </div>
            </div>
            <hr />
            <div class="container-fluid table-responsive"> {{-- Faz com que a tabela não grude nas bordas --}}
                <div class="table">
                    <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;"> {{-- Text-align gera responsividade abaixo de Large --}}
                            <tr class="align-middle" style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                <th class="col-2">Parentesco</th>
                                <th class="col-4">Nome</th>
                                <th class="col-2">Data de Nascimento</th>
                                <th class="col-2">CPF</th>
                                <th class="col-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color:#000000;">
                            @foreach ($dependentes as $dependente)
                                <tr>
                                    <td>{{ $dependente->nome }}</td>{{--  Parentesco  --}}
                                    <td>{{ $dependente->nome_dependente }}</td>{{--  Nome  --}}
                                    <td>{{--  Data de nascimento  --}}
                                        {{ \Carbon\Carbon::parse($dependente->dt_nascimento)->format('d/m/Y') }}</td>
                                    <td id="cpf">{{ $dependente->cpf }}</td>{{--  CPF  --}}
                                    <td> {{--  Área de ações  --}}
                                        <center>
                                            <a href="/editar-dependentes/{{ $dependente->id }}"
                                                class="btn btn-outline-warning">{{--  Botão editar  --}}
                                                <i class="bi bi-pencil"></i></a>
                                            <button class="btn btn-outline-danger" {{-- Botão que aciona o modal  --}}
                                                data-bs-toggle="modal"
                                                data-bs-target="#A{{ $dependente->dt_nascimento }}-{{ $dependente->id }}">
                                                <i class="bi bi-trash"></i></button>
                                            <div class="modal fade"{{--  Modal  --}}
                                                id="A{{ $dependente->dt_nascimento }}-{{ $dependente->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color:rgba(202, 61, 61, 0.911);">
                                                            <div class="row">
                                                                <h2 style="color:white;">Excluir Dependente</h2>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="color:#e24444;">
                                                            <br />
                                                            <p class="fw-bold alert  text-center">Você
                                                                realmente deseja excluir
                                                                <br>
                                                                <span class="fw-bolder fs-5">
                                                                    {{ $dependente->nome_dependente }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer  ">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar
                                                            </button>
                                                            <a href="/deletar-dependentes/{{ $dependente->id }}">
                                                                <button type="button" class="btn btn-danger">Excluir
                                                                    permanentemente
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </fieldset>
    </div>
@endsection
