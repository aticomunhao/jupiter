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
                            <table
                                class="table table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                <thead class="text-align: center">
                                <div class="row flex-row">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                        <th scope="col-2 flex-column">Cargo</th>
                                        <th scope="col-2 flex-column">Salario Atual</th>
                                        <th scope="col-2 flex-column">Data Inicio</th>
                                        <th scope="col-2 flex-column">Data Fim</th>
                                        <th scope="col-2 flex-column">Acões</th>
                                    </tr>
                                </div>
                                </thead>
                                <tbody>
                                @foreach($cargosregulares as $cargoregular)
                                    <div class="row flex-row">
                                        <tr>
                                            @if($cargoregular->nomeCR <> null)
                                                <td>{{$cargoregular->nomeCR}}</td>
                                            @elseif($cargoregular->nomeCC <> null)
                                                <td>{{$cargoregular->nomeCC}}</td>
                                            @endif
                                            <td>R&dollar; {{$cargoregular->salariobase}}</td>
                                            <td>{{ \Carbon\Carbon::parse($cargoregular->dt_inicioCR)->format('d/m/Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($cargoregular->dt_inicioCR)->format('d/m/Y')}}</td>
                                            <td>Otto</td>
                                        </tr>
                                    </div>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            </fieldset>
        </div>
    </div>
@endsection
