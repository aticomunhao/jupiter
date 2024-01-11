@extends('layouts.app')
@section('head')
    <title>Incluir Dependentes</title>
@endsection
@section('content')
<br />
<div class="container"> {{-- Container completo da página  --}}
    <div class="card" style="border-color: #5C7CB6;">
        <div class="card-header">
            Incluir Dependentes
        </div>
        <div class="card-body">
            <div class="row"> {{-- Linha com o nome e botão novo --}}
                <div class="col-md-6 col-12">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}}
                        style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 7px; padding-left: 10px; background-color: #ebebeb;">
                        {{ $funcionario_atual[0]->nome_completo }}</fieldset>

                </div>

            </div>
        </div>

            <div class="card-body">
                <form method="post" action="/armazenar-dependentes/{{ $funcionario_atual[0]->id }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-2 mt-1 mt-md-0">Parentesco
                            <select class="form-select" id="4" name="relacao_dep" required="required">
                                @foreach ($tp_relacao as $tp_relacaos)
                                    <option value="{{ $tp_relacaos->id }}">{{ $tp_relacaos->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">Nome completo
                            <input class="form-control" type="text" maxlength="40" id="2"
                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                name="nomecomp_dep" value="" required="required">
                        </div>
                        <div class="col-md-3 mt-3 mt-md-0">Data nascimento
                            <input class="form-control" type="date" value="" id="3" name="dtnasc_dep"
                                required="required">
                        </div>
                        <div class="col-md-2 mt-3 mt-md-0">CPF
                            <input class="form-control" type="numeric" maxlength="11" value="" id="cpf"
                                name="cpf_dep" required="required"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        </div>
                    </div>

                    <div class="row">

                            <center>
                                <a class="btn btn-danger col-md-3 col-5 mt-5" href="/gerenciar-dependentes/{{ $funcionario_atual[0]->id }}"
                                    role="button">Cancelar</a>
                                <button type="submit" class="btn btn-primary col-md-3 col-5 mt-5 offset-md-5 offset-1 " id="sucesso">Confirmar
                                </button>
                            </center>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
