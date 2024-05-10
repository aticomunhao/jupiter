@extends('layouts.app')
@section('head')
    <title>Gerenciar Funcionários</title>
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
                                Gerenciar Funcionários
                            </h5>
                        </div>
                    </div>
                    <div>
                        <div class="card-body">
                            <form action="{{ route('gerenciar') }}" class="form-horizontal mt-2" method="GET">
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">CPF
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                            maxlength="11" type="text" id="1" name="cpf"
                                            value="{{ $cpf }}">
                                    </div>
                                    <div class="col-md-2 col-sm-12">Identidade
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                            maxlength="9" type="text" id="2" name="idt"
                                            value="{{ $idt }}">
                                    </div>
                                    <div class="col-md-2 col-sm-12">Nome
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                            maxlength="50" type="text" id="3" name="nome"
                                            value="{{ $nome }}">
                                    </div>
                                    <div class="col-md-2 col-sm-12">Situação
                                        <select class="form-select custom-select"
                                            style="border: 1px solid #999999; padding: 5px;" id="4" name="status"
                                            type="number" required="required">
                                            <option value="">Todos</option>
                                            <option value="1">Ativo</option>
                                            <option value="2">Inativo</option>
                                        </select>
                                    </div>
                                    <div class="col" style="margin-top: 20px">
                                        <input class="btn btn-light btn-sm"
                                            style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"
                                            type="submit" value="Pesquisar">

                                        <a href="/gerenciar-funcionario" class="btn btn-light btn-sm"
                                            style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"
                                            type="button" value="">
                                            Limpar
                                        </a>

                                        <a href="/informar-dados">
                                            <input class="btn btn-success btn-sm" type="button" name="6"
                                                value="Novo Cadastro +"
                                                style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">
                                        </a>
                                    </div>
                            </form>
                        </div>
                        <br>
                        <hr>
                        <div class="table-responsive">
                            <table
                                class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                <thead style="text-align: center;">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th class="col-1">CPF</th>
                                        <th class="col-1">Identidade</th>
                                        <th class="col-4">Nome</th>
                                        <th class="col">Situação</th>
                                        <th class="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px; color:#000000;">
                                    @foreach ($lista as $listas)
                                        <tr>
                                            <td scope="">{{ $listas->cpf }}</td>
                                            <td scope="">{{ $listas->idt }}</td>
                                            <td scope="">{{ $listas->nome_completo }}</td>
                                            @if ($listas->status == 1)
                                                <td scope="" style="text-align: center;">Ativo</td>
                                            @else
                                                <td scope="" style="text-align: center;">Inativo</td>
                                            @endif
                                            <td scope="" style="text-align: center">
                                                <a href="/editar-funcionario/{{ $listas->idp }}">
                                                    <button type="button" class="btn btn-outline-warning" data-tt="tooltip"
                                                        data-placement="top" title="Editar"><i class="bi-pencil"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/pessoas-funcionario/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary" data-tt="tooltip"
                                                        data-placement="top" title="Visualizar"><i class="bi-search"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-dependentes/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Dependentes"><i
                                                            class="bi-people-fill"
                                                            style="font-size: 1rem;color:#303030; "></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-dados-bancarios/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Dados Bancários"><i
                                                            class="bi bi-bank"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-afastamentos/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Afastamento"><i
                                                            class="bi-bandaid" style="font-size: 1rem;color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-certificados/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Certificados"><i
                                                            class="bi-mortarboard"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-acordos/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Acordos"><i
                                                            class="bi bi-pencil-square"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <a href="/gerenciar-base-salarial/{{ $listas->idf }}">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-tt="tooltip" data-placement="top" title="Base Salarial"><i
                                                            class="bi bi-currency-dollar"
                                                            style="font-size: 1rem; color:#303030;"></i>
                                                    </button>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#A{{ $listas->cpf }}-{{ $listas->idf }}"
                                                    class="btn btn-outline-danger btn-sm"><i class="bi-trash"
                                                        style="font-size: 1rem; color:#303030;" data-tt="tooltip"
                                                        data-placement="top" title="Inativar"></i></button>
                                                <!-- <a href="/excluir-funcionario/{{ $listas->idf }}"><button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal fader" data-bs-target="#A{{ $listas->cpf }}-{{ $listas->idf }}"><i class="bi-trash" style="font-size: 1rem; color:#303030;"></i></button></a>
                                                                                                            -->
                                            </td>
                                            <!-- Modal -->
                                            <div>
                                                <div class="modal fade" id="A{{ $listas->cpf }}-{{ $listas->idf }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Excluir
                                                                    Funcionário</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="fw-bold alert alert-danger text-center">Você
                                                                    realmente deseja excluir:
                                                                    <br>
                                                                    {{ $listas->nome_completo }}
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Cancelar
                                                                </button>
                                                                <a href="/excluir-funcionario/{{ $listas->idf }}">
                                                                    <button type="button"
                                                                        class="btn btn-primary">Confirmar
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fim Modal-->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection


@section('footerScript')
@endsection
