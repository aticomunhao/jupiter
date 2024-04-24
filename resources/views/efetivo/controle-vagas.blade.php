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
                                                    <option value="{{ $setores->idSetor }}">{{ $setores->nomeSetor }}
                                                    </option>
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
                                            <th class="col-4">Cargo</th>
                                            <th class="col-2">Vagas Preenchidas</th>
                                            <th class="col-2">Vagas Totais</th>
                                            <th class="col-2">Vagas Remanescentes</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;" id='cargoTabela'>
                                        @php
                                            $cargosExibidos = []; // Array para armazenar os cargos já exibidos
                                        @endphp
                                        @foreach ($cargo as $cargos)
                                            @if ($cargos->nomeCargo && !in_array($cargos->nomeCargo, $cargosExibidos))
                                                @php
                                                    $vagasTotais = 0; // Inicializa as vagas totais para este cargo
                                                @endphp
                                                @foreach ($vaga as $v)
                                                    @if ($v->idDoCargo == $cargos->idCargo)
                                                        @php
                                                            $vagasTotais += $v->total_vagas; // Soma as vagas totais para este cargo
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <tr style="text-align: center">
                                                    <td scope="">{{ $cargos->nomeCargo }}</td>
                                                    <td scope="">{{ $cargos->quantidade_funcionarios }}</td>
                                                    <td scope="">
                                                        {{ $vagasTotais }}</td>
                                                    <!-- Exibe as vagas totais -->
                                                    <td scope="">
                                                        {{ $vagasTotais - $cargos->quantidade_funcionarios }}</td>
                                                </tr>
                                                @php
                                                    $cargosExibidos[] = $cargos->nomeCargo; // Adiciona o cargo ao array de cargos exibidos
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tbody style="font-size: 15px; color:#000000;" id='setorTabela'>
                                        @foreach ($setor as $setor)
                                            <tr style="text-align: center">
                                                <td colspan="" style="font-weight: bold;">{{ $setor->nomeSetor }}</td>
                                                <td colspan="" style="font-weight: bold;">Funcionários</td>
                                                <td colspan="" style="font-weight: bold;">Autorizadas</td>
                                                <td colspan="" style="font-weight: bold;">Sobrando</td>
                                            </tr>
                                            @php
                                                $totalVagasSetor = 0;
                                                $totalFuncionariosSetor = 0;
                                            @endphp
                                            @foreach ($cargo as $cargos)
                                                @if ($cargos->idCargo == $setor->idDoCargo)
                                                    <tr style="text-align: center">
                                                        <td scope="">{{ $cargos->nomeCargo }}</td>
                                                        <td scope="">{{ $cargos->quantidade_funcionarios }}</td>
                                                        <td scope="">{{ $setor->total_vagas }}</td>
                                                        <td scope="">{{ $setor->total_vagas - $cargos->quantidade_funcionarios }}</td>
                                                        @php
                                                            $totalFuncionariosSetor += $cargos->quantidade_funcionarios;
                                                            $totalVagasSetor += $setor->total_vagas; // Adicionar vagas do setor ao total
                                                        @endphp
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr style="text-align: center; font-weight: bold;">
                                                <td>Total</td>
                                                <td>{{ $totalFuncionariosSetor }}</td>
                                                <td>{{ $totalVagasSetor }}</td>
                                                <td>{{ $totalVagasSetor - $totalFuncionariosSetor }}</td>
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
