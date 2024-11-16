<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-striped bg-light">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Fecha</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($transacciones as $transaccion)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $transaccion->amount }}</td>
                            <td>{{ $transaccion->razon }}</td>
                            <td>{{ $transaccion->created_at }}</td>
                        </tr>
                    @endforeach
                  
                  
                  
                </tbody>
              </table>
        </div>
    </div>
</div>