@extends('layouts.app')

@section('head')
    <title>Gerenciar Contratos</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card border-primary">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="text-primary m-0">Gerenciar Contratos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                    disabled>
                            </div>
                            <div class="col-md-3 offset-md-3 col-12">
                                <a href="/incluir-contrato/{{ $funcionario->id }}" class="d-block">
                                    <button type="button" class="btn btn-success w-100 shadow-sm">Novo+</button>
                                </a>
                            </div>
                        </div>

                        <hr />

                        <div class="table-responsive">
                            <table
                                class="table table-striped table-bordered border-secondary table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr class="text-dark" style="font-size: 17px;">
                                        <th class="col-2">Tipo de Contrato</th>
                                        <th class="col-2">Admissão</th>
                                        <th class="col-1">Matrícula</th>
                                        <th class="col-2">Demissão</th>
                                        @if (collect($contrato)->contains('tp_contrato', 5))
                                            <th class="col-2">Previsão de Fim</th>
                                        @endif
                                        <th class="col-3">Motivo Desligamento</th>
                                        <th class="col-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 15px;">
                                    @foreach ($contrato as $contratos)
                                        <tr>
                                            <td>{{ $contratos->nome }}</td>
                                            <td>{{ \Carbon\Carbon::parse($contratos->dt_inicio)->format('d/m/Y') }}</td>
                                            <td>{{ $contratos->matricula }}</td>
                                            <td>
                                                {{ $contratos->dt_fim ? \Carbon\Carbon::parse($contratos->dt_fim)->format('d/m/Y') : 'Em vigor' }}
                                            </td>
                                            @if (isset($contratos->tp_contrato) && $contratos->tp_contrato == 5)
                                                <td>{{ $contratos->previsao_fim ?? '-' }}</td>
                                            @endif
                                            <td>{{ $contratos->motivo ?? '-' }}</td>
                                            <td>
                                                <a href="#" class="btn btn-outline-secondary" title="Visualizar">
                                                    <i class="bi bi-archive"></i>
                                                </a>

                                                <a href="/editar-contrato/{{ $contratos->id }}"
                                                    class="btn btn-outline-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#A{{ $contratos->id }}" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#situacao{{ $contratos->id }}"
                                                    title="Finalizar contrato">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                </button>

                                                {{-- Modal Finalizar --}}
                                                <div class="modal fade" id="situacao{{ $contratos->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST"
                                                            action="{{ url('/inativar-contrato/' . $contratos->id) }}">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title">Confirmar Inativação</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <label class="form-label">Motivo da Inativação:</label>
                                                                    <select class="form-select mb-3" name="motivo_inativar"
                                                                        required>
                                                                        <option value=""></option>
                                                                        @foreach ($situacao as $situacaos)
                                                                            <option value="{{ $situacaos->id }}">
                                                                                {{ $situacaos->motivo }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="form-label">Data de Inativação:</label>
                                                                    <input class="form-control" type="date"
                                                                        name="dt_fim_inativacao" required>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Confirmar</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                {{-- Modal Excluir --}}
                                                <div class="modal fade" id="A{{ $contratos->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">Excluir Contrato</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger fw-bold">
                                                                Tem certeza que deseja excluir o contrato:
                                                                <br><span class="fs-5">{{ $contratos->nome }}</span>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <a href="/excluir-contrato/{{ $contratos->id }}">
                                                                    <button type="button" class="btn btn-danger">Excluir
                                                                        permanentemente</button>
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

                        <div class="row mt-4">
                            <div class="col-md-4 mx-auto">
                                <a href="{{ route('gerenciar') }}">
                                    <button class="btn btn-danger w-100">Retornar</button>
                                </a>
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
            </div>
        </div>
    </div>
@endsection
