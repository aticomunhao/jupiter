@extends('layouts.app')
@section('head')
    <title>Gerenciar Cargos</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Gerenciar Cargos
            </div>
            <div class="card-body">
                <form method="GET" action="/gerenciar-cargos">{{-- Formulario de pesquisa --}}
                    @csrf
                    <div class="row justify-content-start">
                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                name="pesquisa"{{-- Input de pesquisa --}} value= "" maxlength="40">
                        </div>
                        <div class="col-md-8 col-12">

                            <button class="btn btn-secondary col-md-3 col-12 mt-5 mt-md-0 "{{-- Botao submit do formulario de pesquisa --}}
                                type="submit">Pesquisar</button>

                            <a href="/incluir-cargos"{{-- Botao com rota para incluir cargo --}}
                                class="btn btn-success col-md-3 col-12 offset-md-5 offset-0 mt-2 mt-md-0">
                                Novo+
                            </a>
                        </div>
                    </div>{{-- Final Formulario de pesquisa --}}
                </form>
                <br />
                <hr>
                <table{{-- Inicio da tabela de informacoes --}}
                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle table-responsive">
                    {{-- inicio header tabela --}}
                    <thead style="text-align: center; ">
                        <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                            <th>Nome</th>
                            <th>Tipo de Cargo</th>
                            <th>Salário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>{{-- Fim do header da tabela --}}
                    <tbody style="font-size: 15px; color:#000000;">{{-- Inicio body tabela --}}

                        @foreach ($cargo as $cargos)
                            <tr>
                                <td class="col-5">{{ $cargos->nome }}</td>{{-- Adiciona o nome da Pessoa  --}}
                                <td style="text-align:center;">{{ $cargos->nomeTpCargo }}</td>{{-- Adiciona o tipo de cargo --}}
                                <td style="text-align:center;">{{ $cargos->salario }}</td>{{-- Adiciona o salario --}}
                                <td style="text-align: center;">
                                    <a href="/editar-cargos/{{ $cargos->id }}"
                                        class="btn btn-outline-warning" data-tt="tooltip" data-placement="top" title="Editar">{{-- Botao com rota para editar cargos --}}
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('vizualizarHistoricoCargo', ['id' => $cargos->id]) }}">
                                        <button type="button" class="btn btn-outline-danger" data-tt="tooltip" data-placement="top" title="Visualizar">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal"{{-- Botao com rota para a modal de exclusao --}}
                                        data-bs-target="#exampleModal{{ $cargos->id }}" data-tt="tooltip" data-placement="top" title="Desativar">
                                        <i class="bi bi-x-circle"></i>
                                    </button>

                                </td>
                            </tr>
                            <div class="modal fade"{{--  Modal  --}}
                            id="exampleModal{{ $cargos->id }}" tabindex="-1"
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
                                                {{ $cargos->nome }}</span>
                                        </p>
                                    </div>
                                    <div class="modal-footer  ">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar
                                        </button>
                                        <a href="/deletar-cargos/{{ $cargos->id}}">
                                            <button type="button" class="btn btn-danger">Excluir
                                                permanentemente
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </tbody>{{-- Fim body da tabela --}}
                    </table>
            </div>
        </div>
    </div>
    {{-- Scritp  de funcionamento dos tooltips --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
