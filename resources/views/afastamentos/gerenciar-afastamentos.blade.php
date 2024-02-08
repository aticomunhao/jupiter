@extends('layouts.app')
<title>Gerenciar Afastamentos </title>
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
                                        style=" color: rgb(26, 53, 173); font-size:15px;">Gerenciar-Afastamentos</span>
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
                                            <div style="color: rgb(26, 53, 173); font-size:15px;">
                                                {{ $funcionario->nome_completo }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-1">

                                    <div class="row">
                                        <span style="margin-top: 15px; margin-left: -18px"><a
                                                href="/incluir-afastamentos/{{ $funcionario->funcionario_id }}"><button type="button"
                                                    class="btn btn-success btn-sm"
                                                    style="padding: 5px 80px;margin-right:100px;font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Novo&plus;</button></a></span>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                            <hr>
                            <div class="table">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-2">Nome</th>
                                            <th class="col-2">Data de Inicio</th>
                                            <th class="col-2">Quantidade de dias</th>
                                            <th class="col-2">Data de Fim</th>
                                            <th class="col-3">Motivo do Afastamento</th>
                                            <th class="col-1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px; color:#000000;">

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
