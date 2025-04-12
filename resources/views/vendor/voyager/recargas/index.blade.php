@extends('voyager::master') @section('page_title', 'Todo') @section('content')




<div class="page-content container-fluid">


Recargas Vitrix
    @if (session('success'))
    <div class="alert alert-success" role="alert">
       Dinero depositado correctamente
       </div>
    @endif
    <div class="row  justify-content-end">
        <div class="col-md-12">
            <button id="scanBtn">Escanear QR</button>
            <video id="preview" style="display:none;" playsinline></video>
            <p>Contenido escaneado: <span id="qrResult">Nada aún</span></p>
        </div>
    </div>
</div>
</div>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });

    scanner.addListener('scan', function (content) {
        console.log('QR escaneado:', content);
        document.getElementById('qrResult').innerText = content;

        // Si quieres detener la cámara después de escanear:
        scanner.stop();

        // Opcional: ocultar el preview
        document.getElementById('preview').style.display = 'none';
    });

    document.getElementById('scanBtn').addEventListener('click', function () {
        document.getElementById('preview').style.display = 'block';

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No se encontró cámara.');
            }
        }).catch(function (e) {
            console.error(e);
            alert('Error al acceder a la cámara.');
        });
    });
</script>
@endsection