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
        </div>
    </div>
</div>
</div>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });

    scanner.addListener('scan', function (content) {
        console.log('QR escaneado:', content);
        // Aquí puedes hacer lo que quieras con el UUID escaneado
        // Por ejemplo: redirigir o hacer una petición AJAX
        // window.location.href = '/procesar-uuid/' + content;
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