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
                    <div class="card-header">Número de Períodos </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('ArmazenarFerias', ['id' => $periodo_aquisitivo->id_funcionario]) }}">
                            @csrf
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="umperiodo" name="numeroPeriodoDeFerias" value="1"
                                            required> Um periodo
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="doisperiodos" name="numeroPeriodoDeFerias" value="2"
                                            required> Dois periodos
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="tresperiodos" name="numeroPeriodoDeFerias" value="3"
                                            required> Tres Periodos
                                    </label>
                                </div>
                            </div>

                            <br>
                            <div class="row" id="dates">
                            </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div id="informacaoferias">
                    <div class="container">
                        <div class="card">
                            <div class="card-header">Informações Sobre as Férias</div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="form-check">
                                        <div class="col-4">
                                            <input class="form-check-input vendeferias" type="checkbox" id="vendeferias1"
                                                name="vendeFerias">
                                            <label class="form-check-label" for="vendeferias1">Vender Férias</label>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-check-input " type="checkbox" id="adiantaDecimoTerceiro"
                                                name = "adiantaDecimoTerceiro">
                                            <label class="form-check-label" for="vendeferias2">Adianta Decimo
                                                Terceiro</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="periodosDeFerias"></div>
                </div>
                <div id="tempo">
                </div>
            </div>
            <br>
            <div class="row justify-content-around">
                <div class="col-4">
                    <a href="/gerenciar-ferias" class="btn btn-danger" style="width: 100%">
                        Cancelar
                    </a>
                </div>
                <div class="col-4"><button type="submit" class="btn btn-primary" style="width: 100%">Enviar</button></div>
            </div>
        </div>

        </form>
    </div>

    <style>

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.form-check-input').prop('checked', false);
            $('input[name="numeroPeriodoDeFerias"]').change(function(e) {
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
                    '<div class="container">' +
                    '<div class="card">' +
                    '<div class="card-header">Informações Sobre as Férias</div>' +
                    '<div class="card-body">' +
                    '<div class="row justify-content-center">' +
                    '<div class="form-check">' +
                    '<div class="col-4">' +
                    '<input class="form-check-input vendeferias" type="checkbox" id="vendeferias1" name="vendeFerias">' +
                    '<label class="form-check-label" for="vendeferias1">Vender Férias</label>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<input class="form-check-input " type="checkbox" id="adiantaDecimoTerceiro" name = "adiantaDecimoTerceiro">' +
                    '<label class="form-check-label" for="vendeferias2">Adianta Decimo Terceiro</label>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<br>' +
                    '<div id="periodosDeFerias"></div>'
                );
            });

            $(document).on('change', '.vendeferias', function() {
                var numeroDePeriodos = $('input[name="numeroPeriodoDeFerias"]:checked').val();
                var estadoBotao = $(this).prop('checked');
                $('#periodosDeFerias')
                    .empty();

                if (estadoBotao) {
                    var optionsHTML = '';

                    for (var i = 0; i < numeroDePeriodos; i++) {
                        optionsHTML +=
                            '<div class="form-check">' +
                            '<div class="col-4">' +
                            '<input class="form-check-input" type="radio" id="periodoFerias' + i +
                            '" name = periodoDeVendaDeFerias value = ' + i + '>' +
                            '<label class="form-check-label" for="periodoFerias' + i +
                            '"> ' + (i + 1) + '° Periodo </label>' +
                            '</div>' +
                            '</div>';
                    }

                    var card = $(
                        '<div class="container">' +
                        '<div class="card">' +
                        '<div class="card-header">Qual periodo das Ferias Você deseja vender?</div>' +
                        '<div class="card-body">' +
                        '<div class="row justify-content-center">' +
                        optionsHTML +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );

                    $('#periodosDeFerias').append(card);
                }
            });
        });
    </script>
@endsection
