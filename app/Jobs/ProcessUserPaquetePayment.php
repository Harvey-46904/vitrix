<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserPaquete;
use App\Models\TransaccionsPaquete;
use App\Models\Rentabilidade;
use App\Services\CashMoney;
use Carbon\Carbon;

class ProcessUserPaquetePayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $userPaquete;

    /**
     * Create a new job instance.
     */

    
  
    public function __construct(UserPaquete $userPaquete)
    {
        $this->userPaquete = $userPaquete;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { 
        $money = app(CashMoney::class);
        // Obtén el día actual
        $currentDay = Carbon::now()->day - 1; // -1 para usar índice de array (0 a 30)

        // Obtén el registro de rentabilidad correspondiente al id_inversion
        $rentabilidad = Rentabilidade::where('id_inversion', $this->userPaquete->id_inversion)->first();

        if (!$rentabilidad) {
            // Manejo de error si no se encuentra rentabilidad
            return;
        }
        // Decodifica el array `formato_rentabilidad` para acceder al valor correspondiente
        $formatoRentabilidad = json_decode($rentabilidad->formato_rentabilidad, true);
        
        // Asegúrate de que el array tiene la posición correcta
         if (!isset($formatoRentabilidad[$currentDay])) {
            // Manejo de error si el día actual no está en el array
            return;
        }
        $porcentajeDiario = $formatoRentabilidad[$currentDay];
        //sacar porcentajes
    
        $paymentAmount = $this->userPaquete->monto_invertido * ($porcentajeDiario / 100);
        
        $remaining = $this->userPaquete->paquete_meta - $this->userPaquete->monto_depositar;
        if ($remaining <= 0) {
            return;
        }

        $paymentAmount = min($paymentAmount, $remaining);
        //$paymentAmount = min(50, $remaining);

        // Registra el pago en `user-paquetes`
        $this->userPaquete->increment('monto_depositar', $paymentAmount);
        $this->userPaquete->increment('monto_parcial', $paymentAmount);
        
        //pagar a moneda
        $money->AddMoneyInversion($this->userPaquete->user_id,$paymentAmount);
        // Crea un registro en `transaccion`
        TransaccionsPaquete::create([
            'user_paquetes_id' => $this->userPaquete->id,
            'amount' => $paymentAmount,
            'razon' => 'Pago parcial',
        ]);
    }
}
