@extends('voyager::master') @section('page_title', 'Todo') @section('content')


<div class="page-content container-fluid">
    Configuración de rentabilidades

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        Nuevos Valores de rentabilidad modificados correctamente
       </div>
    @endif
    
    <div class="row  justify-center items-center">
        <div class="col-md-6 col-12 text-center ">
            
            <form action="{{route('UpdateRentabilidad',['id'=>$id])}}" method="POST" class="p-4">
                @csrf
                <div class="mb-3">
                    <h5>Rentabilidad por  <span id="nivelLabel"></span> dia </h5>
                </div>
            
                <div id="inputsContainer">
                    @for ($i = 0; $i < count($numeros) ; $i++)
                        <div class="mb-3">
                            <label for="input{{ $i }}" class="form-label">Dia {{ $i + 1 }}</label>
                            <input type="text" class="form-control" id="input{{ $i }}" name="parametros[]" value="{{ $numeros[$i] ?? 0 }}">
                        </div>
                    @endfor
                </div>
            
               
            
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            
         
        </div>
       
    </div>
</div>

@endsection