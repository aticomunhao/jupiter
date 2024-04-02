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
                <br>
                <div class="card">
                    <div class="card-header">
                        Datas Do Período de Licença para Férias
                    </div>
                    <div class="card-body">

                        <div class="row d-flex justify-content-around" style="text-align: center">
                            <div class="col-4">
                                <h5 class="card-title">A partir de:</h5>
                                <div class="card">

                                    <div class="card-body">
                                        {{  \Carbon\Carbon::parse($periodo_aquisitivo->dt_inicio_periodo_de_licenca)->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <h5 class="card-title">Não mais que:</h5>
                                <div class="card">

                                    <div class="card-body">
                                        {{     \Carbon\Carbon::parse($periodo_aquisitivo->dt_fim_periodo_de_licenca)->format('d/m/Y')    }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="card">
                    <div class="card-header">Número de Períodos</div>
                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('ArmazenarFerias', ['id' => $periodo_aquisitivo->id_funcionario]) }}">
                            @csrf
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="umperiodo" name="numeroPeriodoDeFerias" value="1"
                                               required> Um período
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="doisperiodos" name="numeroPeriodoDeFerias" value="2"
                                               required> Dois períodos
                                    </label>
                                </div>
                                <div class="col-3 radio-label">
                                    <label>
                                        <input type="radio" id="tresperiodos" name="numeroPeriodoDeFerias" value="3"
                                               required> Três períodos
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
                <div id="informacaoferias"></div>
                <div class="container">
                    <div class="card">
                        <div class="card-header">Informações Sobre as Férias</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="form-check">
                                    <div class="col-4">
                                        <input class="form-check-input vendeferias" type="checkbox"
                                               id="vendeferias1"
                                               name="vendeFerias">
                                        <label class="form-check-label" for="vendeferias1">Vender Férias</label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input " type="checkbox" id="adiantaDecimoTerceiro"
                                               name="adiantaDecimoTerceiro">
                                        <label class="form-check-label" for="vendeferias2">Adiantar Décimo
                                            Terceiro</label>
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
            <div class="container" id="containerPeriodos" hidden>
                <div class="card">
                    <div class="card-header">Qual período das Férias Você deseja vender um terço?</div>
                    <div class="card-body">

                        <div class="form-check">
                            <div id="periodo1" hidden>
                                <input class="form-check-input" type="radio" id="periodoFerias"
                                       name=periodoDeVendaDeFerias
                                       value=1>
                                <label class="form-check-label" for="periodoFerias"> 1° Período</label>
                            </div>

                            <div id="periodo2" hidden>
                                <input class="form-check-input" type="radio" id="periodoFerias"
                                       name=periodoDeVendaDeFerias
                                       value=2>
                                <label class="form-check-label" for="periodoFerias"> 2° Período</label>
                            </div>
                            <div id="periodo3" hidden>
                                <input class="form-check-input" type="radio" id="periodoFerias"
                                       name=periodoDeVendaDeFerias
                                       value=3>
                                <label class="form-check-label" for="periodoFerias"> 3° Período</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around">
                <div class="col-4">
                    <a href="/gerenciar-ferias" class="btn btn-danger" style="width: 100%">
                        Cancelar
                    </a>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary" style="width: 100%">Enviar</button>
                </div>
            </div>
        </div>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.form-check-input').prop('checked', false);
            $('input[name="numeroPeriodoDeFerias"]').change(function (e) {
                var numeroInputDates = $(this).val();
                $('#dates').empty();
                $('#informacaoferias').empty();
                for (var i = 0; i < numeroInputDates; i++) {
                    var dateInput = $(
                        '<div class="col-md-6 col-sm-12 mb-3">' +
                        '<label for="dateini' + i + '">Início ' + (i + 1) +
                        ' ° Período </label>' +
                        '<input type="date" id="dateini' + i + '" name="data_inicio_' + i +
                        '" class="form-control" required="required">' +
                        '</div>' +
                        '<div class="col-md-6 col-sm-12 mb-3">' +
                        '<label for="datefim' + i + '">Fim ' + (i + 1) + '° Período </label>' +
                        '<input type="date" id="datefim' + i + '" name="data_fim_' + i +
                        '" class="form-control" required="required">' +
                        '</div>'
                    );
                    $('#dates').append(dateInput);
                }

                $('#containerPeriodos').prop('hidden', true);
            });

            $(document).on('change', '.vendeferias', function () {
                var numeroDePeriodos = $('input[name="numeroPeriodoDeFerias"]:checked').val();
                var estadoBotao = $(this).prop('checked');
                $('#periodosDeFerias')
                    .empty();

                if (estadoBotao) {
                    $('#containerPeriodos').prop('hidden', false);
                } else {

                    $('#containerPeriodos').prop('hidden', true);
                }

                for (var i = 1; i <= numeroDePeriodos; i++) {

                    $('#periodo' + i).prop('hidden', false);

                }

            });
        });
    </script>
@endsection
