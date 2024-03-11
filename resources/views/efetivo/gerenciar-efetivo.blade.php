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
                            <div style="text-align: center;">
                                <div style="display: inline-block; margin-right: 20px; position: relative; margin-bottom: 40px;">
                                    <label style="margin-bottom: 5px;">Quantidade atual de Funcionários</label>
                                    <div style="width: 50px; height: 50px; background-color: lightblue; text-align: center; line-height: 50px; position: absolute; left: 50%; transform: translateX(-50%);">
                                        <span style="display: inline-block;">10</span>
                                    </div>
                                </div>

                                <div style="display: inline-block; position: relative;">
                                    <label style="margin-bottom: 5px;">Quantidade máxima de Funcionários</label>
                                    <div style="width: 50px; height: 50px; background-color: lightblue; text-align: center; line-height: 50px; position: absolute; left: 50%; transform: translateX(-50%);">
                                        <span style="display: inline-block;">50</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <h5 style="margin-left: 5px; color: #355089; margin-bottom: -10px">
                                Funcionários
                            </h5>
                            <div class="table" style="padding-top:20px">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-1">CPF</th>
                                            <th class="col-1">Identidade</th>
                                            <th class="col-4">Nome Completo</th>
                                            <th class="col-2">Cargo</th>
                                            <th class="col-3">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($lista as $index => $listas)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    Teste
                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <hr>
                            <h5 style="margin-left: 5px; color: #355089; margin-bottom: -10px">
                                Menor Aprendiz
                            </h5>
                            <div class="table" style="padding-top:20px">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-1">CPF</th>
                                            <th class="col-1">Identidade</th>
                                            <th class="col-4">Nome Completo</th>
                                            <th class="col-2">Cargo</th>
                                            <th class="col-3">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($lista as $index => $listas)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    Teste
                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">

                                                </td>
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
@endsection
