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
                    <div class="col-md-6 col-12">
                        <fieldset {{-- Gera a barra ao redor do nome do funcionario --}}
                            style="border: 1px solid #c0c0c0; border-radius: 3px;padding-bottom: 7px; padding-top: 7px; padding-left: 10px; background-color: #ebebeb;">
                           {{$associado}}</fieldset>
                    </div>
                    <div class="col-md-3 offset-md-3 col-12 mt-4 mt-md-0"> {{-- Botão de incluir --}}
                        <a href="/incluir-dados-bancarios/" class="col-6"><button type="button"
                                class="btn btn-success col-md-8 col-12">Novo+</button></a>
                    </div>
                </div>
            </div>
            <hr />
            <div class="container-fluid table-responsive"> {{-- Faz com que a tabela não grude nas bordas --}}
                <div class="table">
                    <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                        <thead style="text-align: center;"> {{-- Text-align gera responsividade abaixo de Large --}}
                            <tr class="align-middle" style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                <th class="col">Valor</th>
                                <th class="col">ultima contribuicao</th>
                                <th class="col">dt_vencimento</th>
                                <th class="col">ultima contribuicao</th>
                                <th class="col">Banco do Brasil</th>
                                <th class="col">mensal</th>
                                <th class="col">trimestral</th>
                                <th class="col">Aç</th>
                                <th class="col">valor</th>
                                <th class="col">ultima contribuicao</th>
                                <th class="col">Conta</th>
                                <th class="col">Tipo</th>
                                <th class="col">Subtipo</th>
                                <th class="col">Dt inicio</th>
                                <th class="col">Dt Fim</th>
                                <th class="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 15px; color:#000000;">
                        
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        </td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        
                                    </td>
                                    <td class="text-center">
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        </td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        
                                    </td>
                                    <td class="text-center">
                                        
                                    </td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                </tr>
                        
                        </tbody>
                    </table>
                </div>
            </div>
            </fieldset>
        </div>
    </div>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tt="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
