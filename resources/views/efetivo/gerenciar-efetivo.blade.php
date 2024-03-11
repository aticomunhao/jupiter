@extends('layouts.app')
@section('head')
    <title>Gerenciar Efetivo</title>
@endsection
@section('content')
    <form id="gerenciarEfetivoForm" action="/gerenciar-efetivo" method="get">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Gerenciar Efetivo
                                </h5>
                            </div>
                            <br>
                            <hr>
                            <div class="card-body">
                                <div class="row" style="margin-left:5px">
                                    <div class="col">
                                        <label for="1">Selecione o Setor Desejado</label>
                                        <select id="idsetor" class="form-select" name="setor">
                                            <option></option>
                                            @foreach ($setor as $setores)
                                                <option value="{{ $setores->id_setor }}"
                                                    {{ old('setor', $nm_setor) == $setores->id_setor ? 'selected' : '' }}>
                                                    {{ $setores->nome_setor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col" style="padding-top:25px">
                                        <a href="/gerenciar-efetivo" type="button" class="btn btn-primary"
                                            value="">Limpar</a>
                                        <input type="submit" value="Pesquisar" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="table" style="padding-top:20px">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
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
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    <input type="checkbox" class="checkBox" name="checkboxes[]"
                                                        value="{{ $listas->ids }}" {{ $index === 0 ? 'disabled' : '' }}
                                                        {{ $listas->st_pai ? 'checked' : '' }}>
                                                </td>
                                                <td scope="">
                                                    {{ $listas->nome_setor }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->sigla }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->dt_inicio }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->status }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->nome_substituto }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->st_pai }}
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
                            <form id="updateForm" action="/atualizar-efetivo" method="post">
                                @csrf
                                <a href="/home" type="button" value="" class="btn btn-danger">Cancelar</a>
                                <input type="hidden" name="checkboxes" id="hiddenCheckboxes">
                                <input type="submit" value="Confirmar" class="btn btn-primary">
                            </form>
                        @endsection
