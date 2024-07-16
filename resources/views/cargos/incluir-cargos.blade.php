@extends('layouts.app')
@section('head')
    <title>Adicionar Cargos</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Adicionar Cargos
            </div>
            <div class="card-body">
                <br>
                <form method="POST" action="{{ route('armazenaCargo') }}">{{-- Formulario de insercao de dados --}}
                    @csrf
                    <div class="row col-10 offset-1" style="margin-top:none">{{-- div input --}}
                        <div class="col-lg-3 col-md-6 col-12 mt-3 mt-md-0 ">{{-- Div dropdown --}}
                            <div>Tipo de Cargo</div>
                            <select class="form-select" name="tipoCargo" value="">{{-- select dropdown --}}
                                @foreach ($tiposCargo as $tipoCargo)
                                    <option value="{{ $tipoCargo->idTpCargo }}">{{ $tipoCargo->nomeTpCargo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mt-3 mt-md-0">
                            <div>Salario</div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                <input type="text" class="form-control" id="salario" name="salario" placeholder="Digite o salário" required>
                            </div>{{-- input salario --}}
                        </div>
                        <div class="col-lg-6 col-12 mt-3 mt-md-0 mt-md-3 mt-lg-0">{{-- Div input Nome --}}
                            <div>Nome do Cargo</div>
                            <input type="text" class="form-control" aria-label="Sizing example input" name = "nome"
                                maxlength="50" required="Required">{{-- input de nome  --}}
                        </div>
                    </div>
                    <center>
                        <div class="col-12" style="margin-top: 70px;">{{-- Botao de cancelar com rota para index --}}
                            <a href="{{ route('gerenciar.cargos') }}" class="btn btn-danger col-3">
                                Cancelar
                            </a>
                            <button type = "submit" class="btn btn-primary col-3 offset-3">{{-- Botao de submit do formulario --}}
                                Confirmar
                            </button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('salario').addEventListener('input', function (e) {
            var value = e.target.value;
            value = value.replace(/\D/g, ""); // Remove tudo que não é dígito
            value = value.replace(/(\d)(\d{2})$/, "$1,$2"); // Coloca a vírgula dos centavos
            value = value.replace(/(?=(\d{3})+(\D))\B/g, "."); // Coloca os pontos de milhar
            e.target.value = value;
        });
        </script>
@endsection
