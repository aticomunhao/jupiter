@extends('layouts.app')
@section('head')
    <title>Gerenciar Certificados</title>
@endsection
@section('content')
    <br />
    <div class="container"> {{-- Container completo da página  --}}
        <div class="card" style="border-color: #355089;">
            <h5 class="card-header" style="color: #355089">
                Gerenciar Certificados
            </h5>
            <div class="card-body">
                <div class="row"> {{-- Linha com o nome e botão novo --}}
                    <div class="col-md-6 col-12">
                        <input class="form-control" type="text" value="{{ $funcionario[0]->nome_completo }}" id="iddt_inicio"
                            name="dt_inicio" required="required" disabled>
                    </div>
                    <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                        <a href="/incluir-certificados/{{ $funcionario[0]->id }}" class="col-6">
                            <button type="button" class="btn btn-success col-md-8 col-12">
                                Novo+
                            </button>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="table">
                    <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;">
                            <tr class="align-middle" style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                <th class="col-1">Nivel Ensino</th>
                                <th class="col-3">Nome</th>
                                <th class="col-1">Etapa</th>
                                <th class="col-2">Grau Academico</th>
                                <th class="col-1">Entidade/Autor</th>
                                <th class="col-1">Dt Conlusão</th>
                                <th class="col-1">Ações</th>

                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color:#000000;">
                            @foreach ($certificados as $certificado)
                                <tr>

                                    <td scope="" style="text-align: center">{{ $certificado->nome_tpne }}</td>
                                    <td scope="">{{ $certificado->nome }}</td>
                                    <td scope="" style="text-align: center">{{ $certificado->nome_tpee }}</td>
                                    <td scope="" style="text-align: center">{{ $certificado->nome_grauacad }}</td>
                                    <td scope="" style="text-align: center">{{ $certificado->nome_tpentensino }}</td>
                                    <td scope="" style="text-align: center">
                                        {{ \Carbon\Carbon::parse($certificado->dt_conclusao)->format('d/m/Y') }}</td>

                                    <!--Botão que abre Modal-->
                                    <td scope="" style="text-align: center">
                                        <button type="button"
                                            class="btn btn-outline-danger delete-btn" data-bs-toggle="modal"
                                            data-bs-target="#A{{ $certificado->id }}"><i class="bi bi-trash"></i>
                                        </button>

                                        <!--Modal-->
                                        <div class="modal fade" id="A{{ $certificado->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="row">
                                                            <h2>Excluir Certificado</h2>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
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
                                                                type="button" class="btn btn-danger">Excluir</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Fim modal-->
                                        <a href="/editar-certificado/{{ $certificado->id }}"><button type="submit"
                                                class="btn btn-outline-warning"><i
                                                    class="bi bi-pencil"></i></button></a>
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
