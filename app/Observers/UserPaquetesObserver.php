<?php

namespace App\Observers;

use App\Models\UserPaquete;
use DB;
class UserPaquetesObserver
{
    /**
     * Handle the UserPaquete "created" event.
     */
    public function created(UserPaquete $userPaquete): void
    {
        $data = [
            'user_paquetes_id' =>$userPaquete->id,
            'amount' => 0,
            'razon' => "Inicio Inversión",
        ];
    
        // Insertar en la tabla "paquete"
        $inserted = DB::table('paquete_transaccion')->insert($data);
    
        
    }

    /**
     * Handle the UserPaquete "updated" event.
     */
    public function updated(UserPaquete $userPaquete): void
    {
        //
    }

    /**
     * Handle the UserPaquete "deleted" event.
     */
    public function deleted(UserPaquete $userPaquete): void
    {
        //
    }

    /**
     * Handle the UserPaquete "restored" event.
     */
    public function restored(UserPaquete $userPaquete): void
    {
        //
    }

    /**
     * Handle the UserPaquete "force deleted" event.
     */
    public function forceDeleted(UserPaquete $userPaquete): void
    {
        //
    }
}
