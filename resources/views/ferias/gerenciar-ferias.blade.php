@extends('layouts.app')


@section('content')
    <br>

    <div class="container-fluid">
        <div class="card" style="border-color: #355089">
            <h5 class="card-header" style="color: #355089">Gerenciar Férias</h5>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col-3">
                        <input class="form-control" type="text" value="{{ \Carbon\Carbon::now()->year - 1 }}"
                            aria-label="Disabled input example" disabled readonly
                            style="text-align: center; color: #355089; font-size: 16px; font-weight: bold;
                        border: 2px solid #355089; border-radius: 5px; background-color: #f8f9fa;">
                    </div>
                    <div class="col-3">
                        <a href="{{ route('AbreFerias') }}"><button class="btn btn-outline-success"
                                style="width: 100%">Criar
                                Ferias</button></a>
                    </div>
                </div>
                <br>
                @if (!empty($periodo_aquisitivo))
                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;">
                            <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                <th scope="col">Nome do Funcionario</th>
                                <th scope="col">inicio 1</th>
                                <th scope="col">Fim 1</th>
                                <th scope="col">Inicio 2</th>
                                <th scope="col">Fim 2</th>
                                <th scope="col">Inicio 3</th>
                                <th scope="col">Fim 3</th>
                                <th scope="col">Status</th>
                                <th scope="col">Motivo</th>
                                <th scope="col">Ações</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodo_aquisitivo as $periodo_aquisitivos)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        @endsection
