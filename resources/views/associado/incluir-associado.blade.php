@extends('layouts.app')
@section('head')
<title>Criar Associado</title>
@endsection
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                    <div class="card-body">
                        <form class="form-horizontal mt-4" method='POST' action="/incluir-associado">
                            @csrf

                            <div class="container-fluid">
                                <div style="padding-left: 80%;">
                                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalExemplo" type="button" value="" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Tirar Foto</button>
                                    <a href="visualizar-foto"><button class="btn btn-light btn-sm" type="button" value="" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Ver Foto</button></a>
                                </div>
                                <div class="row d-flex justify-content-around">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="1">Nome Completo</label>
                                        <input type="text" class="form-control" name="nome_completo" maxlength="45" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">CPF</label>
                                        <input type="text" class="form-control" name="cpf" maxlength="11" required>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="2">Identidade</label>
                                        <input type="text" class="form-control" name="idt" maxlength="9" required>
                                    </div>
                                    <div class="row d-flex justify-content-around">
                                        <div class="col-md-1 col-sm-12">
                                            <label for="3">DDD</label>
                                            <select class="form-select" name="ddd" id="3" value="" required>
                                                <option></option>
                                                @foreach ($ddd as $ddds)
                                                <option value="{{ $ddds->id }}">{{ $ddds->descricao }}</option>
                                                @endforeach
                                            </select>

                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-12">
                                            <label for="2">Telefone</label>
                                            <input type="text" class="form-control" id="2" maxlength="12" name="telefone" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="2">Email</label>
                                            <input type="text" class="form-control" id="2" maxlength="50" name="email" value="" required>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="4">Data de Inicio</label>
                                            <input type="date" class="form-control" name="dt_inicio" id="4" required>
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
                    <div class="ROW">
                        <h5 class="col-12" style="color: #355089">
                            Dados Residenciais
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <hr>
                    <div class="row d-flex justify-content-around">
                        <div class="form-group col-xl-2 col-md-4 mt-3 ">
                            <label for="1">CEP</label>
                            <input type="text" class="form-control" id="1" name="cep" value="" required>
                        </div>
                        <div class="form-group col-xl-1 col-md-4 mt-3 ">
                            <label for="id_uf">UF</label>
                            <select class="js-example-responsive form-select" id="iduf" name="uf_end" required>
                                <option value=""></option>
                                @foreach ($tp_uf as $tp_ufs)
                                <option @if (old('uf_end')==$tp_ufs->id) {{ 'selected="selected"' }} @endif
                                    value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xl-2 col-md-4 mt-3 ">
                            <label for="ciadade">Cidade</label>
                            <select class="js-example-responsive form-select" id="idcidade" name="cidade" value="{{ old('cidade') }}" disabled required>
                            </select>
                        </div>
                        <div class="form-group col-xl-3 col-md-4 mt-3 ">
                            <label for="1">Logradouro</label>
                            <input type="text" class="form-control" id="1" name="logradouro" value="" required>
                        </div>
                        <div class="form-group col-xl-1 col-md-4 mt-3 ">
                            <label for="1">Número</label>
                            <input type="text" class="form-control" id="1" name="numero" value="" required>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="form-group col-xl-3 col-md-4 mt-3 ">
                                <label for="1">Complemento</label>
                                <input type="text" class="form-control" id="1" name="complemento" value="" required>
                            </div>
                            <div class="form-group col-xl-2 col-md-4 mt-3 ">
                                <label for="1">Bairro</label>
                                <input type="text" class="form-control" id="1" name="bairro" value="" required>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <br>

            <a class="btn btn-danger col-md-3 col-2 mt-5 offset-md-2" href="/gerenciar-associado" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-primary col-md-3 col-2 mt-5 offset-md-2">Confirmar</button>
            </form>

            <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tirar Foto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">

                                <form action="/capture-photo" method="post">
                                    <center>
                                    @csrf
                                    <video id="video" width="300" height="300"autoplay></video>
                                    <input type="hidden" name="photo" id="photo-input">
                                    </center>
                                    <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-secondary"id="capture-btn">Tirar foto</button>
                            <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="excluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ver Foto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <a href=""><button type="button" class="btn btn-primary">Confirmar</button></a>
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            @endsection


            @section('footerScript')
            <!-- Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
            <script>
                $(document).ready(function() {

                    $('#idcidade').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                    });


                    $('#iduf').change(function(e) {
                        e.preventDefault();

                        $('#idcidade').removeAttr('disabled');
                        var cidadeDadosResidenciais = $(this).val();

                        $.ajax({
                            type: "get",
                            url: "/retorna-cidade-dados-residenciais/" + cidadeDadosResidenciais,
                            dataType: "json",
                            success: function(response) {
                                $.each(response, function(indexInArray, item) {
                                    $('#idcidade').append('<option value = ' + item.id_cidade +
                                        '>' + item.descricao + '</option>');
                                });
                            },
                        });
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