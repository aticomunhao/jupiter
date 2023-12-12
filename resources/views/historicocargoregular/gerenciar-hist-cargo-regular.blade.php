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

                                </div>
                            </div>
                        </h5>

                        <div class="card-body">
                            <table
                                class="table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                <thead class="text-align: justify-center">
                                <tr style="background-color: #d6e3ff; font-size:17px; color:#343434">
                                    <th scope="col-4">Cargo</th>
                                    <th scope="col-2">Salario Atual</th>
                                    <th scope="col-2">Data Inicio</th>
                                    <th scope="col-2">Data Fim</th>
                                    <th scope="col-2">Acões</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection
