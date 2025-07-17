<div class="container">
	<div class="row ">
		<div class="col-md-12 text-center  py-3">
			<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
				IBOX</h1>

			<p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

				{{ __('general.ibox.option1') }}<b class='text-warning'>{{ __('general.ibox.option2') }}</b>{{ __('general.ibox.option3') }}<b class='text-warning'>{{ __('general.ibox.option4') }}</b>{{ __('general.ibox.option5') }}</p>

		</div>
	</div>
	<div class="row justify-content-center text-light ">
		@foreach ($iboxes as $ibox)
		<div class="col-md-3 neon-purple  p-3 mx-2 my-2"     
		style="background-image: url('{{ Voyager::image($ibox->fondo)   }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
			<div class="row">
				<div class="col-md-12 ">
					{{$ibox->nombre}}<br>
					<b>{{$ibox->descripcion}}</b>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h1 class="gamers texturizado-warning">${{$ibox->beneficio}} </h1>
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-3">
					
					<a  
					data-balances={{route('cashbalanceIboxBalance', ['id' => $ibox->id]) }}
					data-url="{{ route('payforms', ['action' => 'deposito', 'hash' => encrypt(Auth::id())]) }}"
					data-efectivo="{{ auth()->user()->balance_general->balance ?? 0 }}"
					data-precio="{{ $ibox->precio_compra }}"
					data-id="{{$ibox->id}}"
					
					class="btn my-1 bg-azul-secundario compra_validacion"> {{ __('general.ibox.option6') }}<b class="text-warning">{{$ibox->precio_compra}} USD</b> </a>
				</div>
			</div>
		</div>
		@endforeach

	</div>

	<script>
    window.trans = {
        realizar_compra: "{{ __('general.compras.option1') }}",
        saldo_insuficiente: "{{ __('general.compras.option3') }}",
        saldo_disponible: "{{ __('general.compras.option2') }}",
        no_saldo: "{{ __('general.compras.option4') }}",
		cancelar: "{{ __('general.compras.cancelar') }}",
		comprar: "{{ __('general.compras.comprar') }}",
		proceso: "{{ __('general.compras.option5') }}",
		espera: "{{ __('general.compras.option6') }}"

    };
</script>
</div>
