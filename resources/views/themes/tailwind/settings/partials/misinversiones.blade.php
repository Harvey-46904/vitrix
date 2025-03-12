<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row py-5">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach ($tabs as $index => $tab)
                        <a class="list-group-item list-group-item-action {{ $index === 0 ? 'active' : '' }}"
                            id="list-{{ $tab->id }}-list" data-toggle="list" href="#list-{{ $tab->id }}" role="tab"
                            aria-controls="home">
                            {{ $tab->paquete_nombre }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($tabs as $index => $tab)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="list-{{ $tab->id }}"
                            role="tabpanel" aria-labelledby="list-{{ $tab->id }}-list">
                            <div class="jumbotron text-secondary">
                                <p class=" py-2">
                                    Rentabilidad acumulada de este paquete <b class="text-rosa">{{ number_format($tab->monto_depositar, 2, '.', '') }} USD</b>
                                </p>
                                
                                <div class="progress bg-fondo-morado ">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                        style="width: {{($tab->monto_depositar*100)/$tab->paquete_meta;}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <p class=" pt-4 text-justify lead"> El paquete que a compró tuvo un precio total de
                                    <b class="text-azul-variante">{{$tab->monto_invertido}} USDT</b>
                                    .La rentabilidad que genera este paquete de inversión es de
                                    <b class="text-azul-variante">{{$tab->paquete_porcentaje}}%</b>
                                    , lo que significa que usted recibirá depositos diarios de rentabilidad hasta llegar
                                    a la meta de
                                    <b class="text-azul-variante">{{$tab->paquete_meta}} USDT.</b>
                                </p>
                                <p class="lead pt-2">
                                    <a class="btn btn-primary btn-lg" href="{{route('wave.paquetes.personal.transaccion',['id'=>$tab->id])}}" role="button">Mirar Depositos</a>
                                </p>
                                <p>¡Tienes la suerte!¿Deseas seguir ganando? En <b class="text-rosa">Vitrix</b>
                                tienes la oportunidad de pasar tus rentabilidades al <b class="text-rosa">Casino Vitrix</b>
                                y tener mas chances de aumentar tus ganancias
                            </p>
                            @if ($tab->monto_parcial!=0)
                            <p class="lead pt-2">
                                <a class="btn btn-success btn-lg" href="{{route('wave.paquetes.casino',['id'=>$tab->id])}}" role="button">Pasar <b class="text-rosa">{{ number_format($tab->monto_parcial, 2, '.', '') }} </b> a Casino Vitrix </a>
                            </p> 
                            @endif
                              
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>