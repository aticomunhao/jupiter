@extends('layouts.app')

@section('head')
    <title>Incluir Base Salarial</title>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Incluir Base Salarial
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4 col-sm-12">
                        <input class="form-control" type="text" value="{{ $tp_cargo->nomeTpCargo }}" aria-label="Disabled input example" disabled>
                    </div>
                    <div class="col-md-4 col-sm-12 mt-3 mt-md-0">
                        <form action="{{ route('ArmazenarBaseSalarial', ['idf' => $idf]) }}" method="POST">
                            @csrf
                            <select class="form-select" aria-label="Cargo" name="cargo">
                                <option value="">Escolha o Cargo</option>
                                @foreach ($cargo as $cargos)
                                    <option value="{{ $cargos->id }}">{{ $cargos->nome }}</option>
                                @endforeach
                            </select>
                            <br>

                            <button class="btn btn-primary col-md-6 col-12 offset-md-5 offset-0 mt-3 mt-md-0" type="submit">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
