@extends('layouts.app')
@section('head')
    <title>Criar Associado</title>
@endsection
@section('content')

    @csrf
    <div class="container"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <legend style="color: #355089; font-size:25px;">Criar Associado</legend>
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Dados Pessoais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                            <form class="form-horizontal mt-4" method='POST' action="/incluir-associado">
                                @csrf
                                    <div class="row d-flex justify-content-around">
                                        <div class="col-md-4 col-sm-12">
                                            <label for="1">Nome Completo</label>
                                            <input type="text" class="form-control" name="nome_completo" maxlength="45" value="{{ old('nome_completo') }}" style="border: 1px solid #999999; padding: 5px;"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">CPF</label>
                                            <input type="text" class="form-control" name="cpf" maxlength="11" value="{{ old('cpf') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">Identidade</label>
                                            <input type="text" class="form-control" name="idt" maxlength="9" value="{{ old('idt') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">Data de Nascimento</label>
                                            <input type="date" class="form-control" name="dt_nascimento" value="{{ old('dt_nascimento') }}" style="border: 1px solid #999999; padding: 5px;" required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Sexo
                                            <select class="form-select" id="sexo" name="sexo"  value="{{ old('sexo') }}" style="border: 1px solid #999999; padding: 5px;" required="required">
                                                <option value=""></option>
                                                @foreach ($sexo as $sexos)
                                                    <option
                                                        @if (old('sexo') == $sexos->id) {{ 'selected="selected"' }} @endif
                                                        value="{{ $sexos->id }}">{{ $sexos->tipo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">Número de Associado</label>
                                            <input type="text" class="form-control" name="nrassociado" maxlength="11" value="{{ old('nrassociado') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                        </div>
                                        <div class="col-md">
                                            <label for="3">DDD</label>
                                            <select class="form-select" name="ddd" id="3" value="{{ old('ddd') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                                <option></option>
                                                @foreach ($ddd as $ddds)
                                                    <option value="{{ $ddds->id }}">{{ $ddds->descricao }}</option>
                                                @endforeach
                                            </select>

                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-12">
                                            <label for="2">Celular</label>
                                            <input type="text" class="form-control" id="2" maxlength="9" name="telefone" value="{{ old('telefone') }}" style="border: 1px solid #999999; padding: 5px;"
                                                
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                required>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="2">Email</label>
                                            <input type="text" class="form-control" id="2" maxlength="50" name="email"  value="{{ old('email') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="4">Data de Inicio</label>
                                            <input type="date" class="form-control" name="dt_inicio" id="4" value="{{ old('dt_inicio') }}" style="border: 1px solid #999999; padding: 5px;"
                                                required>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card" style="border-color: #355089">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Dados Residenciais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-around">
                            <div class="row ">
                                <div class="col-md-2 col-sm-12">CEP
                                    <input type="text" class="form-control" name="cep" id="cep" value="{{ old('cep') }}" style="border: 1px solid #999999; padding: 5px;"
                                        required  oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);"
                                        >
                                </div>
                                <div class="col-md-1 col-sm-12">UF
                                    <br>
                                    <select class="js-example-responsive form-select"
                                            style="border: 1px solid #999999; padding: 5px;" id="uf2" name="uf_end" value="{{ old('uf_end') }}">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_end') == $tp_ufs->id)
                                                        {{ 'selected="selected"' }}
                                                    @endif
                                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">Cidade
                                    <br>
                                    <select class="js-example-responsive form-select" id="cidade2" name="cidade"
                                            value="{{ old('cidade') }}" style="border: 1px solid #999999 !important; padding: 5px;"  readonly>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro"
                                    value="{{ old('logradouro') }}" style="border: 1px solid #999999; padding: 5px;" required>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-around">
                                <div class="form-group col-md">
                                    <label for="1">Número</label>
                                    <input type="text" class="form-control" id="1" name="numero"
                                    value="{{ old('numero') }}" style="border: 1px solid #999999; padding: 5px;" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento"
                                    value="{{ old('complemento') }}" style="border: 1px solid #999999; padding: 5px;" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro"
                                    value="{{ old('bairro') }}" style="border: 1px solid #999999; padding: 5px;" required>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <br>
                <div class="row gap-3 justify-content-center ">
                    <div class="col-md-3 d-grid gap-2">
                        <a class="btn btn-danger" href="/gerenciar-associado" class="btn btn-danger">Cancelar</a>
                    </div>
                    <div class="col-md-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Confirmar</button>

                    </div>
                </div>
                </form>

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
