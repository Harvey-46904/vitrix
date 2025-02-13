<div class="container">
    <div class="row ">
		<div class="col-md-12 text-center  py-3">
			<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
				REFERIDOS</h1>

			<p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

				"En Vitrix, tus <b class='text-warning'>referidos</b> cuentan. Por cada persona que se registre con tu link unico,
				recibirás una <b class='text-warning'>recompensa</b>. Y no solo por referirlo a partir de ahora todo juego en el que ellos interactuen se vera reflejado en tu saldo bono."</p>

		</div>
	</div>
    <div class="row  justify-content-center">
        <div class="col-md-2 text-center col-7">
            <img id="preview" src="{{ Voyager::image(auth()->user()->avatar) . '?' . time() }}"
                class="w-32 h-32 rounded-full ">
            <h2 class="text-light">{{auth()->user()->name}}</h2>

        </div>
        
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($totales_referidos>0)
            <h3 class="text-light">Actualmente cuenta con <b> {{$totales_referidos}} </b> miembros en total , a continuación mostramos a sus referidos directos</h3>
            @else
            <h3 class="text-light">Actualmente no cuenta con referidos , puede invitar a personas y obtener recompenzas</h3>
            @endif
          
            </h3>
        </div>
    </div>
    <div class="row  justify-content-start">

        <div class="col-md-3">
            <!-- Cambiado a col-md-12 para usar todo el ancho -->


            <div class="btn-group" role="group" aria-label="Basic example">
                @foreach ($arbol as $ab)
                <button type="button" class="btn  text-light">
                    <li class="list-group-item text-center"
                        style="flex: 1 0 30%; margin: 5px; background-color: #00000000;">
                        <!-- Añadido estilo flex -->
                        <div style="position: relative; display: inline-block;">
                            <img id="preview" src="{{ Voyager::image('wave/marco.png') }}" class="w-32 h-32">
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <h2 class="text-light">{{$ab->id}}</h2>
                            </span>
                        </div>
                        <hr>
                        <h2 class="text-light">{{$ab->name}}</h2>
                    </li>

                </button>


                @endforeach
                </ul>
            </div>
        </div>
    </div>