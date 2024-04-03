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
                            <div class="card-body">
                                <label for="1">Selecione a Forma de Pesquisa Desejada</label>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Cargo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Setor
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="1">Selecione o Setor Desejado</label>
                                    <select id="idsetor" class="form-select status select2" name="setor" multiple>
                                        <option></option>
                                        @foreach ($setor as $setores)
                                            <option value="{{ $setores->id_setor }}"
                                                {{ $setores->nome == $setores->id_setor ? 'selected' : '' }}>
                                                {{ $setores->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col" style="padding-top:24px;">
                                    <a href="/controle-vagas" type="button" class="btn btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 150px; margin-right: 5px"
                                        value="">Limpar</a>
                                    <input type="submit" value="Pesquisar" class="btn btn-success btn-light"
                                        style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 200px;">
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
                                            <th class="col-2">Vagas Remanescentes</th>
                                            <th class="col-2">Vagas Totais</th>
                                            <th class="col-2">Setor</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 15px; color:#000000;">
                                        @foreach ($base as $bases)
                                            <tr style="text-align: center">
                                                <td scope="">
                                                    {{ $bases->cargo }}
                                                </td>
                                                <td scope="">
                                                    {{ $totalFuncionariosSetor }}
                                                </td>
                                                <td scope="">

                                                </td>
                                                <td scope="">
                                                   {{ $totalVagasAutorizadas}}
                                                </td>
                                                <td scope="">
                                                    {{ $bases->nome}}
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            //Importa o select2 com tema do Bootstrap para a classe "select2"
            $('.select2').select2( { theme: 'bootstrap-5'});

        });
    </script>
@endsection
