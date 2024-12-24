<div class="col-md-4 text-center d-flex flex-column align-items-center text-light neon-shadow  bg-gris">
    <h2 class="gamers texturizado-primary">Puede ser tuyo el gran acumulado de</h2>
    <h1 class="gamers texturizado-warning">{{$eventos["Bote"]}} USDT</h1>
   
    <img src="{{ asset('vitrix/img/svg/nave.svg') }}" class="moving-svg" width="100" height="100">
</div>
<div class="col-md-7 text-center text-light neon-shadow bg-gris ">
    <h1 class="gamers texturizado-primary">Apresurate faltan</h1>
    <h1 class="gamers texturizado-warning">{{$eventos["evento"]->fecha_fin}}</h1>
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Jugador</th>
                <th scope="col">Tiempo</th>
                <th scope="col">Puntuación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventos["lista"] as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$item->user->name}}</td>
                <td>  <i class="fas fa-clock"></i>{{$item->tiempo}}</td>
                <td>  <i class="fas fa-star"></i>{{$item->puntuacion}}</td>
            </tr>
            @endforeach
            
    
        </tbody>
    </table>
</div>

