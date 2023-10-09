
@extends('layouts.app')

<title>Incluir Dependentes</title>

@section('content')

<div class="container">
    <div class="justify-content-center">
    <div class="col-12">
        <br>
        <fieldset class="border rounded border-primary ">
            <div class="card">
                <div class="card-header">
                <DIV class="ROW">
                    <div class="col-12">
                        <span>Editar Dependente</span>
                    </div>
                </DIV>
                </div>
                <div class="card-body">
                <form method="post" action="/atualizar-dependentes/{{$dependente->id}}">
                            @csrf
                            @method('PUT')
                    <div class="row">
                        <div class="col-5">
                        <div class="card" style="padding: 0px">
                            <div class="card-body bg-body-secondary" value= {{$funcionario[0]->id}}>
                                  {{$funcionario[0]->nome_completo}}
                            </div>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                                <div class="col-2">Parentesco
                                    <select class="form-select" id="4" name="relacao_dep" required="required" value = "{{$dependente->id_parentesco}}">
                                        @foreach ($tp_relacao as $tp_relacaos)
                                        <option value="{{$tp_relacaos->id}}">{{$tp_relacaos->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">Nome completo
                                    <input class="form-control"  type="text" maxlength="40" id="2" name="nomecomp_dep" value="{{$dependente->nome_dependente}}" required="required">
                                </div>
                                <div class="col-3">Data nascimento
                                    <input class="form-control" type="date" value="{{$dependente->dt_nascimento}}" id="3" name="dtnasc_dep" required="required">
                                </div>
                                <div class="col-2">CPF
                                <input class="form-control" type="numeric" maxlength="11"  value="{{$dependente->cpf}}" id="8" name="cpf_dep" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="d-grid gap-1 col-2 mx-auto">
                            <a class="btn btn-danger btn-sm" href="/gerenciar-certificados/{{ $funcionario[0]->id }}"
                                role="button">Cancelar</a>
                        </div>
                            <div class="d-grid gap-3 col-2 mx-auto">
                              <button type="submit" class="btn btn-warning btn-sm" >Confirmar</button>
                            </div>
                    </div>
                    </form>
                </div>
                </div>
        </fieldset>
        </div>
    </div>
    </div>
</div>

@endsection

