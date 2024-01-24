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
                    <div class="col-md-6 col-sm-12">
                        <input class="form-control" type="text" value="{{ $tp_cargo->nomeTpCargo }}"
                            aria-label="Disabled input example" disabled>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-3 mt-md-0">
                        <form action="{{ route('ArmazenarBaseSalarial', ['idf' => $idf]) }}" method="POST">
                            @csrf
                            <select class="form-select" aria-label="Cargo" name="cargo">
                                <option value="">Escolha o Cargo</option>
                                @foreach ($cargo as $cargos)
                                    <option value="{{ $cargos->id }}">{{ $cargos->nome }}</option>
                                @endforeach
                            </select>

                    </div>
                    <center>
                        <div class="col-12" style="margin-top: 70px;">
                            <a href="/retorna-formulario/{{ $idf }}" class="btn btn-secondary col-3">
                                Cancelar
                            </a>
                            <button type = "submit" class="btn btn-primary col-3 offset-3">
                                Confirmar
                            </button>
                        </div>
                    </center>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
