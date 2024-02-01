@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="border border-primary" style="border-radius: 5px;">
        <div class="card">
            <div class="card-header">
                Criar Associado
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method='POST' action="/incluir-setores">
                    @csrf

                    <div class="container-fluid">                       
                    <div class="row d-flex justify-content-around">
                        <div class="col-md-4 col-sm-12">
                            <label for="1">Nome Completo</label>
                            <input type="text" class="form-control" id="1" name="nome_setor" value="">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="2">CPF</label>
                            <input type="text" class="form-control" id="2" name="sigla" value="">
                        </div>
                        <div class="col-md-1 col-sm-12">
                            <label for="3">DDD</label>
                            <select class="form-select" name="nivel" id="3" value="">
                                <value="">

                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="2">Telefone</label>
                            <input type="text" class="form-control" id="2" name="sigla" value="" style="width: 100;">
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4 col-sm-12">
                                <label for="2">Email</label>
                                <input type="text" class="form-control" id="2" name="sigla" value="">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <label for="4">Data de Inicio</label>
                                <input type="date" class="form-control" name="dt_inicio" id="4">
                            </div>
                            <br>
                            <br>
                            <div class="col-md-2 col-sm-12">
                                <label for="2">Valor</label>
                                <input type="text" class="form-control" id="2" name="sigla" value="">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <label for="4">Data de Vencimento</label>
                                <input type="date" class="form-control" name="dt_inicio" id="4">
                            </div>
                        </div>
                    </div>
                <div class="border border-primary" style="border-radius: 5px;">
                    <div class="row d-flex justify-content-around">
                    <h5>Tesouraria</h5>
                    <div class="col-md-3 col-sm-12">
                        
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Dinheiro
                        </label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cheque
                        </label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cartão de Crédito
                        </label>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cartão de Débito
                        </label>
                    </div>
                    </div>
</div>
<br>
<div class="border border-primary" style="border-radius: 5px;">
                    <div class="row d-flex justify-content-around">
                    <h5>Boleto Bancário</h5>
                    <div class="col-md-3 col-sm-12">
                        
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Mensal
                        </label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cheque
                        </label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cartão de Crédito
                        </label>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Cartão de Débito
                        </label>
                    </div>
                    </div>
</div>
                    <div class="border border-primary" style="border-radius: 5px;">

                        <div class="card">
                            <div class="card-header">
                                Dados Residenciais
                            </div>
                            <div class="row d-flex justify-content-around">
                                <div class="form-group col-xl-2 col-md-4 mt-3 ">
                                    <label for="1">CEP</label>
                                    <input type="text" class="form-control" id="1" name="nome_setor" value="">
                                </div>
                                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                                    <label for="2">UF</label>
                                    <input type="text" class="form-control" id="2" name="sigla" value="">
                                </div>
                                <div class="form-group col-xl-2 col-md-4 mt-3 ">
                                    <label for="3">Cidade</label>
                                    <select class="form-select" name="nivel" id="3" value="">
                                        <value="">

                                    </select>
                                </div>
                                <div class="form-group col-xl-3 col-md-4 mt-3 ">
                                    <label for="1">Logradouro</label>
                                    <input type="text" class="form-control" id="1" name="nome_setor" value="">
                                </div>
                                <div class="form-group col-xl-1 col-md-4 mt-3 ">
                                    <label for="1">Número</label>
                                    <input type="text" class="form-control" id="1" name="nome_setor" value="">
                                </div>
                                <div class="row d-flex justify-content-around">
                                    <div class="form-group col-xl-3 col-md-4 mt-3 ">
                                        <label for="1">Complemento</label>
                                        <input type="text" class="form-control" id="1" name="nome_setor" value="">
                                    </div>
                                    <div class="form-group col-xl-2 col-md-4 mt-3 ">
                                        <label for="1">Bairro</label>
                                        <input type="text" class="form-control" id="1" name="nome_setor" value="">
                                    </div>
                                </div>
                            </div>
                            <br>
                            </br>
                        </div>




                    </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-around">
        <div class="col-2"><a href="/gerenciar-setor" class="btn btn-danger" style="width:100%">Cancelar</a></div>
        <div class="col-2"><button type="submit" class="btn btn-primary" style="width: 100%;">Confirmar</button></div>
    </div>
    </form>


</div>



</div>
@endsection