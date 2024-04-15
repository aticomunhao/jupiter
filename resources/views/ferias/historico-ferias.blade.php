@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                {{ $funcionario->nome_completo }}
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>

                <div class="table-responsive">
                    <table
                        class="table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                        style="margin-top:10px;">
                        <thead style="text-align: center;">
                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                            <th class="text-align: center">Data de Recusa</th>
                            <th class="text-align: center">Motivo Recusa</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($historico_recusa_ferias as $recusa_de_ferias)
                            <tr>
                                <td class="text-align: center">{{ \Carbon\Carbon::parse($recusa_de_ferias->data_de_acontecimento)->format('d/m/Y') }}</td>
                                <td class="text-align: center">{{$recusa_de_ferias->motivo_retorno}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-5">
                        <a href="{{ URL::previous() }}">
                            <button class="btn btn-outline-primary" style="width: 100%">Retornar</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
