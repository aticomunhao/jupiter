@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card">

                    <div class="card-header">

                        <div class="row">
                            <div class="col-8">
                                <h2>Dependentes</h2>
                                <h5 class="card-title">
                                    <form class="d-flex" role="search">
                                        <input class="form-control me-2" type="search" placeholder="Search"
                                            aria-label="Search">
                                        <a href=""><button class="btn btn-success" type="submit">Enviar</button></a>
                                    </form>
                                </h5>
                            </div>

                            <div class="col-4">


                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                            <thead>
                                <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                    <th class="col-10">Entidades de Ensino</th>
                                    <th class="col-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entidades as $entidade)
                                    <tr>
                                        <th scope="">{{ $entidade->nome }}</th>
                                        <th scope=""><button type="button" class="btn btn-danger delete-btn btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#A"><i
                                                    class="bi bi-trash"></i></button>
                                            <a href=""><button type="submit" class="btn btn-primary btn-sm"><i
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
