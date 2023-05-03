
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
                        <input class="form-control" type="numeric" name="nome" value="">
                    </div>
                        <div class=" bootstrapToggle data-toggle-toggle">
                            <input id="chkToggle2" type="checkbox" data-toggle="toggle"checked>
                            <script>
                                $(function(){ $('#chkToggle2').bootstrapToggle() });
                              </script>

                        </div>
                        <div class="form-check form-check-inline">
                            <input id="inlineCheckbox2" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="mr-1" disabled>
                            <label for="inlineCheckbox2" class="form-check-label">Disabled</label>
                        </div>

                        <div class="col-3"><br>

                            <input class="btn btn-info btn-sm" type="submit" value="Pesquisar">
                            <a href="/"><input class="btn btn-danger btn-sm" type="button" value="Cancelar"></a>
                    </form>
                            <a href="/"><input class="btn btn-success btn-sm" type="button" value="Novo Cadastro+"></a>

                    </div>
                </div>
                <br>
                <br>
            </div>
            <hr>
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">CPF</th>
                        <th scope="col">Identidade</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Ativo?</th>
                        <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        @foreach($result as $results)
                            <td scope="2">{{$results->cpf}}</td>
                            <td scope="2">{{$results->rg}}</td>
                            <td scope="2">{{$results->nome_pessoa}}</td>
                            <td scope="2">{{$results->sexo}}</td>
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


