@extends('layouts.app')
@section('title', 'Relatórios de E-mail')
@section('content')
    <br>
    <div class="container">
        <div class="card" style="border-color: #355089;">
            <div class="card-header">
                <div class="ROW">
                    <div class="col-sm-12 col-md-6">
                        <h5 style="color: #355089">
                            Gerenciar Emails
                        </h5>
                    </div>
                </div>
            </div>
            <br>
            <div class="card-body">

                <table class="table  table-striped table-bordered border-secondary table-hover align-middle">
                    {{-- Tabela com todas as informacoes --}}
                    <thead style="text-align: center; ">
                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000;">
                            <th>Funcionario</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">
                        @foreach ($funcionarios as $funcionario)
                            <tr style="text-align: center">
                                <td> {{ $funcionario->nome_completo }}</td>
                                <td> {{ $funcionario->email }}</td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
