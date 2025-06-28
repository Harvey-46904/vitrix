@extends('voyager::master') @section('page_title', 'Todo') @section('content')




<div class="page-content container-fluid">

  <div class="row">
    <div class="col-md-12 text-center">
      <h1> {{$sala->nombre_sala}}</h1>

    </div>
  </div>
  <div class="row py-5">
    @forelse ($apuestas as $apuesta)
    <div class="col-md-6">
      <div class="row">

        <div class="col-md-12"><b>Jugador</b> {{$apuesta->username}} </div>
      
        <div class="col-md-12"> dinero total apostado<h1 class="display-1">{{$apuesta->monto ?? 0}} USD</h1>
        </div>
        <div class="col-md-12"> dinero a pagar si gana<h1 class="display-1">{{$apuesta->total_ganancia ?? 0}} USD</h1>
        </div>


      </div>
    </div>
   
    @empty
    <p>No hay apuestas registradas para esta sala.</p>
    @endforelse

    @if ($apuestas->isNotEmpty())
         <div class="row text-center">
    <div class="col-md-12">
      <div class="border p-3">
        <i class="fas fa-money-check-alt fa-2x text-success"></i>
        <h5 class="mt-2">Dinero acumulado de esta sala</h5>
        <h4 class="mt-2">
          {{ ($apuestas[0]->monto ?? 0) + ($apuestas[1]->monto ?? 0) }} USD
        </h4>

      </div>
      <div class="border p-3">
        <i class="fas fa-money-check-alt fa-2x text-success"></i>
        <h5 class="mt-2">Conviene ganar</h5>
        <h4 class="mt-2">
          @if (($apuestas[0]->total_ganancia ?? 0) < ($apuestas[1]->total_ganancia ?? 0))
            {{ $apuestas[0]->username }}
            @else
              
            {{ $apuestas[1]->username ?? 'no jugador'}}
            @endif


        </h4>

      </div>
    </div>
  </div>
    @endif
  </div>






</div>
</div>

@endsection