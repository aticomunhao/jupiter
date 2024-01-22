@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">
                <span style="color: blue">Função Gratificada</span>
            </h5>
            <div class="card-body">
                <form action="{{ route('ArmazenarBaseSalarial', ['idf' => $idf]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cargo" class="form-label">Cargo:</label>
                            <select class="form-select" aria-label="Cargo" name="cargo">
                                @foreach ($cargo as $cargos)
                                    <option value="{{ $cargos->id }}">{{ $cargos->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="funcaog" class="form-label">Função Gratificada:</label>
                            <select class="form-select" aria-label="Função Gratificada" name="funcaog">
                                @foreach ($funcaoGratificada as $funcaoGratificadas)
                                    <option value="{{ $funcaoGratificadas->id }}">{{ $funcaoGratificadas->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- Add your custom scripts here if needed --}}
@endsection
