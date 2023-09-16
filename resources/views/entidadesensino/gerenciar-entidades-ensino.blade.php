@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card">

                    <div class="card-header">

                        <div class="row">
                            <div class="col-4">

                                <h5 class="card-title">

                                </h5>
                            </div>
                            <div class="col-5">
                                <br>
                                <h2>Entidades de ensino</h2>
                            </div>
                            <div class="col-1">

                            </div>


                        </div>
                    </div>
                    <div class="card-body">

                        <table
                            class="table table-sm table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                            <thead>
                                <div class="row">
                                    <div class="col-10"></div>
                                    <div class="col-2"><span style="margin-top: 15px; margin-left: -40px">
                                            <a href="/incluir-entidades-ensino">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    style="padding: 5px 80px;margin-right:100px">Novo&plus;</button>
                                            </a></span>
                                    </div>
                                </div>
                                <br>
                                <tr style="background-color: #d6e3ff; font-size:1.2em; color:#000000;text-align: center ">
                                    <th class="col-10">ENTIDADES DE ENSINO</th>
                                    <th class="col-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entidades as $entidade)
                                    <tr style="text-align: center">
                                        <th scope="">{{ $entidade->nome }}</th>
                                        <th scope=""><a href="/excluir-entidade/{{ $entidade->id }}">
                                                <button type="button" class="btn btn-outline-danger delete-btn btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#A"><i
                                                        class="bi bi-trash"></i></button>
                                            </a>
                                            <a href="/editar-entidade/{{ $entidade->id }}"><button type="submit"
                                                    class="btn btn-outline-primary btn-sm"><i
                                                        class="bi bi-pencil btn-sm"></i></button></a>
                                        </th>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
