<div class="container">
    <div class="row ">
        <div class="col-md-12 text-center  py-3">
            <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
               {{ __('general.referidos.option1') }}</h1>

            <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center  sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

               {{ __('general.referidos.option2') }}<b class='text-warning'> {{ __('general.referidos.option3') }}</b> {{ __('general.referidos.option4') }}
               <b class='text-warning'>{{ __('general.referidos.option5') }}</b>{{ __('general.referidos.option6') }}</p>

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
            <h3 class="text-light">{{ __('general.referidos.option7') }}<b> {{$totales_referidos}} </b> {{ __('general.referidos.option8') }}</h3>
            @else
            <h3 class="text-light">{{ __('general.referidos.option9') }}
            </h3>
            @endif

            </h3>
        </div>
    </div>
   
    <div class="row  justify-content-start">
        @foreach ($arbol as $ab)
        <div class="col-md-2 col-6">
            <div class="btn-group" role="group" aria-label="Basic example">
                    <li class="list-group-item text-center"
                        style=" background-color: #00000000;">
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
            </div>
        </div> @endforeach
    </div>