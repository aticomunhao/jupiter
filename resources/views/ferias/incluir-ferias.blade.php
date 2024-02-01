@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card" style="border-color: #355089">
            <div class="card-header">
                <div class="row-fluid d-flex justify-content-between">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                1234567890123456789012345678901234567890123456789012345678
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        Complete as informações referentes ao período de suas merecidas férias.
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('ArmazenarFerias') }}">
                            @csrf
                            <h5>Informações sobre ferias</h5>
                            <div class="row justify-content-around">

                                    <div class="col-3 ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="venderferias" id="flexCheckVender">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Vender Ferias
                                            </label>
                                            </div>
                                    </div>


                                    <div class="col-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="decimoterceiro" id="flexCheckVender">
                                            <label class="form-check-label" for="flexCheckDefault">
                                               Adiantar Decimo Terceiro
                                            </label>
                                        </div>
                                    </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="col">
                                    <h5>Informe em quantos períodos deseja tirar suas férias</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="umperiodo" name="radioOption" value="1"> Opção 1
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="doisperiodos" name="radioOption" value="2"> Opção 2
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="tresperiodos" name="radioOption" value="3"> Opção 3
                                    </label>
                                </div>
                            </div>


                            <br>
                            <div class="row" id="dates">


                            </div>
                            <div class="row">
                                <div class="col-4 justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="width: 100%">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .radio-label {
            display: block;
            margin-bottom: 10px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#flexCheckVender').change(function(e) {
                if ($(this).is(':checked')) {
                    console.log("Férias serão vendidas.");
                    $('#doisperiodos, #tresperiodos').prop('disabled', true);
                } else {
                    console.log("Férias não serão vendidas.");
                    $('#doisperiodos, #tresperiodos').prop('disabled', false);
                }
            });

            $('input[name="radioOption"]').change(function(e) {

                var numeroInputDates = $(this).val();


                $('#dates').empty();


                for (var i = 0; i < numeroInputDates; i++) {
                    var dateInput = $(
                        '<div class="col-6 mb-3">' +
                        '<label for="dateini' + i + '">Data de Início ' + (i + 1) +
                        ' ° Periodo </label>' +
                        '<input type="date" id="dateini' + i + '" name="dateini' + i +
                        '" class="form-control" required="required">' +
                        '</div>' +
                        '<div class="col-6 mb-3">' +
                        '<label for="datefim' + i + '">Data Fim ' + (i + 1) + '° Periodo </label>' +
                        '<input type="date" id="datefim' + i + '" name="datefim' + i +
                        '" class="form-control" required="required">' +
                        '</div>'
                    );
                    $('#dates').append(dateInput);
                }
            });
        });
    </script>
@endsection
