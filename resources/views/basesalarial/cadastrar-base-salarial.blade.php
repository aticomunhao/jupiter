@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">
                <span style="color: blue"> Incluir Cargo </span>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row-fluid d-flex justify-content-evenly">
                        <div class="col-4">
                            <p>Cargo Regular</p>
                            <select class="form-select" aria-label="Default select example" id="idCargoRegular">
                                @foreach  ($cargosregulares as $cargoregular)
                                @if ($cargoregular->nomeCR == null)
                                <option value="{{$cargoregular->id}}">{{$cargoregular->nomeCC}}</option>
                                @endif
                                @if($cargoregular->nomeCR != null)
                                <option value="{{$cargoregular->id}}">{{$cargoregular->nomeCR}}
                                @endif

                                @endforeach



                            </select>
                        </div>

                        <div class="col-4" id="FuncaoGratificada">
                            <p>Função Gratificada</p>
                            <select class="form-select" aria-label="Default select example" id="idfuncaogratificada">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="row-fluid d-flex justify-content-evenly">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#FuncaoGratificada").hide();
            $('#idCargoRegular').change(function (e) {
                $("#FuncaoGratificada").show();

            });
        });
    </script>
@endsection
