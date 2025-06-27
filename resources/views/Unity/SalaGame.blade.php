@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
    <div class="container">
        <div class="row ">
            <div class="col-md-12 text-center  py-3">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    {{$eventosala->nombre_sala}}</h1>

                <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

                    "La emocionante carrera te hará <b class='text-warning'>Ganar</b>"</p>

            </div>
        </div>
        @php
        use Carbon\Carbon;
        $fechaActual = Carbon::now();
        $fechaDB = Carbon::parse($eventosala->fecha_juego); // Suponiendo que $sala->fecha es el dato de la BD
        @endphp

        @if ($evento_finalizado)
        <div class="row bg-dark p-4">
            <div class="col-md-12">
                <h1 class="display-1 text-light"> EVENTO FINALIZADO</h1>
            </div>
        </div>
        @else
        <div class="row  justify-content-center align-items-center text-light  ">
            <div class="col-md-8  align-self-center fondo-personalizado" >
                @if($fechaActual->lessThan($fechaDB))
                <p class="text-warning bg-primary">Faltan</p>
                <p id="countdown" data-fecha="{{ $eventosala->fecha_juego }}" class="display-4 text-warning bg-primary py-4"></p>

                @else
                <div class="row">
                    <livewire:sala-live :sala-id="$eventosala->id" />
                </div>

                @endif
            </div>
            <div class="col-md-4">
                @if ($cerrar_apuestas)
                <div class="row">
                    <p class=" mx-3 px-2 bg-success text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                        data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

                        <b class='text-warning'>Vitrix</b> ha cerrado las apuestas. ¡Prepárate, que gane el mejor!"
                    </p>
                </div>
                @else
                <div class="row">
                    <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                        data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                        Hoy traemos a nuestros dos competidores <b class='text-warning'>Vitrix</b> Apuesta por el mejor
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @livewire('apuestas-volt', ['sala_id' => $eventosala->id])
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif




    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const countdownElement = document.getElementById("countdown");
        const fechaObjetivo = new Date(countdownElement.dataset.fecha).getTime();

        function actualizarCuentaRegresiva() {
            const ahora = new Date().getTime();
            const diferencia = fechaObjetivo - ahora;

            if (diferencia <= 0) {
            countdownElement.innerHTML = "¡La carrera ha comenzado! dirigiendote al evento";
            clearInterval(intervalo);
            setTimeout(() => {
                location.reload(); // Recarga la página
            }, 2000); // Espera 2 segundos antes de recargar
            return;
            }

            const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
            const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
            const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `${dias}D ${horas}H ${minutos}M ${segundos}S`;
        }

        // Actualizar cada segundo
        const intervalo = setInterval(actualizarCuentaRegresiva, 1000);
        actualizarCuentaRegresiva(); // Llamar inmediatamente para evitar el delay inicial
    });
</script>

@endsection