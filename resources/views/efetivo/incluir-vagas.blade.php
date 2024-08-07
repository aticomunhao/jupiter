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
                        <div class="card-body">
                            <div class="ROW" style="margin-left:5px">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div for="cargoSelect" class="form-label">Selecione o cargo desejado
                                        <br>
                                        <select id="cargoSelect" class="form-select status select2 pesquisa-select"
                                            name="vagasCargo" style="width: 600px;" required>
                                            <option></option>
                                            @foreach ($cargo as $cargos)
                                                <option value="{{ $cargos->idCargo }}">{{ $cargos->nomeCargo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div for="setorSelect" style="margin-top:20px" class="form-label">Selecione o
                                            Setor pertencente
                                        <br>
                                        <select id="setorSelect" class="form-select status select2 pesquisa-select"
                                            name="vagasSetor" style="width: 600px;" required>
                                            <option></option>
                                            @foreach ($setor as $setores)
                                                <option value="{{ $setores->idSetor }}">{{ $setores->nomeSetor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 20px; align-items: flex-end; margin-top: 20px;">
                                    <div  for="number" style="margin-top:20px; margin-right: 20px" class="form-label">
                                        Selecione a quantidade de vagas para o cargo selecionado
                                        <input type="number" class="form-control form-control-number" id="number"
                                            name="vTotal" style="width: 600px;" required>
                                    </div>
                                    <div for="number" style="margin-top:20px" class="form-label">
                                            Selecione a quantidade de Vagas de Excelência para o cargo
                                            selecionado
                                        <input type="number" class="form-control form-control-number" id="number"
                                            name="vExcelencia" style="width: 600px;" required>
                                    </div>
                                </div>
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
