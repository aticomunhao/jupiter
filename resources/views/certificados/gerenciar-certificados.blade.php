@extends('layouts.app')




@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card">
                    <fieldset class="border rounded border-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><span style=" color: rgb(26, 53, 173); font-size:15px;">Gerenciar
                                        Certificados</span>
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
                                                {{ $funcionario[0]->nome_completo }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-3">
                                    <div class="row">

                                        <span style="margin-top: 15px; margin-left: -18px"><a
                                                href="/incluir-certificados/{{ $funcionario[0]->id }}"><button
                                                    type="button" class="btn btn-success btn-sm"
                                                    style="padding: 5px 50px;">Novo &plus;</button></a></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-1">Nivel Ensino</th>
                                            <th class="col-3">Nome</th>
                                            <th class="col-1">Etapa</th>
                                            <th class="col-2">Grau Academico</th>
                                            <th class="col-1">Entidade/Autor</th>
                                            <th class="col-1">Dt Conlusão</th>
                                            <th class="col-1">Ações</th>

                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px; color:#000000;">
                                        @foreach ($certificados as $certificado)
                                            <tr>

                                                <td scope="">{{ $certificado->nome_tpne }}</td>
                                                <td scope="">{{ $certificado->nome }}</td>
                                                <td scope="">{{ $certificado->nome_tpee }}</td>
                                                <td scope="">{{ $certificado->nome_grauacad }}</td>
                                                <td scope="">{{ $certificado->nome_tpentensino }}</td>
                                                <td scope="">{{ $certificado->dt_conclusao }}</td>
                                                <!--Botão que abre Modal-->
                                                <td scope=""><button type="button"
                                                            class="btn btn-outline-danger delete-btn btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#A{{ $certificado->id }}"><i
                                                                class="bi bi-trash"></i></button>

                                                <!--Modal-->
                                                <div class="modal fade"
                                                        id="A{{ $certificado->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <div class="row">
                                                                        <h2>Excluir Dependente</h2>
                                                                    </div>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="fw-bold alert alert-danger text-center">Você
                                                                        realmente deseja
                                                                        <br>
                                                                        <span class="fw-bolder fs-5">EXCLUIR
                                                                            {{ $certificado->nome }}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <a href="/deletar-certificado/{{ $certificado->id }}"><button
                                                                            type="button"
                                                                            class="btn btn-danger">Excluir</button></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Fim modal-->
                                                        <a href="/editar-certificados/{{ $certificado->id }}"><button type="submit"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="bi bi-pencil btn-sm"></i></button></a>
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
