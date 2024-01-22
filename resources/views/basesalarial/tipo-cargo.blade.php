@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                Tipo de Cargo
            </div>
            <div class="card-body">
                <form action="{{ route('IncluirBaseSalarial', ['idf' => $idf]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tipocargo" class="form-label">Selecione o Tipo de Cargo:</label>
                        <select class="form-select" id="tipocargo" name="tipocargo">
                            @foreach ($tp_cargo as $tp_cargos)
                                <option value="{{ $tp_cargos->idTpCargo }}">{{ $tp_cargos->nomeTpCargo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
