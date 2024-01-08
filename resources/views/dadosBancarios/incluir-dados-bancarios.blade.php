@extends('layouts.app')

@section('content')
    <div class="container-fluid">

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
                                            {{ $funcionario->nome_completo }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-1">

                            </div>
                            <div class="col-2"></div>
                        </div>
                        <hr>
                        <form action="/armazenar-dados-bancarios/{{ $funcionario->id }}">
                            <div class="row">
                                <div class="form-group  col-xl-3 col-md-1 ">
                                    <label for="Banco">Banco</label>
                                    <select id="idbanco" class="form-select" aria-label="Default select example"
                                        name="desc_banco" required>
                                        @foreach ($desc_bancos as $desc_banco)
                                            <option value="{{ $desc_banco->id_db }}">
                                                {{ str_pad($desc_banco->id_db, 3, '0', STR_PAD_LEFT) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xl-4 col-md-4">
                                    <label for="agencia">Agencia</label>
                                    <select id="idagencia" class="form-select" aria-label="Default select example"
                                        name="tp_banco_ag" required disabled>

                                    </select>
                                </div>
                                <div class="form-group col-xl-2 col-md-4">Numero da Conta
                                    <input class="form-control" type="text" maxlength="40" name="nmr_conta"
                                        value="" required="required">
                                </div>
                                <div class="form-group col-xl-2 col-md-3">
                                    <label for="tconta">Tipo de Conta</label>
                                    <select id="tconta" class="form-select" aria-label="Default select example"
                                        name="tp_conta" required>
                                        @foreach ($tp_contas as $tp_conta)
                                            <option value="{{ $tp_conta->id }}">{{ $tp_conta->nome_tipo_conta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>


                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="sbconta">Subtipo de Conta</label>
                                    <select id="sbconta" class="form-select" aria-label="Default select example"
                                        name="tp_sub_tp_conta">
                                        @foreach ($tp_sub_tp_contas as $tp_sub_tp_conta)
                                            <option value="{{ $tp_sub_tp_conta->id }}">{{ $tp_sub_tp_conta->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">Data de Inicio
                                    <input class="form-control" type="date" value="" id="3"
                                        name="dt_inicio" required="required">
                                </div>
                                <div class= "form-group col-md-2">Data de Fim
                                    <input class="form-control" type="date" value="" id="3" name="dt_fim">
                                </div>
                            </div>



                            <br>
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-2">
                                    <a class="btn btn-danger " href="../" role="button">Cancelar</a>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn" id="sucesso">Confirmar</button>
                                </div>
                            </div>

                        </form>
                </fieldset>
            </div>
        </div>
    </div>

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#idbanco').change(function() {
                var banco = $(this).val();

                $.ajax({
                    url: '/recebe-agencias/' + banco,
                    type: 'get',
                    success: function(data) {
                        $('#idagencia').removeAttr('disabled');
                        $('#idagencia').empty();;
                            $.each(data, function (index, agencia) {
                                $('#idsetor').append('<option value="' + item.id + '">' + item.nome + '</option>');
                            }); {


                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while fetching agencies');
                    }
                });
            });
        });
    </script>
@endsection
