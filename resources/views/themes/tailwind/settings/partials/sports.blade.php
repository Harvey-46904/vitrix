<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12 text-center  py-3">
            <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
                E-Sport</h1>

            <p class="text-white invisible mt-0 text-base text-center text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl"
                data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>

                {{ __('general.sport.option1') }}  <b class='text-warning'>{{ __('general.sport.option2') }}</b> {{ __('general.sport.option3') }}<b class='text-warning'> {{ __('general.sport.option4') }}</b>.
            
            </p>

        </div>
    </div>
    <div class="row justify-content-center text-light ">
        <div class="col-md-4">
            <h5 class="card-title gamers texturizado-warning">{{ __('general.sport.option5') }}</h5>
            <table class="table table-dark neon-table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('general.sport.option6') }} </th>
                        <th scope="col">{{ __('general.sport.option7') }} </th>
                        <th scope="col">{{ __('general.sport.option8') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $salasConJugador as $item)
                    <tr>
                        <th scope="row">{{$item->nombre_sala}}</th>
                        <td>{{$item->fecha_juego}}</td>
                        <td>
                            <a class="btn btn-success d-none" data-fecha="{{$item->fecha_juego}}"
                                id="btn-evento-{{$item->id}}" onclick="loadgame('{{$item->id}}')">
                                {{ __('general.sport.option9') }} 
                            </a>
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <div class="col-md-8 text-center">
            <h5 class="card-title gamers texturizado-warning">{{ __('general.sport.option10') }} </h5>

            <div class="row  ">

                @foreach ($salasSinJugador as $sala)
                <div class="col-md-5 p-4 neon-shadow col-5 mx-1">
                    <div class="row ">
                        <div class="col-md-12  text-center">
                            <h6 class="card-title gamers texturizado-warning">{{$sala->nombre_sala}}</h6>

                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 texturizado-warning text-center">
                            {{$sala->fecha_juego}}
                        </div>
                    </div>
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-4 circular-image text-center"></div>
                        <div class="col-md-8 pl-2">
                            <div class="row bg-rosa  text-center p-2">
                                <h4>{{$sala->player_one_name}} </h4>

                            </div>
                            <div class="row bg-rosasi text-center p-2">
                                <h4>{{$sala->player_two_name}} </h4>

                            </div>
                        </div>
                    </div>
                    <div class="row   py-3 mt-3">
                        <div class="col-md-12  text-center">

                            @if ($sala->estado=="option5")

                            <a href="{{ route('sala.detalle', ['id' => $sala->id]) }}" class="btn btn-success"
                                style="color: yellow;">
                                {{ __('general.sport.option11') }} 
                            </a>
                            @else

                            <a href="{{ route('sala.detalle', ['id' => $sala->id]) }}" class="btn btn-warning"
                                style="color: black;">
                               {{ __('general.sport.option12') }}  
                            </a>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach




            </div>
        </div>

    </div>

</div>
<script>
    function verificarFechasEventos() {
        const botones = document.querySelectorAll('a[data-fecha]');
        const ahora = new Date();

        botones.forEach(btn => {
            const fechaEvento = new Date(btn.dataset.fecha);
            if (ahora >= fechaEvento) {
                btn.classList.remove('d-none');
            } else {
                btn.classList.add('d-none');
            }
        });
    }

    // Llamar al inicio
    verificarFechasEventos();

    // Repetir cada 10 segundos por si la fecha cambia mientras está en la página
    setInterval(verificarFechasEventos, 10000);
</script>
<script>
    function loadgame(uid){
       
       let serial="cars"

        const width = 965; // Ancho de la ventana
        const height = 610; // Alto de la ventana
        const left = (screen.width - width) / 2; // Centrado horizontal
        const top = (screen.height - height) / 2; // Centrado vertical

        // Abrir la ventana emergente
        const routeName = serial; // Aquí puedes usar cualquier lógica para obtener este nombre dinámicamente.
        const url = `{{ url('/') }}/${routeName}/${uid}`;

        window.open(
            url, // URL completa
            "UnityGame", // Nombre de la ventana
            `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=no`
        );
       
    }
    document.getElementById('openGame').addEventListener('click', function () {
    // Obtener el ancho y alto de la pantalla del usuario
    const screenWidth = window.screen.availWidth;
    const screenHeight = window.screen.availHeight;

    // Definir el ancho y alto de la ventana emergente
    const width = Math.min(960, screenWidth);  // Máximo 960 o el tamaño de la pantalla
    const height = Math.min(650, screenHeight); // Máximo 650 o el tamaño de la pantalla

    // Calcular posición para centrar la ventana
    const left = (screenWidth - width) / 2;
    const top = (screenHeight - height) / 2;

    // Abrir la ventana emergente sin scroll y con tamaño adecuado
    const popup = window.open(
        "{{ route('unity-game') }}", // URL de la vista del juego
        "UnityGame", // Nombre de la ventana
        `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=no`
    );

    // Intentar maximizar la ventana (algunos navegadores pueden bloquear esto)
    if (popup) {
        popup.moveTo(0, 0);
        popup.resizeTo(screenWidth, screenHeight);
    }
});
</script>