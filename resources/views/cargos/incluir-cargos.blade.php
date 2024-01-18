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
                <form method="POST" action="">{{-- Formulario de insercao de dados --}}
                    @csrf
                    <div class="row col-10 offset-1" style="margin-top:none">{{-- div input de salario --}}
                        <div class="col-lg-2 col-md-6 col-12 mt-3 mt-md-0 ">
                            <div>Salario</div>
                            <input type="number" class="form-control" aria-label="Sizing example input" name = "dtdesc"
                                min="1" step="0.01">{{-- input de salario --}}
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mt-3 mt-md-0 ">{{-- Div dropdown --}}
                            <div>FK</div>
                            <select class="form-select" name="FK">{{-- select dropdown --}}
                                <option value=""></option>

                                {{-- Espaco para foreach de options --}}

                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mt-3 mt-md-0 mt-md-3 mt-lg-0">{{-- Div input Nome --}}
                            <div>Nome</div>
                            <input type="text" class="form-control" aria-label="Sizing example input" name = "name"
                                maxlength="50">{{-- input de nome --}}
                        </div>
                    </div>
                    <center>
                        <div class="col-12" style="margin-top: 70px;">
                            <a href="/gerenciar-cargos" class="btn btn-secondary col-3">{{-- Botao de cancelar com rota para index --}}
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
@endsection
