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
                            <div class="col-md-3 offset-md-8 col-12"> {{-- Botão de incluir --}}
                                <a href="/incluir-vagas/" class="col-6">
                                    <button type="button" style="font-size: 1rem; box-shadow: 1px 2px 5px #000000;"
                                        class="btn btn-success col-md-8 col-12">
                                        Novo+
                                    </button>
                                </a>
                            </div>
                            <div class="card-body">
                                <label for="1">Selecione a Forma de Pesquisa Desejada</label>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pesquisa" value="cargo"
                                        {{ $pesquisa == 'cargo' ? 'checked' : '' }} id="pesquisaCargo">
                                    <label class="form-check-label" for="pesquisaCargo">
                                        Cargo
                                    </label>
                                </div>
                                <div class="form-check col-12">
                                    <input class="form-check-input" type="radio" name="pesquisa" value="setor"
                                        id="pesquisaSetor" {{ $pesquisa == 'setor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pesquisaSetor">
                                        Setor
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-left:5px">
                                <div class="col" id="cargoSelectContainer" style="display: none">
                                    <label for="1">Selecione o Cargo Desejado</label>
                                    <br>
                                    <select id="cargoSelect" class="form-select status select2 pesquisa-select"
                                        name="cargo" multiple=multiple>
                                        <option></option>
                                        @php
                                            $cargosExibidos = []; // Array para armazenar os cargos únicos já exibidos
                                        @endphp
                                        @foreach ($cargo as $cargos)
                                            @if ($cargos->nomeCargo)
                                                <!-- Exibir apenas se o nome do cargo não for nulo -->
                                                @if (!in_array($cargos->nomeCargo, $cargosExibidos))
                                                    <!-- Adicionar à lista suspensa somente se o nome do cargo não tiver sido exibido anteriormente -->
                                                    <option value="{{ $cargos->idCargo }}">{{ $cargos->nomeCargo }}</option>
                                                    @php
                                                        $cargosExibidos[] = $cargos->nomeCargo; // Adiciona o cargo ao array de cargos únicos exibidos
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col" id="setorSelectContainer" style="display: none">
                                    <label for="1">Selecione o Setor Desejado</label>
                                    <br>
                                    <select id="setorSelect" class="form-select status select2 pesquisa-select"
                                        name="setor" multiple=multiple>
                                        <option></option>
                                        @php
                                            $setoresExibidos = []; // Array para armazenar os setores únicos já exibidos
                                        @endphp
                                        @foreach ($setor as $setores)
                                            @if ($setores->nomeSetor)
                                                <!-- Exibir apenas se o nome do setor não for nulo -->
                                                @if (!in_array($setores->nomeSetor, $setoresExibidos))
                                                    <!-- Adicionar à lista suspensa somente se o nome do setor não tiver sido exibido anteriormente -->
                                                    <option value="{{ $setores->idSetor }}">
                                                        {{ $setores->nomeSetor }}</option>
                                                    @php
                                                        $setoresExibidos[] = $setores->nomeSetor; // Adiciona o setor ao array de setores únicos exibidos
                                                    @endphp
                                                @endif
                                            @endif
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
                                            <th class="col-4">SETOR/CARGO</th>
                                            <th class="col-2">VAGAS PEENCHIDAS</th>
                                            <th class="col-2">TOTAL DE VAGAS</th>
                                            <th class="col-2">VAGAS REMANESCENTES</th>
                                            <th class="col-2">AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <!-- Primeira tabela -->
                                    <tbody style="font-size: 15px; color:#000000;" id='cargoTabela'>
                                        @php
                                            $totalFuncionarios1 = 0;
                                            $totalVagas1 = 0;
                                            $cargosExibidos = [];
                                        @endphp

                                        @foreach ($cargo as $cargos)
                                            @if ($cargos->nomeCargo && !in_array($cargos->nomeCargo, $cargosExibidos))
                                                @php
                                                    $vagasTotais = 0;
                                                @endphp
                                                @foreach ($vaga as $v)
                                                    @if ($v->idDoCargo == $cargos->idCargo)
                                                        @php
                                                            $vagasTotais += $v->total_vagas;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td>{{ $cargos->nomeCargo }}</td>
                                                    <td style="text-align: center">{{ $cargos->quantidade_funcionarios }}
                                                    </td>
                                                    <td style="text-align: center">{{ $vagasTotais }}</td>
                                                    <td style="text-align: center">
                                                        {{ $vagasTotais - $cargos->quantidade_funcionarios }}</td>
                                                        <td style="text-align: center">NÃO DISPONÍVEL</td>
                                                </tr>
                                                @php
                                                    $totalFuncionarios1 += $cargos->quantidade_funcionarios;
                                                    $totalVagas1 += $vagasTotais;
                                                    $cargosExibidos[] = $cargos->nomeCargo;
                                                @endphp
                                            @endif
                                        @endforeach

                                        <!-- Total da primeira tabela -->
                                        <tr style="background-color: #436ce6">
                                            <td style="text-align: center"><strong>Total</strong></td>
                                            <td style="text-align: center"><strong>{{ $totalFuncionarios1 }}</strong></td>
                                            <td style="text-align: center"><strong>{{ $totalVagas1 }}</strong></td>
                                            <td style="text-align: center">
                                                <strong>{{ $totalVagas1 - $totalFuncionarios1 }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>

                                    </tbody>

                                    <!-- Segunda tabela -->
                                    <tbody style="font-size: 15px; color:#000000;" id='setorTabela'>
                                        @php
                                            $totalFuncionarios2 = 0;
                                            $totalVagas2 = 0;
                                        @endphp

                                        @foreach ($setor as $setores)
                                            @foreach ($setores->bola as $vagaDois)
                                                @php
                                                    $somaF += $vagaDois->gato->first()->quantidade;
                                                    $somaV += $vagaDois->vagas;
                                                @endphp
                                                <tr>
                                                    <td>{{ $setores->nomeSetor }} / {{ $vagaDois->nomeCargo }}</td>
                                                    <td style="text-align: center">
                                                        {{ $vagaDois->gato->first()->quantidade }}
                                                    </td>
                                                    <td style="text-align: center">{{ $vagaDois->vagas }}</td>
                                                    <td style="text-align: center">
                                                        {{ $vagaDois->vagas - $vagaDois->gato->first()->quantidade }}</td>
                                                        <td scope=""
                                                        style="font-size: 1rem; color:#303030; text-align: center">
                                                        <a href="/editar-vagas/{{ $vagaDois->idCargo }}"
                                                            class="btn btn-outline-warning" data-tt="tooltip"
                                                            style="font-size: 1rem; color:#303030" data-placement="top"
                                                            title="Editar">
                                                            <i class="bi bi-pencil">
                                                            </i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalFuncionarios2 += $vagaDois->gato->first()->quantidade;
                                                    $totalVagas2 += $vagaDois->vagas;
                                                @endphp
                                            @endforeach
                                        @endforeach

                                        <!-- Total da segunda tabela -->
                                        <tr style="background-color: #436ce6">
                                            <td style="text-align: center"><strong>Total</strong></td>
                                            <td style="text-align: center"><strong>{{ $totalFuncionarios2 }}</strong></td>
                                            <td style="text-align: center"><strong>{{ $totalVagas2 }}</strong></td>
                                            <td style="text-align: center">
                                                <strong>{{ $totalVagas2 - $totalFuncionarios2 }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>

                                    <!-- Contagem geral -->

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
