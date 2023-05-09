
@extends('layouts.app')


@section('content')
<div class="container-xxl">
    <div class="col-12">
        <div class="row justify-content-center">
            <div>
                <form action="{{route('gerenciar')}}" class="form-horizontal mt-4" method="GET" >
                <div class="row">
                    <div class="col-2">CPF
                        <input class="form-control" type="numeric" name="cpf" value="">
                    </div>
                    <div class="col-2">Identidade
                        <input class="form-control" type="numeric" name="idt" value="">
                    </div>
                    <div class="col-4">Nome
                        <input class="form-control" type="text" name="nome" value="">
                    </div>
                    <div class="col-1 form-check form-switch"><br>
                            <input type="checkbox" data-size="sm" checked data-toggle="toggle" data-onlabel="Ativo" data-offlabel="Inativo" data-onstyle="secondary" data-offstyle="light">
                    </div>
                        <div class="col-3"><br>
                            <input class="btn btn-info btn-sm" type="submit" value="Pesquisar">
                            <a href="/"><input class="btn btn-danger btn-sm" type="button" value="Cancelar"></a>
                    </form>
                            <a href="/incluir-funcionario"><input class="btn btn-success btn-sm" type="button" value="Novo Cadastro+"></a>

                    </div>
                </div>
                <br>
                <br>
            </div>
            <hr>
            <div>
                <table class="table table-striped table-bordered border-dark">
                    <thead style="text-align: center;">
                        <tr style="background-color: #82a9ff; color:#000000">
                        <th scope="col">CPF</th>
                        <th scope="col">Identidade</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Ativo?</th>
                        <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;">
                        <tr>
                        @foreach($lista as $listas)
                            <td scope="2">{{$listas->cpf}}</td>
                            <td scope="2">{{$listas->rg}}</td>
                            <td scope="2">{{$listas->nome_pessoa}}</td>
                            <td scope="2">{{$listas->sexo}}</td>
                            <td scope="2">Botões</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footerScript')
            <script src="{{ URL::asset('/js/pages/mascaras.init.js')}}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
            <script src="{{ URL::asset('/libs/select2/select2.min.js')}}"></script>
            <script src="{{ URL::asset('/js/pages/form-advanced.init.js')}}"></script>
            <script src="{{ URL::asset('/js/pages/cadastro-inicial.init.js')}}"></script>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>

@endsection




