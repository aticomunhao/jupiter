
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
            <form method="post" action="/armazenar-dependentes/{{$funcionario_atual[0]->id}}">
                        @csrf
                <div class="row">
                    <div class="col-5">
                    <div class="card" style="padding: 0px">
                        <div class="card-body bg-body-secondary" value= "{{$funcionario_atual[0]->id}}">
                              {{$funcionario_atual[0]->nome_completo}}
                        </div>
                    </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">

                            <div class="col-2">Parentesco
                                <select class="form-select" id="4" name="relacao_dep" required="required">
                                    @foreach ($tp_relacao as $tp_relacaos)
                                    <option value="{{$tp_relacaos->id}}">{{$tp_relacaos->nome}}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="col-5">Nome completo
                                <input class="form-control"  type="text" maxlength="40" id="2" name="nomecomp_dep" value="" required="required">
                            </div>
                            <div class="col-3">Data nascimento
                                <input class="form-control" type="date" value="" id="3" name="dtnasc_dep" required="required">
                            </div>
                            <div class="col-2">CPF
                            <input class="form-control" type="numeric" maxlength="11"  value="" id="8" name="cpf_dep" required="required">
                            </div>
                </div>
                <br>
                <div class="row">
                        <div class="d-grid gap-1 col-5 mx-auto">
                            <a class="btn btn-danger" href="/incluir-dependentes/{{$funcionario_atual[0]->id}}" role="button">Limpar</a>
                        </div>
                        <div class="d-grid gap-2 col-5 mx-auto">
                          <button type="submit" class="btn btn-success" id="sucesso" onclick="sucesso()">Confirmar</button>
                        </div>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    function sucesso(){
        confirm('Tem certeza que deseja sair?')
    }
</script>

@endsection

