@extends('layouts.app')
@section('head')
<title>Editar Entidade de Ensino</title>
@endsection
@section('content')
    <br />

    <div class="container">

        <div class="card" style="border-color:#355089">

            <div class="card-header">
                Editar Entidades de Ensino
            </div>

            <div class="card-body">

                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/atualizar-entidade-ensino/{{ $entidade->id }}">
                        @csrf

                            <div class="row col-10 offset-1" style="margin-top:none">

                                <div class=" col-12">
                                    <div>Entidade de ensino</div>
                                    <input class="form-control" type="text" maxlength="100"
                                    id="2"name="nome_ent" value="{{ $entidade->nome_tpentensino }}" required="required">
                                </div>




                        <center>
                            <div class="col-12" style="margin-top: 70px;">
                                <a href="/gerenciar-entidades-de-ensino" class="btn btn-secondary col-4">
                                    Cancelar
                                </a>

                                <button type = "submit" class="btn btn-primary col-4 offset-3">
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
