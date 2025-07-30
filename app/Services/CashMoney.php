<?php
namespace App\Services;

use App\Models\Transaccions;
use App\Models\UserBalance;
use App\Models\UserBono;
use App\Models\UserCard;
use App\Models\UserIbox;
use App\Models\UserInversion;
use Exception;
use Illuminate\Support\Facades\DB;

class CashMoney
{
    public function GetMoneyBalance($userId)
    {
        DB::beginTransaction();
        try {
            $userBalance = UserBalance::where('user_id', $userId)->first();
            DB::commit();
            return $userBalance->balance;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
    }
    public function AddMoneyBalance($userId, $amount, $reason, $optional = null)
    {
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserBalance::where('user_id', $userId)->first();
            $fondo_total = 0;
            if ($userBalance) {
                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $fondo_total          = $userBalance->balance;
                $userBalance->save();

            } else {
                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserBalance::create([
                    'user_id' => $userId,
                    'balance' => $amount,
                ]);
            }

            $data = [
                'user_id'       => $userId,
                'amount'        => $amount,
                'type'          => $reason,
                'balance_after' => $userBalance->balance,
            ];

            if (! is_null($optional)) {
                $data['optional'] = $optional;
            }
            // Crea el registro de transacción
            Transaccions::create($data);

            // Si todo sale bien, se confirma la transacción
            //event(new BalanceControl($userId, $fondo_total));
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();

            return false;
        }
    }

    public function AddMoneyBonos($userId, $amount, $reason)
    {
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
                    'balance' => $amount,
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id'       => $userId,
                'amount'        => $amount,
                'type'          => $reason, // Define el tipo de transacción
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
    public function AddMoneyInversion($userId, $amount)
    {
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
                    'balance' => $amount,
                ]);
            }

            // Crea el registro de transacción
            Transaccions::create([
                'user_id'       => $userId,
                'amount'        => $amount,
                'type'          => 'rentabilidad de paquete', // Define el tipo de transacción
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
    public function AddMoneyCards($userId, $amount, $reason, $optional = null)
    {
        DB::beginTransaction();

        try {
            // Busca el balance actual del usuario
            $userBalance = UserCard::where('user_id', $userId)->first();

            $fondo_total = 0;

            if ($userBalance) {

                // Suma el nuevo monto al balance existente
                $newBalance = $userBalance->balance + $amount;

                // Actualiza el balance en la base de datos
                $userBalance->balance = $newBalance;
                $fondo_total          = $userBalance->balance;
                $userBalance->save();

            } else {

                // Si no tiene un balance, crea uno nuevo para el usuario
                $userBalance = UserCard::create([
                    'user_id' => $userId,
                    'balance' => $amount,
                ]);
            }

            $data = [
                'user_id'       => $userId,
                'amount'        => $amount,
                'type'          => $reason,
                'balance_after' => $userBalance->balance,
            ];

            if (! is_null($optional)) {
                $data['optional'] = $optional;
            }
            // Crea el registro de transacción
            Transaccions::create($data);

            // Si todo sale bien, se confirma la transacción
            //event(new BalanceControl($userId, $fondo_total));
            DB::commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            //return $e->getMessage();
            return false;
        }
    }
    ///
    public function PayRefery($userId, $amount, $razon, $optional = null)
    {
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
                    'balance' => $amount,
                ]);
            }
            $data = [
                'user_id'       => $userId,
                'amount'        => $amount,
                'type'          => 'Pago ref-' . $razon,
                'balance_after' => $userBalance->balance,
            ];

            if (! is_null($optional)) {
                $data['optional'] = $optional;
            }
            // Crea el registro de transacción
            Transaccions::create($data);
            // Crea el registro de transacción

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
