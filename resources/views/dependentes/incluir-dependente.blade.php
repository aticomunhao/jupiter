
@extends('layouts.app')

<title>Incluir Dependentes</title>

@section('content')

<div class="container">
    <div class="justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <DIV class="ROW">
                <div class="col-12">
                    Novo Dependente
                </div>
            </DIV>
            </div>
            <div class="card-body">
            <form method="post" action="/incluir-dependente/{id}">
                        @csrf
                <div class="row">
                    <div class="col-5">
                    <div class="card" style="padding: 0px">
                        <div class="card-body bg-body-secondary">
                              Fulaninha da Silva
                        </div>
                    </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">

                            <div class="col-2">Parentesco
                                <select class="form-select" id="4" name="sex" required="required">
                                        <option value="">Filho/a</option>
                                        <option value="">Pai</option>                                    >   
                                </select>
                            </div>
                            <div class="col-5">Nome completo
                                <input class="form-control"  type="text" maxlength="40" id="2" name="nome_completo" value="" required="required">
                            </div>
                            <div class="col-3">Data nascimento
                                <input class="form-control" type="date" value="" id="3" name="dt_nascimento" required="required">
                            </div>
                            <div class="col-2">CPF
                            <input class="form-control" type="numeric" maxlength="11"  value="" id="8" name="cpf" required="required" onkeypress="$(this).mask('000.000.000-00');">
                            </div>
                </div>
                <br>
                <div class="row">
                        <div class="d-grid gap-1 col-5 mx-auto">
                            <a class="btn btn-danger" href="/gerenciar-dependentes/{id}" role="button">Limpar</a>
                        </div>
                        <div class="d-grid gap-2 col-5 mx-auto">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    </div>
</div>


@endsection

