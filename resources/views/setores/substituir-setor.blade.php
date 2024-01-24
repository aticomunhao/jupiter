@extends('layouts.app')
@section('head')
<title>Substituir-setor</title>
@endsection
@section('content')
<br />

<div class="container">

    <div class="card" style="border-color:#355089">

        <div class="card-header">
            Substituir Setor
        </div>

        <div class="card-body">

            <br>
            <div class="row justify-content-start">
                <form method="POST" action="/substituir-setor/{ids}">{{-- Formulario de envio  --}}
                    @csrf

                    <div class="row col-10 offset-1" style="margin-top:none">

                        <div class=" col-12">
                            <div>Selecione Setor Substituto</div>
                            <select class="form-select" name="setor_substituto">
                                <value="">
                                    <option value=""></option>
                                    @foreach ($setor as $setores)
                                    <option value="{{ $setores->id }}">{{ $setores->nome}}</option>
                                    @endforeach

                            </select>
                        </div>




                        <center>
                            <div class="col-12" style="margin-top: 70px;">
                                <a href="/gerenciar-setor" class="btn btn-secondary col-4">{{-- Botao de cancelar com link para o index --}}
                                    Cancelar
                                </a>

                                <button type="submit" class="btn btn-primary col-4 offset-3">{{-- Botao submit --}}
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