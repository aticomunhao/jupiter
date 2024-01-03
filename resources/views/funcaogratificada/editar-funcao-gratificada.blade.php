@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <fieldset class="border rounded border-primary">
            <div class="card">
                <div class="card-header">
                    Editar Cargo Regular
                </div>

                <div class="card-body">
                    <form action="/alterar-funcao-gratificada/{{ $funcaogratificada->id }}">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <label for="#idnomecargo">Nome do Cargo</label>
                                <input type="text" name="nomecargo" id="idnomecargo" class="form-control"
                                       required="required" value="{{ $funcaogratificada->nomeFG }}">
                            </div>
                        </div>
                        <br>
                        <div class="container-fluid">
                            <div class="row flex-row justify-content-between">

                                <div class="col-lg-2 col-md-6 flex-column">
                                    <label for="#id_data_inicial">Data Inicial</label>
                                    <input type="date" name="data_inicial" id="id_data_inicial" class="form-control"
                                           required="required" value="{{ $funcaogratificada->dt_inicioFG }}">
                                </div>

                                <div class="col-lg-3 col-md-6 flex-column"><label for="#idsalario">Salario</label>
                                    <input type="number" name="salario" id="idsalario" class="form-control" step="0.01"
                                           min="0" value="{{ $funcaogratificada->salarioFG }}" required="required">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="exampleFormControlTextarea1" class="form-label">Motivo Alteracao</label>
                            <div class="container-fluid">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"
                                          name="motivoalteracao"
                                          required="required"></textarea>
                            </div>

                        </div>
                        <br>
                        <div class="row flex-row justify-content-around">
                            <div class="col-lg-3 col-sm-12 flex-column">
                                <a href="../gerenciar-funcao-gratificada" class="btn btn-danger"
                                   style=" box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);margin-top: 1%;width:100%">Cancelar</a>
                            </div>

                            <div class="col-lg-3 col-sm-12 flex-column">
                                <button type="submit" class="btn btn-success"
                                        style=" box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836);width:100%; ">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </fieldset>
    </div>
    </div>
@endsection
