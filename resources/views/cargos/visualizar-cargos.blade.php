@extends('layouts.app')

@section('head')
    <title>Visualizar Cargos</title>
@endsection

@section('content')
    <br/>
    <div class="container">
        <div class="card" style="border-color:#5C7CB6">
            <div class="card-header">
                <div class="row">Visualizar Cargos</div>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-5 col-sm-12">
                        <input class="form-control" type="text" value="{{ $cargo->nomeCR }}" aria-label="Disabled input example" disabled>
                    </div>
                    <div class="col-md-7 col-12" >
                        <a href="{{ route('gerenciar.cargos') }}">
                            <button type="button" class="btn btn-primary col-md-3 col-12 offset-md-5 offset-0 mt-2 mt-md-0" >Retorne</button>
                        </a>
                    </div>
                </div>
             <hr>



                <div class="container-fluid">
                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;">
                            <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                                <th class="col-2">Data Inicial</th>
                                <th class="col-2">Data Final</th>
                                <th class="col-4">Salário</th>
                                <th class="col-4">Motivo</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color:#000000;">
                            @foreach ($hist_cargo_regular as $hist_cargo_regulars)
                                <tr>
                                    <td style="text-align:center;">{{ $hist_cargo_regulars->data_inicio }}</td>
                                    <td style="text-align:center;">{{ $hist_cargo_regulars->data_fim ?? '--' }}</td>
                                    <td style="text-align:center;">{{ $hist_cargo_regulars->salarioHist }}</td>
                                    <td style="text-align:center;">{{ $hist_cargo_regulars->motivoAlt }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
