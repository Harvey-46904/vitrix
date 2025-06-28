@extends('theme::layouts.app')


@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-light gamers"> {{ __('general.dashboard.option1') }} <b> {{Auth::user()->name}}</b> </h1>
		</div>
	</div>
	<div class="row">
		<marquee behavior="scroll" direction="left" scrollamount="8"
			style="color: #cf00b4; font-size: 1.5em; font-weight: bold;" class="bg-rosa neon-shadow  ">
			{{ __('general.dashboard.option2') }}
		</marquee>

		<div class="col-md-12 text-center">
			<h1 class="text-light gamers">{{ __('general.dashboard.option3') }} </h1>
		</div>
		<div class="row ">
			<div class="col-3 col-md-3 ">
				<div class="">
					<img  class=" circle-image img-fluid rounded-circle" src="./vitrix/img/rangos/RANGOS PORTADAS_ZAFIRO.png" alt="Imagen 1">

				</div>
			</div>
			<div class="col-3 col-md-3">
				<div class="">
					<img class=" circle-image img-fluid rounded-circle" src="./vitrix/img/rangos/RANGOS PORTADAS_ESMERALDA.png" alt="Imagen 2">
				</div>
			</div>
			<div class="col-3 col-md-3">
				<div class="">
					<img class="circle-image img-fluid rounded-circle"  src="./vitrix/img/rangos/RANGOS PORTADAS _ RUBI.png" alt="Imagen 2">
				</div>
			</div>
			<div class="col-3 col-md-3">
				<div class="">
					<img  class=" circle-image img-fluid rounded-circle" src="./vitrix/img/rangos/RANGOS PORTADAS_DIAMANTE.png" alt="Imagen 2">
				</div>
			</div>
		</div>

	</div>
	<div class="row neon-shadow align-items-center my-3 p-3">
		<div class="col-md-4">
			<div class="card neon-purple miembros" style="background-color: #ffffff00;">
				<div class="card-body text-center ">
					<h5 class="card-title gamers texturizado-warning">{{ __('general.dashboard.option4') }}</h5>
					<h5 class="card-title gamers texturizado-primary">
						${{number_format(auth()->user()->balance_card->balance, 2) }}</h5>
					<p class="card-text text-light">{{ __('general.dashboard.option5') }}</p>
					<a href="{{route('wave.ibox')}}" class="btn my-1  bg-azul-secundario">{{ __('general.dashboard.option6') }}</a>
				</div>
			</div>
		</div>

		<div class="col-md-8">

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

		</div>

	</div>


	<div class="container text-center text-light py-2">

		<div class="row justify-content-center ">
			<div class="col-md-8 text-center py-1 ">
				<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
					data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
					{{ __('general.inicio.titulo_1') }}
				</h1>



			</div>
		</div>
		<marquee behavior="scroll" direction="left" scrollamount="8"
			style="color: #cf00b4; font-size: 1.5em; font-weight: bold;" class="bg-rosa neon-shadow  ">
			{{ __('general.dashboard.option7') }}
		</marquee>
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
	<div class="row justify-content-center ">
		<div class="col-md-8 text-center py-1 ">
			<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
				Nebula Race</h1>



		</div>
	</div>
	<div class="row justify-content-between">
		<x-tabla-eventos :eventos="$eventos" />

	</div>

	<div class="row pb-3 mt-2">
		<div class="col-md-12">
			<div class="row justify-content-center ">
				<div class="col-md-8 text-center py-1 ">
					<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
						data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
						Speed Stakes</h1>

					<p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
						data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
						{{ __('general.dashboard.option8') }}<b
							class="text-warning">{{ __('general.dashboard.option9') }}</b>{{ __('general.dashboard.option10') }} <b
							class="text-warning">{{ __('general.dashboard.option11') }}</b>!</p>


				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<a class="btn bg-azul-variante m-4 p-4" href="{{route('wave.esports')}}">{{ __('general.dashboard.option12') }}</a>
				</div>
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
    // Obtener el ancho y alto de la pantalla del usuario
    const screenWidth = window.screen.availWidth;
    const screenHeight = window.screen.availHeight;

    // Definir el ancho y alto de la ventana emergente
    const width = Math.min(960, screenWidth);  // Máximo 960 o el tamaño de la pantalla
    const height = Math.min(650, screenHeight); // Máximo 650 o el tamaño de la pantalla

    // Calcular posición para centrar la ventana
    const left = (screenWidth - width) / 2;
    const top = (screenHeight - height) / 2;

    // Abrir la ventana emergente sin scroll y con tamaño adecuado
    const popup = window.open(
        "{{ route('unity-game') }}", // URL de la vista del juego
        "UnityGame", // Nombre de la ventana
        `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=no`
    );

    // Intentar maximizar la ventana (algunos navegadores pueden bloquear esto)
    if (popup) {
        popup.moveTo(0, 0);
        popup.resizeTo(screenWidth, screenHeight);
    }
});
</script>
@endsection