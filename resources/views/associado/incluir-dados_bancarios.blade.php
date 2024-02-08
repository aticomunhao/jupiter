@extends('layouts.app')

@section('content')
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

@endsection