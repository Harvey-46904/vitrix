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


    Configuración de bonos
    @if (session('success'))
    <div class="alert alert-success" role="alert">
       Dinero bono depositado correctamente
       </div>
    @endif
    <div class="row  justify-content-center px-5">
        <div class="col-md-3 col-6">
            <div class="border p-3">
                <i class="fas fa-sign-in-alt fa-2x text-primary"></i>
                <h5 class="mt-2">Entradas</h5>
                <p class="font-weight-bold">$10,000</p>
            </div>
        </div>
        <!-- Salidas -->
        <div class="col-md-3 col-6">
            <div class="border p-3">
                <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                <h5 class="mt-2">Salidas</h5>
                <p class="font-weight-bold">$5,000</p>
            </div>
        </div>
        <!-- Balance -->
        <div class="col-md-3 col-6">
            <div class="border p-3">
                <i class="fas fa-balance-scale fa-2x text-success"></i>
                <h5 class="mt-2">Balance</h5>
                <p class="font-weight-bold">$5,000</p>
            </div>
        </div>
        <!-- Transacciones -->
        <div class="col-md-3 col-6">
            <div class="border p-3">
                <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                <h5 class="mt-2">Transacciones</h5>
                <p class="font-weight-bold">45</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Transacciones</label>
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
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection