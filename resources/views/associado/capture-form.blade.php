<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Photo</title>
</head>
<body>
    <h1>Capture Photo</h1>

    
    <form action="/capture-photo" method="post">
        @csrf
        <video id="video" width="300" height="400" autoplay></video>
        <button type="button" id="capture-btn">Capture Photo</button>
        <input type="hidden" name="photo" id="photo-input">
        <br>
        <button type="submit">Save Photo</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const video = document.getElementById('video');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const captureBtn = document.getElementById('capture-btn');
            const photoInput = document.getElementById('photo-input');

            navigator.mediaDevices.getUserMedia({ video: true })
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
