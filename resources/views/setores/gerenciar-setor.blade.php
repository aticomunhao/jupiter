@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Setores
                            </h5>
                        </div>
                    </div>
                    <div>
                        <div class="card-body">
                            <div class="justify-content-center" class="form-horizontal" method="GET">
                                <div class="row mt-2">
                                    <div class="col-3" >Setor
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="50" type="text" id="2"
                                            name="nome" value="{{ $nome }}">
                                    </div>
                                    <div class="col-1">Sigla
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="text" id="3"
                                            name="sigla" value="{{ $sigla }}">
                                    </div>
                                    <div class="col-2">Data de Início
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="date" id="3"
                                            name="dt_inicio" value="{{ $dt_inicio }}">
                                    </div>
                                    <div class="col-2">Data de Fim
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="date" id="3"
                                            name="dt_fim" value="{{ $dt_fim }}">
                                    </div>
                                    <div class="col" style="margin-top:20px">
                                        <input class="btn btn-light btn-sm"
                                            style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"
                                            type="submit" value="Pesquisar">

                                        <a href="/gerenciar-setor"><button class="btn btn-light btn-sm" type="button"
                                                value=""
                                                style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Limpar</button></a>
                                        </form>

                                        <a href="/incluir-setor"><input class="btn btn-success btn-sm" type="button"
                                                name="6" value="Novo Cadastro +"
                                                style="font-size: .9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"></a>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="table">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-3">Setor</th>
                                            <th class="col-1">Sigla</th>
                                            <th class="col-2">Data Inicio</th>
                                            <th class="col-2">Data Final</th>
                                            <th class="col-1">Status</th>
                                            <th class="col-1">Substituto</th>
                                            <th class="col">Ações</th>

                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 16px; color:#000000; text-align: center">
                                        <tr>
                                            @foreach ($lista as $listas)
                                                <td scope="">
                                                    {{ $listas->nome }}
                                                <td scope="">
                                                    {{ $listas->sigla }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->dt_inicio }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->dt_fim }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->status }}
                                                </td>
                                                <td scope="">
                                                    {{ $listas->nome_substituto }}
                                                </td>


                                                <td scope="" style="text-align: center">


                                                    <a href="/editar-setor/{{ $listas->ids }}"><button type="button"
                                                            class="btn btn-outline-warning"><i class="bi-pencil"
                                                                style="font-size: 1rem; color:#303030;"></i></button></a>
                                                    <a href=""><button type="button"
                                                            class="btn btn-outline-primary"><i class="bi-search"
                                                                style="font-size: 1rem; color:#303030;"></i></button></a>
                                                    <a href="/carregar-dados/{{ $listas->ids }}"><button type="button"
                                                            class="btn btn-outline-primary"><i
                                                                class="bi bi-arrow-left-right"
                                                                style="font-size: 1rem;color:#303030; "></i></button></a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#A{{ $listas->nome }}-{{ $listas->ids }}"
                                                        class="btn btn-outline-danger"><i class="bi-trash"
                                                            style="font-size: 1rem; color:#303030;"></i></button>







                                                    <!-- Modal -->
                                                    <div>
                                                        <div class="modal fade"
                                                            id="A{{ $listas->nome }}-{{ $listas->ids }}" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Excluir
                                                                            Funcionário</h5>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="fw-bold alert alert-danger text-center">
                                                                            Você
                                                                            realmente deseja excluir o setor:
                                                                            <br>
                                                                            {{ $listas->nome }}
                                                                            <br>
                                                                            com o subsetor: {{ $listas->nome }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <a
                                                                            href="/excluir-setor/{{ $listas->ids }}/{{ $listas->ids }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Confirmar</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <!--Fim Modal-->


                                                </td>
                                        </tr>

                                        </tr>
                                        @endforeach
                                    @endsection
