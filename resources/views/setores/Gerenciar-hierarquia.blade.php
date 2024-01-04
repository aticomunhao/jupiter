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

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
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
