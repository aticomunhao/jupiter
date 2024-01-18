@extends('layouts.app')
@section('head')
    <title>Gerenciar Cargos</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                Gerenciar Cargos
            </div>
            <div class="card-body">
                <form method="GET" action="/gerenciar-cargos">{{-- Formulario de pesquisa --}}
                    @csrf
                    <div class="row justify-content-start">
                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                name="pesquisa"{{-- Input de pesquisa --}} value= "" maxlength="40">
                        </div>
                        <div class="col-md-8 col-12">

                            <button class="btn btn-secondary col-md-3 col-12 mt-5 mt-md-0 "{{-- Botao submit do formulario de pesquisa --}}
                                type="submit">Pesquisar</button>

                            <a href="/incluir-cargos"{{-- Botao com rota para incluir cargo --}}
                                class="btn btn-success col-md-3 col-12 offset-md-5 offset-0 mt-2 mt-md-0">
                                Novo+
                            </a>
                        </div>
                    </div>{{-- Final Formulario de pesquisa --}}
                </form>
                <br />
                <hr>
                <table{{-- Inicio da tabela de informacoes --}}
                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle table-responsive">
                    {{-- inicio header tabela --}}
                    <thead style="text-align: center; ">
                        <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                            <th>Foreign Key</th>
                            <th>Nome</th>
                            <th>Salário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>{{-- Fim do header da tabela --}}
                    <tbody style="font-size: 15px; color:#000000;">{{-- Inicio body tabela --}}

                        {{-- Espaco de insercao para a tabela (Foreach)  --}}

                    </tbody>{{-- Fim body da tabela --}}
                    </table>
            </div>
        </div>
    </div>
    {{-- Scritp  de funcionamento dos tooltips --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
