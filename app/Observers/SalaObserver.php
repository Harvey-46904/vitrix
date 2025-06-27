<?php
namespace App\Observers;

use App\Models\Sala;
use App\Models\User;
use App\Notifications\UserNotification;
use App\Models\Apuestascar;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Services\CashMoney;
class SalaObserver
{
        protected $cashMoney;

    public function __construct(CashMoney $cashMoney)
    {
        $this->cashMoney = $cashMoney;
    }
    /**
     * Handle the Sala "created" event.
     */
    public function created(Sala $sala): void
    {

        $ruta       = "/desafio" . "/" . $sala->id;
        $mensaje    = "Te desafia a que compitas con uno de sus mejores jugadores";
        $player_one = $sala->player_one;
        $player_two = $sala->plater_two;

        User::find($player_one)->notify(new UserNotification($mensaje, $ruta, ["name" => "hello moto"]));
        User::find($player_two)->notify(new UserNotification($mensaje, $ruta, ["name" => "hello moto"]));
    }

    public function deleted(Sala $sala): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $campo = "imagepoint$i";

            if ($sala->$campo) {
                $imagenes = json_decode($sala->$campo, true);

                if (is_array($imagenes)) {
                    foreach ($imagenes as $ruta) {
                        Storage::disk('public')->delete($ruta);
                    }
                }
            }
        }
    }

    public function updated(Sala $sala): void
    {
        if ($sala->estado === 'option3') {
            DB::transaction(function () use ($sala) {
                // Bloqueamos apuestas pendientes para esta sala
                $apuestasPendientes = Apuestascar::where('sala_id', $sala->id)
                    ->where('estado', 'pendiente')
                    ->lockForUpdate()
                    ->get();

                if ($apuestasPendientes->isNotEmpty()) {
                  

                    // Aquí va tu lógica de reverso: por ejemplo, actualizar estado o devolver saldo
                    foreach ($apuestasPendientes as $apuesta) {
                        $apuesta->estado = 'reversada';
                        $apuesta->save();
                        $this->cashMoney->AddMoneyBalance($apuesta->jugador_apostador, $apuesta->monto, "Reeintegro Cars Vitrix");
                    }
                }
            });
        }
    }

}
