@extends('voyager::master') @section('page_title', 'Todo') @section('content')




<div class="page-content container-fluid">

  <div class="row">
    <div class="col-md-12 text-center">
      <h1> {{$sala[0]->nombre_sala}}</h1>

    </div>
  </div>

  <div class="row py-5">
    <div class="col-md-6">
        <div class="row">
          
            <div class="col-md-12"><b>Jugador</b> {{$sala[0]->jugador}} </div>
            <div class="col-md-12"><b>Cuota</b> {{$sala[0]->cuota_player_one}} </div>
            <div class="col-md-12"> dinero total apostado<h1 class="display-1">{{$sala[0]->monto ?? 0}} USD</h1></div>
            <div class="col-md-12"> dinero a pagar si gana<h1 class="display-1">{{$sala[0]->total_ganancia ?? 0}} USD</h1></div>
        
           
        </div>
    </div>
    <div class="col-md-6">
      <div class="row">
                
                <div class="col-md-12"><b>Jugador</b> {{$sala[1]->jugador}} </div>
                <div class="col-md-12"><b>Cuota</b> {{$sala[1]->cuota_player_two}} </div>
                <div class="col-md-12"> dinero total apostado<h1 class="display-1">{{$sala[1]->monto ?? 0}} USD</h1></div>
                <div class="col-md-12"> dinero a pagar si gana<h1 class="display-1">{{$sala[1]->total_ganancia ?? 0}} USD</h1></div>
   
         
      </div>
  </div>
  </div>
  <div class="row text-center">
    <div class="col-md-12">
        <div class="border p-3">
            <i class="fas fa-money-check-alt fa-2x text-success"></i>
            <h5 class="mt-2">Dinero acumulado de esta sala</h5>
            <h4 class="mt-2">
              {{ ($sala[0]->monto ?? 0) + ($sala[1]->monto ?? 0) }} USD
          </h4>
          
        </div>
        <div class="border p-3">
            <i class="fas fa-money-check-alt fa-2x text-success"></i>
            <h5 class="mt-2">Conviene ganar</h5>
            <h4 class="mt-2">
              @if (($sala[0]->total_ganancia ?? 0) < ($sala[1]->total_ganancia ?? 0))
              {{ $sala[0]->player_one_name ?? '' }}
          @else
              {{ $sala[0]->player_two_name ?? '' }}
          @endif
            

            </h4>
          
        </div>
    </div>
  </div>
</div>
</div>

@endsection