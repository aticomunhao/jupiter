@extends('layouts.app')
@section('head')
    <title>Incluir Vagas</title>
@endsection
@section('content')
    <form method="post" action="/armazenar-vagas/" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Incluir Vagas
                                </h5>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="ROW" style="margin-left:5px">
                                <label for="cargoSelect" class="form-label">Selecione o cargo desejado</label>
                                <select id="cargoSelect" class="form-select status select2 pesquisa-select"
                                    name="vagasCargo">
                                    <option></option>
                                    @foreach ($cargo as $cargos)
                                        <option value="{{ $cargos->idCargo }}">{{ $cargos->nomeCargo }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="setorSelect" class="form-label">Selecione o Setor pertencente</label>
                                <select id="setorSelect" class="form-select status select2 pesquisa-select"
                                    name="vagasSetor">
                                    <option></option>
                                    @foreach ($setor as $setores)
                                        <option value="{{ $setores->idSetor }}">{{ $setores->nomeSetor }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="number" class="form-label">Selecione a quantidade de vagas para o cargo
                                    selecionado</label>
                                <input type="number" class="form-control form-control-number" id="number"
                                    name="number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
            <a class="btn btn-danger col-md-3 col-2 mt-4 offset-md-1" href="/controle-vagas" role="button">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-3" id="sucesso">
                Confirmar
            </button>
        </div>
    </form>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <head>
        <style>
            .select2-container .select2-selection--multiple {
                min-width: 600px;
            }
        </style>
    </head>

    <script>
        $(document).ready(function() {

            //Importa o select2 com tema do Bootstrap para a classe "select2"
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

        });
    </script>
@endsection
