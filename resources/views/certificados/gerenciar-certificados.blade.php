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

                                            <td scope="">{{ $certificado->nome_tpne}}</td>
                                            <td scope="">{{ $certificado->nome }}</td>
                                            <td scope="">{{ $certificado->nome_tpee}}</td>
                                            <td scope="">{{ $certificado->nome_grauacad }}</td>
                                            <td scope="">{{ $certificado->nome_tpentensino }}</td>
                                            <td scope="">{{ $certificado->dt_conclusao }}</td>
                                            <td scope=""><a href="/deletar-dependentes/"><button type="submit"
                                                        class="btn btn-danger delete-btn btn-sm"><i
                                                            class="bi bi-trash"></i></button></a>
                                                <a href="/editar-dependentes/"><button type="submit"
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
