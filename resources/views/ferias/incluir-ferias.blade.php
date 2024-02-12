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
                                {{ $periodo_aquisitivo->nome_completo_funcionario }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="card">

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('ArmazenarFerias', ['id', $periodo_aquisitivo->id_funcionario]) }}">
                            @csrf
                            <h5>Informações sobre ferias</h5>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <h5>Informe em quantos períodos deseja tirar suas férias</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="umperiodo" name="radioOption" value="1"> Um periodo
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="doisperiodos" name="radioOption" value="2"> Dois
                                        periodos
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="tresperiodos" name="radioOption" value="3"> Tres
                                        Periodos
                                    </label>
                                </div>
                            </div>

                            <br>
                            <div class="row" id="dates">
                            </div>
                            <div id="informacaoferias">
                            </div>
                            <div id="tempo">

                            </div>
                            <BR>
                            <div class="row justify-content-around">
                                <div class="col-4"><button class="btn btn-danger" style="width: 100%">Cancelar</button>
                                </div>
                                <div class="col-4">
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

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.form-check-input').prop('checked', false);
            $('input[name="radioOption"]').change(function(e) {
                var numeroInputDates = $(this).val();
                $('#dates').empty();
                $('#informacaoferias').empty();
                for (var i = 0; i < numeroInputDates; i++) {
                    var dateInput = $(
                        '<div class="col-md-6 col-sm-12 mb-3">' +
                        '<label for="dateini' + i + '">Início ' + (i + 1) +
                        ' ° Periodo </label>' +
                        '<input type="date" id="dateini' + i + '" name="dateini' + i +
                        '" class="form-control" required="required">' +
                        '</div>' +
                        '<div class="col-md-6 col-sm-12 mb-3">' +
                        '<label for="datefim' + i + '">Fim ' + (i + 1) + '° Periodo </label>' +
                        '<input type="date" id="datefim' + i + '" name="datefim' + i +
                        '" class="form-control" required="required">' +
                        '</div>'
                    );
                    $('#dates').append(dateInput);
                }
                $('#informacaoferias').append(
                    '<div class="card">' +
                    '<h5 class="card-header">Informações Sobre as Férias</h5>' +
                    '<div class="card-body">' +
                    '<div class="row justify-content-center"><div class="form-check">' +
                    '<DIV CLASS="col-4"><input class="form-check-input" type="checkbox" value="" id="vendeferias">' +
                    '<label class="form-check-label" for="flexCheckDefault">Vender Férias</label>' +
                    '</div></div>' +
                    '</div></div>' +
                    '</div>'
                );
              

            });

        });
    </script>
@endsection
