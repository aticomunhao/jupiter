@extends('layouts.app')
@section('head')
    <title>Gerenciar Entidade de Ensino</title>
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Entidade de Ensino
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <style>

                        </style>
                        <form method="GET" action="/gerenciar-entidades-de-ensino">{{-- Formulario para o botao e input de pesquisa --}}
                            @csrf
                            <div class="row justify-content-start">
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" aria-label="Sizing example input"
                                        name="pesquisa" value= "{{ $pesquisa }}" maxlength="40">{{-- Input de pesquisa --}}
                                </div>
                                <div class="col-md-8 col-12">
                                    <button class="btn btn-secondary col-md-3 col-12 mt-5 mt-md-0 "
                                        type="submit">Pesquisar</button>{{-- Botao submit da pesquisa --}}
                                    <a href="/incluir-entidades-ensino"{{-- Botao com rota para incluir entidades --}}
                                        class="btn btn-success col-md-3 col-12 offset-md-5 mt-4 mt-md-0">
                                        Novo+
                                    </a>
                                </div>
                            </div>

                        </form>
                        <br>
                        <hr>
                        <table class="table  table-striped table-bordered border-secondary table-hover align-middle">
                            {{-- Tabela com todas as informacoes --}}
                            <thead style="text-align: center; ">
                                <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                                    <th>Entidades de ensino</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 15px; color:#000000;">
                                @foreach ($entidades as $entidade)
                                    {{-- Foreach da tabela com os dados --}}
                                    <tr style="text-align: center">
                                        <td>{{ $entidade->nome_tpentensino }}</td> {{-- Variavel que tras os nomes das entidades de ensino --}}
                                        <td>
                                            <a href="/editar-entidade/{{ $entidade->id }}"><button type="submit"
                                                    class="btn btn-outline-warning"{{-- Botao de editar --}} data-tt="tooltip"
                                                    data-placement="top" title="Editar"><i
                                                        class="bi bi-pencil sm"></i></button></a>
                                            <button type="button"
                                                class="btn btn-outline-danger delete-btn"{{-- Botao de excluir que aciona o modal --}}
                                                data-bs-toggle="modal" data-bs-target="#A{{ $entidade->id }}"
                                                data-tt="tooltip" data-placement="top" title="Excluir"><i
                                                    class="bi bi-trash"></i></button>
                                            <div class="modal fade" id="A{{ $entidade->id }}"
                                                tabindex="-1"{{--  Modal  --}} aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color:rgba(202, 61, 61, 0.911);">
                                                            {{-- Cor do header do modal --}}
                                                            <div class="row">
                                                                <h2 style="color:white;">Excluir Entidade de Ensino</h2>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="color:#e24444;">
                                                            {{-- Body do modal, determina a cor da letra --}}
                                                            <br />
                                                            <p class="fw-bold alert  text-center">Você
                                                                realmente deseja excluir
                                                                <br>
                                                                <span class="fw-bolder fs-5">
                                                                    {{ $entidade->nome_tpentensino }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer  ">
                                                            <button type="button"
                                                                class="btn btn-secondary"{{-- Botao de cancelar --}}
                                                                data-bs-dismiss="modal">Cancelar
                                                            </button>
                                                            <a href="/excluir-entidade/{{ $entidade->id }}">
                                                                <button type="button"
                                                                    class="btn btn-danger">Excluir{{-- Botao de exclusao --}}
                                                                    permanentemente
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>{{-- Fim da modal --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            </script>
        </div>
    </div>
@endsection
