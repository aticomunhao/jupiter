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


                    <center>
                        <div class="col-10" style="margin-top:none">

                            <input type="text" class="form-control" aria-label="Sizing example input"
                                placeholder="Tipo de desconto...">
                        </div>



                        <center>
                            <div class="col-12" style="margin-top: 70px;">
                                <a href="/gerenciar-tipo-desconto" class="btn btn-secondary col-3">
                                    Cancelar
                                </a>

                                <a href="/store-tipo-desconto" class="btn btn-success col-3 offset-4">
                                    Novo
                                </a>
                            </div>
                        </center>

                </div>
            </div>
        </div>
    </div>
@endsection
