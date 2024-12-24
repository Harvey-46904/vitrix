<?php
namespace App\Traits;
use DB;
use App\Models\Naveevento;
trait Listnave
{
    public function ultimo_evento(){
        //consultar ultimo evento
        $ultimo_evento = DB::table("eventos")
        ->orderBy("id", "desc")
        ->first();
       return $ultimo_evento;
     }
     public function ListNaves(){
        $ultimo_evento=$this->ultimo_evento();
        $precio=$ultimo_evento->precio;
        $comision=$ultimo_evento->comision;
        $naveeventos = Naveevento::with(['user:id,name'])
        ->where("id_evento", $ultimo_evento->id)
        ->orderBy('puntuacion', 'asc') // Ordenar por puntuacion de mayor a menor
        ->get();
        $totalRegistros = $naveeventos->count();
        $Premio=$precio*$totalRegistros;
        $GananciaCasino=($Premio*$comision)/100;
        $BoteAcumulado=$Premio-$GananciaCasino;
        $nave=[
           "evento"=>$ultimo_evento,
           "lista"=>$naveeventos,
           "Bote"=>$BoteAcumulado
        ];
        return $nave;
     }
}