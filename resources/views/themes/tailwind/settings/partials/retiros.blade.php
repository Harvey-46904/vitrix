<div class="container">

    @if ($errors->has('billetera'))
        <div class="alert alert-danger">
            {{ $errors->first('billetera') }}
        </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
      Solicitud de retiro enviada correctamente
       </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
       </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="row justify-content-center text-center pt-3">
            <div class="col-md-3 col-5 text-light bg-rosa-transparente m-2 neon-shadow ">
                Efectivo USDT
                <h1  class="letragrande text-rosa">{{$balances["efectivo"]}}</h1>
            </div>
           
            <div class="col-md-3 col-5 text-light bg-rosa-transparente m-2 neon-shadow ">
                Referidos USDT
                <p>El saldo disponible para retiro de referidos es de <b class="text-warning">{{$balances["referidos"]}}</b>.</p>
                <p>Para poder retirar este saldo de referidos, es necesario que su saldo en IBOX tenga fondos suficientes. Actualmente, su saldo en IBOX es de <b  class="text-warning">{{$balances["cards"]}}</b>.</p>
                
            </div>
            
           </div>
             
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-md-9 neon-shadow">
            <form class="text-light p-3" action="{{route('RetirosVitrix')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlInput1">Moneda</label>
                  <input type="text"  class="form-control" value="USDT" readonly >
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Red</label>
                    <input type="text"  class="form-control"  value="TRC20" readonly >
                </div>
                
                <div class="form-group">
                    <label for="balanceSelect">¿De dónde saldrá el dinero?</label>
                    <select class="form-control" id="balanceSelect" name="dinero">
                        <!-- Opciones del select se generarán con JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Dirección de retiro</label>
                    <input type="text"  class="form-control"  placeholder="Escriba correctamente la direccion de retiro " name="billetera">
                </div>

                <div class="form-group">
                    <label for="withdrawAmount">Cantidad a retirar</label>
                    <input type="text" id="withdrawAmount" class="form-control" value="1" placeholder="Mínimo 1 USDT" name="cantidad">
                </div>
                <div class="button-group pb-3">
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('min')">Min</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('25')">25%</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('50')">50%</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('max')">Max</button>
                </div>
                <button type="submit" class="btn bg-azul-variante">Retirar</button>
            </form>
        </div>
    </div>
</div>


<script>
    // Definir los balances como un objeto
    const balances = {
        efectivo: {{$balances["efectivo"]}},
       
        referidos: {{$balances["referidos"]}}
      
    };

    // Obtener los elementos del DOM
    const balanceSelect = document.getElementById('balanceSelect');
    const withdrawAmount = document.getElementById('withdrawAmount');

    // Añadir opciones al select con balance > 0
    for (const [key, value] of Object.entries(balances)) {
        if (value > 0) {
            const option = document.createElement('option');
            option.value = key;
            option.text = `${capitalizeFirstLetter(key)} - ${value} USDT`;
            balanceSelect.appendChild(option);
        }
    }

    // Helper para capitalizar la primera letra
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Restablecer el input al valor mínimo al cambiar de selección
    balanceSelect.addEventListener('change', () => {
        withdrawAmount.value = 5;
    });

    // Función para actualizar el input según el botón
    function setAmount(type) {
        const selectedBalance = balanceSelect.value;
        const balanceValue = balances[selectedBalance];

        if (type === 'min') {
            withdrawAmount.value = 1;
        } else if (type === '25') {
            withdrawAmount.value = (balanceValue * 0.25).toFixed(2);
        } else if (type === '50') {
            withdrawAmount.value = (balanceValue * 0.50).toFixed(2);
        } else if (type === 'max') {
            withdrawAmount.value = balanceValue.toFixed(2);
        }
    }
</script>