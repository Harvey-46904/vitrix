@extends('voyager::master') @section('page_title', 'Todo') @section('content')




<div class="page-content container-fluid">


    Configuración de bonos
    @if (session('success'))
    <div class="alert alert-success" role="alert">
       Dinero bono depositado correctamente
       </div>
    @endif
    <div class="row  justify-content-end">
        <div class="col-md-12">
            <form action="{{route('cashbalanceBono')}}" method="POST" >
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">ID Usuario</label>
                  <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Usuario ID" name="id_user">
                  <small id="emailHelp" class="form-text text-muted">id de usuario al que se le enviara dinero bono</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Monto (USDT)</label>
                  <input type="number" class="form-control" id="exampleInputPassword1" placeholder="monto de recarga" name="monto">
                </div>

                <button type="submit" class="btn btn-primary">Recargar</button>
              </form>
        </div>
    </div>
</div>
</div>

@endsection