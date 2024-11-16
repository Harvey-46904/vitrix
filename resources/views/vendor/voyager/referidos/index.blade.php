@extends('voyager::master') @section('page_title', 'Todo') @section('content')

<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 50px;
    }

    .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .circle {
        width: 50px;
        height: 50px;
        background-color: #7d1192;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
        margin: 10px 0;
    }
    .circle_user {
        width: 50px;
        height: 50px;
        background-color: #3498db;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
        margin: 10px 0;
    }

    .line {
        width: 2px;
        height: 50px;
        background-color: #ccc;
        position: relative;
    }

    .line span {
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background-color: #fff;
        padding: 2px 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        white-space: nowrap;
        margin-left: 10px;
    }
</style>


<div class="page-content container-fluid">

  
    Configuración de referidos
   
    <div class="row  justify-content-end">
        <div class="col-md-6 col-12 text-center ">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Número de niveles</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$configuracion_referidos["nivel"]}}</h6>
                    <p class="card-text">Necesarios para uso de la jerarquia en nivel de referidos</p>
                  
                    <a class="btn btn-success" href="{{ route('EditNiveles', ['parametros' => $configuracion_referidos]) }}">Editar niveles y porcentajes</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12 text-center border border-success">

            <div class="container">
                <div class="item">
                    <div class="circle_user">User</div>
                   
                </div>
              
                @for ($i = 0; $i < $configuracion_referidos["nivel"]; $i++)
                <div class="item">
                    <div class="line">
                        <span>{{$configuracion_referidos["parametros"][$i]}} %</span>
                    </div>
                    <div class="circle">{{$i+1}}</div>
                   
                </div> 
            @endfor
                
               
            </div>
        </div>
    </div>
</div>

@endsection