<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\User;
use App\Services\CashMoney;
class Referidos
{
    protected $cashService;
    public function __construct(CashMoney $cashService)
    {
        $this->cashService = $cashService;
      
    }
    public function ReferidosLevel($iduser,$razon){
        $user = new User;
       
        $configuraciones=self::ObtenerNivelesPorcentajes($razon);
        $recompenza=$user->referidoPrincipalHaciaArriba($iduser,  $configuraciones["nivel"]);
            // Crear el arreglo combinado
            $resultado = [];
            foreach ($recompenza as $key => $valor) {
                // Sacar el índice correspondiente para los porcentajes
                $indice = substr($key, -1) - 1; // Extraemos el número del nivel (1, 2, 3)
                
                // Combinar el valor del nivel con el porcentaje
                $resultado[] = [
                    "nivel" => $valor,
                    "porcentaje" => $configuraciones["parametros"][$indice]
                ];
            }

           return $resultado;
           
        
    }
    public function PagosIboxReferidos($id_user,$montototal,$razon){
        DB::beginTransaction();
        try {
            $pagos=self::ReferidosLevel($id_user,$razon);
            foreach ($pagos as $item) {
                // Acceder a cada valor individualmente
                $nivel = $item['nivel'];
                $porcentaje = $item['porcentaje'];
                $recargaribox=($montototal* $porcentaje)/100;
                $this->cashService->PayRefery($nivel,$recargaribox,$razon);
            }
            // Si todo sale bien, se confirma la transacción
            DB::commit();
            return back();
            //return response(["pagado"=>$pagos]);
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, se revierte todo
            DB::rollBack();
            return false;
        }
        
    }

    public function ReferidosMios($iduser){
        $user = new User;
        $referidos = $user->referidosEnTresNiveles($iduser,1);
        return response(["data"=>$referidos]);
       
    }

    public function ObtenerNivelesPorcentajes($razon){

        $nivel=DB::table("configuraciones")->select('parametros')
        ->whereIn('nombre', ['niveles_'.$razon, 'parametros_'.$razon])
        ->get()
        ->map(function ($fila) {
            // Convierte el campo 'parametros' de JSON string a un objeto
            $fila->parametros = json_decode($fila->parametros);
            return $fila;
        });

        $nivel_numero=$nivel[0]->parametros->niveles;
        $nivel_parametros=$nivel[1]->parametros->parametros;
        
        return $configuracion_referidos=[
            "nivel"=>$nivel_numero,
            "parametros"=>$nivel_parametros
        ];
    }

  




}