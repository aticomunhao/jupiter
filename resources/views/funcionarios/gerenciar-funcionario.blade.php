@extends('layouts.app')


@section('content')
    <div class="container-xxl">
        <div class="col-12">
            <div class="row justify-content-center">
                <div>
                    <form action="{{ route('gerenciar') }}" class="form-horizontal mt-4" method="GET">
                        <div class="row">
                            <div class="col-2">CPF
                                <input class="form-control" type="text" id="1" name="cpf"
                                    value="{{ $cpf }}">
                            </div>
                            <div class="col-2">Identidade
                                <input class="form-control" type="text" id="2" name="idt"
                                    value="{{ $idt }}">
                            </div>
                            <div class="col-4">Nome
                                <input class="form-control" type="text" id="3" name="nome"
                                    value="{{ $nome }}">
                            </div>
                            {{-- <div class="col-1 form-check form-switch"><br>
                            <input type="checkbox" data-size="sm" checked data-toggle="toggle" data-onlabel="Ativo" data-offlabel="Inativo" data-onstyle="secondary" data-offstyle="light">
                    </div> --}}
                            <div class="col-1">Ativo?
                                <select class="form-select" id="4" name="status" type="number"
                                    required="required">
                                    <option value="1">Sim</option>
                                    <option value="">Todos</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="col-3"><br>
                                <input class="btn btn-primary btn-sm" type="submit" value="Pesquisar">
                                <a href="/gerenciar-funcionario"><input class="btn btn-danger btn-sm" type="button"
                                        value="Limpar"></a>
                    </form>
                    <a href="/informar-dados"><input class="btn btn-success btn-sm" type="button" autofocus
                            value="Novo Cadastro &plus;"></a>

                </div>
            </div>
            <br>
            <br>
        </div>
        <hr>
        <div class="table">
            <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                <thead style="text-align: center;">
                    <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                        <th class="col-1">CPF</th>
                        <th class="col-1">Identidade</th>
                        <th class="col-4">Nome</th>
                        <th class="col-1">Status</th>
                        <th class="col-4">Ações</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px; color:#000000;">
                    <tr>
                        @foreach ($lista as $listas)
                            <td scope="">{{ $listas->cpf }}</td>
                            <td scope="">{{ $listas->idt }}</td>
                            <td scope="">{{ $listas->nome_completo }}</td>
                            <td scope="" style="text-align: center;">{{ $listas->status }}</td>
                            <td scope="">
                                <a href="/editar-funcionario/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-warning btn-sm"><i class="bi-pencil"
                                            style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href="/editar-funcionario/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-danger btn-sm"><i class="bi-trash"
                                            style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href="/editar-funcionario/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-secondary btn-sm"><i class="bi-search"
                                            style="font-size: 1rem;"></i></button></a>
                                <a href="/gerenciar-dependentes/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-secondary btn-sm"><i class="bi-people-fill"
                                            style="font-size: 1rem; "></i></button></a>
                                <a href="/editar-funcionario/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-primary-1 btn-sm"><i class="bi-coin"
                                            style="font-size: 1rem; "></i></button></a>
                                <a href="/editar-funcionario/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-secondary btn-sm"><i class="bi-bandaid"
                                            style="font-size: 1rem;"></i></button></a>
                                <a href="/gerenciar-certificados/{{ $listas->idf }}"><button type="button"
                                        class="btn btn-outline-secondary btn-sm"><i class="bi-mortarboard"
                                            style="font-size: 1rem;"></i></button></a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
                <div class="doido">AAA</div>
            </table>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('footerScript')
    <script src="{{ URL::asset('/js/pages/mascaras.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="{{ URL::asset('/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/js/pages/cadastro-inicial.init.js') }}"></script>

    <!--botão toggle-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
   <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
@endsection
