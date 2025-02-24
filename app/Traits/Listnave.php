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
        ->take(5)->get();
     
    
    // Ordenar en PHP después de descifrar
    $naveeventos = $naveeventos->sortByDesc(function ($evento) {
        return (int) $evento->puntuacion; // Asegurar que es un número
    })->values(); // Reindexar el array
        //return response(["hola"=>$naveeventos]);
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