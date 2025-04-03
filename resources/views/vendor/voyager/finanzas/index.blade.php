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
            <h1>Cash Vitrix</h1>
            <div class="col-md-12 col-12">
                <div class="border p-3">
                  
                    <i class="fas fa-money-check-alt fa-2x text-success"></i>
                    <h5 class="mt-2">Dinero Total de usuarios</h5>
                    <h4 class="mt-2">Tenga en cuenta que este es el dinero total de balance de todos los usuarios sin importar el rango de fecha</h4>
                    <p class="font-weight-bold">  {{ $informacion_estadistica['balancetotal'] }} USDT</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="border p-3">
                  
                    <i class="fas fa-money-check-alt fa-2x text-success"></i>
                    <h5 class="mt-2">Ganancias</h5>
                    <p class="font-weight-bold">  {{ $informacion_estadistica['juegos']['ganancia_genius']->ganancia +$informacion_estadistica['juegos']['ganancia_nebula'] }} USDT</p>
                </div>
            </div>
            <!-- Salidas -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-money-check-alt fa-2x text-danger"></i>
                    <h5 class="mt-2">Apuestas</h5>
                    <p class="font-weight-bold">{{ $informacion_estadistica['juegos']['total_apostado']->total_apostado }} USD</p>
                </div>
            </div>
            <!-- Balance -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-money-check-alt fa-2x text-success"></i>
                    <h5 class="mt-2">Pagos Recibidos</h5>
                    <p class="font-weight-bold">{{array_sum($informacion_estadistica['pagos']['chartData']["data"] ) }} USDT</p>
                </div>
            </div>
            <!-- Transacciones -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                    <h5 class="mt-2">Retiros Solicitados</h5>
                    <p class="font-weight-bold">{{ $informacion_estadistica['retiros']['resumen']->total_monto }} USDT</p>
                </div>
            </div>
        </div>

        <h1>Jugadores</h1>
        <div class="row">
            
            <div class="col-md-12">
                <label> Estadísticas de jugadores nuevos</label>
                <canvas id="usuariosChart"></canvas>

            </div>
        </div>
        <h1>Ganancias juegos</h1>
        <div class="row  justify-content-center px-5">
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-hat-wizard fa-2x text-primary"></i>
                    <h5 class="mt-2">GENIUS</h5>
                    <p class="font-weight-bold">{{ $informacion_estadistica['juegos']['ganancia_genius']->ganancia }}
                        USDT</p>
                </div>
            </div>
          
            <!-- Salidas -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fab fa-avianex fa-2x text-danger"></i>
                    <h5 class="mt-2">NEBULA</h5>
                    <p class="font-weight-bold">{{ $informacion_estadistica['juegos']['ganancia_nebula'] }} USDT</p>
                </div>
            </div>
            <!-- Balance -->
            <div class="col-md-3 col-6">
                <div class="border p-3">
                    <i class="fas fa-car fa-2x text-success"></i>
                    <h5 class="mt-2">CARS</h5>
                    <p class="font-weight-bold">No disponible</p>
                </div>
            </div>


        </div>

        <div class="row">

            <div class="col-md-6">
                <h1>Inversión</h1>
                <label>inversión mas comprada</label>
                <ul class="list-group">
                    <li class="list-group-item">
                        {{ $informacion_estadistica['inversiones']['maxpaquete']->paquete_nombre }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">

                <canvas id="miGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    @foreach ( $informacion_estadistica['inversiones']['paquetes_comprados'] as $item)
                        <li class="list-group-item"> <b>Paquete:</b> {{$item->nombre}} <b>Cantidad comprada de este paquete por usuarios:</b> {{$item->cantidad}} <b>Estas compras recolectaron un total de </b> {{$item->recolectado}} USDT para ser trabajados</li>
                    @endforeach
                    
                  </ul>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-12">
                <h1>Entrada de pagos</h1>
                <div class="row  justify-content-center px-5">
                    <div class="col-md-6"> <canvas id="miGraficoDona"></canvas></div>
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Depositos -->
                            <div class="col-md-12 col-12">
                                <div class="border p-3">
                                    <i class="fas fa-sign-in-alt fa-2x text-primary"></i>
                                    <h5 class="mt-2">Depositos</h5>
                                    <p class="font-weight-bold">
                                        Total de transacciones {{ $informacion_estadistica["pagos"]['pagos_agrupado'][0]->total_transacciones ?? 0 }}
                                    </p>
                                </div>
                            </div>
                            <!-- Ibox -->
                            <div class="col-md-12 col-12">
                                <div class="border p-3">
                                    <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                                    <h5 class="mt-2">Ibox</h5>
                                    <p class="font-weight-bold">
                                        Total de transacciones {{ $informacion_estadistica["pagos"]['pagos_agrupado'][1]->total_transacciones ?? 0 }}
                                    </p>
                                </div>
                            </div>
                            <!-- Inversiones -->
                            <div class="col-md-12 col-12">
                                <div class="border p-3">
                                    <i class="fas fa-balance-scale fa-2x text-success"></i>
                                    <h5 class="mt-2">Inversiones</h5>
                                    <p class="font-weight-bold">
                                        Total de transacciones {{ $informacion_estadistica["pagos"]['pagos_agrupado'][2]->total_transacciones ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>


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
                        @foreach ($informacion_estadistica['pagos']['pagos'] as $pago)
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
        <h1>Retiros</h1>
        <div class="row">
            <div class="col-md-6">
                <label>Total de retiros</label>
                <h3> {{ $informacion_estadistica['retiros']['resumen']->total_retiros }}</h3>
            </div>
            <div class="col-md-6">
                <label>Monto de retiros</label>
                <h3> {{ $informacion_estadistica['retiros']['resumen']->total_monto }} USDT</h3>
            </div>
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th scope="col">Wallet</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($informacion_estadistica['retiros']['listaRetiros'] as $pago)
                        <tr>
                            <td>{{$pago->billetera}}</td>
                            <td>{{$pago->monto}} USDT</td>
                            <td>{{$pago->estado}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>Intentos de fraudes</h3>
            </div>
            <div class="col-md-6">

                <h3> {{ $informacion_estadistica['fraudes']['valor']->total_fraudes }}</h3>
            </div>
        </div>
    </div>
    @else
    <h1>Consulte un rango de fecha para poder visualizar la información</h1>
    @endif


</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if ($estadistica)
<script>
    var chartData = @json($informacion_estadistica['inversiones']['chartData']);
    var chartDatadona = @json($informacion_estadistica['pagos']['chartData']);
    var chartDataline = @json($informacion_estadistica['usuarios']['chatusers']);
</script>
<script>
    const ctx = document.getElementById('miGrafico').getContext('2d');

    const miGrafico = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (puedes usar 'line', 'pie', etc.)
        data: {
            labels: chartData.labels, // Etiquetas
            datasets: [{
                label: 'Paquetes comprados por usuarios',
                data: chartData.data, // Datos de cada mes
                backgroundColor: 'rgba(86,71,135,0.7)', // Color de las barras
                borderColor: 'rgba(75, 192, 192, 1)', // Color del borde
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    const ctx1 = document.getElementById('miGraficoDona').getContext('2d');

    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: chartDatadona.labels, // Etiquetas dinámicas
            datasets: [{
                label: 'Entrada USDT',
                data: chartDatadona.data, // Valores dinámicos
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

<script>
const ctx2 = document.getElementById('usuariosChart').getContext('2d');

    const usuariosChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: chartDataline.labels, // Fechas
            datasets: [{
                label: 'Usuarios Nuevos por Día',
                data:chartDataline.data, // Cantidad de usuarios
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3 // Suaviza las líneas
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Fecha' } },
                y: { title: { display: true, text: 'Usuarios Nuevos' }, beginAtZero: true }
            }
        }
    });
</script>
@endif
   
@endsection