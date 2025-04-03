@extends('theme::layouts.app')

@section('content')




<div class="container-fluid">

    <div id="carouselExampleControls" class="carousel slide " data-ride="carousel" style="width: 100%">
        <div class="carousel-inner">
            @foreach ($banners as $index => $imagen)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img class="w-100" src="{{ Voyager::image($imagen->imagen) }}" alt="Slide {{ $index + 1 }}">
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>



    <div class="container text-center text-light py-2">

        <div class="row justify-content-center ">
            <div class="col-md-8 text-center py-1 ">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    Los Mejores Juegos</h1>



            </div>
        </div>

        <div class="row justify-content-center pt-3 neon-shadow">

            @foreach ($juegos as $juego)
            <div class="col-md-3 col-5 my-2">
                <div class="card card-container p-3" style=" background-color: #ffffff00;"
                    onmouseover="this.style.cursor='pointer';" onclick="loadgame('{{$juego->nombre}}')">
                    <img src="{{ Voyager::image($juego->imagen) }}" class="card-img-top  card-flip" alt="...">
                </div>
            </div>
            @endforeach


        </div>


    </div>

    <marquee behavior="scroll" direction="left" scrollamount="8"
        style="color: #cf00b4; font-size: 1.5em; font-weight: bold;" class="bg-rosa neon-shadow  ">
        🎰 ¡VITRIX! Grandes premios, jackpots acumulados y diversión sin límites. ¡Apuesta y gana! 💰
    </marquee>
    <div class="container ">
        <div class="row">
            <div class="col-md-12 text-center py-3">
                <h1 class=" invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    Jackpots y Premios</h1>

                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    Descubre nuestros emocionantes jackpots y premios especiales que podrían <b
                        class="text-warning">cambiar tu vida.</b> ¡Apuesta y
                    sé el próximo gran <b class="text-warning">ganador</b>!</p>

            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4">

                <div class="card text-center" style=" background-color: #ffffff00; border: 1px solid rgb(0 0 0 / 0%);">

                    <div class="card-body bg-gris neon-shadow">
                        <h5 class="card-title text-light gamers texturizado-warning ">Premios Ganadores</h5>
                        <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                            data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                            Juega cualquiera de nuestros juegos y podras ganar uno de nuestros jackpots</p>

                        <a href="#" class="btn  bg-azul-variante mt-4">Jugar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-md-7 text-center">
                        <div class="jumbotron jumbotron-fluid i neon-shadow bg-black">
                            <div class="container ">
                                <p class="lead gamers texturizado-warning">
                                    Speed stakes <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                </p>
                                <h1 id="speed" class="display-4 text-light">0</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="jumbotron jumbotron-fluid  t  bg-black neon-shadow">
                                    <div class="container ">
                                        <p class="lead gamers texturizado-warning">
                                            Genie's Rise <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                        </p>
                                        <h1 id="genie" class="display-4 text-light">0</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="jumbotron jumbotron-fluid s bg-black neon-shadow">
                                    <div class="container ">
                                        <p class="lead gamers texturizado-warning">
                                            Nebula Race <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                        </p>
                                        <h1 id="nebula" class="display-4 text-light">0</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <marquee behavior="scroll" direction="left" scrollamount="8"
        style="color: #cf00b4; font-size: 1.5em; font-weight: bold;" class="bg-rosa neon-shadow  ">
        🎰 ¡VITRIX! Invierte con nosotros, obten recompenzas. ¡Apuesta y gana! 💰
    </marquee>


    <div class="container">
        <div class="row ">
            <div class="col-md-12 text-center  py-3">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    Tabla de Ganadores</h1>

                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

                    Conoce a nuestros <b class="text-warning">ganadores</b> más recientes y descubre cómo tú también
                    puedes aparecer en la lista de
                    <b class="text-warning">triunfadores</b>. ¡Tu nombre <b class="text-warning">{{ Auth::user()->name ?? 'Vitrix' }}</b> podría ser el
                    siguiente!
                </p>

            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6"> <img src="{{asset('vitrix/img/marcotetris.png') }}" class=" img-fluid" alt="..."></div>
            <div class="col-md-6 bg-gris neon-shadow text-center">
                <h1 class="gamers texturizado-primary">Evento Nebula Race</h1>
                <h1 class="gamers texturizado-warning">{{$eventos["evento"]->nombre}}</h1>
                <h1 class="gamers texturizado-primary" id="fechaFin">{{$eventos["evento"]->fecha_fin}}</h1>
                <table class="table table-dark">
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
                            <td>{{$item->user->name}}</td>
                            <td> <i class="fas fa-clock"></i>{{$item->tiempo}}</td>
                            <td> <i class="fas fa-star"></i>{{$item->puntuacion}}</td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script>
    function loadgame(name){
       
        let serial="";
        switch (name) {
            case "aviator":
            window.location.href = "/e-sports";
                serial="cars"
            break;
            case "Genius":
            serial="genius"
            break;
            case "Monster":
            serial="navial"
            break;
        }

        const width = 965; // Ancho de la ventana
        const height = 610; // Alto de la ventana
        const left = (screen.width - width) / 2; // Centrado horizontal
        const top = (screen.height - height) / 2; // Centrado vertical

        // Abrir la ventana emergente
        const routeName = serial; // Aquí puedes usar cualquier lógica para obtener este nombre dinámicamente.
        const url = `{{ url('/') }}/${routeName}`;

        window.open(
            url, // URL completa
            "UnityGame", // Nombre de la ventana
            `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=no`
        );
       
    }
    document.getElementById('openGame').addEventListener('click', function () {
        // Configuración de la ventana emergente
        const width = 960; // Ancho de la ventana
        const height = 605; // Alto de la ventana
        const left = (screen.width - width) / 2; // Centrado horizontal
        const top = (screen.height - height) / 2; // Centrado vertical

        // Abrir la ventana emergente
        window.open(
            "{{ route('unity-game') }}", // URL de la vista del juego
            "UnityGame", // Nombre de la ventana
            `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=no`
        );
    });
</script>

<script type="module">
    import { CountUp } from 'https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.0/countUp.min.js';
  
    document.addEventListener('DOMContentLoaded', function () {
      // Obtén el valor dinámico desde Laravel
      const balanceFinal = {{ $balance }}; // Asegúrate de que $balance está disponible en el Blade
        const balancegenie=12000;
        const balancenebula={{$eventos["Bote"]}};
      // Inicializa CountUp.js
      const options = {
        duration: 1, // Duración de la animación en segundos
        decimalPlaces: 2, // Número de decimales
        useEasing: true, // Usa una animación suave
      };
      const counter = new CountUp('speed', balanceFinal, options);
      const counter1 = new CountUp('genie', balancegenie, options);
      const counter2 = new CountUp('nebula', balancenebula, options);

      counter.start();
      counter1.start();
      counter2.start();
    });
</script>
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
@endsection