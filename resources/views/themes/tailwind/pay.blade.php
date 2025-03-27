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
								aria-describedby="basic-addon1" disabled value="{{$user->name}}">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">Billetera</span>
							</div>
							<input type="text" id="walletAddress" class="form-control" placeholder="Username"
								aria-label="Username" aria-describedby="basic-addon1" disabled
								value="Billetera No conectada">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">Recarga</span>
							</div>
							<input type="text" class="form-control" placeholder="Username" aria-label="Username"
								aria-describedby="basic-addon1" value="{{$action}}" disabled>
						</div>
					</div>




				</div>
				<div class="row text-center d-none" id="methodspay">

					@switch($action)
					@case('deposito')
					<div class="col-md-12">
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
							<label for="opcionExtra">Monto Diferente:</label>
							<input type="number" class="form-control" id="opcionExtra" name="respuesta_extra"
								placeholder="Digita tu monto" min="1" oninput="disableRadios(); checkMinValue(this)">
						</div>

						<!-- Botón de enviar -->
						<button onclick="validador('{{$action}}')" type="submit" class="btn btn-primary">Pagar</button>



					</div>
					@break

					@case('inversion')
					<div class="col-md-12 ">

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
							<input class="form-check-input" type="radio" name="respuesta" id="valueinversion"
								value="{{$paquete->precio_base}}" onclick="disableTextInput(false)" checked>
							<label class="form-check-label" for="opcion1">
								{{$paquete->precio_base}} USDT
							</label>
						</div>



						<!-- Botón de enviar -->
						<button onclick="validador('{{$action}}')" type="submit"
							class="btn btn-primary mt-4">Pagar</button>


					</div>
					@break

					@case('ibox')
					<div class="col-md-12">

						<p class="text-rosa"> Montos a pagar</p>


						<!-- Opciones de respuesta (radio buttons) -->
						<div class="form-check">
							<input class="form-check-input" type="radio" name="respuesta" id="valueibox"
								value="{{$paquete->precio_compra}}" onclick="disableTextInput(false)" checked>
							<label class="form-check-label" for="opcion1">
								{{$paquete->precio_compra}} USDT
							</label>
						</div>



						<!-- Botón de enviar -->
						<button onclick="validador('{{$action}}')" type="submit"
							class="btn btn-primary mt-4">Pagar</button>


					</div>
					@break
					@endswitch
					<div class="col-md-12">
						<div class="alert alert-danger d-none" id="alertaerror"  role="alert">
							text
						  </div>
						  <div class="alert alert-success d-none" id="alertacorrecto"  role="alert">
							text
						  </div>
						  <div class="alert alert-warning text-break d-none" id="esperaconfirmacion" role="alert">
							Validando su transacción en la blockchain. Por favor, no cierre ni recargue la ventana hasta que el proceso se complete.
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" id="progress-bar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
							<p>Tiempo máximo <span id="countdown">3:00</span></p>
						</div>
						  <div class="alert alert-success text-break d-none " id="hashid"  role="alert">
							text
						  </div>

						  <div class="alert alert-primary d-none" id="actionfinal"  role="alert">
							text
						  </div>
						 
					</div>
					
				</div>
				<div class="row text-center">
					<div class="col-md-12 text-center d-none" id="computador">

						<button id="tronlinkButton" class="btn  bg-tronlink d-flex align-items-center">
							<img src="https://d1muf25xaso8hp.cloudfront.net/https://meta-q.cdn.bubble.io/f1669295699744x508414720900902000/tron_link.png?w=&h=&auto=compress&dpr=1&fit=max"
								alt="TronLink" style="width: 40px; height: 40px; margin-right: 5px;">
							Abrir TronLink extensión
						</button>
					</div>

					<div class="col-md-12 d-none " id="celular">

						<button id="btnTronLink" class="btn  bg-tronlink d-flex align-items-center" data-user="{{$hash}}"
							data-action="{{$action}}" data-id="{{$id}}">
							<img src="https://d1muf25xaso8hp.cloudfront.net/https://meta-q.cdn.bubble.io/f1669295699744x508414720900902000/tron_link.png?w=&h=&auto=compress&dpr=1&fit=max"
								alt="TronLink" style="width: 40px; height: 40px; margin-right: 5px;">
							Abrir TronLink Movil
						</button>

						<!-- 
							<button id="btnOKX" class="btn btn-success" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir OKX</button>
						<button id="btnTokenPocket" class="btn btn-warning" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir TokenPocket</button>
						-->

					</div>

					<div class="col-md-12">
						<div class="alert alert-danger d-none" id="walleterror" role="alert">
							<strong>Algo inesperado ha ocurrido.</strong> Intente los siguientes pasos:
							<ul class="mt-2" style="list-style-type: disc; color: black;">
								<li>Compruebe que tiene instalada la aplicación <strong>TronLink</strong> en su navegador o móvil.</li>
								<li>Verifique que ha iniciado sesión en su billetera.</li>
								<li>Borre la caché de su navegador.</li>
								<li>Pruebe accediendo desde una ventana de incógnito.</li>
							</ul>
							<p class="mt-3"><strong>Si el problema persiste, póngase en contacto con nosotros.</strong></p>
						</div>
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
<script>
	function checkMinValue(input) {
    if (input.value < 1) {
        input.value = 1; // Ajusta el valor al mínimo permitido
    }
}
    // Deshabilitar los radio buttons si el usuario comienza a escribir en la caja de texto
    function disableRadios() {
      document.querySelectorAll('input[name="respuesta"]').forEach(radio => {
        radio.checked = false;  // Deselecciona los radio buttons
       // radio.disabled = true;  // Deshabilita los radio buttons
      });
    }

    // Habilitar los radio buttons y limpiar el campo de texto si el usuario selecciona un radio button
    function disableTextInput(enable) {
      const textInput = document.getElementById('opcionExtra');
      textInput.value = '';     // Limpia el campo de texto
      textInput.disabled = enable;  // Habilita o deshabilita el campo de texto según el parámetro
      document.querySelectorAll('input[name="respuesta"]').forEach(radio => {
        radio.disabled = false;  // Habilita todos los radio buttons
      });
    }
</script>

<script src="{{ asset('js/tron.js') }}"></script>
<script>

function obtenerValor() {
    let valorSeleccionado = $("input[name='respuesta']:checked").val();
    let valorExtra = $("#opcionExtra").val();

    if (valorExtra) {
        return valorExtra; // Si el usuario escribió un monto, usar ese
    } else if (valorSeleccionado) {
        return valorSeleccionado; // Si seleccionó un radio, usar ese
    }

    return null; // Si no se seleccionó nada
}

	function validador(action){

		const usersId = @json($userId);
		const id = @json($id);
		let valor=0;
		switch (action) {
			case "deposito":
			let monto = obtenerValor();
			if (monto) {
				valor=monto;
				
			} else {
				alert("Por favor, selecciona o ingresa un monto.");
			}
				break;
			case "ibox":
			valor=$("#valueibox").val();
			
				break;
			case "inversion":
			valor=$("#valueinversion").val();
			
				break;
		
			default:
				break;
		}
		payWithUSDT(valor,action,usersId,id);
	
	}

</script>
@endsection