@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="border border-primary" style="border-radius: 5px;">
        <div class="card">
            <form id="gerenciarHierarquiaForm" action="/consultar-hierarquia/" method="POST">
                <div class="card-header">
                    <div class="row" style="margin-left:5px">
                        <div class="col-2">
                            <label for="1">Nivel</label>
                            <select id="idnivel" class="form-select" name="nivel">
                                <option></option>
                                @foreach ($nivel as $niveis)
                                <option value="{{ $niveis->id_nivel }}">{{ $niveis->nome_nivel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="1">Setor</label>
                            <select id="idsetor" class="form-select" name="nome_setor" disabled>
                                <option></option>
                            </select>
                        </div>
                        <div class="col" style="padding-top:25px">
                            <a href="/gerenciar-hierarquia" type="button" value="" class="btn btn-danger">Cancelar</a>
                            <a href="/gerenciar-hierarquia" type="button" class="btn btn-primary" value="">Limpar</a>
                            <input type="submit" value="Confirmar" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table" style="padding-top:20px">
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center;">
                        <tr style="background-color: #365699; font-size:19px; color:#ffffff">
                            <th class="col-1"><input type="checkbox" id="masterCheckBox"></th>
                            <th class="col-4">Nome</th>
                            <th class="col-2">Sigla</th>
                            <th class="col-2">Data de Inicio</th>
                            <th class="col-1">Status</th>
                            <th class="col-2">Substituto</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">
                        <tr>
                            @foreach ($setor as $setores)
                            <td scope="">
                                <center><input type="checkbox" class="checkBox"></center>
                            </td>
                            <td scope="">
                                <center>{{ $setores->nome_setor }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $setores->sigla }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $setores->dt_inicio }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $setores->status ? 'Ativo' : 'Inativo' }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $setores->nome_substituto }}</center>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    const masterCheckBox = document.getElementById('masterCheckBox');
                    const checkBoxes = Array.from(document.querySelectorAll('.checkBox'));

                    // Marca ou desmarca todas as checkboxes de acordo com a checkbox master
                    masterCheckBox.addEventListener('change', function(event) {
                        checkBoxes.forEach(function(e) {
                            e.checked = event.target.checked;
                            changeBackground(e);
                        });
                    });

                    // Marca masterCheckBox se todas as outras estiverem marcadas
                    // Desmarca se pelo menos uma estiver desmarcada
                    checkBoxes.forEach(function(e) {
                        e.addEventListener('change', function(event) {
                            masterCheckBox.checked = checkBoxes.every(function(f) {
                                return f.checked;
                            });
                            changeBackground(e);
                        });
                    });

                    // Destaca background das linhas selecionadas
                    function changeBackground(input) {
                        const tableRow = input.parentElement.parentElement;
                        if (input.checked) tableRow.style.background = '#aaa';
                        else tableRow.style.background = '';
                    }
                    $('#idsetor').change(function() {
                        var selectedSetor = $(this).val();
                        console.log("Valor selecionado no campo Setor:", selectedSetor);
                        // Se precisar, faça algo com o valor selecionado aqui
                    });

                    // Ao submeter o formulário
                    $('#gerenciarHierarquiaForm').submit(function(event) {
                        // Captura o valor selecionado no campo "Setor" e atribui ao campo oculto
                        var selectedSetor = $('#idsetor').val();
                        $('#hiddenSetor').val(selectedSetor);

                        // Evita o envio automático do formulário
                        event.preventDefault();

                        // Submete manualmente o formulário
                        $(this).unbind('submit').submit();
                    });


                    // Início do código AJAX
                    $('#idnivel').change(function() {
                        var nivel_id = $(this).val();

                        $.ajax({
                            url: '/obter-setores/' + nivel_id,
                            type: 'GET',
                            success: function(data) {
                                $('#idsetor').removeAttr('disabled');
                                $('#idsetor').empty();
                                $.each(data, function(index, item) {
                                    $('#idsetor').append('<option value="' + item.id + '">' + item.nome + '</option>');
                                });

                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>
</div>
@endsection