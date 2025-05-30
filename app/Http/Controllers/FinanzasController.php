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
        $id                 =$request->id;
        $dataevent          = "";

        $consulta=Vitrixpago::find($id);
        //return response(["data"=>$consulta->successpay]);
        $id_pagar=$consulta->successpay;

        $pagados= self::Procesador_transaccion($id_pagar);

        if($pagados){
            return response(["data"=>"todo correcto"]);
        }else{
            return response(["data"=>"algo salio mal"]);
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
            "pay_moment"  => $request->pay_moment,
             "successpay" => $request->transaction_ids
            // Si no existe, será null
        ]);
    
        return response()->json(["data" => $pago->id]);
    }

  public function Procesador_transaccion($valores)
{
    try {
        $numeros = array_map('intval', explode(',', $valores)); // Asegura que sean enteros

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
                "user_id"       => $retiro->id_user,
                "type"          => "Pago USDT wallet",
                "balance_after" => 0,
                "amount"        => $retiro->monto,
            ]);
        }

        return true;
    } catch (\Exception $e) {
        // Puedes loguear el error si deseas: Log::error($e->getMessage());
        return false;
    }
}

    public function getTransactionEvents($transactionHash)
    {
          $keypolgon= config('app.polygonscan_api_key');
        $url = "https://api.polygonscan.com/api?module=proxy&action=eth_getTransactionReceipt&txhash={$transactionHash}&apikey={$keypolgon}";
        $response = Http::withHeaders([
            'accept' => 'application/json',
        ])->get($url);
        if ($response->successful()) {
            $data = $response->json();
            $logs = $data['result']['logs'] ?? [];
            $myaddress = "0x8DEE78F5525df489b32060Be79021CaE0d283f93";
            $logs = array_values(array_filter($logs, function($item) use ($myaddress) {
                return strtolower($item['address']) === strtolower($myaddress);
            }));
            return response(["data"=>$logs]);
            $sender = '0x' . substr($logs[0]['topics'][1], 26);
            $newdata=$logs[0]["data"];
            $data= substr($newdata, 2); // quitar el "0x"
               // amount, reason, idus, idmeta => 4 valores
            $amountHex = '0x' . substr($data, 0, 64);
            $reasonOffset = hexdec(substr($data, 64, 64)); // offset al string
            $idusHex = '0x' . substr($data, 128, 64);
            $idmetaHex = '0x' . substr($data, 192, 64);

            $amount = hexdec($amountHex); // suponiendo 6 decimales de USDT
            $idus = hexdec($idusHex);
            $idmeta = hexdec($idmetaHex);

            // Extraer y decodificar string `reason`
            $reasonStart = 192 + 64; // offset comienza después de 4 palabras (256 bits c/u)
            $reasonLength = hexdec(substr($data, $reasonStart, 64));
            $reasonData = substr($data, $reasonStart + 64, $reasonLength * 2); // en hex
            $reason = hex2bin($reasonData);
            return [
                'data' => [
                    [
                        'event_name' => 'ReceivedUSDT',
                        'result' => [
                            'sender' => $sender,
                            'amount' => $amount,
                            'reason' => $reason,
                            'idus'   => $idus,
                            'idmeta' => $idmeta
                        ]
                    ]
                ]
            ];
        } else {
            return [
                'error'   => true,
                'message' => 'Error al obtener los eventos',
                'status'  => $response->status(),
            ];
        }
    }
}
