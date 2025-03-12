@extends('voyager::master') @section('page_title', 'Todo') @section('content')




<div class="page-content container-fluid">


    Configuración de feeds retiros
    @if (session('success'))
    <div class="alert alert-success" role="alert">
       Feed de retiro configurada correctamente
       </div>
    @endif
    <div class="row  justify-content-end">
        <div class="col-md-12">
            <form action="{{route('feedsconfiguracion')}}" method="POST" >
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Feed Retiro en porcentaje</label>
                  <input type="number" class="form-control" value="{{$valor}}" placeholder="feed" name="feed">
                 
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
        </div>
    </div>
</div>
</div>

@endsection