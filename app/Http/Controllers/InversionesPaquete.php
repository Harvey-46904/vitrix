<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Inversione;
class InversionesPaquete extends Controller
{
    public function mostrar_paquetes(){
        
        $products = Inversione::all();
       // return response(["data"=>$arbol]);
         $section="inversion";
         return view('theme::settings.index', compact('section','products'));
    }
}
