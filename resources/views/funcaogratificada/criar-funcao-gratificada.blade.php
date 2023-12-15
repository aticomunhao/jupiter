@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <fieldset class="border rounded border-primary">
            <div class="card">
                <div class="card-header">
                    Adicionar Funcao Gratificada
                </div>

                <div class="card-body">
                    <form action="/incluir-funcao-gratificada">
                        @csrf

                        <div class="row flex-row justify-content-center">
                            <div class="col-lg-4 col-md-12">
                                <label for="idnomecargo">Nome do Cargo</label>
                                <input type="text" name="nomefuncao" id="idnomecargo" class="form-control"
                                       required="required">
                            </div>


                            <div class="col-lg-2 col-md-6 flex-column">
                                <label for="#id_data_inicial">Data Inicial</label>
                                <input type="date" name="data_inicial" id="id_data_inicial" class="form-control"
                                       required="required">
                            </div>
                            <div class="col-lg-2 col-md-6 flex-column">
                                <label for="#id_data_final">Data Final<i class="fa fa-terminal"
                                                                         aria-hidden="true"></i></label>
                                <input type="date" name="data_final" id="id_data_final" class="form-control">
                            </div>
                            <div class="col-lg-3 col-md-6 flex-column"><label for="#idsalario">Salario</label>
                                <input type="number" name="salario" id="idsalario" class="form-control" step="0.01"
                                       min="0" required="required">
                            </div>
                        </div>
                        <br>
                        <div class="row flex-row justify-content-around">
                            <div class="col-lg-3  col-sm-6 col-sm-12 flex-column">
                                <a href="../gerenciar-cargos-regulares" class="btn btn-danger"
                                   style=" box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);margin-top: 1%;width:100%">Cancelar</a>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-sm-12 flex-column">
                                <button type="submit" class="btn btn-success"
                                        style=" box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);width:100%; ">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </fieldset>
    </div>
    <br>
    </div>
@endsection
