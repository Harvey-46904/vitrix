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
        <div class="row justify-content-center align-items-center text-light ">
            <div class="col-md-7">
                <img src="{{asset('vitrix/img/usdt.png') }}" class="" alt="...">
            </div>
            <div class="col-md-5 aling-items-center">
                <div class="row">
                    <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                        data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

                        Hoy traemos a nuestros dos competidores <b class='text-warning'>Vitrix</b> Apuesta por el mejor
                    </p>
                </div>
                <div class="row bg-danger">
                    <div class="col-md-12  texturizado-warning gamers">
                        {{$eventosala->player_one_name}}
                    </div>

                </div>
                <div class="row bg-danger mt-3">
                    <div class="col-md-12 texturizado-warning gamers">
                        {{$eventosala->player_two_name}}
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection