<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
class ReferidosController extends Controller
{
   public function ArbolMultiNivel(){

      $user = User::find(1); // Cambia el ID por el usuario de inicio
      $referidos = $user->referidosEnTresNiveles($user->id,3);
      $recompenza=$user->referidoPrincipalHaciaArriba(20, 3);
    return response(["arbol"=>$referidos,"recompenza"=>$recompenza]);
   /* foreach ($referidos as $referido) {
        echo $referido->name; // Muestra el nombre de cada usuario referido
    }*/
   }
   public function ibox(){
    
     
      $iboxes=DB::table("iboxes")
      ->select()
      ->get();

       $section="ibox";
       return view('theme::settings.index', compact('section','iboxes'));
   }

  
}
