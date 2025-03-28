@extends('voyager::master') @section('page_title', 'Todo') @section('content')

<style>
    /* Clases de Bootstrap 4 */

    /* Estructura de filas */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    /* Clases de columnas generales */
    .col {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }

    /* Clases de columnas responsivas */
    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    /* Contenedor fluido */
    .container-fluid {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    /* Bordes */
    .border {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background-color: #fff;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* Espaciado interno */
    .p-3 {
        padding: 1rem !important;
    }

    /* Margen superior */
    .mt-2 {
        margin-top: 0.5rem !important;
    }

    /* Negrita */
    .font-weight-bold {
        font-weight: 700 !important;
    }

    /* Colores de texto */
    .text-primary {
        color: #007bff !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }
</style>

<div class="page-content container-fluid">

    <h1>Finanzas</h1>
    <form action="" method="GET" class="form-inline">
        <div class="form-group mb-2">
            <label for="start_date" class="mr-2">Desde:</label>
            <input type="date" class="form-control" id="start_date" name="start_date"
                value="{{ request('start_date') }}">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="end_date" class="mr-2">Hasta:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
        </div>

        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

    </form>
    @if ($estadistica)
    <div class="container">
        <div class="row  justify-content-center px-5">
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-sign-in-alt fa-2x text-primary"></i>
                    <h5 class="mt-2">Ingresos</h5>
                    <p class="font-weight-bold">$10,000</p>
                </div>
            </div>
            <!-- Salidas -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                    <h5 class="mt-2">Apuestas</h5>
                    <p class="font-weight-bold">$5,000</p>
                </div>
            </div>
            <!-- Balance -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-balance-scale fa-2x text-success"></i>
                    <h5 class="mt-2">Pagos</h5>
                    <p class="font-weight-bold">$5,000</p>
                </div>
            </div>
            <!-- Transacciones -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                    <h5 class="mt-2">Saldo</h5>
                    <p class="font-weight-bold">45</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h1>IBOX</h1>
                <label>Ibox mas comprado</label>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h1>INVERSION</h1>
                <label>inversión mas comprada</label>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Estadísticas de Jugadores</label>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
            <div class="col-md-6">
                <label> Estadísticas de Juegos</label>
    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Transacciones & Finanzas</label>
    
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Razón</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Hash</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr>
                                <th scope="row">{{$pago->reason}}</th>
                                <td>{{$pago->amount}}</td>
                                <td>{{$pago->transaction_hash}}</td>
                                <td>{{$pago->created_at}}</td>
                            </tr>
                        
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Alertas y Seguridad</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <h1>Consulte un rango de fecha para poder visualizar la información</h1>
    @endif
  
    
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection