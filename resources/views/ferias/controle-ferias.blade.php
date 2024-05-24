@extends('layouts.app')
@section('head')
    <title>Controle de Férias</title>
@endsection
@section('content')
    <form id="controleFeriasForm" action="/controle-ferias" method="get">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Controle de Férias
                                </h5>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row" style="margin-left:5px">
                                    <div class="col-md-3">
                                        <label for="1">Selecione o Setor Desejado</label>
                                        <select id="idsetor" class="form-select select2" name="setor">
                                            <option></option>
                                            @foreach ($ferias as $feriass)
                                                <option value="{{ $feriass->nome_setor }}"
                                                    {{ $feriass->nome_setor ? 'selected' : '' }}>
                                                    {{ $feriass->nome_setor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="1">Selecione o mês Desejado</label>
                                        <select id="idsetor" class="form-select select2" name="setor">
                                            <option></option>
                                            @foreach ($ferias as $feriass)
                                                <option value="{{ $feriass->ano_de_referencia }}"
                                                    {{ $feriass->ano_de_referencia ? 'selected' : '' }}>
                                                    {{ $feriass->ano_de_referencia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3"">
                                        <label for="1">Selecione o Ano Desejado</label>
                                        <select id="idsetor" class="form-select select2" name="setor">
                                            <option></option>
                                            @foreach ($ferias as $feriass)
                                                <option value="{{ $feriass->ano_de_referencia }}"
                                                    {{ $feriass->ano_de_referencia ? 'selected' : '' }}>
                                                    {{ $feriass->ano_de_referencia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 20px;">
                                        <a href="/controle-ferias" type="button" class="btn btn-light btn-sm"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right: 5px"
                                            value="">Limpar</a>
                                        <button class="btn btn-light btn-sm "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;"{{-- Botao submit do formulario de pesquisa --}}
                                            type="submit">Pesquisar
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="table" style="padding-top:20px">
                                    <table
                                        class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                        <thead style="text-align: center;">
                                            <tr style="background-color: #d6e3ff; font-size: 0.7rem; color:#000000;">
                                                <th class="col-md-3">NOME DO EMPREGADO</th>
                                                <th class="col">DATA DE ADMISSÃO</th>
                                                <th class="col">PERÍODO AQUISITIVO</th>
                                                <th class="col">SITUAÇÃO DO PERÍODO AQUISITIVO</th>
                                                <th class="col">DATA LIMITE DO GOZO DE FÉRIAS</th>
                                                <th class="col" colspan="2">PERÍODO LIMITE DO GOZO DE FÉRIAS</th>
                                                <th class="col">INÍCIO DO 1° PERÍODO</th>
                                                <th class="col">FIM DO 1° PERÍODO</th>
                                                <th class="col">INÍCIO DO 2° PERÍODO</th>
                                                <th class="col">FIM DO 2° PERÍODO</th>
                                                <th class="col">INÍCIO DO 3° PERÍODO</th>
                                                <th class="col">FIM DO 3° PERÍODO</th>
                                                <th class="col">MÊS DAS FÉRIAS</th>
                                                <th class="col">SITUAÇÃO DAS FÉRIAS</th>
                                                <th class="col">VENDEU FÉRIAS</th>
                                                <th class="coL">SETOR/CARGO</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 0.6rem; color:#000000;">
                                            @foreach ($ferias as $feriass)
                                                <tr style="text-align: center">
                                                    <td scope="">
                                                        {{ $feriass->nome_completo }}
                                                    </td>
                                                    <td scope="">
                                                        {{ date('d/m/Y', strtotime($feriass->dt_inicio_funcionario)) }}
                                                    </td>
                                                    <td scope="">
                                                        {{ $feriass->ano_de_referencia + 1 }} -
                                                        {{ $feriass->ano_de_referencia + 2 }}
                                                    </td>
                                                    <td scope="">

                                                    </td>
                                                    <td scope="">
                                                        {{ date('d/m/Y', strtotime($feriass->dt_fim_gozo)) }}
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y', strtotime($feriass->dt_inicio_gozo)) }}
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y', strtotime($feriass->dt_fim_gozo)) }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_ini_a ? \Carbon\Carbon::parse($feriass->dt_ini_a)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_fim_a ? \Carbon\Carbon::parse($feriass->dt_fim_a)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_ini_b ? \Carbon\Carbon::parse($feriass->dt_ini_b)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_fim_b ? \Carbon\Carbon::parse($feriass->dt_fim_b)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_ini_c ? \Carbon\Carbon::parse($feriass->dt_ini_c)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $feriass->dt_fim_c ? \Carbon\Carbon::parse($feriass->dt_fim_c)->format('d/m/y') : '--' }}
                                                    </td>
                                                    <td scope="">

                                                    </td>
                                                    <td scope="">
                                                        {{ $feriass->nome_stf }}
                                                    </td>
                                                    <td scope="">

                                                    </td>
                                                    <td scope="">
                                                        {{ $feriass->sigla_setor }} / {{ $feriass->nome_cargo }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="margin-right: 10px; margin-left: 10px">
                                {{ $ferias->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <head>
        <style>
            .select2-container .select2-selection--multiple {
                min-width: 600px;
            }
        </style>
    </head>

    <script>
        $(document).ready(function() {

            //Importa o select2 com tema do Bootstrap para a classe "select2"
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

        });
    </script>
@endsection
