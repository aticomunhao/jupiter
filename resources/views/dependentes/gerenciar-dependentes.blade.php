
@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="justify-content-center">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-2">Editar-Dependentes
                                    </div>
                                    <div class="col-8">
                                    </div>
                                    <div class="col-2">aaa
                                    </div>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body bg-body-secondary">
                                            {{$funcionario[0]->nome_completo}}
                                        </div>
                                        </div>
                                    </div>
                                <div class="col-4"></div>
                                <div class="col-3">
                                <button type="button" class="btn btn-success btn-lg" style="padding: 5px 80px;">Novo &plus;</button>
                                </div>
                            </div>
                            <hr>
                                <div class="table"></div>
                            
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection