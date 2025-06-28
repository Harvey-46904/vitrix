<div class="container">

    @if ($errors->has('billetera'))
        <div class="alert alert-danger">
            {{ $errors->first('billetera') }}
        </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ __('general.retiro.option1') }}
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
                {{ __('general.retiro.option2') }}
                <h1  class="letragrande text-rosa">{{$balances["efectivo"]}}</h1>
            </div>
           
            <div class="col-md-3 col-5 text-light bg-rosa-transparente m-2 neon-shadow ">
                {{ __('general.retiro.option3') }}
                <p>{{ __('general.retiro.option4') }} <b class="text-warning">{{$balances["referidos"]}}</b>. </p>
                <p>{{ __('general.retiro.option5') }} <b  class="text-warning">{{$balances["cards"]}}</b>. </p>
                
            </div>
            
           </div>
             
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-md-9 neon-shadow">
            <div class="alert alert-info my-2" role="alert">
                {{ __('general.retiro.option6') }} <b>{{$valor}}% </b>{{ __('general.retiro.option7') }}
              </div>
            <form class="text-light p-3" action="{{route('RetirosVitrix')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlInput1">{{ __('general.retiro.option8') }}</label>
                  <input type="text"  class="form-control" value="USDT" readonly >
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">{{ __('general.retiro.option9') }}</label>
                    <input type="text"  class="form-control"  value="ERC20" readonly >
                </div>
                
                <div class="form-group">
                    <label for="balanceSelect">{{ __('general.retiro.option10') }}</label>
                    <select class="form-control" id="balanceSelect" name="dinero">
                        <!-- Opciones del select se generarán con JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">{{ __('general.retiro.option11') }}</label>
                    <input type="text"  class="form-control"  placeholder="{{ __('general.retiro.option11') }}" name="billetera">
                    <label class="text-danger">
                        {{ __('general.retiro.option12') }}
                        {{ __('general.retiro.option13') }}
                        <br>{{ __('general.retiro.option14') }}
                        <br>{{ __('general.retiro.option15') }}
                        <br>{{ __('general.retiro.option16') }}
                        
                    </label>
                </div>

                <div class="form-group">
                    <label for="withdrawAmount">{{ __('general.retiro.option16') }}</label>
                    <input type="text" id="withdrawAmount" class="form-control" value="1" placeholder="Mínimo 1 USDT" name="cantidad">
                </div>
                <div class="button-group pb-3">
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('min')">Min</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('25')">25%</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('50')">50%</button>
                    <button type="button" class="btn bg-fondo-morado" onclick="setAmount('max')">Max</button>
                </div>
                <button type="submit" class="btn bg-azul-variante">{{ __('general.retiro.option17') }}</button>
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