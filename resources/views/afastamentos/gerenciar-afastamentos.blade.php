@extends('layouts.app')
@section('head')
    <title>Gerenciar Afastamentos</title>
@endsection
@section('content')
    <div class="container"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Afastamentos
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row"> {{-- Linha com o nome e botão novo --}}
                            <div class="col-md-6 col-12">
                                <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                    id="iddt_inicio" name="dt_inicio" required="required" disabled>
                            </div>
                            <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                                <a href="/incluir-afastamentos/{{ $funcionario->funcionario_id }}" class="col-6">
                                    <button type="button" class="btn btn-success col-md-8 col-12">
                                        Novo+
                                    </button>
                                </a>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="table-responsive">
                            <div class="table">
                                <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr class="align-middle"
                                            style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-2">Tipo Afastamento</th>
                                            <th class="col-2">Data de Início</th>
                                            <th class="col-2">Quantidade de dias</th>
                                            <th class="col-2">Data de Retorno</th>
                                            <th class="col-2">Justificado</th>
                                            <th class="col-2">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($afastamentos as $afastamento)
                                            <tr>
                                                <td scope="">
                                                    {{ $afastamento->nome_afa }}
                                                </td>
                                                <td scope="" style="text-align: center">
                                                    {{ \Carbon\Carbon::parse($afastamento->dt_inicio)->format('d/m/Y') }}
                                                </td>
                                                <td scope=""style="text-align: center">
                                                    {{ \Carbon\Carbon::parse($afastamento->dt_inicio)->diffInDays(\Carbon\Carbon::parse($afastamento->dt_fim)) }}
                                                </td>
                                                <td scope=""style="text-align: center">
                                                    {{ \Carbon\Carbon::parse($afastamento->dt_fim)->format('d/m/Y') }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $afastamento->justificado ? 'Sim' : 'Não' }}
                                                </td>

                                                <!--Botao de Arquivo-->
                                                <td scope=""
                                                    style="font-size: 1rem; color:#303030; text-align: center">

                                                    @if ($afastamento->caminho)
                                                        <a href="{{ asset($afastamento->caminho) }}"
                                                            class="btn btn-outline-secondary" target="_blank">
                                                            <i class="bi bi-archive">
                                                            </i>
                                                        </a>
                                                    @endif
                                                            <!--Botao de Editar-->
                                                            <a href="/editar-afastamentos/{{ $afastamento->id }}"
                                                                class="btn btn-outline-warning" data-tt="tooltip"
                                                                style="font-size: 1rem; color:#303030" data-placement="top"
                                                                title="Editar">
                                                                <i class="bi bi-pencil">
                                                                </i>
                                                            </a>

                                                            <!-- Botao de excluir, trigger modal -->
                                                            <a>
                                                                <button type="button"
                                                                    class="btn btn-outline-danger delete-btn"
                                                                    style="font-size: 1rem; color:#303030"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#A{{ $afastamento->id }}">
                                                                    <i class="bi bi-trash">
                                                                    </i>
                                                                </button>
                                                            </a>

                                                    <!-- Modal -->

                                                    <div class="modal fade" id="A{{ $afastamento->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <div class="row">
                                                                        <h2>
                                                                            Excluir Afastamento
                                                                        </h2>
                                                                    </div>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="fw-bold alert alert-danger text-center">
                                                                        Você realmente deseja
                                                                        <br>
                                                                        <span class="fw-bolder fs-5">
                                                                            EXCLUIR {{ $afastamento->nome }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        Cancelar
                                                                    </button>
                                                                    <a href="/excluir-afastamento/{{ $afastamento->id }}">
                                                                        <button type="button" class="btn btn-danger">
                                                                            Excluir
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row d-flex justify-content-around">
                    <div class="col-4">
                        <a href="{{ route('gerenciar') }}">
                            <button class="btn btn-primary" style="width: 100%">Retornar </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
