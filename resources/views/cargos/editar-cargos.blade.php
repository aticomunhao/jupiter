@extends('layouts.app')
@section('head')
    <title>Editar Cargos</title>
@endsection

@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Editar Cargos
            </div>
            <div class="card-body">
                <br>
                <form method="POST" action="{{route('AtualizaCargo', ['id' => $id])}}">{{-- Formulario de edicao de dados --}}
                    @csrf

                    <div class="row col-10 offset-1" style="margin-top:none">{{-- div input de salario --}}
                        <div class="col-lg-2 col-md-6 col-12 mt-3 mt-md-0 ">
                            <div>Salario</div>
                            <input type="number" class="form-control" aria-label="Sizing example input" name = "salario"
                                min="1" step="0.01" value="{{$cargo->salario}}">{{-- input com value do item editado --}}
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mt-3 mt-md-0 ">{{-- Div dropdown --}}
                            <div>FK</div>
                            <select class="form-select" name="tipocargo" value="">{{-- select dropdown --}}
                                @foreach ( $tiposCargo as $tipoCargo )
                                <option value="{{ $tipoCargo->idTpCargo }}">{{ $tipoCargo->nomeTpCargo }}</option>

                                @endforeach

                                {{-- Espaco para foreach de options --}}

                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mt-3 mt-md-0 mt-md-3 mt-lg-0">{{-- Div input Nome --}}
                            <div>Nome</div>
                            <input type="text" class="form-control" aria-label="Sizing example input" name = "name"
                                maxlength="50" value="{{$cargo->nome}}">{{-- input de nome com value do item editado --}}
                        </div>
                    </div>
                    <center>
                        <div class="col-12" style="margin-top: 70px;">{{-- Botao de cancelar com rota para index --}}
                            <a href="/gerenciar-cargos" class="btn btn-secondary col-3">
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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Your custom script -->


    <script>
        $(document).ready(function () {
            var valorDoBanco = {{ isset($cargo) ? $cargo->tp_cargo : 'default_value' }};
            alert(valorDoBanco);
            if(valorDoBanco == )
        });
    </script>
@endsection
