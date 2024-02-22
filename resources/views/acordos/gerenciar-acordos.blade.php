@extends('layouts.app')
@section('head')
    <title>Gerenciar Acordos</title>
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <br />
    <div class="container"> {{-- Container completo da página  --}}
        <div class="card" style="border-color: #355089;">
            <h5 class="card-header" style="color: #355089">
                Gerenciar Acordos
            </h5>
            <div class="card-body">
                <div class="row"> {{-- Linha com o nome e botão novo --}}
                    <div class="col-md-6 col-12">
                        <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}" id="iddt_inicio"
                            name="dt_inicio" required="required" disabled>
                    </div>
                    <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                        <a href="/incluir-acordos/{{ $funcionario->id }}" class="col-6"><button type="button"
                                class="btn btn-success col-md-8 col-12">Novo+</button>
                        </a>
                    </div>
                </div>
                <br />
                <hr />
                <div class="table-responsive"> {{-- Faz com que a tabela não grude nas bordas --}}
                    <div class="table">
                        <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                            <thead style="text-align: center;"> {{-- Text-align gera responsividade abaixo de Large --}}
                                <tr class="align-middle" style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                    <th class="col-2">Tipo de Acordo</th>
                                    <th class="col">Data de Inicio</th>
                                    <th class="col">Valido</th>
                                    <th class="col">Data de Fim</th>
                                    <th class="col">Observações</th>
                                    <th class="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 15px; color:#000000;">
                                @foreach ($acordos as $acordo)
                                    <tr>
                                        {{-- tipo de acordo --}}
                                        <td>
                                            {{ $acordo->nome }}
                                        </td>
                                        {{-- data de inicio --}}
                                        <td style="text-align: center">
                                            {{ \Carbon\Carbon::parse($acordo->data_inicio)->format('d/m/Y') }}
                                        </td >
                                        {{-- Se é válido --}}
                                        <td style="text-align: center">
                                            {{ $acordo->valido }}
                                        </td>
                                        {{-- data de fim --}}
                                        <td style="text-align: center">
                                            {{ \Carbon\Carbon::parse($acordo->data_fim)->format('d/m/Y') }}
                                        </td>
                                        {{-- Observação --}}
                                        <td style="text-align: center">
                                            {{ $acordo->observacao }}
                                        </td>
                                        {{--  Área de ações  --}}
                                        <td style="text-align: center">
                                            <!-- Botao de Arquivo -->
                                            <a href="{{ asset("$acordo->caminho") }}" class="btn  btn-outline-secondary"
                                                data-tt="tooltip" data-placement="top" title="Visualizar">
                                                <i class="bi bi-archive"></i>
                                            </a>
                                            <!-- Botao de Editar -->
                                            <a href="/editar-acordo/{{ $acordo->id }}" class="btn btn-outline-warning"
                                                data-tt="tooltip" data-placement="top" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <!-- Botao de Excluir, trigger modal -->
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#A{{ $acordo->id }}" data-tt="tooltip"
                                                data-placement="top" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="A{{ $acordo->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"
                                                        style="background-color:rgba(202, 61, 61, 0.911);">
                                                        <div class="row">
                                                            <h2 style="color:white;">Excluir Dependente</h2>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="color:#e24444;">
                                                        <br />
                                                        <p class="fw-bold alert  text-center">Você
                                                            realmente deseja excluir
                                                            <br>
                                                            <span class="fw-bolder fs-5">
                                                                {{ $acordo->nome }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer ">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar
                                                        </button>
                                                        <a href="/excluir-acordo/{{ $acordo->id }}">
                                                            <button type="button" class="btn btn-danger">Excluir
                                                                permanentemente
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
@endsection
