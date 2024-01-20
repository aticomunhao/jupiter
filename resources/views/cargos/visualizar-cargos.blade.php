@extends('layouts.app')
@section('head')
    <title>Visualizar Cargos</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#5C7CB6">
            <div class="card-header">
                Visualizar Cargos
            </div>
            <div class="card-body">

                <div class="col-md-6 col-12">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}}
                        style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 7px; padding-left: 10px; background-color: #ebebeb;">
                        {{ $cargo->nomeCR}}</fieldset>
                </div>
                <br />
                <hr>
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    {{-- Inicio da tabela de informacoes --}}
                    <thead style="text-align: center; ">
                        <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                            <th>Data Inicial</th>
                            <th>Data Final</th>
                            <th>Salário</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">

                        @foreach ($hist_cargo_regular as $hist_cargo_regulars)
                            <tr>
                                <td style="text-align:center;"></td>{{-- Adiciona a data de inicio --}}
                                <td style="text-align:center;"></td>{{-- Adiciona a data final  --}}
                                <td style="text-align:center;"></td>{{-- Adiciona o salario  --}}
                                <td style="text-align:center;"></td>{{-- Adiciona o Motivo  --}}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
