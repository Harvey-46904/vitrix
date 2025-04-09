<div>

    @if($sala)
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
       </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
       </div>
    @endif
   
   
    <div class="row ">
        <div class="col-md-12  apostar1">
            <div class="input-group " >
                <input type="text" class="form-control" aria-label="" value="   {{$sala->player_one_name}}" disabled>
                <div class="input-group-append">
                    <span class="input-group-text">X</span>
                    <span class="input-group-text  bg-success">1.8</span>
                </div>
            </div>

        </div>

    </div>
    <div class="row mt-3 bg-light mx-3 p-2 d-none" id="apuesta1">
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-12 bg-success text-light">
                    Sencilla
                </div>
            </div>
            <form method="POST" action="{{ route('apostarcars', ['id_sala' => $sala->id]) }}">
                @csrf
            <div class="row text-dark">
                <div class="col-md-6">
                    <b> Gana la carrera</b>
                    <input type="hidden" name="user"  value="{{$sala->id_one}}">
                    <p class="text-success"> {{$sala->player_one_name}}</p>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="cuota"  value="1.8">
                            <b>1.8</b>

                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">USDT</span>
                            </div>
                            <input type="number"  name ="valor" class="form-control" aria-label="Amount (to the nearest dollar)">

                        </div>

                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12">
                    <b class="text-dark"> Ganancia posible:</b>
                    <br>
                    <b class="text-dark" id="ganancia1">0 USDT</b>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                   
                    <a>
                        <button type="submit" class="btn btn-success">Apostar</button>
                    </a>
                </form>
                    <button type="button" class="btn btn-danger cerrar-apuesta">Cancelar</button>
                </div>
            </div>
       
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-md-12  apostar2">
            <div class="input-group">
                <input type="text" class="form-control" value="  {{$sala->player_two_name}}" aria-label="" disabled>
                <div class="input-group-append">
                    <span class="input-group-text">X</span>
                    <span class="input-group-text bg-success">1.8</span>
                </div>
            </div>

        </div>

    </div>

    <div class="row mt-3 bg-light mx-3 p-2 d-none" id="apuesta2" >
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-12 bg-success text-light">
                    Sencilla
                </div>
            </div>
            <form method="POST" action="{{ route('apostarcars', ['id_sala' => $sala->id]) }}">
                @csrf
            <div class="row text-dark">
                <div class="col-md-6">
                    <b> Gana la carrera</b>
                    <input type="hidden" name="user"  value="{{$sala->id_two}}">
                    <p class="text-success"> {{$sala->player_two_name}}</p>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="cuota"  value="1.8">
                            <b>1.8</b>

                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">USDT</span>
                            </div>
                            <input type="number"  name ="valor" class="form-control" aria-label="Amount (to the nearest dollar)">

                        </div>

                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12">
                    <b class="text-dark"> Ganancia posible:</b>
                    <br>
                    <b class="text-dark" id="ganancia2">0 USDT</b>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  
                    <a>
                        <button type="submit" class="btn btn-success">Apostar</button>
                    </a>
                </form>
                    <button type="button" class="btn btn-danger cerrar-apuesta">Cancelar</button>
                </div>
            </div>
       
        </div>

    </div>




    @else
    <p>No se encontró la sala.</p>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const cuota = 1.8;
        
            // Para apuesta1
            $('#apuesta1 input[name="valor"]').on('input', function() {
                const valor = parseFloat($(this).val());
                const ganancia = (valor > 0) ? (valor * cuota).toFixed(2) : 0;
                $('#ganancia1').text(`${ganancia} USDT`);
            });
        
            // Para apuesta2 si usas otro input
            $('#apuesta2 input[name="valor"]').on('input', function() {
                const valor = parseFloat($(this).val());
                const ganancia = (valor > 0) ? (valor * cuota).toFixed(2) : 0;
                $('#ganancia2').text(`${ganancia} USDT`);
            });
        });
        </script>
    <script>
       

       $(".apostar1").click(function () {
    if ($("#apuesta1").is(":visible")) {
        $("#apuesta1").addClass("d-none");
        $("#apuesta2").addClass("d-none");
        $('#apuesta1 input[name="valor"]').val(0);
        $('#ganancia1').text("0 USDT");
    } else {
        $("#apuesta1").removeClass("d-none");
        $("#apuesta2").addClass("d-none");
    }
});

$(".apostar2").click(function () {
    if ($("#apuesta2").is(":visible")) {
        $("#apuesta1").addClass("d-none");
        $("#apuesta2").addClass("d-none");
        $('#apuesta2 input[name="valor"]').val(0);
        $('#ganancia2').text("0 USDT");
    } else {
        $("#apuesta2").removeClass("d-none");
        $("#apuesta1").addClass("d-none");
    }
});

$(".cerrar-apuesta").click(function () {
    open = false;
    $("#apuesta1").addClass("d-none");
    $("#apuesta2").addClass("d-none"); // Oculta el div cuando se hace clic en la "X"
    $('#apuesta1 input[name="valor"]').val(0);
    $('#ganancia1').text("0 USDT");
    $('#apuesta2 input[name="valor"]').val(0);
    $('#ganancia2').text("0 USDT");
});
    </script>
</div>