@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <legend style="color:rgb(16, 19, 241); font-size:15px;">Dados Bancários Associado</legend>
    <div class="border border-primary" style="border-radius: 5px;" <div class="card">
        <div class="card-header">
            Dados Pessoais
        </div>
        <div class="card-body">
            <form class="form-horizontal mt-4" method='POST' action="/incluir-dados-bancarios/{{ $associado[0]->ida}}">
                @csrf

                <div class="container-fluid">
                    <div class="row d-flex justify-content-around">

                        <div class="col-md-2 col-sm-12">
                            <label for="2">Valor</label>
                            <input type="text" class="form-control" name="valor" placeholder="R$ 0,00"  maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="4">Data de Vencimento</label>
                            <input type="date" class="form-control" name="dt_vencimento" id="4" value="">
                        </div>
                    </div>
                </div>
                <br>
                    <div class="row d-flex justify-content-evenly">
                        <div class="col">
                            <h6>Tesouraria</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dinheiro" id="examplecheckboxs1" value="dinheiro">
                                <label class="form-check-label" for="examplecheckboxs1">
                                    Dinheiro
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cheque" id="examplecheckboxs2" value="cheque">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Cheque
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cartao_de_debito" id="examplecheckboxs2" value="cartao_de_debito">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Cartão de Débito
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cartao_de_credito" id="examplecheckboxs2" value="cartao_de_credito">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Cartão de Crédito
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Boleto Bancário</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mensal" id="examplecheckboxs1" value="option1">
                                <label class="form-check-label" for="examplecheckboxs1">
                                    Mensal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="trimestral" id="examplecheckboxs2" value="option2">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Trimestral
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="semestral" id="examplecheckboxs2" value="option2">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Semestral   
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="anual" id="examplecheckboxs2" value="option2">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    Anual  
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Autorização em Débito em conta</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="banco_do_brasil" id="examplecheckboxs1" value="option1">
                                <label class="form-check-label" for="examplecheckboxs1">
                                    Banco do Brasil
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="brb" id="examplecheckboxs2" value="option2">
                                <label class="form-check-label" for="examplecheckboxs2">
                                    BRB
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>



    <div class="row d-flex justify-content-evenly">
        <div class="col-2"><a href="/gerenciar-associado" class="btn btn-danger" style="width:150%">Cancelar</a></div>
        <div class="col-2"><button type="submit" class="btn btn-primary" style="width: 150%;">Confirmar</button></div>
    </div>
    </form>


    @endsection