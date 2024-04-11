<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Photo</title>
</head>

<body>
    <div>
        @foreach($lista_associado as $associado)
        <tr>
            <!-- Colunas anteriores -->
            <td>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#camera{{$associado->id}}"><i class="bi bi-camera" style="font-size: 1rem; color:#303030;"></i></button>
                <!-- Modal para cada associado -->
                <div class="modal fade" id="camera{{$associado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <!-- Conteúdo do modal -->
                </div>
            </td>
        </tr>
        @endforeach
        <div class="modal fade" id="camera{{$lista_associado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</body>

</html>