<?php
namespace App\Http\Controllers;

use App\Models\Transaccions;
use App\Models\Vitrixpago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
class FinanzasController extends Controller
{
    //las tablas de finanzas en la bd son
    //user_transaccion

    public function UsersPagos(Request $request)
    {
       
        $hash               = $request->hash;
        $dataevent          = "";
       
       
        $blockchainresquest = self::getTransactionEvents($hash);
        if (! empty($blockchainresquest['data'])) {
            $events = $blockchainresquest['data'];
            // $dataevent=$events;
            foreach ($events as $event) {
                if ($event['event_name'] === "BatchTransferCompleted" && isset($event['result'])) {
                    $success   = $event['result']['successfulTransactions'] ?? null;
                    $fails     = $event['result']['failedTransactions'] ?? null;
                    $infofinal = [
                        'success' => $success,
                        'fails'   => $fails,
                    ];
                    self::Procesador_transaccion($fails);
                    $dataevent = [
                        "estado"      => "Encontrado",
                        "informacion" => $infofinal,
                    ];
                    break;
                }
            }
            return response(["data" => $dataevent]);
            return $dataevent;
        } else {
            $dataevent = ["estado" => "Evento no encontrado"];
            return response(["data" => $dataevent]);
        }

    }

    public function blockchainvitrix(Request $request){

        $nivel = DB::table("configuraciones")
        ->where("nombre", "feeds")
        ->value("parametros"); // Obtiene solo el valor sin array
    
        $parametros = json_decode($nivel, true); // Decodificar JSON
        $feed=$parametros["parametros"];
        
        $pago = Vitrixpago::create([
            "hash"        => $request->hash,
            "feed_moment" => $feed,
            "pay_moment"  => $request->pay_moment, // Si no existe, será null
        ]);
    
        return response()->json(["data" => $pago->id]);
    }

    public function Procesador_transaccion($valores)
    {
        $variable = $valores;
        $numeros  = array_map('intval', explode("\n", trim($variable)));

        // Obtener los usuarios y montos de los retiros antes de actualizar
        $datos = DB::table("retiros")
            ->whereIn("id", $numeros)
            ->get(["id_user", "monto"]);

// Actualizar los retiros a "PAGADO"
        DB::table("retiros")
            ->whereIn("id", $numeros)
            ->update(["estado" => "PAGADO"]);

// Crear transacciones para cada usuario
        foreach ($datos as $retiro) {
            Transaccions::create([
                "user_id"       => $retiro->id_user, // Ahora cada retiro es independiente
                "type"          => "Pago USDT wallet",
                "balance_after" => 0,
                "amount"        => $retiro->monto, // Se usa el monto correspondiente
            ]);
        }
    }

    public function getTransactionEvents($transactionHash)
    {
        $base_url= config('app.tron_url_api');
        $url =$base_url."/transactions/{$transactionHash}/events";

        $response = Http::withHeaders([
            'accept' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            return $response->json(); // Devuelve los datos en formato JSON
        } else {
            return [
                'error'   => true,
                'message' => 'Error al obtener los eventos',
                'status'  => $response->status(),
            ];
        }
    }
}
