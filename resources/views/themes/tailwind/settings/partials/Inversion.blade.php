<div class="container">
<style>
    /* Cambiar color de la flecha "prev" */
    .carousel-control-prev-icon {
        background-color: rgba(0, 0, 0, 0.5); /* Color negro semitransparente */
        border-radius: 50%; /* Para redondear la flecha */
    }

    /* Cambiar color de la flecha "next" */
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5); /* Color negro semitransparente */
        border-radius: 50%; /* Para redondear la flecha */
    }

    /* Para un color sólido específico */
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: #d58cfc; /* Cambia esto al color que prefieras */
        border-radius: 50%; /* Redondeado para una mejor apariencia */
    }
</style>
    <div class="row justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-success" href="{{ route('wave.paquetes.personal') }}">MIS_INVERSIONES</a>
            </div>
        </div>
        <div class="col-md-12">
           
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($products->chunk(2) as $index => $chunk)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($products->chunk(1) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                @foreach ($chunk as $product)
                                    <div class="col-md-5 text-secondary">
                                        <div class="card text-center my-4" style=" background-color: #3471b385;" >
                                            <img class="card-img-top mx-auto d-block w-50 h-50" src="{{ Voyager::image($product->icono) }}" alt="Vitrix Paquetes de Inversion">
                                            <div class="card-body">
                                                <h5 class="card-title text-light"><b>{{ $product->nombre }}</b></h5>
                                               
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item display-4">$ {{ $product->precio_base }} </li>
                                                <li class="list-group-item">Rentabilidad <br>{{ $product->porcentaje_rentabilidad }} %</li>
                                                <li class="list-group-item">Duración<br>{{ $product->duracion_meses }} Meses</li>
                                            </ul>
                                            <div class="card-body">
                                                <a class="card-link btn  btn-primary text-light" onClick="calcular({{$product}})">🧮 CALCULADORA</a>
                                                <a 
                                                data-balances={{route('cashbalanceInversionBalance', ['id' => $product->id]) }}
                                                data-url="{{ route('payforms', ['action' => 'deposito', 'hash' => encrypt(Auth::id())]) }}"
                                                data-efectivo="{{ auth()->user()->balance_general->balance ?? 0 }}"
                                                data-precio="{{ $product->precio_base }}"
                                                data-id="{{$product->id}}"
                                                class="card-link btn btn-success compra_validacion text-light">🏷️ SER SOCIO</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Función para mostrar el SweetAlert con un gráfico dinámico
function showChartWithSwal(numMonths, percentageGain,p) {
    // Crear el modal de SweetAlert con el canvas donde irá el gráfico
    Swal.fire({
        title: 'Evolución de ganancias-Paquete '+p.nombre,
        html: '<canvas id="myChart" width="400" height="200"></canvas>', // Lienzo para Chart.js
        showConfirmButton: false,  // Quita el botón de confirmación para hacerlo automático
        willOpen: () => {
            // Configuramos el gráfico al abrir el Swal
            const ctx = document.getElementById('myChart').getContext('2d');
            
            // Datos para el gráfico
            const labels = []; // Array para las etiquetas de los meses
            const data = [0]; // Array para las ganancias progresivas

            let baseGain = 0; // Base de ganancia
            let monthlyGain = percentageGain / numMonths; // Ganancia mensual

            // Llenar los datos de los meses y las ganancias
            for (let i = 1; i <= numMonths; i++) {
                labels.push(`Mes ${i}`); // Etiqueta del mes
                baseGain += monthlyGain; // Aumentar la ganancia
                data.push(baseGain); // Añadir la ganancia al array
            }

            // Crear el gráfico con Chart.js
            new Chart(ctx, {
                type: 'line', // Tipo de gráfico
                data: {
                    labels: labels, // Meses
                    datasets: [{
                        label: 'Rentabilidad '+p.porcentaje_rentabilidad+'%',
                        data: data, // Datos de ganancias
                        borderColor: 'rgba(75, 192, 192, 1)', // Color de la línea
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true, // Empieza desde 0
                            ticks: {
                                callback: function(value) { return value + '%'; } // Formato de porcentaje
                            }
                        }
                    }
                }
            });
        }
    });
}

function calcular(p){
        console.log(p);
        showChartWithSwal(p.duracion_meses, p.porcentaje_rentabilidad,p);
}
// Llamada de ejemplo para mostrar el gráfico con 12 meses y 50% de ganancia
//
</script>

