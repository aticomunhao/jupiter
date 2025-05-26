@extends('layouts.app')

@section('head')
    <title>Dados Externos</title>
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header">Lista de Grupos</h5>
            <div class="card-body">
                <p class="card-text">
                <div class="row ">
                </div>
                <hr>
                <div class="container">
                    <table class="table table-striped table-bordered border-secondary table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th scope="col">GRUPO</th>
                                <th scope="col">Visualizar</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupos as $grupo)
                                <tr>
                                    <td>{{ $grupo->nome }} - {{ $grupo->nome_setor}}</th>
                                    <td>
                                        <a href="{{route('gerenciar_descontos.show', $grupo->id)}}" class="btn btn-primary">
                                            <i class="bi bi-search">    </i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                </p>

            </div>
        </div>
    </div>
@endsection
