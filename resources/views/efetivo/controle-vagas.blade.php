@extends('layouts.app')
@section('head')
    <title>Controle de Vagas</title>
@endsection
@section('content')
    <form id="controleVagasForm" action="/controle-vagas" method="get">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Controle de Vagas
                                </h5>
                            </div>
                            <hr>
                            <div class="card-body">
                                <label for="1">Selecione a Forma de Pesquisa Desejada</label>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pesquisa" value="cargo"
                                        {{ $pesquisa === 'cargo' ? 'checked' : '' }} id="pesquisaCargo">
                                    <label class="form-check-label" for="pesquisaCargo">
                                        Cargo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pesquisa" value="setor"
                                        id="pesquisaSetor" {{ $pesquisa === 'setor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pesquisaSetor">
                                        Setor
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-left:5px">
                                <div class="col" id="cargoSelectContainer" style="display: none">
                                    <label for="1">Selecione o Cargo Desejado</label>
                                    <br>
                                    <select id="cargoSelect"
                                        class="form-select status select2 pesquisa-select" name="cargo"
                                        multiple=multiple>
                                        <option></option>
                                        @foreach ($cargo as $cargos)
                                            <option value="{{ $cargos->idCargo }}">{{ $cargos->nomeCargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col" id="setorSelectContainer" style="display: none">
                                    <label for="1">Selecione o Setor Desejado</label>
                                    <br>
                                    <select id="setorSelect" class="form-select status select2 pesquisa-select"
                                        name="setor" multiple=multiple>
                                        <option></option>
                                        @foreach ($setor as $setores)
                                            <option value="{{ $setores->idSetor }}">{{ $setores->nomeSetor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col" style="padding-top:20px;">
                                    <a href="/controle-vagas" type="button" class="btn btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 150px; margin-right: 5px"
                                        value="">Limpar</a>
                                    <input type="submit" value="Pesquisar" class="btn btn-success btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 200px;">
                                    <input type="hidden" name="tipo_pesquisa" id="tipoPesquisa"
                                        value="{{ $pesquisa }}">
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="table" style="padding-top:20px">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-4">Cargo</th>
                                            <th class="col-2">Vagas Preenchidas</th>
                                            <th class="col-2">Vagas Remanescentes</th>
                                            <th class="col-2">Vagas Totais</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;" id='cargoTabela'>
                                        @foreach ($cargo as $cargos)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    {{ $cargos->nomeCargo }}
                                                </td>
                                                <td scope="">
                                                    {{ $cargos->numero_funcionario }}
                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">
                                                    {{ $cargos->vagasTotais}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody style="font-size: 15px; color:#000000;" id='setorTabela'>
                                        @foreach ($setor as $setores)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                   @if ($setores->nomeCargo !== null)
                                                   {{ $setores->nomeCargo }}
                                                   @else
                                                   @endif
                                                </td>
                                                <td scope="">
                                                    @if ($setores->nomeCargo !== null)
                                                    {{ $setores->numero_funcionario }}
                                                    @else
                                                    @endif
                                                </td>
                                                <td scope="">
                                                    @if ($setores->nomeCargo !== null)
                                                    {{ $setores->nomeCargo }}
                                                    @else
                                                    @endif
                                                </td>
                                                <td scope="">
                                                    @if ($setores->nomeCargo !== null)
                                                    {{ $setores->vagasTotais }}
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script>
        $(document).ready(function() {
            //Inicializar a variável para manter o estado da tabela selecionada
            var tabelaSelecionada = "{{ $pesquisa }}";

            //Esconder a tabela que não está selecionada inicialmente
            if (tabelaSelecionada === 'cargo') {
                $("#setorTabela").hide();
            } else {
                $("#cargoTabela").hide();
            }

            //Esconder o select que não está selecionado inicialmente
            if (tabelaSelecionada === 'cargo') {
                $("#setorSelectContainer").hide();
            } else {
                $("#cargoSelectContainer").hide();
            }

            // Monitorar a mudança nos botões de rádio
            $("input[type='radio'][name='pesquisa']").change(function() {
                var pesquisaSelecionada = $(this).val();
                $("#tipoPesquisa").val(
                pesquisaSelecionada); // Atualizar o campo hidden com a opção selecionada

                // Esconder a tabela e o select que não estão selecionados
                if (pesquisaSelecionada === 'cargo') {
                    $("#cargoTabela").show();
                    $("#setorTabela").hide();
                    $("#cargoSelectContainer").show();
                    $("#setorSelectContainer").hide();
                } else if (pesquisaSelecionada === 'setor') {
                    $("#setorTabela").show();
                    $("#cargoTabela").hide();
                    $("#setorSelectContainer").show();
                    $("#cargoSelectContainer").hide();
                }
            });
        });
    </script>
@endsection
