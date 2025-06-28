@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
	<div class="container text-light  ">
		<div class="row justify-content-center my-5 ">

			<div class="col-md-6 neon-shadow">
				<div class="row">
					<div class="col-md-12 bg-fondo-azul">
						<h1 class="display-4 text-light">{{ __('general.deposito.option1') }}</h1>
					</div>
				</div>
				<div class="row my-3 py-3">
					<div class="col-md-2 text-center col-3"> <img src="{{asset('vitrix/img/usdt.png') }}"
							class="icono not-prose" alt="...">
					</div>
					<div class="col-md-10 d-flex align-items-center col-9">
						<img src="{{ asset('vitrix/img/Polygon.png') }}" class="not-prose icono me-2" alt="...">
						<span>{{ __('general.deposito.option2') }}<b>{{ __('general.deposito.option3') }}</b></span>
					</div>
				</div>
				<div class="row bg-rosa-transparente py-2 mx-2">
					<div class="col-md-2  col-3"><img src="{{asset('vitrix/img/regalo.png') }}" class="icono not-prose"
							alt="..."></div>
					<div class="col-md-10 align-self-center col-9 "> {{ __('general.deposito.option4') }}</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-end ">{{ __('general.deposito.option5') }}<b class="text-danger" id="status"> {{ __('general.deposito.option6') }}</b></div>
					<div class="col-md-12">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">{{ __('general.deposito.option7') }}</span>
							</div>
							<input type="text" class="form-control" placeholder="Username" aria-label="Username"
								aria-describedby="basic-addon1" disabled value="{{$user->name}}">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">{{ __('general.deposito.option8') }}</span>
							</div>
							<input type="text" id="walletAddress" class="form-control" placeholder="Username"
								aria-label="Username" aria-describedby="basic-addon1" disabled
								value="{{ __('general.deposito.option14') }}">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">{{ __('general.deposito.option9') }}</span>
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
						<p class="text-rosa"> {{ __('general.deposito.option10') }}</p>
						<h4 class="text-light">{{ __('general.deposito.option11') }}</h4>

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
							<label for="opcionExtra">{{ __('general.deposito.option12') }}</label>
							<input type="number" class="form-control" id="opcionExtra" name="respuesta_extra"
								placeholder="Digita tu monto" min="1" oninput="disableRadios(); checkMinValue(this)">
						</div>

						<!-- Botón de enviar -->
						<button onclick="validador('{{$action}}')" type="submit" class="btn btn-primary">{{ __('general.deposito.option13') }}</button>



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
						<div class="alert alert-danger d-none" id="alertaerror" role="alert">
							text
						</div>
						<div class="alert alert-success d-none" id="alertacorrecto" role="alert">
							text
						</div>
						<div class="alert alert-warning text-break d-none" id="esperaconfirmacion" role="alert">
							Validando su transacción en la blockchain. Por favor, no cierre ni recargue la ventana hasta
							que el proceso se complete.
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
									id="progress-bar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
									style="width: 100%"></div>
							</div>
							<p>Tiempo máximo <span id="countdown">3:00</span></p>
						</div>
						<div class="alert alert-success text-break d-none " id="hashid" role="alert">
							text
						</div>

						<div class="alert alert-primary d-none" id="actionfinal" role="alert">
							text
						</div>

					</div>

				</div>
				<div class="row text-center">
					<div class="col-md-12 text-center d-none" id="computador">
						<div class="row  align-items-center" id="contend_meta_pc">
							<div class="col-md-2 col-2">
								<img src="https://1000logos.net/wp-content/uploads/2022/05/MetaMask-Symbol-1536x864.png"
									alt="TronLink" style="width: 200px;">
							</div>
							<div class="col-md-10 col-10">
								<button id="Metamaskbutton" class="btn btn-outline-light btn-lg btn-block ">
							{{ __('general.deposito.option15') }}
									
								</button>
							</div>
						</div>

					</div>

					<div class="col-md-12 d-none text-center " id="celular">
						<div class="row  align-items-center" id="contend_meta_pc">
							<div class="col-md-2 col-2">
								<img src="https://1000logos.net/wp-content/uploads/2022/05/MetaMask-Symbol-1536x864.png"
									alt="TronLink" style="width: 200px;">
							</div>
							<div class="col-md-10 col-10">
								<button id="btnMetamaskMobile" class="btn btn-outline-light btn-lg btn-block "
									data-user="{{$hash}}" data-action="{{$action}}" data-id="{{$id}}">
						{{ __('general.deposito.option16') }}
									
								</button>
							</div>
						</div>
						

						<!-- 
							<button id="btnOKX" class="btn btn-success" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir OKX</button>
						<button id="btnTokenPocket" class="btn btn-warning" data-user="xyz" data-action="{{$action}}" data-id="{{$id}}">Abrir TokenPocket</button>
						-->

					</div>

					<div class="col-md-12">
						<div class="alert alert-danger d-none" id="walleterror" role="alert">
							<strong>{{ __('general.deposito.error.option1') }}</strong> {{ __('general.deposito.error.option2') }}
							<ul class="mt-2" style="list-style-type: disc; color: black;">
								<li>{{ __('general.deposito.error.option3') }}<strong>metamask</strong> {{ __('general.deposito.error.option4') }}</li>
								<li>{{ __('general.deposito.error.option5') }}</li>
								<li>{{ __('general.deposito.error.option6') }}</li>
								<li>{{ __('general.deposito.error.option7') }}</li>
							</ul>
							<p class="mt-3"><strong>{{ __('general.deposito.error.option8') }}</strong>
							</p>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-12">{{ __('general.deposito.option17') }}</div>
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

<script src="{{ asset('js/polygon.js') }}"></script>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function () {
        $("#Metamaskbutton").click(async function () {
			
            await obtenerBilletera(); // Esperar a que termine antes de continuar
        });
    });
</script>
@endsection