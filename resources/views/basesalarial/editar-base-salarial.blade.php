@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card" style=" border-color:#355089">
            <h5 class="card-header">
                <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                {{ $funcionario->nome_completo }}
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h5 class="card-title">Cargo Regular</h5>
                        <div class="card">
                            <div class="card-body">
                                {{ $base_salarial->cargo_regular_nome }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h5 class="card-tittle"> Salario Cargo Regular</h5>
                        <div class="card">
                            <div class="card-body">
                                {{ formatSalary($base_salarial->salario_cargo_regular) }}
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @if ($base_salarial->funcao_gratificada_id != null)
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h5 class="card-title">Função Gratificada</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $base_salarial->funcao_gratificada_nome }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h5 class="card-title">Salario Função Gratificada</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $base_salarial->funcao_gratificada_nome }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <hr>

                <h5>Selecione o novo Tipo de Cargo</h5>
                <label for="opcoesDeTipoDeCargo">Escolha uma opção:</label>
                <select class="form-control" id="opcoesDeTipoDeCargo">
                    @foreach ($tp_cargo as $tp_cargos)
                        <option value="{{ $tp_cargos->idTpCargo }}">{{ $tp_cargos->nomeTpCargo }} </option>
                    @endforeach

                  
            </div>

        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
@php
    function formatSalary($salary)
    {
        return 'R$ ' . number_format($salary, 2, ',', '.');
    }

@endphp
