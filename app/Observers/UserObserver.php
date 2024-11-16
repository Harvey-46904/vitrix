<?php

namespace App\Observers;


//use TCG\Voyager\Models\User;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\UserBono;
use App\Models\UserInversion;
use App\Models\UserIbox;

 
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
        $encryptedBalance = 0;

        // Crear el hash del saldo inicial
        $balanceHash = hash_hmac('sha256', $encryptedBalance, env('APP_KEY'));

        UserBalance::create([
            'user_id' => $user->id,
            'balance' => $encryptedBalance,
            'balance_hash' => $balanceHash,
        ]);
        UserBono::create([
            'user_id' => $user->id,
            'balance' => $encryptedBalance,
            'balance_hash' => $balanceHash,
        ]);
        UserInversion::create([
            'user_id' => $user->id,
            'balance' => $encryptedBalance,
            'balance_hash' => $balanceHash,
        ]);
        UserIbox::create([
            'user_id' => $user->id,
            'balance' => $encryptedBalance,
            'balance_hash' => $balanceHash,
        ]);
        
    }

   
}
