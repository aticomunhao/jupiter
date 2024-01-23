@extends('layouts.app')
@section('head')
    <title>Tipo de Cargo</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Tipo de Cargo
            </div>
            <div class="card-body">
                <form action="{{ route('IncluirBaseSalarial', ['idf' => $idf]) }}" method="POST">
                    @csrf
                    <div class="row justify-content-start">
                        <div class="col-md-6 col-sm-12">
                            <select class="form-select" name="tipocargo" id="tipocargo">
                                @foreach ($tp_cargo as $tp_cargos)
                                    <option value="{{ $tp_cargos->idTpCargo }}">{{ $tp_cargos->nomeTpCargo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <button
                                class="btn btn-success col-md-3 col-12 offset-md-8 offset-0 mt-2 mt-md-0" type="submit">
                                Novo+
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
