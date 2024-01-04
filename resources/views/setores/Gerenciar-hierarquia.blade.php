@extends('layouts.app')

@section('content')
    <br>

    <div class="container">
        <div class="border border-primary" style="border-radius: 5px;">
            <div class="card">
                <div class="card-header">
                    <div class="row" style="margin-left:5px">
                        <div class="col-2">
                            <label for="1">Nivel</label>
                            <select id="idnivel" class="form-select" name="nivel" value="{{ $nome_nivel }}" type="text">
                                <option></option>
                                @foreach ($nivel as $niveis)
                                    <option value="{{ $niveis->id_nivel }}">{{ $niveis->nome_nivel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="1">Setor</label>
                            <select id="idsetor" class="form-select" name="setor" type="text" value="{{ $nome_setor }}">
                                <option></option>
                                @foreach ($setor as $setores)
                                    <option value="{{ $setores->id_setor }}">{{ $setores->nome_setor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" style="padding-top:25px">
                            <a href="" type="button" value="" class="btn btn-danger">Cancelar</a>
                            <a href="" type="button" class="btn btn-primary" value="">Limpar</a>
                            <input type="submit" value="Confirmar" class="btn btn-success">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <hr>
                    <h5 style="padding-top:20px" class="card-title">Hierarquia de Setores</h5>
                    <div class="row" style="padding-top:20px">
                        <div class="col-2">
                            <label for="3">Ordenar</label>
                            <select id="3" class="form-select" name="nivel" type="text">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="4">Data de Inicio</label>
                            <input type="date" class="form-control" name="dt_inicio" id="4" value="">
                        </div>
                        <div class="col-2">
                            <label for="5">Nivel</label>
                            <select id="1" class="form-select" name="nivel" value="{{ $nome_nivel }}" type="text">
                                <option></option>
                                @foreach ($nivel as $niveis)
                                    <option value="{{ $niveis->id_nivel }}">{{ $niveis->nome_nivel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" style="padding-top:25px">
                            <a href="" type="button" class="btn btn-success" value="">Confirmar</a>
                        </div>
                    </div>
                    <div class="table" style="padding-top:20px">
                        <table
                            class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
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
                            @foreach ($setor as $setores)
                                <tr>
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

                        <a href="" type="button" value="" class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Confirmar" class="btn btn-success">

                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const masterCheckBox = document.getElementById('masterCheckBox');
                            const checkBoxes = Array.from(document.querySelectorAll('.checkBox'));

                            // Marca ou desmarca todas as checkboxes de acordo com a checkbox master
                            masterCheckBox.addEventListener('change', function (event) {
                                checkBoxes.forEach(function (e) {
                                    e.checked = event.target.checked;
                                    changeBackground(e);
                                });
                            });

                            // Marca masterCheckBox se todas as outras estiverem marcadas
                            // Desmarca se pelo menos uma estiver desmarcada
                            checkBoxes.forEach(function (e) {
                                e.addEventListener('change', function (event) {
                                    masterCheckBox.checked = checkBoxes.every(function (f) {
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

                            //JQUERY
                            $(document).ready(function () {
                                const idNivelSelect = $('#idnivel');
                                const idSetorSelect = $('#idsetor');
                                const nomeSetorElement = $('#nomeSetor');
                                const responsavelSetorElement = $('#responsavelSetor');

                                idNivelSelect.on('change', function () {
                                    const nivel = $(this).val();

                                    if (nivel) {
                                        $.ajax({
                                            type: "get",
                                            url: "/retornar-setor/" + nivel,
                                            dataType: "json",
                                            success: function (response) {
                                                if (response && response.setor) {
                                                    // Update the displayed information
                                                    nomeSetorElement.text('Nome: ' + response.setor.nome_setor);
                                                    responsavelSetorElement.text('Responsável: ' +
                                                        response.setor.responsavel);

                                                    // Update options in the idsetor select element
                                                    idSetorSelect.empty(); // Clear existing options
                                                    idSetorSelect.append('<option></option>'); // Add an empty option

                                                    // Add options based on the data returned from the server
                                                    $.each(response.setores, function (index, setor) {
                                                        idSetorSelect.append('<option value="' +
                                                            setor.id_setor + '">' + setor.nome_setor + '</option>');
                                                    });

                                                    // Enable the idsetor select element
                                                    idSetorSelect.prop('disabled', false);
                                                } else {
                                                    console.log('Setor não encontrado.');
                                                }
                                            },
                                            error: function (error) {
                                                console.log(error);
                                            }
                                        });
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
