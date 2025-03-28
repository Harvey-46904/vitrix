<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    public function IndexNiveles()
    {
        $nameruta = "UpdateNiveles";
        $nivel    = DB::table("configuraciones")->select('parametros')
            ->whereIn('nombre', ['niveles_referidos', 'parametros_referidos'])
            ->get()
            ->map(function ($fila) {
                // Convierte el campo 'parametros' de JSON string a un objeto
                $fila->parametros = json_decode($fila->parametros);
                return $fila;
            });

        $nivel_numero     = $nivel[0]->parametros->niveles;
        $nivel_parametros = $nivel[1]->parametros->parametros;

        $configuracion_referidos = [
            "nivel"      => $nivel_numero,
            "parametros" => $nivel_parametros,
            "ruta"       => $nameruta,
        ];
        //return response(["data"=>$configuracion_referidos]);

        return view("vendor.voyager.referidos.index", compact('configuracion_referidos'));
    }

    public function EditNiveles(Request $request)
    {
        //return response(["data"=>$request->parametros]);
        $configuracion_referidos = $request->parametros;
        return view("vendor.voyager.referidos.edit", compact('configuracion_referidos'));

    }

    public function UpdateNiveles(Request $request)
    {

        DB::table("configuraciones")
            ->where('nombre', 'niveles_referidos')
            ->update(['parametros' => json_encode(['niveles' => $request->nivel])]);

        DB::table("configuraciones")
            ->where('nombre', 'parametros_referidos')
            ->update(['parametros' => json_encode(['parametros' => $request->parametros])]);
        return redirect()->route('IndexNiveles')->with('success', 'Configuraciones actualizadas exitosamente.');
        return response(["data" => "datos actualizados"]);
    }
    public function getParametrosAttribute($value)
    {
        return json_decode($value->parametros, true); // true convierte el JSON en un array asociativo
    }

    public function indexbono()
    {
        return view("vendor.voyager.bonos.index");
        return response(["data" => "bonos"]);
    }

    public function finanzas(Request $request)
    {
        $estadistica = false;

        // Verificar si hay fechas en la solicitud
        if ($request->has(['start_date', 'end_date'])) {
            $estadistica = true;

            ///MAXIMA INVERSION
            $paquetes = DB::table('user_paquetes')
                ->select('paquete_nombre', DB::raw('COUNT(id_inversion) as total'))
                ->groupBy('paquete_nombre')
                ->orderByDesc('total')
                ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->get();

            $paqueteMasRepetido = $paquetes->first();

            $labels = $paquetes->pluck('paquete_nombre'); // Extrae nombres de paquetes
            $data   = $paquetes->pluck('total');          // Extrae totales

            ///PAGOS
            $pagos = DB::table("pagos")
            ->select("amount", "reason", "transaction_hash", "created_at")
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();
        
        $pagosAgrupados = DB::table("pagos")
            ->select("reason", DB::raw("SUM(amount) as total_amount"), DB::raw("COUNT(*) as total_transacciones"))
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->groupBy("reason")
            ->get();

            $labelsagrupados = $pagosAgrupados->pluck('reason')->toArray();
            $dataagrupados = $pagosAgrupados->pluck('total_amount')->toArray();
            $chartDataPagos = [
                "labels" => $labelsagrupados,
                "data" => $dataagrupados
            ];
            //Juegos
            //genius
            //ganancia de este juego
                                                           // Sumar el monto apostado en esas apuestas
                $ganancia_genius = DB::table('apuestas')
                ->selectRaw('SUM(bet_amount) - SUM(win_amount) as ganancia')
                ->whereBetween('created_at', [$request->start_date, $request->end_date]) // Si quieres filtrar por fecha
                ->first();

                $total_apostado = DB::table('apuestas')
            ->selectRaw('SUM(bet_amount) as total_apostado')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->first();
            //
            // Consulta para obtener el detalle de cada evento
            $ganancia_nebula = DB::table('naveeventos')
                ->join('eventos', 'naveeventos.id_evento', '=', 'eventos.id')
                ->whereBetween('naveeventos.created_at', [$request->start_date, $request->end_date])
                ->select(
                    'id_evento',
                    DB::raw('COUNT(id_evento) as total'),
                    DB::raw('(COUNT(id_evento) * eventos.precio) as total_ingreso'),
                    DB::raw('(COUNT(id_evento) * eventos.precio * (eventos.comision / 100)) as ganancia_casino')
                )
                ->groupBy('id_evento', 'eventos.precio', 'eventos.comision')
                ->get();

// Consulta para sumar la ganancia total del casino
            $ganancia_nebula = $ganancia_nebula->sum('ganancia_casino');


            //retiros
            $retirosResumen = DB::table("retiros")
            ->select(DB::raw("SUM(monto) as total_monto"), DB::raw("COUNT(*) as total_retiros"))
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->first();
            $listaRetiros = DB::table("retiros")
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();
            //intentos de fraude
            
            $intento_fraudes = DB::table("intento_fraudes")
            ->select( DB::raw("COUNT(*) as total_fraudes"))
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->first();

            //users
            $usuariosPorDia = DB::table("users")
            ->select(DB::raw("DATE(created_at) as fecha"), DB::raw("COUNT(id) as total"))
            ->whereBetween("created_at", [$request->start_date, $request->end_date])
            ->groupBy("fecha")
            ->orderBy("fecha")
            ->get();
            $labelsusuarios =  $usuariosPorDia->pluck('fecha')->toArray(); // Fechas
            $datausuarios = $usuariosPorDia->pluck('total')->toArray();   // Cantidad de usuarios
            $chartDatausuarios = [
                "labels" => $labelsusuarios,
                "data" => $datausuarios
            ];
      
        
       
            $informacion_estadistica = [
                "juegos"      => [
                    "total_apostado"=>$total_apostado,
                    "ganancia_genius" => $ganancia_genius,
                    "ganancia_nebula" => $ganancia_nebula,
                ],
                "inversiones" => [
                    "maxpaquete" => $paqueteMasRepetido,
                    "chartData"  => [
                        "labels" => $labels,
                        "data"   => $data,
                    ],
                ],
                "pagos"       => [
                    "pagos"=>$pagos,
                    "pagos_agrupado"=>$pagosAgrupados,
                    "chartData" => $chartDataPagos
                ],
                "retiros"=>[
                    "listaRetiros"=>$listaRetiros,
                    "resumen"=>$retirosResumen
                ],
                "fraudes"=>[
                    "valor"=>$intento_fraudes

                ],
                "usuarios"=>[
                    "usuarios_nuevos" => $usuariosPorDia,
                    "chatusers"=> $chartDatausuarios
                    ]
            ];

           // return response(["data" => $informacion_estadistica]);
            return view("vendor.voyager.finanzas.index", compact("estadistica", "informacion_estadistica"));
        } else {
            return view("vendor.voyager.finanzas.index", compact("estadistica"));
            return response(["no data"]);
        }

    }

    public function indexfeeds()
    {

        $nivel = DB::table("configuraciones")->select('parametros')
            ->whereIn('nombre', ["feeds"])
            ->get()
            ->first();

        $nivel = json_decode($nivel->parametros);
        $valor = $nivel->parametros;

        return view("vendor.voyager.configuraciones.index", compact("valor"));
        return response(["data" => "bonos"]);
    }

}
