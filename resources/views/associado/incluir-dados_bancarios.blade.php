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
            <form class="form-horizontal mt-4" method='POST' action="/incluir-dados_bancarios-associado/{{ $associado[0]->ida}}">
                @csrf

                <div class="container-fluid">
                    <div class="row d-flex justify-content-around">

                        <div class="col-md-2 col-sm-12">
                            <label for="2">Valor</label>
                            <input type="text" class="form-control" name="valor" placeholder="R$ 0,00" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="Banco">
                                Banco
                            </label>
                            <select id="idbanco" style="border: 1px solid #999999; padding: 5px;" class="form-select" aria-label="Default select example" name="desc_banco" required>
                                @foreach ($desc_bancos as $desc_banco)
                                <option value="{{ $desc_banco->id_db }}">
                                    {{ str_pad($desc_banco->id_db, 3, '0', STR_PAD_LEFT) }} -
                                    {{ $desc_banco->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="agencia">
                                Agência
                            </label>
                            <select id="idagencia" style="border: 1px solid #999999; padding: 5px;" class="form-select" aria-label="Default select example" name="tp_banco_ag" required disabled>
                            </select>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="container-fluid">
                    <div class="row d-flex justify-content-around">
                        <div class="col-md-2 col-sm-12">
                            <label for="4">Data de Vencimento</label>
                            <input type="date" class="form-control" name="dt_vencimento" id="4" value="">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="2">Conta Corrente</label>
                            <input type="text" class="form-control" name="conta_corrente" maxlength="6">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row d-flex justify-content-evenly">
                    <div class="col">
                        <h6>Tesouraria</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tesouraria" id="dinheiro" value="dinheiro">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Dinheiro
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tesouraria" id="cheque" value="cheque">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cheque
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tesouraria" id="ct_de_debito" value="ct_de_debito">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cartão de Débito
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tesouraria" id="ct_de_credito" value="ct_de_credito">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cartão de Crédito
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <h6>Boleto Bancário</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="boleto" id="mensal" value="mensal">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Mensal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="boleto" id="trimestral" value="trimestral">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Trimestral
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="boleto" id="semestral" value="semestral">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Semestral
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="boleto" id="anual" value="anual">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Anual
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <h6>Autorização em Débito em conta</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="autorizacao" id="banco_do_brasil" value="banco_do_brasil">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Banco do Brasil
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="autorizacao" id="brb" value="brb">
                            <label class="form-check-label" for="flexRadioDefault1">
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


<!--JQUERY-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>


<script>
    $(document).ready(function() {
        $('#idagencia').select2({
            theme: 'bootstrap-5',
            disabled: true, // Initialize the select2 with disabled state
        });


        $('#idbanco').change(function(e) {
            var idbanco = $(this).val();
            e.preventDefault();
            $('#idagencia').prop('disabled', false); // Enable the #idagencia dropdown

            $.ajax({
                type: "GET",
                url: "/recebe-agencias/" + idbanco,
                dataType: "json",
                success: function(response) {
                    $('#idagencia').empty();
                    $.each(response, function(index, item) {
                        $('#idagencia').append("<option value =" + item.id + "> " +
                            item.agencia + " - " + item.desc_agen + "</option>");
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection