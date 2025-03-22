<?php

namespace App\Observers;

use App\Models\Sala;
use App\Notifications\UserNotification;
use App\Models\User;
class SalaObserver
{
    /**
     * Handle the Sala "created" event.
     */
    public function created(Sala $sala): void
    {

        $ruta="/desafio"."/".$sala->id;
        $mensaje="Te desafia a que compitas con uno de sus mejores jugadores";
        $player_one=$sala->player_one;
        $player_two=$sala->plater_two;

        User::find($player_one)->notify(new UserNotification($mensaje,$ruta,["name"=>"hello moto"]));
        User::find($player_two)->notify(new UserNotification($mensaje,$ruta,["name"=>"hello moto"]));
    }

}
