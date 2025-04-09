@extends('voyager::master') @section('page_title', 'Todo') @section('content')


@can('browse_pagares')
    <h1>puede</h1>
@endcan

<div class="page-content container-fluid">

    @php
    $totalMonto = 0;
    @endphp

Gestión de pagos
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        Dinero bono depositado correctamente
    </div>
    @endif
    <div class="row  justify-content-end">
        <div class="col-md-4">
            <form method="GET" action="{{ url()->current() }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="limite" class="mr-2">Límite de consulta:</label>
                    <input type="number" name="limite" id="limite" class="form-control" value="{{ $limiteValor }}">
                </div>
                <button type="submit" class="btn btn-primary">Aplicar</button>
            </form>
        </div>
        @if ($limite)
        <div class="col-md-12">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id transaccion</th>
                        <th scope="col">Billetera</th>
                        <th scope="col">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                    @php
                    $totalMonto += $pago->monto;
                    @endphp
                    <tr>
                        <td>{{ $pago->id }}</td>
                        <td>{{ $pago->billetera }}</td>
                        <td>{{ number_format($pago->monto, 2) }} USDT</td>
                    </tr>
                    @endforeach
                    <tr class="font-weight-bold">
                        <td>Total</td>
                        <td class="totalMonto">{{ number_format($totalMonto, 2) }} USDT</td>
                    </tr>
                </tbody>
            </table>
            <div class="alert alert-warning d-none" id="informacion" role="alert">
                Primero inicie la comprobación de fondos
              </div>
  
            <button id="btnGetBalance" class="btn btn-success">Ver Balance de contrato USDT</button>
            <p id="usdtBalance"></p>
           
            <button id="btnPagar" class="btn btn-primary d-none" style="display: none">Pagar</button>
            <div id="resultado"></div>
        </div>
        @endif

        
    </div>
</div>
</div>
<script src="{{ asset('js/tron.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let totalMonto;
    $(document).ready(function () {
      
    $("#btnGetBalance").click(function(){
        getUSDTBalance(); // Llamada a la función que obtiene el balance

        // Esperar un tiempo para que se actualice el balance antes de comparar
        setTimeout(() => {
            let balanceText = $("#usdtBalance").text().replace("Balance: ", "").replace(" USDT", "");
            let balanceUSDT = parseFloat(balanceText) || 0;

            let totalText = $("td.totalMonto").text().replace(" USDT", "");
            totalMonto = parseFloat(totalText) || 0;

            let infoDiv = $("#informacion");

            if (balanceUSDT >= totalMonto) {
                $("#btnPagar").removeClass("d-none").css("display", "block");
                infoDiv.removeClass("d-none alert-warning").addClass("alert-success");
                infoDiv.text(`El balance es suficiente porque el contrato tiene ${balanceUSDT} USDT y la solicitud de retiro es ${totalMonto} USDT.`);
            } else {
                infoDiv.removeClass("d-none alert-warning").addClass("alert-danger");
                infoDiv.text(`El balance es insuficiente porque el contrato tiene ${balanceUSDT} USDT y la solicitud de retiro es ${totalMonto} USDT.`);
            }
                    }, 1000); // Espera 1 segundo (ajústalo si es necesario)
                });
            });


</script>

<script>
    $(document).ready(function () {
    $("#btnPagar").click(async function () {
        $("#resultado").html(`<p class="text-warning">Por favor espere max 3 minutos</p>`);
        try {

            let pagos = @json($pagos);

            if (pagos.length === 0) {
                alert("No hay retiros pendientes.");
                return;
            }

            let recipients = pagos.map(p => p.billetera);
            let amounts = pagos.map(p => window.tronWeb.toSun(p.monto)); // Convertimos a SUN
            let transactionIds = pagos.map(p => p.id.toString()); // Convertimos ID a string
            let envio={
                "recipientes":recipients,
                "amount":amounts,
                "id":transactionIds
            }
            console.log(envio);
            
            
            let result = await batchTransferUSDT(recipients, amounts, transactionIds,totalMonto);
           
            if (result) {
                $("#resultado").html(`<p class="text-success">Pagos generados con exito</p>`);
                
                 /* 
                $("#resultado").html(`
                    <p class="text-success">Pagos exitosos: ${result.successfulTransactions.join(", ")}</p>
                    <p class="text-danger">Pagos fallidos: ${result.failedTransactions.join(", ")}</p>
                `);*/
            } else {
                $("#resultado").html(`<p class="text-danger">Error en la transacción.</p>`);
            }
        } catch (error) {
            console.error("Error:", error);
            $("#resultado").html(`<p class="text-danger">Error al obtener datos.</p>`);
        }
    });
});
</script>
@endsection