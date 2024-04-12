@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="justify-content-center">
        <div class="col-12">
            <br>
            <div class="card" style="border-color: #355089;">
                <div class="card-header">
                    <div class="ROW">
                        <h5 class="col-12" style="color: #355089">
                            Gerenciar Associado
                        </h5>
                    </div>
                </div>
                <div>
                    <div class="card-body">
                        <form class="justify-content-center" action="{{route('pesquisar')}}" class="form-horizontal mt-4" method="GET">
                            <div class="row mt-2">
                                <div class="col-1">Nr Associado
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="50" type="text" id="2" name="nr_associado" value="{{$nr_associado}}">
                                </div>
                                <div class="col-3">Nome
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="text" id="3" name="nome_completo" value="{{$nome_completo}}">
                                </div>
                                <div class="col-2">Data de Início
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="date" id="3" name="dt_inicio" value="{{$dt_inicio}}">
                                </div>
                                <div class="col-2">Data de Fim
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="30" type="date" id="3" name="dt_fim" value="{{$dt_fim}}">
                                </div>
                                <div class="col-1">Status
                                    <select class="form-select" id="4" name="status" type="number" style="border: 1px solid #999999; padding: 5px;">
                                        <option value="">Todos</option>
                                        <option value="1">Ativo</option>
                                        <option value="2">Inativo</option>
                                    </select>
                                </div>
                                <div class="col"><br>
                                    <input class="btn btn-light btn-sm" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit" value="Pesquisar">

                                    <a href="/gerenciar-associado"><button class="btn btn-light btn-sm" type="button" value="" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Limpar</button></a>
                        </form>

                        <a href="/informar-dados-associado"><input class="btn btn-success btn-sm" type="button" name="6" value="Novo Cadastro +" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin:5px;"></a>

                    </div>
                </div>
            </div>
            <hr>
            <div class="table">
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center;">
                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                            <th class="col-1">Nr associado</th>
                            <th class="col-3">Nome</th>
                            <th class="col-1">Voluntário</th>
                            <th class="col-1">Votante</th>
                            <th class="col-1">Data Inicio</th>
                            <th class="col-1">Data Final</th>
                            <th class="col-1">Status</th>
                            <th class="col-2">Ações</th>

                        </tr>
                    </thead>
                    <tbody style="font-size: 16px; color:#000000; text-align: center">

                        @foreach ($lista_associado as $lista_associados)
                        <tr>
                            <td scope="">
                                <center>{{ $lista_associados->nr_associado }}</center>
                            </td>
                            <td scope="">
                                <center>{{ $lista_associados->nome_completo }}</center>
                            </td>
                            <td scope="">
                                <center></center>
                            </td>
                            <td scope="">
                                <center></center>
                            </td>
                            <td scope="">
                                <center>{{ Carbon\Carbon::parse($lista_associados->dt_inicio)->format('d-m-Y') }}</center>
                            </td>
                            <td scope="">
                                @if (!empty($lista_associados->dt_fim))
                                {{ Carbon\Carbon::parse($lista_associados->dt_fim)->format('d-m-Y') }}
                                @endif

                            </td>
                            <td scope="">
                                <center>{{ $lista_associados->status}}</center>
                            </td>

                            <td scope="" style="text-align: center">

                                <a href="/editar-associado/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-warning btn-sm"><i class="bi-pencil" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#camera{{$lista_associados->id}}"><i class="bi bi-camera" style="font-size: 1rem; color:#303030;"></i></button>
                                <a href="/capture-photo/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi-search" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <a href="/gerenciar-dados_bancarios/{{$lista_associados->id}}"><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi bi-currency-dollar" style="font-size: 1rem; color:#303030;"></i></button></a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#excluir{{$lista_associados->id}}" class="btn btn-outline-danger"><i class="bi-trash" style="font-size: 1rem; color:#303030;"></i></button>

                                <!-- Modal -->
                                <div>
                                    <div class="modal fade" id="excluir{{$lista_associados->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:rgba(202, 61, 61, 0.911);">
                                                    <div class="row">
                                                        <h2 style="color:white;">Excluir Associado</h2>
                                                    </div>

                                                </div>
                                                <div class="modal-body" style="color:#e24444;">
                                                    <p class="fw-bold alert alert text-center">
                                                        Você
                                                        realmente deseja excluir o Associado:
                                                        <span>{{ $lista_associados->nome_completo}}</span>

                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="/excluir-associado/{{ $lista_associado->id }}"><button type="button" class="btn btn-danger">Desativar
                                                            Permanentemente
                                                        </button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <!--Fim Modal-->
                                <!-- Modal -->
                                <div>
                                    <div class="modal fade" id="camera{{$lista_associados->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:#355089;">
                                                    <div class="row">
                                                        <h2 style="color:white;">Foto Associado</h2>
                                                    </div>

                                                </div>

                                                <div class="modal-body">
                                                    <div class="container-fluid">

                                                        <form action="/capture-photo" method="post">
                                                            <center>
                                                                @csrf
                                                                <video id="video" width="300" height="300" autoplay></video>
                                                                <input type="hidden" name="photo" id="photo-input">
                                                            </center>
                                                            <br>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-secondary" id="capture-btn">Tirar foto</button>
                                                    <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Fim Modal-->
                            </td>
                        </tr>
                        </tr>
                        @endforeach

                    </tbody>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const video = document.getElementById('video');
                            const captureBtn = document.getElementById('capture-btn');
                            const photoInput = document.getElementById('photo-input');
                            const canvas = document.createElement('canvas');

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


                    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                    @endsection