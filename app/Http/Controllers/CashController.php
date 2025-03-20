<?php
namespace App\Http\Controllers;

use App\Events\BalanceUpdated;
use App\Models\Retiro;
use App\Models\User;
use App\Models\UserPaquete;
use App\Services\CashMoney;
use App\Services\Referidos;
use App\Services\Wallets;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use kornrunner\Keccak;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CashController extends Controller
{
    protected $cashService;
    protected $referidosService;
    protected $wallet;
    public function __construct(CashMoney $cashService, Referidos $referidosService, Wallets $wallet)
    {
        $this->cashService      = $cashService;
        $this->referidosService = $referidosService;
        $this->wallet           = $wallet;
    }
    public function encodeFunctionData($amount, $reason)
    {
        $functionSignature = 'receiveUSDT(uint256,string)';
        $encodedFunction   = '0x' . Keccak::hash($functionSignature, 256);

        // Codifica `amount` (uint256) a hexadecimal (debe ser de 64 caracteres)
        $encodedAmount = str_pad(dechex($amount), 64, '0', STR_PAD_LEFT);

        // Codifica `reason` (string) a hexadecimal UTF-8
        $encodedReason = bin2hex($reason);
        $encodedReason = str_pad($encodedReason, 64, '0', STR_PAD_RIGHT); // Alinear a 32 bytes

        return $encodedFunction . $encodedAmount . $encodedReason;
    }

    public function generateQR($amount, $reason)
    {
        $contractAddress = 'TTnQXYX1HF2LZFgyTFXSRAncfMnQ8BLM7y';                      // Dirección del contrato
        $hexData         = self::encodeFunctionData(1000000, "Payment for services"); // Datos hexadecimales

        $url = "tron:{$contractAddress}?callFunction=triggerSmartContract&data={$hexData}";

        $qrCode = QrCode::size(250)->generate($url);

        return view('theme::Cashqr', compact('qrCode'));
    }

    public function tranfers()
    {
        return response(["datra" => "por desarrollar"]);
    }

    public function addFunds(Request $request)
    {
        //return response(["data"=>$request->all()]);
        // Validar que se haya seleccionado al menos una opción o ingresado texto en la caja de texto
        $request->validate([
            'respuesta'       => 'required_without:respuesta_extra',
            'respuesta_extra' => 'required_without:respuesta',
        ]);
        // Obtener el valor de la opción seleccionada
        $respuesta = $request->input('respuesta');

        // Obtener el valor de la caja de texto
        $respuestaExtra = $request->input('respuesta_extra');

        // Aquí puedes decidir cómo almacenar o manejar los datos
        if ($respuesta) {
            // return self::generateQR($respuesta,"Recarga");
            return self::FoundBalance($respuesta);
        }
        if ($respuestaExtra) {
            //return self::generateQR($respuestaExtra,"Recarga");
            return self::FoundBalance($respuestaExtra);
        }
        return response()->json(['error' => 'No se recibió ninguna respuesta'], 400);
    }

    public function addFoundBono(Request $request)
    {

        $request->validate([
            'id_user' => 'required|numeric',       // El campo user es obligatorio y debe ser texto.
            'monto'   => 'required|numeric|min:1', // El campo monto es obligatorio y debe ser un número mayor o igual a 1.
        ]);

        return self::FoundBalanceBono($request->id_user, $request->monto, 'Bono de Vitrix');
    }

    public function addFoundinversionBalance($id)
    {

        $id_inversion      = $id;
        $user              = auth()->user();
        $paquete_inversion = DB::table("inversiones")->where("id", "=", $id)->first();
        $precio_compra     = $paquete_inversion->precio_base;
        $userId            = $user->id;
        $balance           = $user->balance_general->balance;

        if ($balance >= $precio_compra) {

            self::PagosReferidos($userId, $precio_compra, "referidos");

            $consulta = $paquete_inversion;

            UserPaquete::create([
                'user_id'            => $userId,
                'id_inversion'       => $id_inversion,
                'monto_depositar'    => 0,
                'monto_parcial'      => 0,
                'tiempo'             => $consulta->duracion_meses,
                'monto_invertido'    => $consulta->precio_base,
                'paquete_nombre'     => $consulta->nombre,
                'paquete_porcentaje' => $consulta->porcentaje_rentabilidad,
                'paquete_meta'       => $consulta->totalidad,
            ]

            );

            // return response(["data"=>"alteracion"]);
            $this->cashService->AddMoneyBalance($userId, -$precio_compra, 'Descuento Compra Inversion con Balance');

            return response(["data" => "Compra Realizada"]);
        } else {
            return response(["data" => "alteracion"]);
        }
    }
    public function addFoundinversion($id, Request $request)
    {
        $id_inversion = $id;

        $userId = auth()->user()->id;
        //primero pagamos a referidos
        self::PagosReferidos($userId, $request->respuesta, "referidos");
        //ahora creamos su paquete en la tabla
        //para ello consultamos primero el paquete id
        $consulta = DB::table("inversiones")->select()->where("id", $id_inversion)->first();
        UserPaquete::create([
            'user_id'            => $userId,
            'id_inversion'       => $id_inversion,
            'monto_depositar'    => 0,
            'monto_parcial'      => 0,
            'tiempo'             => $consulta->duracion_meses,
            'monto_invertido'    => $consulta->precio_base,
            'paquete_nombre'     => $consulta->nombre,
            'paquete_porcentaje' => $consulta->porcentaje_rentabilidad,
            'paquete_meta'       => $consulta->totalidad,
        ]

        );

        return redirect()->route('wave.paquetes.personal')->with('success', 'Configuraciones actualizadas exitosamente.');

        return response(["data" => $consulta, "did" => $id_inversion]);
    }
    public function PagosReferidos($userId, $Monto, $razon)
    {
        return $this->referidosService->PagosIboxReferidos($userId, $Monto, $razon);
    }

    public function FoundBalance($amount)
    {

        $bonos = DB::table("bonos")->select('estado', 'Precio_USDT')->where('nombre', 'Bono de Bienvenida')->first();

        // return $this->wallet->generateNewAddress();
        $userId = $id = auth()->user()->id;

        //debo consultar si la opcion esta activa primero
        $hasTransactions = DB::table('user_transaccion')
            ->where('user_id', $userId)
            ->exists();

        if (! $hasTransactions) {
            $recompenza = $bonos->estado == '0' ? 'none' : self::FoundBalanceBono($userId, $bonos->Precio_USDT, 'Bono de bienvenida');

        }

        $result = $this->cashService->AddMoneyBalance($userId, $amount, 'Deposito');

        event(new BalanceUpdated($userId));

        if ($result) {
            return back();
        } else {
            return response()->json(['error' => 'Hubo un error al procesar la transacción'], 500);
        }
    }
    public function FoundBalanceBono($userId, $amount, $reason)
    {
        $result = $this->cashService->AddMoneyBonos($userId, $amount, $reason);
        if ($result) {
            return back()->with('success', 'Monto bono depositado correctamente');
        } else {
            return response()->json(['error' => 'Hubo un error al procesar la transacción'], 500);
        }
    }

    public function retirar()
    {
        $id = auth()->user()->id;

        $balances = [
            "efectivo"  => auth()->user()->balance_general->balance,
            "referidos" => auth()->user()->balance_ibox->balance,
            "cards"     => auth()->user()->balance_card->balance,
        ];
        // return response(["data"=>$arbol]);
        $section = "retiros";
        // return response(["data"=>$mispaquetes]);
        return view('theme::settings.index', compact('section', 'balances'));
    }

    public function SendInversionToEfectivo($id)
    {
        $userPaquete = UserPaquete::where('id', $id)->first();
        //guardar valor
        $valor_gestionado = $userPaquete->monto_parcial;
        $userId           = $userPaquete->user_id;
        //quitar monto de userpaquete
        $userPaquete->monto_parcial = 0;
        $userPaquete->save();
        //tranferir
        $this->cashService->AddMoneyBalance($userId, $valor_gestionado, "Transferencia Rentabilidad");
        $this->cashService->AddMoneyInversion($userId, -$valor_gestionado);
        return back();
        return response(["data" => $userPaquete]);
    }
    public function retirosvitrix(Request $request)
    {

        $id       = auth()->user()->id;
        $opciones = $request->dinero;

        //validar el no dineros
        $efectivo  = auth()->user()->balance_general->balance;
        $referidos = auth()->user()->balance_ibox->balance;
        $cards     = auth()->user()->balance_card->balance;

        $valor_retirado = $request->cantidad;

        switch ($opciones) {
            case "efectivo":
                if ($valor_retirado > $efectivo) {
                    return back()->with('error', 'No tiene suficientes fondos para realizar este retiro');
                } else {
                    $this->cashService->AddMoneyBalance($id, -$valor_retirado, 'Solicitud de retiro Balance');
                }

                break;
            case "referidos":
                if ($valor_retirado > $referidos) {
                    return back()->with('error', 'No tiene suficientes fondos para realizar este retiro');
                } else {
                    //validacion ibox
                    if ($referidos <= $cards) {
                        $this->cashService->AddMoneyCards($id, -$valor_retirado, 'Consumo Ibox retiro referido');
                        $this->cashService->PayRefery($id, -$valor_retirado, 'Solicitud de retiro Referido');
                    } else {
                        return back()->with('error', 'No posee suficientes IBOX para realizar este retiro de referidos por favor recarge');
                    }

                }

                break;
            default:
                return back()->with('error', 'Error : por favor comuniquese con soporte');
                break;

        }
        $nivel = DB::table("configuraciones")->select('parametros')
            ->whereIn('nombre', ["feeds"])
            ->get()
            ->first();

        $nivel = json_decode($nivel->parametros);
        $valor = $nivel->parametros;

        $descuento   = ($valor_retirado * $valor) / 100;
        $total_final = $valor_retirado - $descuento;
        Retiro::create([
            'id_user'   => $id,
            'billetera' => $request->billetera,
            'monto'     => $total_final,
        ]);

        return back()->with('success', 'Configuraciones actualizadas exitosamente.');
        return response(["data" => $request->all()]);
    }

    public function index()
    {
        $id            = auth()->user()->id;
        $transacciones = DB::table("user_transaccion")
            ->where("user_id", $id)
            ->get();
        return view('theme::notifications.Transacciones', compact('transacciones'));
    }
    public function generateQRs()
    {
        return view("theme::pay");
                                                                 // Datos del contrato y parámetros para la función logicusdt
        $contractAddress = "TTnQXYX1HF2LZFgyTFXSRAncfMnQ8BLM7y"; // Reemplaza con la dirección de tu contrato
        $amount          = 1000000;                              // Cantidad en SUN (1 USDT = 1,000,000 SUN)
        $reason          = "casino";                             // Puede ser "casino", "bono", etc.

        /**
         * Construir la URL para interactuar con el contrato.
         * En este ejemplo usamos la URL de Tronscan, la cual al abrirse en una billetera compatible
         * llevará al usuario a la pantalla para interactuar con el contrato.
         *
         * La URL tiene el siguiente formato:
         * https://tronscan.org/#/contract/{CONTRACT_ADDRESS}/interact?method=logicusdt&params=[{MONTO},"{RAZON}"]
         */
        $url = "https://tronscan.org/#/contract/{$contractAddress}/interact?method=logicusdt&params=[{$amount},\"{$reason}\"]";
        return response($url);
        // Generar el código QR de 300x300 píxeles con la URL
        $qrCode = QrCode::size(300)->generate($url);

        // Retornar el QR como una imagen SVG para que pueda mostrarse en el navegador
        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qrcode.svg"');
    }

    public function feeds(Request $request)
    {

        $parametros["parametros"] = $request->feed;
        DB::table("configuraciones")
            ->where("nombre", "feeds")
            ->update(["parametros" => json_encode($parametros)]);
        return back()->with('success', 'Configuraciones actualizadas exitosamente.');
    }

    public function PayBlockchains(Request $request)
    {
        //  return response(["data"=>$request->all()]);
        $data = $request->all();

        // Verificar si es un evento válido
        if (! isset($data['transaction_id'], $data['result'])) {
            return response()->json(['error' => 'Evento inválido'], 400);
        }

        $tx     = $data['transaction_id'];
        $sender = $data['result']['sender'];
        $amount = $data['result']['amount'];
        $reason = $data['result']['reason'];

        // Evitar procesar transacciones duplicadas
        if (! DB::table('pagos')->where('transaction_hash', $tx)->exists()) {
            DB::table('pagos')->insert([
                'sender'           => $sender,
                'amount'           => $amount,
                'reason'           => $reason,
                'transaction_hash' => $tx,
                'created_at'       => now(),
            ]);

            Log::info("Pago recibido: $sender envió $amount USDT. Razón: $reason");
        } else {
            Log::info("Transacción duplicada ignorada: $tx");
        }

        return response()->json(['success' => true]);
    }

    public function payforms($action, $hash, $id = null)
    {
        try {
            $userId = decrypt($hash);
            $user   = User::find($userId);
            if (! $user) {
                return redirect('/');
            }

            switch ($action) {
                case 'deposito':
                    return view("theme::pay", compact("action", "id", "user","hash"));
                case 'inversion':
                    $paquete = DB::table("inversiones")
                        ->where('id', $id)
                        ->first();
                    if ($paquete) {
                        return view("theme::pay", compact("action", "paquete", "id", "user","hash"));
                    } else {
                        return redirect('/');
                    }

                case 'ibox':
                    $paquete = DB::table("iboxes")
                        ->where('id', $id)
                        ->first();
                    if ($paquete) {
                        return view("theme::pay", compact("action", "paquete", "id", "user","hash"));
                    } else {
                        return redirect('/');
                    }
                default:
                    return redirect('/');
            }

        } catch (\Exception $e) {
            return redirect('/');
        }

    }

}
