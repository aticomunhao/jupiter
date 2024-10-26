@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('head')
    <title>Gerenciar Férias</title>
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Férias
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <form action="/administrar-ferias" method="GET">
                            <div class="row justify-content-between">
                                <div class="col-md-3 col-sm-12">
                                    <h5>Nome do Funcionário</h5>
                                    <input type="text" name="nomefuncionario" id="idnomefuncionario"
                                        @if ($nome_funcionario != null) value="{{ $nome_funcionario }}" @endif
                                        class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <h5>Selecione o Período Aquisitivo</h5>
                                    <select class="form-select" aria-label="Ano" name="anoconsulta" id="idanoconsulta">
                                        @if ($ano_consulta != null)
                                            <option value="{{ $ano_consulta }}">{{ $ano_consulta }} -
                                                {{ $ano_consulta + 1 }}
                                            </option>
                                        @endif
                                        <option value="*">Todos</option>
                                        @foreach ($anos_possiveis as $ano_possivel)
                                            <option value="{{ $ano_possivel->ano_de_referencia }}">
                                                {{ $ano_possivel->ano_de_referencia }}
                                                -{{ $ano_possivel->ano_de_referencia + 1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <h5>Selecione o Setor</h5>
                                    <select class="form-select" aria-label="Ano" name="setorconsulta" id="idsetorconsulta">

                                        @if ($setor != null)
                                            <option value="{{ $setor->id }}">{{ $setor->sigla }}
                                            </option>
                                        @endif
                                        <option value="">Todos</option>
                                        @foreach ($setores_unicos as $setor_unico)
                                            <option value="{{ $setor_unico->id }}">
                                                {{ $setor_unico->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <h5>Selecione o Status</h5>
                                    <select class="form-select" aria-label="Ano" name="statusconsulta"
                                        id="idstatusconsulta">
                                        @if ($status_consulta_atual != null)
                                            <option value="{{ $status_consulta_atual->id }}">
                                                {{ $status_consulta_atual->nome }}
                                            </option>
                                        @endif
                                        <option value="">Todos</option>
                                        @foreach ($status_ferias as $id_status_ferias)
                                            <option value="{{ $id_status_ferias->id }}">
                                                {{ $id_status_ferias->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-submit btn-primary"
                                        style="width:100%; margin-top: 20%">Pesquisar</button>
                                </div>
                        </form>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalCriarFerias"
                                style="font-size: 1rem; box-shadow: 1px 2px 5px #000000;margin-top: 20%"
                                data-toggle="tooltip" data-placement="top" title="Texto ao passar o mouse">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalCriarFerias" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Gerar novo período de Férias
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('AbreFerias') }}">
                                            @csrf
                                            <h3>Periodo Aquisitivo</h3>
                                            <select class="form-select custom-select" aria-label="Ano" name="ano_referencia"
                                                id="ano" style="color: #0e0b16">
                                                @foreach ($listaAnos as $ano)
                                                    <option value="{{ $ano }}">{{ $ano }}
                                                        - {{ $ano + 1 }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; ">Close</button>
                                        <button type="submit" class="btn btn-success"
                                            style="box-shadow: 1px 2px 5px #0e0b16;">Gerar Novo Período
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Modal-->
                    </div>
                    <br>
                    <hr>

                    <br>


                    @if (!empty($periodo_aquisitivo))
                        <div style="max-height: 400px; overflow-y: auto;">
                            <div class="table-reponsive">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                    style="margin-top:10px;">
                                    <thead
                                        style="text-align: center; position: sticky; top: 0; z-index: 1; background-color: #d6e3ff;">
                                        <tr style="font-size:17px; color:#000000;">
                                            <th scope="col" style="position: sticky; top: 0;">Nome do Funcionário</th>
                                            <th scope="col" style="position: sticky; top: 0;">Setor</th>
                                            <th scope="col" style="position: sticky; top: 0;" colspan="2">Periodo
                                                Aquisitivo</th>
                                            <th scope="col" style="position: sticky; top: 0;">Início 1</th>
                                            <th scope="col" style="position: sticky; top: 0;">Fim 1</th>
                                            <th scope="col" style="position: sticky; top: 0;">Início 2</th>
                                            <th scope="col" style="position: sticky; top: 0;">Fim 2</th>
                                            <th scope="col" style="position: sticky; top: 0;">Início 3</th>
                                            <th scope="col" style="position: sticky; top: 0;">Fim 3</th>
                                            <th scope="col" style="position: sticky; top: 0;">Status</th>
                                            <th scope="col" style="position: sticky; top: 0;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="idtable">
                                        @foreach ($periodo_aquisitivo as $periodos_aquisitivos)
                                            <tr>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->sigla_do_setor ?? 'N/A' }}</td>
                                                <td style="text-align: center">
                                                    {{ Carbon::parse($periodos_aquisitivos->inicio_periodo_aquisitivo)->format('d/m/y') }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ Carbon::parse($periodos_aquisitivos->fim_periodo_aquisitivo)->format('d/m/y') }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_a ? Carbon::parse($periodos_aquisitivos->dt_ini_a)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_a ? Carbon::parse($periodos_aquisitivos->dt_fim_a)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_b ? Carbon::parse($periodos_aquisitivos->dt_ini_b)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_b ? Carbon::parse($periodos_aquisitivos->dt_fim_b)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_ini_c ? Carbon::parse($periodos_aquisitivos->dt_ini_c)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->dt_fim_c ? Carbon::parse($periodos_aquisitivos->dt_fim_c)->format('d/m/y') : '--' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $periodos_aquisitivos->status_pedido_ferias }}</td>
                                                <td style="text-align: center">
                                                    <!-- Adicionar lógica para botões de ações -->
                                                    @if ($periodos_aquisitivos->id_status_pedido_ferias == 4)
                                                        <a href="{{ route('autorizarFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                            class="btn btn-outline-success" title="Autorizar Férias"><i
                                                                class="bi bi-check2"></i></a>
                                                        <a href="{{ route('FormularioFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                            class="btn btn-outline-danger" title="Recusar Férias"><i
                                                                class="bi bi-x"></i></a>
                                                    @else
                                                        <a class="btn btn-outline-secondary disabled"
                                                            aria-label="Close"><i class="bi bi-check2"></i></a>
                                                        <a class="btn btn-outline-secondary disabled"
                                                            aria-label="Close"><i class="bi bi-x"></i></a>
                                                    @endif
                                                    @if ($periodos_aquisitivos->id_status_pedido_ferias == 6)
                                                        <button type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $periodos_aquisitivos->id_ferias }}"
                                                            title="Reabrir Formulário"><i
                                                                class="bi bi-arrow-counterclockwise"></i></button>
                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModal{{ $periodos_aquisitivos->id_ferias }}"
                                                            tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary text-white">
                                                                        <h2 class="modal-title">Reabrir Formulário</h2>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Deseja Reabrir as férias do funcionário: <span
                                                                            class="text-primary">{{ $periodos_aquisitivos->nome_completo_funcionario ?? 'N/A' }}</span>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <a
                                                                            href="{{ route('ReabrirFormulario', ['id' => $periodos_aquisitivos->id_ferias]) }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Confirmar</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <a href="{{ route('HistoricoRecusaFerias', ['id' => $periodos_aquisitivos->id_ferias]) }}"
                                                        class="btn btn-outline-secondary" title="Histórico"><i
                                                            class="bi bi-search"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
    </div>



    <!-- <script>
        $(document).ready(function() {
            // Função para carregar os dados com base nos filtros
            var timeout = null;

            function carregarDados() {
                clearTimeout(timeout); // Limpa o timeout anterior, se houver

                // Define um novo timeout para executar a função após 500ms do último evento de input
                timeout = setTimeout(function() {
                    var anoconsulta = $('#idanoconsulta').val() || "null";
                    var setorconsulta = $('#idsetorconsulta').val() || "null";
                    var nomefuncionario = $('#idnomefuncionario').val() || "null";
                    var statusconsulta = $('#idstatusconsulta').val() || "null";
                    console.log(statusconsulta);


                    $('#idtable').empty(); // Limpa a tabela antes de adicionar novos dados

                    $.ajax({
                        type: "GET",
                        url: "/retorna-periodo-ferias/" + anoconsulta + "/" + nomefuncionario +
                            "/" + setorconsulta + "/" + statusconsulta,
                        dataType: "json",
                        success: function(response) {
                            $('#idtable').empty();
                            console.log(
                                response); // Exemplo de como processar os dados retornados
                            $.each(response, function(index, item) {
                                // Cria uma nova linha na tabela
                                var newRow = $('<tr>');

                                // Adiciona as células da linha com os dados do item atual
                                newRow.append('<td style="text-align: center">' + (item
                                        .nome_completo_funcionario ?? 'N/A') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                    .sigla_do_setor ?? 'N/A') + '</td>');
                                newRow.append('<td style="text-align: center">' + (
                                        parseInt(item.ano_de_referencia)) +
                                    ' - ' + (parseInt(item.ano_de_referencia) + 1) +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_ini_a ? new Date(item.dt_ini_a)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_fim_a ? new Date(item.dt_fim_a)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_ini_b ? new Date(item.dt_ini_b)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_fim_b ? new Date(item.dt_fim_b)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_ini_c ? new Date(item.dt_ini_c)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + (item
                                        .dt_fim_c ? new Date(item.dt_fim_c)
                                        .toLocaleDateString('pt-BR') : '--') +
                                    '</td>');
                                newRow.append('<td style="text-align: center">' + item
                                    .status_pedido_ferias + '</td>');

                                // Botões condicionais com base no status
                                var actionsCell = $('<td style="text-align: center">');

                                if (item.id_status_pedido_ferias == 4) {
                                    actionsCell.append('<a href="/autorizar-ferias/' +
                                        item.id_ferias +
                                        '"><button class="btn btn-outline-success" style="font-size: 1rem; color:#0e0b16;" data-tt="tooltip" data-placement="top" title="Autorizar Férias"><i class="bi bi-check2"></i></button></a>'
                                    );
                                    actionsCell.append(
                                        '<a href="/formulario-recusar-ferias/' +
                                        item.id_ferias +
                                        '"><button class="btn btn-outline-danger" style="font-size: 1rem; color:#0e0b16;" data-tt="tooltip" data-placement="top" title="Recusar Férias"><i class="bi bi-x"></i></button></a>'
                                    );
                                } else {
                                    actionsCell.append(
                                        '<a href="#" class="disabled" aria-disabled="true"><button class="btn btn-outline-secondary" disabled aria-label="Close"><i class="bi bi-check2"></i></button></a>'
                                    );
                                    actionsCell.append(
                                        '<a href="#" class="disabled" aria-disabled="true"><button class="btn btn-outline-secondary" disabled aria-label="Close"><i class="bi bi-x"></i></button></a>'
                                    );
                                }

                                actionsCell.append(
                                    '<a href="/visualizar-historico-recusa-ferias/' +
                                    item.id_ferias +
                                    '" class="disabled" aria-disabled="true"><button class="btn btn-outline-secondary" aria-label="Close" style="font-size: 1rem; color:#0e0b16;" data-tt="tooltip" data-placement="top" title="Histórico"><i class="bi bi-search"></i></button></a>'
                                );

                                newRow.append(actionsCell);

                                // Adiciona a nova linha à tabela com id 'idtable'
                                $('#idtable').append(newRow);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log('Erro na requisição AJAX:', error);
                        }
                    });
                }, 500); // Tempo de espera em milissegundos (500ms)
            }
            // Evento input para o campo de nome do funcionário
            $('#idnomefuncionario').on('input', carregarDados);

            // Eventos de mudança nos campos de ano e setor
            $('#idanoconsulta').change(carregarDados);
            $('#idsetorconsulta').change(carregarDados);
            $('#idstatusconsulta').change(carregarDados);
        });
    </script>-->

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#idsetorconsulta').select2();
        });
    </script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    <script>
        $(document).ready(function() {
            const $tableHead = $('thead');
            const $tableBody = $('tbody');

            // Mover o cabeçalho junto com a rolagem
            $('.table-responsive').on('scroll', function() {
                const scrollTop = $(this).scrollTop();
                $tableHead.css('transform', 'translateY(' + scrollTop + 'px)');
            });
        });
    </script>
@endsection
