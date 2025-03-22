@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
	<div class="container text-light  ">
		<div class="row justify-content-center my-5 ">

			<div class="col-md-6 neon-shadow">
				<div class="row">
					<div class="col-md-12 bg-fondo-azul">
						<h1 class="display-4 text-light">Speed Stakes</h1>
					</div>
				</div>

				
				
				@if ($autorizado)
				<div class="row bg-rosa-transparente py-2 mx-2">
					<div class="col-md-2  col-3"><img src="{{asset('vitrix/img/regalo.png') }}" class="icono not-prose"
							alt="..."></div>
					<div class="col-md-10 align-self-center col-9 ">
						Has sido desafiado a competir contra uno de nuestros mejores jugadores. Estos son los detalles
						de la carrera:
					</div>
				</div>
				<div class="row text-center">
					<div class="col-md-12">
						<div class="row py-3">
							<div class="col-md-12">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">Nombre carrera</span>
									</div>
									<input type="text" class="form-control" value="{{$salas->nombre_sala}}"
										placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
										disabled>
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">Fecha y hora</span>
									</div>
									<input type="text" class="form-control" value="{{$salas->fecha_juego}}"
										placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
										disabled>
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">Premio</span>
									</div>
									<input type="text" class="form-control" value="Al ganador {{$salas->precio_sala}} USDT"
										placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
										disabled>
								</div>
	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								
								<a href="{{ route('actiondesafio', ['action' => 'Aceptar', 'id' => $id]) }}" class="btn btn-success">
									<i class="fas fa-check-circle"></i> Aceptar
								</a>
							</div>
							<div class="col-md-6">
								<a href="{{ route('actiondesafio', ['action' => 'Rechazar', 'id' => $id]) }}" class="btn btn-danger"><i class="fas fa-drumstick-bite"></i> Rechazar</a>
							</div>
						</div>
					</div>
					
				</div>
				@else
				@if ($acepto)
				<div class="row py-3">
					<div class="col-md-12">
						<h1 class="text-success">{{$mesage}}</h1>
						 </div>
				</div>
				@else
				<div class="row py-3">
					<div class="col-md-12">
						<h1 class="text-danger">Este evento expiro o esta invitación no es para usted</h1>
						 </div>
				</div>
				@endif
				
				@endif



			</div>
		</div>



	</div>

</div>

@endsection