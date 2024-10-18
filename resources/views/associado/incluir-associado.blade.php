@extends('layouts.app')
@section('head')
    <title>Criar Associado</title>
@endsection
@section('content')

    @csrf
    <div class="container-fluid"> {{-- Container completo da página  --}}
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
                        <hr>
                            <form class="form-horizontal mt-4" method='POST' action="/incluir-associado">
                                @csrf
                                    <div class="row d-flex justify-content-around">
                                        <div class="col-md-4 col-sm-12">
                                            <label for="1">Nome Completo</label>
                                            <input type="text" class="form-control" name="nome_completo" maxlength="45"
                                                oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">CPF</label>
                                            <input type="text" class="form-control" name="cpf" maxlength="11"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">Identidade</label>
                                            <input type="text" class="form-control" name="idt" maxlength="9"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="2">Data de Nascimento</label>
                                            <input type="date" class="form-control" name="dt_nascimento" required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">Sexo
                                            <select class="form-select" id="sexo" name="sexo" required="required">
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
                                            <input type="text" class="form-control" name="nrassociado" maxlength="11"
                                                required>
                                        </div>
                                        <div class="col-md">
                                            <label for="3">DDD</label>
                                            <select class="form-select" name="ddd" id="3" value=""
                                                required>
                                                <option></option>
                                                @foreach ($ddd as $ddds)
                                                    <option value="{{ $ddds->id }}">{{ $ddds->descricao }}</option>
                                                @endforeach
                                            </select>

                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-12">
                                            <label for="2">Telefone</label>
                                            <input type="text" class="form-control" id="2" maxlength="12"
                                                name="telefone" value=""
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                required>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="2">Email</label>
                                            <input type="text" class="form-control" id="2" maxlength="50"
                                                name="email" value="" required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="4">Data de Inicio</label>
                                            <input type="date" class="form-control" name="dt_inicio" id="4"
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
                        <hr>
                        <div class="row d-flex justify-content-around">
                            <div class="row ">
                                <div class="form-group col-md">
                                    <label for="1">CEP</label>
                                    <input type="text" class="form-control" id="1" name="cep" value=""
                                        required>
                                </div>
                                <div class="form-group col-md ">
                                    <label for="id_uf">UF</label>
                                    <select class="js-example-responsive form-select" id="iduf" name="uf_end"
                                        required>
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option @if (old('uf_end') == $tp_ufs->id) {{ 'selected="selected"' }} @endif
                                                value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="cidade">Cidade</label>
                                    <select class="js-example-responsive form-select" id="idcidade" name="cidade"
                                        value="{{ old('cidade') }}" disabled required>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Logradouro</label>
                                    <input type="text" class="form-control" id="1" name="logradouro"
                                        value="" required>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-around">
                                <div class="form-group col-md">
                                    <label for="1">Número</label>
                                    <input type="text" class="form-control" id="1" name="numero"
                                        value="" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Complemento</label>
                                    <input type="text" class="form-control" id="1" name="complemento"
                                        value="" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="1">Bairro</label>
                                    <input type="text" class="form-control" id="1" name="bairro"
                                        value="" required>
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

            @endsection


            @section('footerScript')
                <!-- Scripts -->
                <script>
                    $(document).ready(function () {
                        $('#idcidade').select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                        });

                        function populateCities(selectElement, stateValue) {
                            $.ajax({
                                type: "get",
                                url: "/retorna-cidade-dados-residenciais/" + stateValue,
                                dataType: "json",
                                success: function (response) {
                                    selectElement.empty();
                                    $.each(response, function (indexInArray, item) {
                                        selectElement.append('<option value="' + item.id_cidade + '">' +
                                            item.descricao + '</option>');
                                    });
                                },
                                error: function (xhr, status, error) {
                                    console.error("An error occurred:", error);
                                }
                            });
                        }

                        $('#iduf').change(function (e) {
                            var stateValue = $(this).val();
                            $('#idcidade').removeAttr('disabled');
                            populateCities($('#idcidade'), stateValue);
                        });
                    });
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const video = document.getElementById('video');
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        const captureBtn = document.getElementById('capture-btn');
                        const photoInput = document.getElementById('photo-input');

                        navigator.mediaDevices.getUserMedia({
                                video: true
                            })
                            .then((stream) => {
                                video.srcObject = stream;
                            })
                            .catch((err) => {
                                console.error('Error accessing webcam: ', err);
                            });

                        captureBtn.addEventListener('click', () => {
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                            photoInput.value = canvas.toDataURL('image/jpeg');
                        });
                    });
                </script>
