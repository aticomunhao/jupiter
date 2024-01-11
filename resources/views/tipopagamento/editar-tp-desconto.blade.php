@extends('layouts.app')
@section('head')
    <title>Editar Tipo de Desconto</title>
@endsection
@section('content')
    <br />

    <div class="container">

        <div class="card" style="border-color:#355089">

            <div class="card-header">
                Editar tipo de Desconto
            </div>

            <div class="card-body">
                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/atualizar-tipo-desconto/{{ $info->id }}">
                        @csrf
                        <center>
                            <div class="row col-10 " style="margin-top:none">

                                <div class="col-md-8 col-12">
                                    <input type="text" class="form-control" aria-label="Sizing example input"
                                        placeholder="Tipo de desconto..." name = "edittpdesc" required="Required"
                                        value = '{{ $info->description }}' maxlength="50">
                                </div>
                                <div class="col-md-4 col-12 mt-3 mt-md-0 ">
                                    <input type="number" class="form-control" aria-label="Sizing example input"
                                        placeholder="Porcentagem do desconto..." name = "editpecdesc" required="Required"
                                        value = '{{ $info->percDesconto }}'>
                                </div>
                            </div>
                        </center>


                        <center>
                            <div class="col-12" style="margin-top: 70px;">
                                <a href="/gerenciar-tipo-desconto" class="btn btn-secondary col-3">
                                    Cancelar
                                </a>

                                <button type = "submit" class="btn btn-success col-3 offset-3">
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
