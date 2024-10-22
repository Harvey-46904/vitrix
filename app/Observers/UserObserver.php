<?php

namespace App\Observers;


//use TCG\Voyager\Models\User;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Saldo inicial encriptado
        $encryptedBalance = Crypt::encryptString(0);

        // Crear el hash del saldo inicial
        $balanceHash = hash_hmac('sha256', 0, env('APP_KEY'));

        UserBalance::create([
            'user_id' => $user->id,
            'balance' => $encryptedBalance,
            'balance_hash' => $balanceHash,
        ]);
    }

   
}
