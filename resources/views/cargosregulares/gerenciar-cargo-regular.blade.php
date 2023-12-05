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
                                    <button type="button" class="btn btn-success"
                                            style="padding: 10px 30%; box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);margin-top: 1%;width:100%">
                                        Novo &plus;
                                    </button>
                                </div>
                            </div>
                        </h5>

                        <div class="card-body">

                            <table
                                class="table table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                <thead class="text-align: center;">
                                <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cargosregulares as $cargoregular)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
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
