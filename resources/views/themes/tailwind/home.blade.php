@extends('theme::layouts.app')

@section('content')


<div class="relative flex items-center w-full">
    <div class="relative z-20 px-8 mx-auto xl:px-5 max-w-7xl">

        <div class="flex flex-col items-center h-full pt-16 pb-56 lg:flex-row">

            <div
                class="flex flex-col items-start w-full mb-16 md:items-center lg:pr-12 lg:items-start lg:w-1/2 lg:mb-0">

                <h2 class="text-white invisible text-sm font-semibold tracking-wide text-gray-700 uppercase transition-none duration-700 ease-out transform translate-y-12 opacity-0 sm:text-base lg:text-sm xl:text-base"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    {{ theme('home_headline') }}</h2>
                <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    {{ theme('home_subheadline') }}</h1>
                <p class=" text-white invisible max-w-2xl mt-0 text-base text-left text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center lg:text-left sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                    {{ theme('home_description') }}</p>
                <div class="invisible w-full mt-5 transition-none duration-700 ease-out transform translate-y-12 opacity-0 delay-450 sm:mt-8 sm:flex sm:justify-center lg:justify-start sm:w-auto"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "opacity-0": "opacity-100" }'>

                </div>
            </div>

            <div class="flex w-full mb-16 lg:w-1/2 lg:mb-0">

                <div class="relative invisible transition-none duration-1000 delay-100 transform translate-x-12 opacity-0"
                    data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-x-12": "translate-y-0", "opacity-0": "opacity-100" }'>
                    <img src="{{ Voyager::image(theme('home_promo_image')) }}" class="w-full max-w-3xl sm:w-auto">
                </div>

            </div>
        </div>
    </div>



</div>

<div class="container-fluid">

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100"
                    src="https://th.bing.com/th/id/OIP.dMLLM_wws6eaEXZeyIPm3AHaEK?rs=1&pid=ImgDetMain"
                    alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100"
                    src="https://th.bing.com/th/id/OIP.dMLLM_wws6eaEXZeyIPm3AHaEK?rs=1&pid=ImgDetMain"
                    alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100"
                    src="https://th.bing.com/th/id/OIP.dMLLM_wws6eaEXZeyIPm3AHaEK?rs=1&pid=ImgDetMain"
                    alt="Third slide">
            </div>
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
    <div class="row">
        <div class="col-md-2">A</div>
        <div class="col-md-2">b</div>
        <div class="col-md-2">c</div>
        <div class="col-md-2">d</div>
        <div class="col-md-2">f</div>
        <div class="col-md-2">g</div>
    </div>
    <div class="section section-c text-white">
        Tabla de perspectiva de premios
    </div>
    <div class="section section-d text-white">
        Bote y dinero recaudado
    </div>
    <div class="section section-a text-white">
        Llamado a la acción (INVERSION)
    </div>
    <div class="section section-b text-white">
        Recientes ganadores
    </div>

</div>

@endsection