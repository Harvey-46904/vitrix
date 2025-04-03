<?php

namespace App\Observers;

use App\Models\Evento;
use App\Services\CashMoney;
use App\Models\Naveevento;
use DB;
class EventoObserver
{
    protected $cashMoney;

    public function __construct(CashMoney $cashMoney)
    {
        $this->cashMoney = $cashMoney;
    }
    /**
     * Handle the Evento "created" event.
     */
    public function created(Evento $evento): void
    {
      
        $evento_anterior = Evento::where('id', '<', $evento->id)
        ->orderBy('id', 'desc')
        ->first();
        if ($evento_anterior && $evento_anterior->pagar == 0) {
            $totalRegistros = Naveevento::where("id_evento", $evento_anterior->id)->count();
        
            $Premio = $evento_anterior->precio * $totalRegistros;
            $GananciaCasino = ($Premio * $evento_anterior->comision) / 100;
            $BoteAcumulado = $Premio - $GananciaCasino;
        
            $idJugador = Naveevento::where("id_evento", $evento_anterior->id)
                ->orderByDesc("puntuacion")
                ->value("id_jugador") ?? 1;
        
            // Procesar pago
            $this->cashMoney->AddMoneyBalance($idJugador, $BoteAcumulado, "Ganador Evento Nebula");
        
            // Actualizar estados
            $evento_anterior->update(['pagar' => 1]);
            Evento::where('id', '!=', $evento->id)->update(['status' => 0]);
            return;
        } else {
           // \Log::info("No hay evento anterior, este es el primero.");
            Evento::where('id', '!=', $evento->id)->update(['status' => 0]);
            return;
        }

      
    }

    /**
     * Handle the Evento "updated" event.
     */
    public function updated(Evento $evento): void
    {
        //
    }

    /**
     * Handle the Evento "deleted" event.
     */
    public function deleted(Evento $evento): void
    {
        //
    }

    /**
     * Handle the Evento "restored" event.
     */
    public function restored(Evento $evento): void
    {
        //
    }

    /**
     * Handle the Evento "force deleted" event.
     */
    public function forceDeleted(Evento $evento): void
    {
        //
    }
}
