@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Incluir Entidades de Ensino</h2>
                    </div>
                    <div class="card-body">


                        <p class="card-text">
                        <form method="POST" action="/armazenar-entidade">
                            @csrf
                            <div class="form-group row">
                                <div class="col-5">Nome da Instituição de Ensino
                                    <input class="form-control" type="text" maxlength="100" id="2"name="nome_ent"
                                        value="" required="required">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="d-grid gap-1 col-2 mx-auto">
                                    <a class="btn btn-danger btn-sm" href="/gerenciar-entidades-de-ensino"
                                        role="button">Limpar</a>
                                </div>
                                <div class="d-grid gap-2 col-2 mx-auto">
                                    <button type="submit" class="btn btn-success btn-sm" id="sucesso">Confirmar</button>
                                </div>
                             </div>
                            </div>
                        </form>
                    </div>
                </p>
            </div>
        </div>
    </div>
@endsection
