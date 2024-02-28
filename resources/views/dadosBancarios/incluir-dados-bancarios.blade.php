@extends('layouts.app')
@section('head')
    <title>Incluir Dados Bancarios</title>
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Incluir Dados Bancários
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/armazenar-dados-bancarios/{{ $funcionario->id }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-5">
                                    <input class="form-control" type="text" value="{{ $funcionario->nome_completo }}"
                                        id="iddt_inicio" name="dt_inicio" required="required" disabled>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="form-group  col-xl-2 col-md-6 ">
                                    <label for="Banco">
                                        Banco
                                    </label>
                                    <select id="idbanco" class="form-select" aria-label="Default select example"
                                        name="desc_banco" required>
                                        @foreach ($desc_bancos as $desc_banco)
                                            <option value="{{ $desc_banco->id_db }}">
                                                {{ str_pad($desc_banco->id_db, 3, '0', STR_PAD_LEFT) }} -
                                                {{ $desc_banco->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xl-4 col-md-6 mt-3 mt-md-0">
                                    <label for="agencia">
                                        Agência
                                    </label>
                                    <select id="idagencia" class="form-select" aria-label="Default select example"
                                        name="tp_banco_ag" required disabled>
                                    </select>
                                </div>
                                <div class="form-group col-xl-3 col-md-6 mt-3 mt-xl-0">
                                    <label>
                                        Data de Início
                                    </label>
                                    <input class="form-control" type="date" value="" id="3"
                                        name="dt_inicio" required="required">
                                </div>
                                <div class="form-group col-xl-3 col-md-6 mt-3 mt-xl-0">
                                    <label>
                                        Data de Fim
                                    </label>
                                    <input class="form-control" type="date" value="" id="3" name="dt_fim">
                                </div>
                                <div class="form-group col-xl-4 col-md-4 mt-3 ">
                                    <label>
                                        Numero da Conta
                                    </label>
                                    <input class="form-control" type="text" maxlength="40" name="nmr_conta"
                                        value="" required="required">
                                </div>
                                <div class="form-group col-xl-4 col-md-4 mt-3">
                                    <label for="tconta">
                                        Tipo de Conta
                                    </label>
                                    <select id="tconta" class="form-select" aria-label="Default select example"
                                        name="tp_conta" required>
                                        @foreach ($tp_contas as $tp_conta)
                                            <option value="{{ $tp_conta->id }}">
                                                {{ $tp_conta->nome_tipo_conta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xl-4 col-md-4 mt-3">
                                    <label for="sbconta">
                                        Subtipo de Conta
                                    </label>
                                    <select id="sbconta" class="form-select" aria-label="Default select example"
                                        name="tp_sub_tp_conta">
                                        @foreach ($tp_sub_tp_contas as $tp_sub_tp_conta)
                                            <option value="{{ $tp_sub_tp_conta->id }}">
                                                {{ $tp_sub_tp_conta->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div>
                                <a class="btn btn-danger col-md-3 col-2 mt-4 offset-md-1"
                                    href="/gerenciar-dados-bancarios/{{ $funcionario->id }}" role="button">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-3"
                                    id="sucesso">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
