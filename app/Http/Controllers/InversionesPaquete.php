<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Inversione;
use Illuminate\Support\Facades\Auth;

use App\Jobs\ProcessUserPaquetePayment;
use App\Models\UserPaquete;

class InversionesPaquete extends Controller
{
    public function mostrar_paquetes(){
        
        $products = Inversione::all();
       // return response(["data"=>$arbol]);
         $section="inversion";
         return view('theme::settings.index', compact('section','products'));
    }


    public function rentabilidadesInversion($id){
        $rentabilidades=DB::table("rentabilidades")
        ->select("formato_rentabilidad","id")
        ->where("id_inversion","=",$id)
        ->first();
        //$id=$rentabilidades->id;
        $numeros = json_decode($rentabilidades->formato_rentabilidad, true);
       // return response(["data"=>$numeros]);
        return view("vendor.voyager.rentabilidades.index",compact('numeros','id'));
    }

    public function actualizarRentabilidad($id,Request $request){
        //return response(["data"=>$id,"rentabilidades"=>$request->parametros]);

        DB::table("rentabilidades")
            ->where('id_inversion', $id)
            ->update(['formato_rentabilidad' => json_encode($request->parametros)]);
        return redirect()->route('RentabilidadesList',["id"=>$id])->with('success', 'Configuraciones actualizadas exitosamente.');
    }

    public function CompraPaqueteInversion($id){
        $paquete=DB::table("inversiones")
        ->where('id',$id)
        ->first();
       // return response(["data"=>$paquete]);
        return view('theme::CashInversion',compact('paquete'));
    }

    public function MisInversiones(){
        $id=auth()->user()->id;
        $tabs = DB::table("user_paquetes")
        ->where("user_id",$id)
        ->get();
       
       // return response(["data"=>$arbol]);
         $section="misinversiones";
       // return response(["data"=>$mispaquetes]);
         return view('theme::settings.index', compact('section','tabs'));
    }

    public function MisInversionesTransaccion($id){
        $transacciones = DB::table("paquete_transaccion")
        ->where("user_paquetes_id",$id)
        ->get();
        $section="misinversionestabla";
        return view('theme::settings.index', compact('section','transacciones'));
    }


    public function RentabilidadDiaria(){
        // Obtiene todos los paquetes que aún no han alcanzado su meta
        $paquetes = UserPaquete::whereRaw('CAST(monto_depositar AS UNSIGNED) < CAST(paquete_meta AS UNSIGNED)')->get();
        //return response(["data"=>$paquetes]);
        foreach ($paquetes as $paquete) {
            ProcessUserPaquetePayment::dispatch($paquete);
        }

        return response()->json(['message' => 'Pagos en proceso'], 200);
    }

}
