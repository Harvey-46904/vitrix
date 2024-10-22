<?php

namespace App\Observers;

use App\Models\Inversione;
use Illuminate\Support\Facades\Log;
class InversionesObserver
{
    /**
     * Handle the Inversione "created" event.
     */
    public function created(Inversione $inversione): void
    {
        Log::info('Observer ejecutado para usuario creado: ' . $inversione);
    }


    function generarGanancias($porcentaje_ganancia, $tiempo_meses) {
        $result = [];
        $ganancia_mensual = $porcentaje_ganancia / $tiempo_meses;
    
        for ($mes = 1; $mes <= $tiempo_meses; $mes++) {
            $dias = [];
            $suma_dias = 0;
    
            // Generar 30 valores aleatorios
            for ($dia = 0; $dia < 30; $dia++) {
                // Generar un valor aleatorio que esté en un rango menor que la ganancia mensual
                $valor_aleatorio = mt_rand(0, 100) / 100 * ($ganancia_mensual * 0.9); // 90% de la ganancia mensual
                $dias[] = round($valor_aleatorio, 2);
                $suma_dias += $valor_aleatorio;
            }
    
            // Calcular el último día para que la suma total sea igual a la ganancia mensual
            $ultimo_dia = round($ganancia_mensual - $suma_dias, 2);
            
            // Asegurarse de que el último día no sea negativo
            if ($ultimo_dia < 0) {
                $ultimo_dia = 0; // Ajustar el último día a 0 si la suma es mayor
            }
    
            // Agregar el último día al array
            $dias[] = round($ultimo_dia, 2);
    
            // Agregar los valores del mes al resultado
            $result["mes$mes"] = $dias;
        }
    
        // Retornar el resultado en formato JSON
        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
