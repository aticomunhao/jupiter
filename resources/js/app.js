import './bootstrap';

import $ from 'jquery';

import 'select2';

import './custom';

window.$ = window.jQuery = $;

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