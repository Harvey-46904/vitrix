<div class="container">
    <div class="row  justify-content-center">
        <div class="col-md-2 text-center col-7">
            <img id="preview" src="{{ Voyager::image(auth()->user()->avatar) . '?' . time() }}"
                class="w-32 h-32 rounded-full ">
            <h2 class="text-light">{{auth()->user()->name}}</h2>

        </div>
        
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="text-light">Actualmente cuenta con <b> {{$totales_referidos}} </b> miembros en total , a continuación mostramos a sus referidos directos
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