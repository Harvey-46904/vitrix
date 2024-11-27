<?php

namespace App\Services;



use App\Models\UserBalance;
use App\Models\UserBono;
use App\Models\UserInversion;
use App\Models\UserIbox;

use App\Models\Transaccions; 
use Illuminate\Support\Facades\DB;
use Exception;


use App\Events\BalanceControl;
class CashMoney
{
    public function AddMoneyBalance($userId, $amount,$reason)
    {
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserBalance::where('user_id', $userId)->first();
            $fondo_total=0;
            if ($userBalance) {
                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $fondo_total=$userBalance->balance;
                $userBalance->save();
               

            } else {
                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserBalance::create([
                    'user_id' => $userId,
                    'balance' => $amount
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $reason, // Define el tipo de transacción
                'balance_after' => $userBalance->balance,
            ]);
           
            // Si todo sale bien, se confirma la transacción
            event(new BalanceControl($userId, $fondo_total));
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
    }

    public function AddMoneyBonos($userId, $amount,$reason){
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserBono::where('user_id', $userId)->first();

            if ($userBalance) {
                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $userBalance->save();
            } else {
                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserBono::create([
                    'user_id' => $userId,
                    'balance' => $amount
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $reason, // Define el tipo de transacción
                'balance_after' => $userBalance->balance,
            ]);

            // Si todo sale bien, se confirma la transacción
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
    }
    public function AddMoneyInversion($userId, $amount){
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserInversion::where('user_id', $userId)->first();

            if ($userBalance) {
                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $userBalance->save();
            } else {
                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserInversion::create([
                    'user_id' => $userId,
                    'balance' => $amount
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => 'rentabilidad de paquete', // Define el tipo de transacción
                'balance_after' => $userBalance->balance,
            ]);

            // Si todo sale bien, se confirma la transacción
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
    }

    ///
    public function PayRefery($userId, $amount){
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserIbox::where('user_id', $userId)->first();

            if ($userBalance) {
                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $userBalance->save();
            } else {
                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserIbox::create([
                    'user_id' => $userId,
                    'balance' => $amount
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => 'Nivel Referido', // Define el tipo de transacción
                'balance_after' => $userBalance->balance,
            ]);

            // Si todo sale bien, se confirma la transacción
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
    }

  
}