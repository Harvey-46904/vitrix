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
            <select id="cameraSelect"></select>
            <button id="scanBtn">Iniciar escaneo</button>
            <video id="preview" style="width:100%; max-width:400px;" playsinline></video>
            <p>QR escaneado: <span id="qrResult">Nada aún</span></p>
            <form action="{{route('addFoundBalancerecarga')}}" method="POST" >
                @csrf
                <input type="text" id="id_user" placeholder="Esperando QR..."  style="margin-top:10px; width:100%;">
                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="monto de recarga" name="monto">
                <button type="submit" class="btn btn-primary">Recargar</button>
              </form>
          
        </div>
    </div>
</div>
</div>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
    let cameras = [];

    scanner.addListener('scan', function (content) {
        console.log('QR escaneado:', content);
        document.getElementById('qrResult').innerText = content;
        document.getElementById('qrResult').value = content;
        scanner.stop();
    });

    Instascan.Camera.getCameras().then(function (foundCameras) {
        cameras = foundCameras;
        let select = document.getElementById('cameraSelect');
        if (cameras.length === 0) {
            alert('No se encontró cámara.');
            return;
        }
        cameras.forEach((cam, index) => {
            let option = document.createElement('option');
            option.value = index;
            option.text = cam.name || `Cámara ${index + 1}`;
            select.appendChild(option);
        });
    }).catch(function (e) {
        console.error(e);
        alert('Error al acceder a las cámaras.');
    });

    document.getElementById('scanBtn').addEventListener('click', function () {
        let selectedCameraIndex = document.getElementById('cameraSelect').value;
        let selectedCamera = cameras[selectedCameraIndex];
        scanner.start(selectedCamera);
    });
</script>
@endsection