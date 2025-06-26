@extends('layouts.app')
@section('head')
    <title>Editar Associado</title>
@endsection

@section('content')

<div class="container"> {{-- Container completo da página  --}}
    <div class="justify-content-center">
        <div class="col-12">
            <legend style="color: #355089; font-size:25px;">Editar Associado</legend>
            <br>
            <div class="card" style="border-color: #355089">
                <div class="card-header">
                    <div class="row">
                        <h5 class="col-12" style="color: #355089; font-size:15px;">
                            Dados Pessoais
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-2" method='POST' action="/atualizar-associado/{{ $edit_associado[0]->ida }}/{{ $edit_associado[0]->idp }}">
                        @csrf
                        <div class="container-fluid">
                            <div class="row g-3 d-flex justify-content-around">
                                <div class="col-md-4 col-sm-12">Nome Completo
                                    <input type="text" class="form-control" name="nome_completo" maxlength="45"
                                        oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="{{ $edit_associado[0]->nome_completo }}" required>
                                </div>
                                <div class="col-md-2 col-sm-12">CPF
                                    <input type="text" class="form-control" name="cpf" maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="{{ $edit_associado[0]->cpf }}" required>
                                </div>
                                <div class="col-md-2 col-sm-12">Identidade
                                    <input type="text" class="form-control" name="idt" maxlength="9"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="{{ $edit_associado[0]->idt }}" required>
                                </div>
                                <div class="col-md-2 col-sm-12">Data de Nascimento
                                    <input type="date" style="border: 1px solid #999999; padding: 5px;"
                                        class="form-control" name="dt_nascimento" id="3"
                                        value="{{ $edit_associado[0]->dt_nascimento }}" required="required">
                                    <div class="invalid-feedback">
                                        Por favor, selecione a Data de Nascimento.
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">Sexo
                                    <select id="4" class="form-select"
                                        style="border: 1px solid #999999; padding: 5px;" name="sexo" type="text"
                                        required="required">
                                        <option value="{{ $edit_associado[0]->id_sexo }}">
                                            {{ $edit_associado[0]->nome_sexo }}</option>
                                        @foreach ($tpsexo as $tpsexos)
                                            <option value="{{ $tpsexos->id }}">
                                                {{ $tpsexos->tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, selecione um Campo
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="2">N.º Associado</label>
                                    <input type="text" class="form-control" name="nrassociado" maxlength="11"
                                        value="{{ $edit_associado[0]->nrAssociado }}" required>
                                </div>

                                <div class="col-md-1 col-sm-12">
                                    <label for="3">DDD</label>
                                    <select id="19" class="form-select" name="ddd">
                                        <option value="{{ $edit_associado[0]->tpd }}">{{ $edit_associado[0]->dddesc }}
                                        </option>
                                        @foreach ($tpddd as $tpddds)
                                            <option value="{{ $tpddds->id }}">{{ $tpddds->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <label for="2">Celular</label>
                                    <input type="text" class="form-control" id="2" maxlength="12"
                                        name="telefone" value="{{ $edit_associado[0]->celular }}" required>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="2">Email</label>
                                    <input type="text" class="form-control" id="2" maxlength="50"
                                        name="email" value="{{ $edit_associado[0]->email }}" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="card" style="border-color: #355089">
        <div class="card-header">
            <div class="row">
                <h5 class="col-12" style="color: #355089; font-size:15px;">
                    Dados Residenciais
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row g-3 d-flex justify-content-around">
                    <div class="col-md-2 col-sm-12">CEP
                        <input type="text" class="form-control" id="cep" name="cep" maxlength="8" value="{{ $edit_associado[0]->cep }}" required oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);">
                    </div>
                    <div class="col-md-1 col-sm-12">UF
                        <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="uf2"
                            name="uf_end">
                            <option value="{{ $edit_associado[0]->tuf }}">
                                {{ $edit_associado[0]->ufsgl }}
                            </option>
                            @foreach ($tp_uf as $tp_ufes)
                                <option @if (old('uf_end') == $tp_ufes->id) {{ 'selected="selected"' }} @endif
                                    value="{{ $tp_ufes->id }}">{{ $tp_ufes->sigla }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">Cidade
                        <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id="cidade2"
                            name="cidade">
                            <option value="{{ $edit_associado[0]->id_cidade }}">
                                {{ $edit_associado[0]->nat }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-5 col-sm-12">Logradouro
                        <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="50"
                            value="{{ $edit_associado[0]->logradouro }}" required>
                    </div>
                </div>
                <div class="row g-3 d-flex justify-content-around">
                    <div class="col-md-4 col-sm-12">Complemento
                        <input type="text" class="form-control" id="complemento" name="complemento" maxlength="50"
                            value="{{ $edit_associado[0]->complemento }}" required>
                    </div>
                    <div class="col-md-4 col-sm-12">Número
                        <input type="text" class="form-control" id="1" name="numero" maxlength="10"
                            value="{{ $edit_associado[0]->numero }}" required>
                    </div>
                    <div class="col-md-4 col-sm-12">Bairro
                        <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50"
                            value="{{ $edit_associado[0]->bairro }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-danger col-md-3 col-2 mt-5 offset-md-2" href="/gerenciar-associado"
        class="btn btn-danger">Cancelar</a>
    <button type="submit" class="btn btn-primary col-md-3 col-2 mt-5 offset-md-2">Confirmar</button>
    </form>
</div>
   
 <script>
        $(document).ready(function() {
            $('#cep').on('input', function() {
                let cep = $(this).val().replace(/\D/g, '');

                if (cep.length === 8) {
                    let estados = @JSON($tp_uf);

                    $.ajax({
                        type: "GET",
                        url: 'https://viacep.com.br/ws/' + cep + '/json/',
                        dataType: "json",
                        success: function(response) {
                            console.log(response);

                            // Preenchendo os campos automaticamente
                            $('#logradouro').val(response.logradouro);
                            $('#bairro').val(response.bairro);
                            $('#complemento').val(response.complemento);

                            // Encontrando o estado correspondente
                            let estadoEncontrado = estados.find(estado => estado.sigla ===
                                response.uf);

                            if (estadoEncontrado) {
                                $('#uf2').val(estadoEncontrado.id).trigger('change');

                                // Buscar cidades automaticamente e selecionar pelo nome
                                populateCities($('#cidade2'), estadoEncontrado.id, response
                                    .localidade);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Erro ao buscar o CEP:", error);
                        }
                    });
                }
            });

            function populateCities(selectElement, uf, cidadeNome) {
                $.ajax({
                    type: "GET",
                    url: "/retorna-cidades/" + uf,
                    dataType: "JSON",
                    success: function(response) {
                        selectElement.empty();
                        selectElement.removeAttr('disabled');

                        let cidadeSelecionada = null;

                        $.each(response, function(indexInArray, item) {
                            selectElement.append('<option value="' + item.id_cidade + '">' +
                                item.descricao + '</option>');

                            // Verifica se o nome da cidade retornado pelo ViaCEP é igual ao da lista
                            if (item.descricao.toLowerCase() === cidadeNome.toLowerCase()) {
                                cidadeSelecionada = item.id_cidade;
                            }
                        });

                        // Se encontramos a cidade pelo nome, selecionamos ela
                        if (cidadeSelecionada) {
                            selectElement.val(cidadeSelecionada).trigger('change');
                        }
                    }
                });
            }
        });
    </script>

@endsection


       
