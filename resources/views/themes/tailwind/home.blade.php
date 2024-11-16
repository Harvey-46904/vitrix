@extends('theme::layouts.app')

@section('content')

<button id="tetrisButton" aria-label="Tetris Button"></button>


<div class="container-fluid">
   
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
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

    <div class="container text-light py-5">
        <div class="row justify-content-between ">
            <div class="col-md-2 col-5 m-2 bg-azul-secundario rounded  p-3">
                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-gift fa-3x mb-2" style="color: #36114e;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="font-weight-normal h3">Free Trial</p>

                    </div>
                </div>
            </div>
            <div class="col-md-2 col-5 m-2 bg-azul-secundario rounded  p-3">
                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-coins fa-3x mb-2" style="color: #36114e;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="font-weight-normal h3">Crypto deposit</p>

                    </div>
                </div>
            </div>
            <div class="col-md-2 col-5 m-2 bg-azul-secundario rounded  p-3">
                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-user-friends fa-3x mb-2" style="color: #36114e;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="font-weight-normal h3">Referral programa</p>

                    </div>
                </div>
            </div>
            <div class="col-md-2 col-5 m-2 bg-azul-secundario rounded  p-3">
                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-headset fa-3x mb-2" style="color: #36114e;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="font-weight-normal h3">Soporte 27/7</p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container text-center text-light">

        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Los Mejores Juegos</h1>
       
                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Ofrecemos recompenzas en todos nuestros juegos para que puedas divertirte</p>

            </div>
        </div>
      
        <div class="row justify-content-center pt-3">

            @foreach ($juegos as $juego)
            <div class="col-md-3 col-10 mx-2">
                <div class="card card-container" style="width: 18rem; background-color: #ffffff00;" 
                @if($juego->nombre == "Genius") id="openGame" @endif
                onmouseover="this.style.cursor='pointer';">
                    <img src="{{ Voyager::image($juego->imagen) }}" class="card-img-top  card-flip" alt="...">
                </div>
            </div>
            @endforeach


        </div>


    </div>

    <marquee behavior="scroll" direction="left" scrollamount="8" style="color: #387CBB; font-size: 1.5em; font-weight: bold;">
        🎰 ¡VITRIX! Grandes premios, jackpots acumulados y diversión sin límites. ¡Apuesta y gana! 💰
    </marquee>
    <div class="container  ">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Jackpots y Premios</h1>
       
                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Descubre nuestros emocionantes jackpots y premios especiales que podrían cambiar tu vida. ¡Apuesta y sé el próximo gran ganador!</p>

            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4">

                <div class="card text-center"
                    style=" background-color: #ffffff00; border: 1px solid rgb(0 0 0 / 0%);">
                    <img src="{{asset('vitrix/img/jackpot.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-light">Premios Ganadores</h5>
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
                        <div class="jumbotron jumbotron-fluid bg-azul-secundario">
                            <div class="container">
                                <p class="lead">
                                    Mega Jackpot <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                </p>
                                <h1 class="display-4">$61,517.40</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="jumbotron jumbotron-fluid  bg-azul-secundario">
                                    <div class="container">
                                        <p class="lead">
                                            Grand Jackpot <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                        </p>
                                        <h1 class="display-4">$517.40</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="jumbotron jumbotron-fluid bg-azul-secundario">
                                    <div class="container">
                                        <p class="lead">
                                            Minor Jackpot <i class="fas fa-money-bill-wave" style="color: green;"></i>
                                        </p>
                                        <h1 class="display-4">$50.2</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <marquee behavior="scroll" direction="left" scrollamount="8" style="color: #9e57cc; font-size: 1.5em; font-weight: bold;">
        🎰 ¡VITRIX! Invierte con nosotros, obten recompenzas. ¡Apuesta y gana! 💰
    </marquee>
    <div class="container text-center py-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Inversiones</h1>
       
                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Haz crecer tu dinero con nuestras opciones de inversión seguras y rentables. Aumenta tus ganancias y maximiza tu retorno.</p>

            </div>
        </div>
        <div class="row text-light justify-content-center pt-3">
            <div class="col-md-4 align-self-center">
                <div class="card " style=" background-color: #061727;">
                    <div class="card-body bg-rosa">
                        <p class="card-text font-weight-normal ">Alta Rentabilidad</p>
                    </div>
                    <img src="{{asset('vitrix/img/vectores/a.png') }}"
                        class="card-img-top vector rounded mx-auto d-block" alt="...">
                    <div class="card-body">
                        <p class="card-text">Genera ingresos pasivos con nuestras estrategias diseñadas para maximizar
                            tus ganancias a corto y largo plazo.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style=" background-color: #061727;">
                    <div class="card-body bg-rosa">
                        <p class="card-text ">Seguridad de Fondo</p>
                    </div>
                    <img src="{{asset('vitrix/img/vectores/b.png') }}"
                        class="card-img-top vector rounded mx-auto d-block" alt="...">
                    <div class="card-body">
                        <p class="card-text">Contamos con tecnología avanzada de encriptación y protección de datos para
                            que tu inversión esté siempre segura.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style=" background-color: #061727;">
                    <div class="card-body bg-rosa">
                        <p class="card-text">Soporte 24/7</p>
                    </div>
                    <img src="{{asset('vitrix/img/vectores/c.png') }}"
                        class="card-img-top vector rounded mx-auto d-block" alt="...">
                    <div class="card-body">
                        <p class="card-text">Nuestro equipo de soporte está disponible a cualquier hora para resolver
                            tus dudas y asistirte en todo momento.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-light justify-content-center pt-2">
            <div class="col-md-6 ">
                <div class="card" style="background-color: #061727;">
                    <div class="card-body bg-rosa">
                        <p class="card-text">Acceso a Criptomonedas</p>
                    </div>
                    <img src="{{asset('vitrix/img/vectores/d.png') }}"
                        class="card-img-top vector rounded mx-auto d-block" alt="...">
                    <div class="card-body">
                        <p class="card-text">Diversifica tu portafolio con acceso a criptomonedas, acciones, y otros
                            activos desde una sola plataforma.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style=" background-color: #061727;">
                    <div class="card-body bg-rosa">
                        <p class="card-text">Educación para Inversores</p>
                    </div>
                    <img src="{{asset('vitrix/img/vectores/e.png') }}"
                        class="card-img-top vector rounded mx-auto d-block" alt="...">
                    <div class="card-body">
                        <p class="card-text">Aprende a invertir de forma inteligente con guías, webinars, y recursos
                            para mejorar tus conocimientos financieros.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                Tabla de Ganadores</h1>
       
                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
              
                Conoce a nuestros ganadores más recientes y descubre cómo tú también puedes aparecer en la lista de triunfadores. ¡Tu nombre podría ser el siguiente!</p>

            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6">  <img src="{{asset('vitrix/img/Designer.jpeg') }}"
                class=" img-fluid" alt="..."></div>
            <div class="col-md-6">
                <h2 class="text-light">Top Semanal</h2>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script>
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
@endsection