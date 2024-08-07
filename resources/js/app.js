import './bootstrap';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import 'bootstrap5-toggle/js/bootstrap5-toggle.ecmas.min.js';

import $ from 'jquery';

import 'select2';

import './custom';

window.$ = window.jQuery = $;

////script de estado com cidade

$(document).ready(function () {
    $('#cidade1, #cidade2, #setorid').select2({
        theme: 'bootstrap-5',
        width: '100%',
    });

    function populateCities(selectElement, stateValue) {
        $.ajax({
            type: "get",
            url: "/retorna-cidade-dados-residenciais/" + stateValue,
            dataType: "json",
            success: function (response) {
                selectElement.empty();
                $.each(response, function (indexInArray, item) {
                    selectElement.append('<option value="' + item.id_cidade + '">' + item.descricao + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error("An error occurred:", error);
            }
        });
    }

    $('#uf1').change(function (e) {
        var stateValue = $(this).val();
        $('#cidade1').removeAttr('disabled');
        populateCities($('#cidade1'), stateValue);
    });

    $('#uf2').change(function (e) {
        var stateValue = $(this).val();
        $('#cidade2').removeAttr('disabled');
        populateCities($('#cidade2'), stateValue);
    });

    $('#idlimpar').click(function (e) {
        $('#idnome_completo').val("");
    });
});


//tooltip permitindo um modal junto com o tooltip no mesmo botão

import { Tooltip } from 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl);
    });
});

//// script controle de vagas

$(document).ready(function () {
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
    $("input[type='radio'][name='pesquisa']").change(function () {
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
