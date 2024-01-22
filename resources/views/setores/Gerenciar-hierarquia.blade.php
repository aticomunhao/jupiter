@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="border border-primary" style="border-radius: 5px;">
        <div class="card">
            <form id="gerenciarHierarquiaForm" action="/gerenciar-hierarquia" method="get">
                @csrf
                <div class="card-header">
                    <div class="row" style="margin-left:5px">
                        <div class="col-2">
                            <label for="1">Nivel</label>
                            <select id="idnivel" class="form-select" name="nivel">
                                <option></option>
                                @foreach ($nivel as $niveis)
                                <option value="{{ $niveis->id_nivel }}" {{ old('nivel', $nm_nivel) == $niveis->id_nivel ? 'selected' : '' }}>
                                    {{ $niveis->nome_nivel }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="1">Setor</label>
                            <select id="idsetor" class="form-select" name="nome_setor" disabled>
                                <option></option>
                                @foreach ($setor as $setor)
                                <option value="{{ $setor->id_setor }}" {{ old('nome_setor', $nome_setor) == $setor->id_setor ? 'selected' : '' }}>
                                    {{ $setor->nome_setor }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" style="padding-top:25px">
                            <a href="/home" type="button" value="" class="btn btn-danger">Cancelar</a>
                            <a href="/gerenciar-hierarquia" type="button" class="btn btn-primary" value="">Limpar</a>
                            <input type="submit" value="Pesquisar" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table" style="padding-top:20px">
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center;">
                        <tr style="background-color: #365699; font-size:18px; color:#ffffff">
                            <th class="col-1">
                                <input type="checkbox" id="masterCheckBox" name="checkbox">
                            </th>
                            <th class="col-4">Nome</th>
                            <th class="col-1">Sigla</th>
                            <th class="col-1">Data Inicio</th>
                            <th class="col-1">Status</th>
                            <th class="col-1">Substituto</th>
                            <th class="col-4">Setor Responsável</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">
                        @foreach ($lista as $index => $listas)
                        <tr>
                            <td scope="">
                                <center>
                                    <input type="checkbox" class="checkBox" name="checkboxes[]" value="{{ $listas->ids }}" {{ $index === 0 ? 'disabled' : '' }} {{ $listas->st_pai ? 'checked' : '' }}>
                                </center>
                            </td>
                            <td scope="">
                                <center>{{ $listas->nome_setor }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $listas->sigla }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $listas->dt_inicio }}</center>
                            </td>
                            <td scope="">
                                <center></center>
                            </td>
                            <td scope="">
                                <center>{{ $listas->nome_substituto }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $listas->st_pai }}</center>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    const masterCheckBox = $('#masterCheckBox');
                    const checkBoxes = $('.checkBox');

                    masterCheckBox.change(function() {
                        checkBoxes.prop('checked', masterCheckBox.prop('checked')).trigger('change');
                    });

                    checkBoxes.change(function() {
                        masterCheckBox.prop('checked', checkBoxes.length === checkBoxes.filter(':checked').length);
                        changeBackground($(this));
                    });

                    function changeBackground(input) {
                        const tableRow = input.closest('tr');
                        if (input.prop('checked')) {
                            tableRow.css('background', '#aaa');
                        } else {
                            tableRow.css('background', '');
                        }
                    }

                    $('#idsetor').change(function() {
                        var selectedSetor = $(this).val();
                        console.log("Valor selecionado no campo Setor:", selectedSetor);
                        // Se precisar, faça algo com o valor selecionado aqui
                    });
                    $('#idnivel option:nth-child(4)').hide();
                    $('#idnivel').change(function() {
                        var nivel_id = $(this).val();

                        $.ajax({
                            url: '/obter-setores/' + nivel_id,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#idsetor').removeAttr('disabled');
                                $('#idsetor').empty();
                                $.each(data, function(indexInArray, item) {
                                    $('#idsetor').append('<option value="' + item.id + '">' +
                                        item.nome + '</option>');
                                });
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    });

                    // Ao submeter o formulário
                    $('#updateForm').submit(function(event) {
                        console.log('Formulário enviado!');

                        const checkboxes = $('.checkBox:checked').map(function() {
                            return $(this).val();
                        }).get();

                        console.log('Valores dos checkboxes:', checkboxes);

                        $('#hiddenCheckboxes').val(checkboxes.join(','));
                    });
                });
            </script>
            <form id="updateForm" action="/atualizar-hierarquia" method="post">
                @csrf
                <a href="/home" type="button" value="" class="btn btn-danger">Cancelar</a>
                <input type="hidden" name="checkboxes" id="hiddenCheckboxes">
                <input type="submit" value="Confirmar" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
@endsection