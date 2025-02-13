<div class="col-md-4 text-center d-flex flex-column align-items-center text-light neon-shadow  l">
    <h2 class="gamers texturizado-primary">Puede ser tuyo el gran acumulado de</h2>
    <h1 class="gamers texturizado-warning">{{$eventos["Bote"]}} USDT</h1>

    <img src="{{ asset('vitrix/img/svg/nave.svg') }}" class="moving-svg" width="100" height="100">
</div>
<div class="col-md-7  text-light neon-shadow  ">
    <div class="row text-center  justify-content-center pt-3">
       
        <div class="col-md-8"><img src="{{ asset('vitrix/img/cabeza.png') }}" width="100%" height="100%" class=""></div>
        
    </div>
    
    <div class="row  justify-content-center py-2 ">
        <div class="col-md-5 bg-blue d-flex align-items-center rounded text-center">
            <img src="{{ asset('vitrix/img/relogs.png') }}" width="60" height="60" class="me-2">
            <h1 class="gamers texturizado-warning mb-0">{{ $eventos["evento"]->fecha_fin }}</h1>
        </div>

    </div>

    <div class="neon-border"></div>
    <table class="table table-dark neon-table">
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
                <td> <i class="fas fa-clock"></i>{{$item->tiempo}}</td>
                <td> <i class="fas fa-star"></i>{{$item->puntuacion}}</td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>