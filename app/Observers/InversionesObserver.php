<?php

namespace App\Observers;

use App\Models\Inversione;
use App\Models\Rentabilidade;
use Illuminate\Support\Facades\Log;
class InversionesObserver
{
    /**
     * Handle the Inversione "created" event.
     */
    public function created(Inversione $inversione): void
    {
       // Log::info('Observer ejecutado para usuario creado: ' . $inversione);
        $total=(($inversione->precio_base*$inversione->porcentaje_rentabilidad)/100)+$inversione->precio_base;
        $inversione->totalidad=$total;
        $inversione->save();
        //operacion de rentabilidad
        $finalidad=$inversione->totalidad-$inversione->precio_base;
        //self::CrearRentabilidades($inversione->id,$inversione->totalidad,$inversione->duracion_meses);
        self::CrearRentabilidades($inversione->id,$finalidad,$inversione->duracion_meses);
        
    }

    public function CrearRentabilidades($idInversion,$total,$duracion){
        Rentabilidade::create([
            'id_inversion' => $idInversion,  // Asigna el valor correspondiente de tu inversión
            'formato_rentabilidad' => json_encode(self::generarNumeros($total,$duracion))  // Asigna el valor que desees
        ]);

    }
function generarNumeros($totalidad, $duracion) {
    // Paso 1: Realizar la división inicial
    $totalObjetivo = $totalidad / $duracion;
    // Paso 2: Generar 31 números aleatorios que sumen $totalObjetivo
    $numeros = [];
    $sumaRestante = $totalObjetivo;
    $limite=$totalObjetivo/31;
    for ($i = 0; $i < 31; $i++) {
        // Generar un número aleatorio entre 0 y la mitad del valor restante, para evitar extremos
        $numeroAleatorio = rand(1, $limite * 10) / 10;
        if( $numeroAleatorio ==0 ){
            $numeros[] = 0.1;
            $sumaRestante -= 0.1;
        }else{
            $numeros[] = $numeroAleatorio;
            $sumaRestante -= $numeroAleatorio;
        }
    }
    $incremento=$sumaRestante/31;
    //regla de 3
    
    for ($i = 0; $i < count($numeros); $i++) {
        $pilar= round($numeros[$i] + $incremento, 2);
        $numeros[$i] = round(($pilar * 100) / $totalObjetivo, 2);
    }
    // Asegurar que la suma total sea exactamente igual al total objetivo sumando el restante al último elemento
    //$numeros[] = $sumaRestante;

    return $numeros;
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
