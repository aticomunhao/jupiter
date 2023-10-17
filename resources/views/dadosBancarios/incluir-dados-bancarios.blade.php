@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
                <div class="col-12">
                    <br>
                    <div class="card">
                        <fieldset class="border rounded border-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6"><span
                                            style=" color: rgb(26, 53, 173); font-size:15px;">Incluir-Contas-Bancarias</span>
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
                                                    {{ $funcionario[0]->nome_completo }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-1">

                                    </div>
                                    <div class="col-2"></div>
                                </div>
                                <hr>
                                    <div class="row">
                                        <div class="col-1"></div>
                                    </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
        </div>
    </div>
@endsection
