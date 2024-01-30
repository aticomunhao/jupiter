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
                        <form method="POST" action="">
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault">
                                   Vender Ferias
                                </label>
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">

                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Enviar</button>
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
            $('input[name="radioOption"]').change(function() {
                // Esconder todos os inputs date
                $('.date-field').addClass('hidden');

                // Mostrar o input date correspondente à opção selecionada
                var selectedOption = $('input[name="radioOption"]:checked').val();
                $('#date' + selectedOption).removeClass('hidden');
            });
        });
    </script>
@endsection
