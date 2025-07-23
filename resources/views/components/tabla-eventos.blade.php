<div class="col-md-4 text-center d-flex flex-column align-items-center text-light neon-shadow  l">
    <h2 class="gamers texturizado-primary">Puede ser tuyo el gran acumulado de</h2>
    <h1 class="gamers texturizado-warning">{{$eventos["Bote"]}} USDT</h1>

    <img src="{{ asset('vitrix/img/svg/nave.svg') }}" class="moving-svg" width="100" height="100">
</div>
<div class="col-md-7  text-light neon-shadow  ">
    <div class="row text-center  justify-content-center pt-3">
       
        <div class="col-md-8"><img src="{{ asset('vitrix/img/cabeza.png') }}" width="100%" height="100%" class=""></div>
        
    </div>
    
  
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="gamers texturizado-warning mb-0" >{{ $eventos["evento"]->nombre }}</h1>
            <h1 class="gamers texturizado-primary mb-0" id="fechaFin">{{ $eventos["evento"]->fecha_fin }}</h1>
        </div>
    </div>

    <div class="neon-border"></div>
    <table class="table table-dark neon-table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Jugador</th>
                <th scope="col">Tiempo</th>
                <th scope="col">Puntuación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventos["lista"] as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$item->user->username}}</td>
                <td> <i class="fas fa-clock"></i>{{$item->tiempo}}</td>
                <td> <i class="fas fa-star"></i>{{$item->puntuacion}}</td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      // Obtén la fecha de finalización desde el HTML
      const fechaFin = document.getElementById('fechaFin').innerText.trim();
  
      // Convierte la fecha de fin (que está en formato string) a un objeto Date
      const fechaFinObj = new Date(fechaFin);
  
      // Obtén la fecha y hora actuales
      const fechaActual = new Date();
  
      // Calcula la diferencia en milisegundos
      const diferencia = fechaFinObj - fechaActual;
  
      // Si la fecha ya pasó, no mostrar nada
      if (diferencia <= 0) {
        document.getElementById('fechaFin').innerHTML = "¡El evento ha finalizado!";
        return;
      }
  
      // Convierte la diferencia de milisegundos a días, horas, minutos y segundos
      const diasRestantes = Math.floor(diferencia / (1000 * 60 * 60 * 24));
      const horasRestantes = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutosRestantes = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
      const segundosRestantes = Math.floor((diferencia % (1000 * 60)) / 1000);
  
      // Muestra el tiempo restante en un formato legible
      document.getElementById('fechaFin').innerHTML = `<b class="text-primary">Quedan</b> ${diasRestantes} días, ${horasRestantes} horas y ${minutosRestantes} Minutos para finalizar el evento`;
    });
</script>