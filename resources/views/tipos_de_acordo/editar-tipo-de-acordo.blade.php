@extends('layouts.app')
@section('head')
    <title>
        Editar Tipo de Acordo</title>
@endsection
@section('content')
    
    <br>
    <div class="container"> {{-- Container completo da página  --}}
        <div class="row justify-content-center">
            <div class="col-md-8"> {{-- Ajuste a largura do card conforme necessário --}}
                <div class="card">
                    <div class="card-header">
                        Editar Novo Tipo de Acordo
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.tipos-de-acordo', ['id' => $tipo_de_acordo->id]) }}" method="PUT">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" type="text" maxlength="100" name="nome" required
                                    value="{{ $tipo_de_acordo->nome }}">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('index.tipos-de-acordo') }}" class="btn btn-danger">Cancelar</a>
                                <button class="btn btn-success" type="submit">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
