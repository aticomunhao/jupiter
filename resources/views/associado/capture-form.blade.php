<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Photo</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        /* Custom CSS styles can be added here */
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-header" style="background-color:#355089; color:white;">
                        <h2 class="text-center">Foto Associado</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store.photo', ['ida' => $ida]) }}" method="post">
                            @csrf
                            <center>
                                <video id="video" width="300" height="300" autoplay class="mb-3"></video>
                                <input type="hidden" name="photo" id="photo-input">
                            </center>
                            <div class="text-center">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger mr-2"
                                        data-bs-dismiss="modal">Cancelar</button></a>
                                <button type="button" class="btn btn-secondary mr-2" id="capture-btn">Tirar
                                    foto</button>
                                <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById('video');
            const captureBtn = document.getElementById('capture-btn');
            const photoInput = document.getElementById('photo-input');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

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
