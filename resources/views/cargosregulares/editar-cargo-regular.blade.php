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
                    <form action="/alterar-cargo-regular/{{ $cargoregular->id }}">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                @if ($cargoregular->nomeCR != null)
                                    <label for="#idnomecargo">Nome do Cargo</label>
                                    <input type="text" name="nomecargo" id="idnomecargo" class="form-control"
                                           required="required" value="{{ $cargoregular->nomeCR }}">
                                @elseif($cargoregular->nomeCC != null)
                                    <label for="#idnomecargo">Nome do Cargo</label>
                                    <input type="text" name="nomecargo" id="idnomecargo" class="form-control"
                                           required="required" value="{{ $cargoregular->nomeCC }}">
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="container-fluid">
                            <div class="row flex-row justify-content-between">
                                <div class="col-lg-3 flex-column col-md-6">
                                    <label for="#id_tipo_cargo">Tipo de Cargo</label>
                                    <select class="form-select form-select" aria-label="Default select example"
                                            id="id_tipo_cargo" name="tipo_cargo">
                                        <option value="1">Cargo Regular</option>
                                        <option value="2">Cargo De Confiança</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 flex-column">
                                    <label for="#id_data_inicial">Data Inicial</label>
                                    <input type="date" name="data_inicial" id="id_data_inicial" class="form-control"
                                           required="required" value="{{ $cargoregular->dt_inicioCR }}">
                                </div>

                                <div class="col-lg-3 col-md-6 flex-column">
                                    <label for="#idsalario">Salario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" name="salario" id="idsalario" class="form-control" step="0.01" min="0" value="{{ $cargoregular->salariobase }}" required="required">
                                    </div>
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
                                <a href="../gerenciar-cargos-regulares" class="btn btn-danger"
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
