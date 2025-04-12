@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
    <div class="container">
        <div class="row ">
            <div class="col-md-12 text-center  py-3">
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                   {{$evento->nombre}}
                <br>
                
               
                </h1>

                <h3 class="text-success">Precio por jugada: {{$evento->precio}} USD</h3>
            </div>
        </div>

        <marquee behavior="scroll" direction="left" scrollamount="8"
			style="color: #cf00b4; font-size: 1.5em; font-weight: bold;" class="bg-rosa neon-shadow  ">
            🎯 Cada partida te acerca al podio, y los mejores se llevan el gran bote acumulado.
            💎 ¡Juega, compite y gana recompensas exclusivas mientras subes de rango!
		</marquee>
        <div class="row justify-content-center align-items-center text-light  ">
            <div class="col-md-6 align-self-center" >

                @livewire('lista-naves')
            </div>
            <div class="col-md-6">  <div id="carouselExampleControls" class="carousel slide " data-ride="carousel" style="width: 100%">
                <div class="row">
                    <div class="col-md-6">
                        <video width="100%" autoplay muted loop>
                            <source src="{{ asset('vitrix/video/nebula.mp4') }}" type="video/mp4">
                            Tu navegador no soporta video HTML5.
                        </video>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('vitrix/img/nebula.gif') }}" alt="Imagen ejemplo" width="100%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
                </div>
                
        
            </div></div>
            
        </div>

    </div>
</div>



@endsection