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
						juego que hagas</div>
				</div>
				<div class="row">
					<div class="col-md-12 d-none" id="computador">
						<button id="tronlinkButton" class="btn btn-primary">Abrir TronLink</button>
					</div>
					
					<div class="col-md-12 d-none" id="celular">
						<button id="btnTronLink" class="btn btn-primary">Abrir TronLink</button>
						<button id="btnOKX" class="btn btn-success">Abrir OKX</button>
						<button id="btnTokenPocket" class="btn btn-warning">Abrir TokenPocket</button>
					</div>
					<div class="col-md-12">
						<button onclick="connectWallet()">Conectar Billetera TRON</button>
						<p id="walletAddress"></p>
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