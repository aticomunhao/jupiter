
@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="justify-content-center">
                    <div class="col-12">
                        <br>
                        <div class="card">
                            <fieldset class="border rounded border-primary">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6"><span
                                            style=" color: rgb(26, 53, 173); font-size:15px;">Editar-Dependentes</span>
                                        </div>
                                        <div class="col-6">
                                        </div>
                                    </div>
                                </div>
                                                        <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body bg-body-secondary">
                                                <div style="color: rgb(26, 53, 173); font-size:15px;">{{$funcionario[0]->nome_completo}}</div>
                                            </div>
                                            </div>
                                        </div>
                                    <div class="col-4"></div>
                                    <div class="col-3">
                                    <div class="row">

                                        <span style="margin-top: 15px; margin-left: -18px"><a href="/incluir-dependentes/{{$funcionario[0]->id}}"><button type="button" class="btn btn-success btn-sm" style="padding: 5px 80px;">Novo &plus;</button></a></span>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                                    <div class="table">
                                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-2">Parentesco</th>
                                            <th class="col-4">Nome</th>
                                            <th class="col-2">Data de Nascimento</th>
                                            <th class="col-2">CPF</th>
                                            <th class="col-3">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px; color:#000000;">
                                    <tr>
                                        @foreach($dependentes as $dependente)
                                            {{--witch($dependente->id_pessoa)
                                            @case(1)
                                                Pai
                                                @break
                                            @case(2)
                                                Mãe
                                                @break
                                            @case(3)
                                                Filha
                                            @break
                                            @case(4)
                                                Filho
                                            @break
                                            @default
                                        @endswitch</td>--}}
                                        <td scope="" >{{$dependente->nome}}</td>
                                        <td scope="" >{{$dependente->nome_dependente}}</td>
                                        <td scope="" >{{$dependente->dt_nascimento}}</td>
                                        <td scope="" >{{$dependente->cpf}}</td>
                                        <td scope=""><a href="/deletar-dependentes/{{$dependente->id}}"><button type="submit" class="btn btn-danger delete-btn btn-sm"><i class="bi bi-trash"></i></button></a>
                                        <a href="/editar-dependentes/{{$dependente->id}}"><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-pencil btn-sm"></i></button></a>
                                        </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
@endsection
