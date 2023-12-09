@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="container-fluid">
                <fieldset class="border border-primary rounded">
                    <div class="card">

                        <h5 class="card-header">

                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <span>
                                        <div class="card">
                                            <div class="card-body">
                                                <span>Gerenciar Cargos Regulares</span>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-lg-5">
                                    <br>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <a href="/criar-cargo-regular"><button type="button" class="btn btn-success"
                                            style="padding: 10px 30%; box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);margin-top: 1%;width:100%">
                                        Novo &plus;
                                    </button> </a>
                                </div>
                            </div>
                        </h5>

                        <div class="card-body">
                            <table class="table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                <thead class="text-align: justify-center">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th scope="col-2 flex-column">Cargo</th>
                                        <th scope="col-2 flex-column">Salario Atual</th>
                                        <th scope="col-2 flex-column">Data Inicio</th>
                                        <th scope="col-2 flex-column">Data Fim</th>
                                        <th scope="col-2 flex-column">Acões</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cargosregulares as $cargoregular)
                                    <tr>
                                        @if($cargoregular->nomeCR <> null)
                                            <td style="vertical-align: middle;">{{$cargoregular->nomeCR}}</td>
                                        @elseif($cargoregular->nomeCC <> null)
                                            <td style="vertical-align: middle;">{{$cargoregular->nomeCC}}</td>
                                        @endif
                                        <td style="vertical-align: middle;">R&dollar; {{$cargoregular->salariobase}}</td>
                                        <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($cargoregular->dt_inicioCR)->format('d/m/Y')}}</td>
                                        <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($cargoregular->dt_fimCR)->format('d/m/Y')}}</td>
                                        <td style="vertical-align: middle;">Otto</td>
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
@endsection
