@extends('theme::layouts.app')

@section('content')

<div class="pt-20 mx-auto prose text-center max-w-7xl">
	<div class="container text-light ">
		<div class="row justify-content-center my-5 ">
			
			<div class="col-md-6 neon-shadow bg-gris">
				<div class="row">
					<div class="col-md-12 bg-fondo-azul"><h1 class="display-4 text-light">{{$paquete->nombre}}</h1></div>
				</div>
				<div class="row my-3 py-3">
					<div class="col-md-2 text-center col-3"> <img src="{{asset('vitrix/img/usdt.png') }}" class="icono not-prose" alt="...">
					</div>
					<div class="col-md-10 d-flex align-items-center col-9">
						<img src="{{ asset('vitrix/img/tron.png') }}" class="not-prose icono me-2" alt="...">
						<span>Trabajamos en la blockchain de Polygon, por lo tanto la red de <b>USDT es TRC20</b></span>
					</div>
				</div>
				<div class="row bg-rosa-transparente py-2 mx-2">
					<div class="col-md-2  col-3"><img src="{{asset('vitrix/img/regalo.png') }}" class="icono not-prose" alt="..."></div>
					<div class="col-md-10 align-self-center col-9 "> En Vitrix todo deposito cuenta y esto ayuda a tus aliados en el sistema</div>
				</div>
				<div class="row">
					<div class="col-md-6 text-center col-12">
						<img src="{{asset('vitrix/img/qrexample.png') }}" class="img-fluid  " alt="...">
					</div>
					<div class="col-md-6">
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
								<input class="form-check-input" type="radio" name="respuesta" id="opcion1" value="{{$paquete->precio_base}}" onclick="disableTextInput(false)" checked>
							  <label class="form-check-label" for="opcion1">
								{{$paquete->precio_base}} USDT
							  </label>
							</div>
					  
							
					  
							<!-- Botón de enviar -->
							<button type="submit" class="btn btn-primary mt-4">Pagar</button>
						  </form>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-justify">Envía únicamente USDT a esta dirección de contrato. su dinero se
						depositarán automáticamente después de 6 confirmaciones de red. Las direcciones de contratos
						inteligentes no son compatibles (contáctanos).
						</div>
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
@endsection