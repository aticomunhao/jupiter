@extends('layouts.app')

@section('head')
    <title>Adicionar Cargos</title>
@endsection

@section('content')
<br>
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Adicionar Cargos
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('armazenaCargo') }}">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div>Tipo de Cargo</div>
                                <select class="form-select" name="tipoCargo"  required = "required">
                                    @foreach ($tiposCargo as $tipoCargo)
                                        <option value="{{ $tipoCargo->idTpCargo }}">{{ $tipoCargo->nomeTpCargo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-5 col-12">
                                <div>Nome</div>
                                <input type="text" class="form-control" name="nome" maxlength="50"  required = "required">
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <label for="salario">Salário:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                    <input type="number" class="form-control" id="salario" name="salario" min="1"
                                        step="0.01" placeholder="Digite o salário"  required = "required">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <a href="{{ route('gerenciar.cargos') }}" class="btn btn-secondary col-3">Cancelar</a>
                                <button type="submit" class="btn btn-primary col-3 offset-3">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery script -->

@endsection
