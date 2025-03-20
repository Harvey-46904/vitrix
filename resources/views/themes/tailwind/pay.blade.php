@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
	<div class="container text-light  ">
		<div class="row justify-content-center my-5 ">

			<div class="col-md-6 neon-shadow">
				<div class="row">
					<div class="col-md-12 bg-fondo-azul">
						<h1 class="display-4 text-light">Depositar</h1>
					</div>
				</div>
				<div class="row my-3 py-3">
					<div class="col-md-2 text-center col-3"> <img src="{{asset('vitrix/img/usdt.png') }}"
							class="icono not-prose" alt="...">
					</div>
					<div class="col-md-10 d-flex align-items-center col-9">
						<img src="{{ asset('vitrix/img/tron.png') }}" class="not-prose icono me-2" alt="...">
						<span>Trabajamos en la blockchain de Tron, por lo tanto la red de <b>USDT es TRC20</b></span>
					</div>
				</div>
				<div class="row bg-rosa-transparente py-2 mx-2">
					<div class="col-md-2  col-3"><img src="{{asset('vitrix/img/regalo.png') }}" class="icono not-prose"
							alt="..."></div>
					<div class="col-md-10 align-self-center col-9 "> En Vitrix todo deposito cuenta y esto ayuda a tus
						aliados en cada
						pago que realizes</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-end ">Estado:<b class="text-danger" id="status"> Desconectado</b></div>
					<div class="col-md-12">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">Usuario</span>
							</div>
							<input type="text" class="form-control" placeholder="Username" aria-label="Username"
								aria-describedby="basic-addon1" disabled value="">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">Billetera</span>
							</div>
							<input type="text" id="walletAddress" class="form-control" placeholder="Username" aria-label="Username"
								aria-describedby="basic-addon1" disabled value="Billetera No conectada">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">Recarga</span>
							</div>
							<input type="text" class="form-control" placeholder="Username" aria-label="Username"
								aria-describedby="basic-addon1"  value="{{$action}}" disabled>
						</div>
					</div>
					
					


				</div>
				<div class="row text-center d-none" id="methodspay">

					@switch($action)
					@case('deposito')
					<div class="col-md-12">

						<form action="{{route('cashbalance')}}" method="POST">
							@csrf
							<p class="text-rosa"> Montos Disponibles</p>
							<h4 class="text-light">Seleccione una opción:</h4>

							<!-- Opciones de respuesta (radio buttons) -->
							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion1" value="5"
									onclick="disableTextInput(false)">
								<label class="form-check-label" for="opcion1">
									5 USDT
								</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion2" value="10"
									onclick="disableTextInput(false)">
								<label class="form-check-label" for="opcion2">
									10 USDT
								</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion3" value="15"
									onclick="disableTextInput(false)">
								<label class="form-check-label" for="opcion3">
									15 USDT
								</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion4" value="20"
									onclick="disableTextInput(false)">
								<label class="form-check-label" for="opcion4">
									20 USDT
								</label>
							</div>

							<!-- Caja de texto adicional -->
							<div class="form-group mt-3">
								<label for="opcionExtra">Otra opción:</label>
								<input type="number" class="form-control" id="opcionExtra" name="respuesta_extra"
									placeholder="Escribe tu respuesta" min="1"
									oninput="disableRadios(); checkMinValue(this)">
							</div>

							<!-- Botón de enviar -->
							<button type="submit" class="btn btn-primary">Pagar</button>
						</form>


					</div>
					@break

					@case('inversion')
					<div class="col-md-12 ">
						<form action="{{route('cashbalanceInversion',['id'=>$paquete->id])}}" method="POST">
							@csrf
							<p class="text-rosa"> Montos a pagar</p>
							<p class="text-light text-justify"> El paquete que va a comprar tiene un precio total de
								<b class="text-azul-variante">{{$paquete->precio_base}} USDT</b>
								.La rentabilidad que genera este paquete de inversión es del
								<b class="text-azul-variante">{{$paquete->porcentaje_rentabilidad}}%</b>
								, lo que significa que, en un periodo de
								<b class="text-azul-variante">{{$paquete->duracion_meses}} Meses</b>
								, usted recibirá un total de
								<b class="text-azul-variante">{{$paquete->totalidad}} USDT.</b>
							</p>

							<!-- Opciones de respuesta (radio buttons) -->
							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion1"
									value="{{$paquete->precio_base}}" onclick="disableTextInput(false)" checked>
								<label class="form-check-label" for="opcion1">
									{{$paquete->precio_base}} USDT
								</label>
							</div>



							<!-- Botón de enviar -->
							<button type="submit" class="btn btn-primary mt-4">Pagar</button>
						</form>

					</div>
					@break

					@case('ibox')
					<div class="col-md-12">
						<form action="{{route('cashbalanceIbox',['id'=>$paquete->id])}}" method="POST">
							@csrf
							<p class="text-rosa"> Montos a pagar</p>


							<!-- Opciones de respuesta (radio buttons) -->
							<div class="form-check">
								<input class="form-check-input" type="radio" name="respuesta" id="opcion1"
									value="{{$paquete->precio_compra}}" onclick="disableTextInput(false)" checked>
								<label class="form-check-label" for="opcion1">
									{{$paquete->precio_compra}} USDT
								</label>
							</div>



							<!-- Botón de enviar -->
							<button type="submit" class="btn btn-primary mt-4">Pagar</button>
						</form>

					</div>
					@break
					@endswitch

				</div>
				<div class="row text-center">
					<div class="col-md-12 text-center d-none" id="computador">
						
						<button id="tronlinkButton" class="btn  bg-tronlink d-flex align-items-center">
							<img src="https://d1muf25xaso8hp.cloudfront.net/https://meta-q.cdn.bubble.io/f1669295699744x508414720900902000/tron_link.png?w=&h=&auto=compress&dpr=1&fit=max" alt="TronLink" style="width: 40px; height: 40px; margin-right: 5px;">
							Abrir TronLink extensión
						</button>
					</div>

					<div class="col-md-12 d-none " id="celular">

						<button id="btnTronLink" class="btn  bg-tronlink d-flex align-items-center" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">
							<img src="https://d1muf25xaso8hp.cloudfront.net/https://meta-q.cdn.bubble.io/f1669295699744x508414720900902000/tron_link.png?w=&h=&auto=compress&dpr=1&fit=max" alt="TronLink" style="width: 40px; height: 40px; margin-right: 5px;">
							Abrir TronLink Movil
						</button>
						
						<!-- 
							<button id="btnOKX" class="btn btn-success" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir OKX</button>
						<button id="btnTokenPocket" class="btn btn-warning" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir TokenPocket</button>
						-->
						
					</div>
				
					<div class="col-md-12">
						<input type="number" id="usdtAmount" placeholder="Monto USDT">
						<button onclick="payWithUSDT(document.getElementById('usdtAmount').value,'Recarga')">Pagar con
							USDT</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">Envía únicamente USDT a esta dirección de contrato. su dinero se
						depositarán automáticamente después de 6 confirmaciones de red. Las direcciones de contratos
						inteligentes no son compatibles (contáctanos).
						Minimum Deposit: 0.000001 USDT.</div>
				</div>
			</div>
		</div>



	</div>

</div>

<script src="{{ asset('js/tron.js') }}"></script>
@endsection