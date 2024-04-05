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
                                        id="pesquisaCargo">
                                    <label class="form-check-label" for="pesquisaCargo">
                                        Cargo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pesquisa" value="setor"
                                        id="pesquisaSetor" checked>
                                    <label class="form-check-label" for="pesquisaSetor">
                                        Setor
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-left:5px">
                                <div class="col-6" id="cargoSelectContainer">
                                    <label for="1">Selecione o Cargo Desejado</label>
                                    <br>
                                    <select id="cargoSelect" class="form-select status select2 pesquisa-select"
                                        name="cargo" multiple>
                                        <option></option>
                                        @foreach ($cargo as $cargos)
                                            <option value="{{ $cargos->id }}">{{ $cargos->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6" id="setorSelectContainer">
                                    <label for="1">Selecione o Setor Desejado</label>
                                    <br>
                                    <select id="setorSelect" class="form-select status select2 pesquisa-select"
                                        name="setor" multiple>
                                        <option></option>
                                        @foreach ($setor as $setores)
                                            <option value="{{ $setores->id_setor }}">{{ $setores->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col" style="padding-top:20px;">
                                    <a href="/controle-vagas" type="button" class="btn btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 150px; margin-right: 5px"
                                        value="">Limpar</a>
                                    <input type="submit" value="Pesquisar" class="btn btn-success btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 200px;">
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
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($base as $bases)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    {{ $bases->nome_cargo_regular }}
                                                </td>
                                                <td scope="">
                                                    {{ $totalFuncionariosSetor }}
                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">
                                                    {{ $totalVagasAutorizadas }}
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
            $("#cargoSelectContainer").hide();
            // Monitorar a mudança nos botões de rádio
            $("input[type='radio'][name='pesquisa']").change(function() {
                // Verificar qual botão de rádio está selecionado
                var pesquisaSelecionada = $(this).val();

                // Mostrar o dropdown de seleção correspondente à pesquisa selecionada
                if (pesquisaSelecionada === 'cargo') {
                    $("#cargoSelectContainer").show()
                    $("#setorSelectContainer").hide();
                } else if (pesquisaSelecionada === 'setor') {
                    $("#setorSelectContainer").show()
                    $("#cargoSelectContainer").hide();
                }
            });
        });
    </script>
@endsection
