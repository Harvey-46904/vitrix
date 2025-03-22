<div>

    @if($sala)
    <div class="row ">
        <div class="col-md-12  apostar">
            <div class="input-group">
                <input type="text" class="form-control" aria-label="" value="   {{$sala->player_one_name}}" disabled>
                <div class="input-group-append">
                    <span class="input-group-text">X</span>
                    <span class="input-group-text  bg-success">1.8</span>
                </div>
            </div>

        </div>

    </div>
    <div class="row mt-3">
        <div class="col-md-12  apostar">
            <div class="input-group">
                <input type="text" class="form-control" value="  {{$sala->player_two_name}}" aria-label="" disabled>
                <div class="input-group-append">
                    <span class="input-group-text">X</span>
                    <span class="input-group-text bg-success">1.8</span>
                </div>
            </div>

        </div>

    </div>

    <div class="row mt-3 bg-light mx-3 p-2 d-none" id="apuesta">
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
                    <input type="hidden" name="user"  value="Hache">
                    <p class="text-success">Hache</p>

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
                            <input type="text"  name ="valor" class="form-control" aria-label="Amount (to the nearest dollar)">

                        </div>

                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12">
                    <b class="text-dark"> Ganancia posible:</b>
                    <br>
                    <b class="text-dark">1212545 USDT</b>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-danger cerrar-apuesta">Cancelar</button>
                    <a>
                        <button type="submit" class="btn btn-success">Apostar</button>
                    </a>
                </div>
            </div>
        </form>
        </div>

    </div>




    @else
    <p>No se encontró la sala.</p>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let open = false;

$(".apostar").click(function () {
    if (!open) { // Solo abre si está cerrado
        open = true;
        $("#apuesta").removeClass("d-none");
    }
});

$(".cerrar-apuesta").click(function () {
    open = false;
    $("#apuesta").addClass("d-none"); // Oculta el div cuando se hace clic en la "X"
});
    </script>
</div>