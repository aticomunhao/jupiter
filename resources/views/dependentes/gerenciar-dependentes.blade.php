@extends('layouts.app')

<title>Gerenciar Dependentes</title>

@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color: #5C7CB6;">
            <div class="card-header">
                Gerenciar dependentes
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <fieldset
                            style="border: 1px solid #c0c0c0; border-radius: 3px; padding: 7 10 7 10; background-color: #ebebeb;">
                            {{ $funcionario->nome_completo }}</fieldset>
                    </div>
                    <div class="col-6">
                        <div class="col-6 offset-7">
                            <a href="/incluir-dependentes/{{ $funcionario->id }}" class="col-6"><button type="button"
                                    class="btn btn-success col-8">Novo</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
            <hr />
            <div class="container-fluid table-responsive">
                <div class="table">
                    <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;">

                            <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                <th class="col-2">Parentesco</th>
                                <th class="col-4">Nome</th>
                                <th class="col-2">Data de Nascimento</th>
                                <th class="col-2">CPF</th>
                                <th class="col-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color:#000000;">
                            @foreach ($dependentes as $dependente)
                                {{--  Foreach gera a tabela  --}}
                                <tr>
                                    <td scope="">{{ $dependente->nome }}</td>{{--  Parentesco  --}}
                                    <td scope="">{{ $dependente->nome_dependente }}</td>{{--  Nome  --}}
                                    <td scope="">{{--  Data de nascimento  --}}
                                        {{ \Carbon\Carbon::parse($dependente->dt_nascimento)->format('d/m/Y') }}</td>
                                    <td scope="" id="cpf">{{ $dependente->cpf }}</td>{{--  CPF  --}}
                                    <td> {{--  Área de ações  --}}
                                        <center>
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

                                            <a href="/editar-dependentes/{{ $dependente->id }}">{{--  Botão editar  --}}
                                                <button class="btn btn-outline-warning"><i
                                                        class="bi bi-pencil"></i></button>

                                            </a>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </fieldset>
    </div>
@endsection
