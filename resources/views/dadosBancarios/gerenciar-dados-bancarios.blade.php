@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <br>
                <div class="card">
                    <fieldset class="border rounded border-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><span
                                        style=" color: rgb(26, 53, 173); font-size:15px;">Gerenciar-Contas-Bancarias</span>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body bg-body-secondary">
                                            <div style="color: rgb(26, 53, 173); font-size:15px;">
                                                {{ $funcionario->nome_completo }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-1">

                                    <span style="margin-top: 15px; margin-left: -18px"><a
                                            href="/incluir-dados-bancarios/{{ $funcionario->id }}"><button type="button"
                                                                                                           class="btn btn-success btn-sm"
                                                                                                           style="padding: 5px 80px;margin-right:100px;font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Novo&plus;</button></a></span>

                                </div>
                                <div class="col-2"></div>
                            </div>
                            <hr>
                            <div class="table">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                    <thead style="text-align: center;">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th class="col-1">Banco</th>
                                        <th class="col-1">Agencia</th>
                                        <th class="col-2">Conta</th>
                                        <th class="col-1">Tipo</th>
                                        <th class="col-1">Subtipo</th>
                                        <th class="col-1">Dt inicio</th>
                                        <th class="col-1">Dt Fim</th>
                                        <th class="col-1">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody style="font-size: 14px; color:#000000;">
                                    @foreach ($contasBancarias as $contaBancaria)
                                        <tr>
                                            <td class="text-center">{{ $contaBancaria->nome }}</td>
                                            <td class="text-center">
                                                {{ str_pad($contaBancaria->agencia, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td class="text-center">{{ $contaBancaria->nmr_conta }}</td>
                                            <td class="text-center">{{ $contaBancaria->nome_tipo_conta }}</td>
                                            <td class="text-center">{{ $contaBancaria->descricao }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($contaBancaria->dt_inicio)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($contaBancaria->dt_fim)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-outline-danger delete-btn btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#A{{ $contaBancaria->id }}"><i
                                                        class="bi bi-trash"></i></button>
                                                <!-- Modal -->

                                                <div class="modal fade" id="A{{ $contaBancaria->id }}" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="row">
                                                                    <h2>Excluir Dado Bancario</h2>
                                                                </div>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="fw-bold alert alert-danger text-center">Você
                                                                    realmente deseja
                                                                    <br>
                                                                    <span class="fw-bolder fs-5">EXCLUIR
                                                                            {{ $contaBancaria->nmr_conta }}
                                                                        </span>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar
                                                                </button>
                                                                <a
                                                                    href="/deletar-dado-bancario/{{ $contaBancaria->id }}">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger">Excluir
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    </fieldset>
                    <!--Fim Modal-->
                    <a href="/editar-dado-bancario/{{ $contaBancaria->id }}">
                        <button type="submit"
                                class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i></button>
                    </a>
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            </fieldset>
        </div>
    </div>
    </div>
    </div>
@endsection
