@extends('layouts.app')

@section('content')
    <br />

    <div class="container">

        <div class="card" style="border-color:#355089">

            <div class="card-header">
                Adicionar Tipo de Desconto
            </div>

            <div class="card-body">
                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/armazenar-tipo-desconto">
                        @csrf
                        <center>
                            <div class="row col-10 " style="margin-top:none">

                                <div class="col-8">
                                    <input type="text" class="form-control" aria-label="Sizing example input"
                                        placeholder="Tipo de desconto..." name = "tpdesc">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" aria-label="Sizing example input"
                                        placeholder="Porcentagem do desconto..." name = "pecdesc">
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
