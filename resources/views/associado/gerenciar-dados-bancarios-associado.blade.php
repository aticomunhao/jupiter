@extends('layouts.app')
@section('head')
<title>Gerenciar Dados Bancarios Associado</title>
@endsection
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<br />
<div class="container"> {{-- Container completo da página  --}}
    <div class="card" style="border-color: #5C7CB6;">
        <div class="card-header">
            Gerenciar Dados Bancarios Associado
        </div>
        <div class="card-body">
            <div class="row"> {{-- Linha com o nome e botão novo --}}
                <div class="col-md-4 col-10">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}} style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 30px; padding-left: 10px; background-color: #ebebeb;">
                    </fieldset>
                </div>
                <div class="col-md-1 col-6">
                    <fieldset {{-- Gera a barra ao redor do nome do funcionario --}} style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 30px; padding-left: 50px; background-color: #ebebeb;">
                    </fieldset>
                </div>
                <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                    <a href="/incluir-dados-bancarios/" class="col-6"><button type="button" class="btn btn-success col-md-8 col-12">Novo+</button></a>
                </div>
            </div>
        </div>
        <hr />
        <div class="row d-flex justify-content-evenly">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Título do card</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Subtitulo do card</h6>
                        <p class="card-text">Um exemplo de texto rápido para construir o título do card e fazer preencher o conteúdo do card.</p>
                        <a href="#" class="card-link">Link do card</a>
                        <a href="#" class="card-link">Outro link</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Título do card</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Subtitulo do card</h6>
                        <p class="card-text">Um exemplo de texto rápido para construir o título do card e fazer preencher o conteúdo do card.</p>
                        <a href="#" class="card-link">Link do card</a>
                        <a href="#" class="card-link">Outro link</a>
                    </div>
                </div>
            </div>
            @endsection