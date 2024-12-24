@extends('theme::layouts.app')


@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-light gamers">Bienvenido <b> {{Auth::user()->name}}</b> </h1>
		</div>
	</div>

	<div class="row neon-shadow align-items-center my-3 p-3">
		<div class="col-md-4">
			<div class="card  bg-gris">
				<div class="card-body text-center ">
					<h5 class="card-title gamers texturizado-warning">RENTABILIDAD</h5>
					<p class="card-text text-light">Recuerda que debes tener activa tu membresia IBOX para retirar tus
						rentabilidades</p>
					<a href="#" class="btn my-1  bg-azul-secundario">Comprar Membresia</a>
				</div>
			</div>
		</div>

		<div class="col-md-5">

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
		<div class="col-md-3 text-center gamers rangos bg-gris rounded">
			<h3 class="texturizado-warning">Rango Actual</h3>
			<br>
			<b class="texturizado-warning">Bronce</b>
		</div>
	</div>
	<div class="row justify-content-between">
		<x-tabla-eventos :eventos="$eventos" />

	</div>
	<div class="row">
		<div class="col-md-12 text-center ">
			<div class="row bg-gris mt-2">
				<div class="col-md-12">
					<h2 class="text-light gamers texturizado-primary">Los juegos con mas ganancias</h2>
				</div>
			</div>

			<div class="row justify-content-center pt-3">

				@foreach ($juegos as $juego)
				<div class="col-md-2 col-5 mx-2 ">

					<img src="{{ Voyager::image($juego->imagen) }}" class="card-img-top  card-flip py-2" width="10%"
						height="10%">

				</div>
				@endforeach

			</div>
		</div>
	</div>
	<div class="row bg-gris mt-2">
		<div class="col-md-12">
			<h2 class="text-light gamers texturizado-primary ">Apuesta al ganador en nuestras competencias online</h2><br>
		</div>
	</div>

	
	<div class="row  justify-content-center">

		<div class="col-md-6">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				<!-- Indicadores -->
				<ol class="carousel-indicators">
					@foreach ($salas as $index => $sala)
					<li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
						class="{{ $loop->first ? 'active' : '' }}"></li>
					@endforeach
				</ol>

				<!-- Contenido del carrusel -->
				<div class="carousel-inner">
					@foreach ($salas as $index => $sala)
					<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
						<div class="card text-center destellos neon-shadow bg-gris"
							style="width: 18rem; margin: 0 auto; background-color: #ffffff00;">
							<img class="card-img-top" src="{{ Voyager::image($sala->banner) }}" alt="Card image cap">
							<div class="card-body">
								<h5 class="card-title gamers-1 texturizado-warning">{{ $sala->nombre_sala }}</h5>
								<p class="card-text"></p>
								<a href="{{ route('sala.detalle', $sala->id) }}" class="btn bg-azul-secundario">Ver
									evento</a>
							</div>
						</div>
					</div>
					@endforeach
				</div>

				<!-- Controles del carrusel -->
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>


@endsection