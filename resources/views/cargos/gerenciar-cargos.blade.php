@extends('layouts.app')
@section('head')
    <title>Gerenciar Cargos</title>
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Cargos
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <form method="GET" action="/gerenciar-cargos">{{-- Formulario de pesquisa --}}
                            @csrf
                            <div class="row justify-content-start">
                                <div class="col-md-4 col-sm-12">
                                    <input type="text" class="form-control" style="border: 1px solid #999999;"
                                        aria-label="Sizing example input" name="pesquisa" value="" maxlength="40">
                                    {{-- Input de pesquisa --}}
                                </div>
                                <div class="col-md-8 col-12">
                                    <button class="btn btn-light col-md-3 col-12 mt-5 mt-md-0 "
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;"{{-- Botao submit do formulario de pesquisa --}}
                                        type="submit">Pesquisar
                                    </button>
                                    <a href="/incluir-cargos" {{-- Botao com rota para incluir cargo --}}
                                        class="btn btn-success col-md-3 col-12 offset-md-5 mt-4 mt-md-0"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000;">
                                        Novo+
                                    </a>
                                </div>
                            </div>
                        </form>{{-- Final Formulario de pesquisa --}}
                        <br />
                        <hr>
                        <table {{-- Inicio da tabela de informacoes --}}
                            class
                = "table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                            <thead style="text-align: center; ">{{-- inicio header tabela --}}
                                <tr style="background-color: #d6e3ff; font-size:19px; color:#000;" class="align-middle">
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
                                        <td style="text-align:center;">{{ number_format($cargos->salario, 2, ',', '.') }}
                                        </td>
                                        {{-- Adiciona o salario --}}
                                        <td style="text-align: center;">{{-- Td dos botoes de acao --}}
                                            {{-- If dos botoes de editar e desativa --}}
                                            @if ($cargos->status)
                                                <a href="/editar-cargos/{{ $cargos->id }}" class="btn btn-outline-warning"
                                                    data-tt="tooltip" data-placement="top"
                                                    title="Editar">{{-- Botao com rota para editar cargos --}}
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('visualizarHistoricoCargo', ['id' => $cargos->id]) }}"{{-- Botao com rota para visualizar --}}
                                                    class="btn btn-outline-primary" data-tt="tooltip" data-placement="top"
                                                    title="Visualizar">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $cargos->id }}" data-tt="tooltip"
                                                    data-placement="top" title="Desativar">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>{{-- Botao com rota para a modal de exclusao --}}
                                            @else
                                                <a href="{{ route('visualizarHistoricoCargo', ['id' => $cargos->id]) }}"{{-- Botao com rota para visualizar --}}
                                                    class="btn btn-outline-primary" data-tt="tooltip" data-placement="top"
                                                    title="Visualizar">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal{{ $cargos->id }}"{{--  Modal  --}}
                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background-color:rgba(202, 61, 61, 0.911);">
                                                    <div class="row">
                                                        <h2 style="color:white;">Desativar Cargo</h2>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="color:#e24444;">
                                                    <br />
                                                    <p class="fw-bold alert  text-center">Você
                                                        realmente deseja desativar
                                                        <br>
                                                        <span class="fw-bolder fs-5">
                                                            {{ $cargos->nome }}</span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer  ">{{-- Botao cancelar com rota para index --}}
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar
                                                    </button>
                                                    <a href="/deletar-cargos/{{ $cargos->id }}">{{-- Botao de desativar --}}
                                                        <button type="button" class="btn btn-danger">Desativar
                                                            Permanentemente
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>{{-- Fim do modal --}}
                                @endforeach
                            </tbody>
                            {{-- Fim body da tabela --}}
                        </table>
                    </div>
                </div>
            </div>
            {{-- Scritp  de funcionamento dos tooltips --}}
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script></script>
        @endsection
