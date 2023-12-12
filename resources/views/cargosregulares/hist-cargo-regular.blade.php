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
                                                @if ($cargoregular->nomeCR != null)
                                                    <span>{{ $cargoregular->nomeCR }}</span>
                                                @elseif($cargoregular->nomeCC != null)
                                                    <span>{{ $cargoregular->nomeCC }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-lg-5">
                                    <br>
                                </div>
                                <div class="col-lg-3 col-md-12">

                                </div>
                            </div>
                        </h5>

                        <div class="card-body">
                            <table
                                class="table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                <thead class="text-align: justify-center">
                                <tr style="background-color: #d6e3ff; font-size:17px; color:#343434">
                                    <th class="col-lg-2">Data de alteracao</th>
                                    <th class="col-lg-2">Salario</th>
                                    <th class="col-lg-4">Motivo</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $historicocargoregular as  $historicocargoregulars)
                                    <tr>
                                        <td> {{ \Carbon\Carbon::parse($historicocargoregulars->dt_alteracao)->format('d/m/y')}}</td>
                                        <td>{{$historicocargoregulars->salarionovo}}</td>
                                        <td>{{$historicocargoregulars->motivoalt}}</td>
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