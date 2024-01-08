@extends('layouts.app')

@section('content')
    <br />

    <div class="container">

        <div class="card" style="border-color:#355089">

            <div class="card-header">
                Editar Tipo de Desconto

            </div>

            <div class="card-body">
                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/editar-tipo-desconto/{{ $info->id }}">
                        @csrf
                        <center>
                            <div class="col-10" style="margin-top:none">
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    value="{{ $info->nome }}">
                            </div>
                        </center>



                        <center>
                            <div class="row" style="margin-top: 70px;">
                                <div class="col-12">
                                    <a href="/gerenciar-tipo-desconto" class="btn btn-secondary col-3">
                                        Cancelar
                                    </a>
                                    <a href="/update-tipo-desconto" class="btn btn-success col-3 offset-4">
                                        Atualizar
                                    </a>
                                </div>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
