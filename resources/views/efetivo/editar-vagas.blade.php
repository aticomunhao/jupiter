@extends('layouts.app')
@section('head')
    <title>Editar Vagas</title>
@endsection
@extends('layouts.app')
@section('content')
    <form method="post" action="/atualizar-vagas/{{ $busca->idCargo }}" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="col-12" style="color: #355089">
                                    Editar Vagas
                                </h5>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="card-body">
                            <div class="row" style="margin-left:5px">
                                <label for="cargoSelect" class="form-label">Cargo a ser editado</label>
                                <select id="cargoSelect" class="form-select status select pesquisa-select" name="vagasCargo" disabled>
                                    <option value="{{ $busca->idCargo }}">{{ $busca->nomeCargo }}</option>
                                </select>
                                <br>
                                <label for="setorSelect" class="form-label">Setor pertencente</label>
                                <select id="setorSelect" class="form-select status select pesquisa-select" name="vagasSetor" disabled>
                                    <option value="{{ $busca->idSetor }}">{{ $busca->nomeSetor }}</option>
                                </select>
                                <br>
                                <label for="number" class="form-label">Selecione a quantidade de vagas a ser editada para o cargo selecionado</label>
                                <input type="number" class="form-control form-control-number" id="number" name="number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
            <a class="btn btn-danger col-md-3 col-2 mt-4 offset-md-1" href="/controle-vagas" role="button">Cancelar</a>
            <button type="submit" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-3" id="sucesso">Confirmar</button>
        </div>
    </form>
@endsection

