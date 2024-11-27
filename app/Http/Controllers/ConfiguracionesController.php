<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ConfiguracionesController extends Controller
{
    public function IndexNiveles(){
        $nivel=DB::table("configuraciones")->select('parametros')
        ->whereIn('nombre', ['niveles_referidos', 'parametros_referidos'])
        ->get()
        ->map(function ($fila) {
            // Convierte el campo 'parametros' de JSON string a un objeto
            $fila->parametros = json_decode($fila->parametros);
            return $fila;
        });

        $nivel_numero=$nivel[0]->parametros->niveles;
        $nivel_parametros=$nivel[1]->parametros->parametros;
        
        $configuracion_referidos=[
            "nivel"=>$nivel_numero,
            "parametros"=>$nivel_parametros
        ];
        //return response(["data"=>$configuracion_referidos]);

        return view("vendor.voyager.referidos.index",compact('configuracion_referidos'));
    }

    public function EditNiveles(Request $request){
        //return response(["data"=>$request->parametros]);
        $configuracion_referidos=$request->parametros;
        return view("vendor.voyager.referidos.edit",compact('configuracion_referidos'));

    }

    public function UpdateNiveles(Request $request){
       

            DB::table("configuraciones")
            ->where('nombre', 'niveles_referidos')
            ->update(['parametros' => json_encode(['niveles' =>$request->nivel])]);

         DB::table("configuraciones")
            ->where('nombre', 'parametros_referidos')
            ->update(['parametros' => json_encode(['parametros' => $request->parametros])]);
            return redirect()->route('IndexNiveles')->with('success', 'Configuraciones actualizadas exitosamente.');
            return response(["data"=>"datos actualizados"]);
    }
    public function getParametrosAttribute($value)
    {
        return json_decode($value->parametros, true); // true convierte el JSON en un array asociativo
    }

    public function indexbono(){
        return view("vendor.voyager.bonos.index");
        return response(["data"=>"bonos"]);
    }

    public function finanzas(){
        return view("vendor.voyager.finanzas.index");
    }

}
