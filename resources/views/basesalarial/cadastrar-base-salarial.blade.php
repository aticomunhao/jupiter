@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">
                <span style="color: blue"> Incluir Cargo </span>
            </h5>
            <div class="card-body">
                <form action="/" method="POST">
                    <div class="container-fluid">
                        <div class="row-fluid d-flex justify-content-evenly">
                            <div class="col-4">
                                <p>Cargo Regular</p>
                                <select class="form-select" aria-label="Default select example" id="idCargoRegular">
                                    @foreach ($cargosregulares as $cargoregular)
                                        @if ($cargoregular->nomeCR == null)
                                            <option value="{{ $cargoregular->id }}">{{ $cargoregular->nomeCC }}</option>
                                        @elseif ($cargoregular->nomeCR != null)
                                            <option value="{{ $cargoregular->id }}">{{ $cargoregular->nomeCR }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="container-fluid align-content-center">
                                    <div class="form-check">
                                        <label class="form-check-label" for="idteste">Função Gratificada</label>
                                        <input class="form-check-input" type="checkbox" name="teste" id="idteste" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-4" id="FuncaoGratificada">
                                <p>Função Gratificada</p>
                                <select class="form-select" name="funcaogratificada" id="idfuncaogratificada">
                                   @foreach ($funcaogratificada as $funcaogratificadas)
                                    <option value="{{$funcaogratificadas->id}}">{{$funcaogratificadas->nomeFG}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row-fluid d-flex justify-content-evenly">
                            <!-- Additional content can be added here if needed -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#FuncaoGratificada').hide();

            $('#idteste').change(function(e) {
                if ($(this).is(":checked")) {
                    $('#FuncaoGratificada').show();
                } else {
                    $('#FuncaoGratificada').hide();
                }
            });
        });
    </script>
@endsection
