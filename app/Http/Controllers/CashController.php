<?php
namespace App\Http\Controllers;

use App\Events\BalanceUpdated;
use App\Models\Invoice;
use App\Models\Retiro;
use App\Models\Transaccions;
use App\Models\User;
use App\Models\UserPaquete;
use App\Services\CashMoney;
use App\Services\Referidos;
use App\Services\Wallets;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

            // Crea el registro de transacción
            Transaccions::create([
                'user_id'       => $userId,
                'amount'        => $precio_compra,
                'type'          => "Compra Paquete de inversion Balance", // Define el tipo de transacción
                'balance_after' => 0,
            ]);

            // return response(["data"=>"alteracion"]);
            $this->cashService->AddMoneyBalance($userId, -$precio_compra, 'Descuento Compra Inversion con Balance');
            DB::table('pagos')->insert([
                'sender'           => "Balance",
                'amount'           => $precio_compra,
                'reason'           => "inversion",
                'transaction_hash' => "No hash",
                'user_id'          => $userId,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
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
            "efectivo"  => auth()->user()?->balance_general?->balance ?? 0,
            "referidos" => auth()->user()?->balance_ibox?->balance ?? 0,
            "cards"     => auth()->user()?->balance_card?->balance ?? 0,
        ];

        $nivel = DB::table("configuraciones")->select('parametros')
            ->whereIn('nombre', ["feeds"])
            ->get()
            ->first();

        $nivel = json_decode($nivel->parametros);
        $valor = $nivel->parametros;
        // return response(["data"=>$arbol]);
        $section = "retiros";
        // return response(["data"=>$mispaquetes]);
        return view('theme::settings.index', compact('section', 'balances', "valor"));
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
        $valor_retirado = $request->cantidad;
        if ($valor_retirado <= 50) {
            return back()->with('error', 'El monto mínimo de retiro es de 50 USDT');
        }

        $request->validate([
            'billetera' => ['required', 'regex:/^T[A-Za-z1-9]{33}$/'],
        ], [
            'billetera.regex' => 'La dirección de la billetera no es válida. Debe comenzar con "T" y tener 34 caracteres (Este proceso no consume su feed).',
        ]);

        $billetera = $request->billetera;

        $response = Http::get("https://api.trongrid.io/v1/accounts/{$billetera}");
        return response([
            "billetera"=>$billetera,
            "response"=>$response,
            "status"=>$response->failed(),
            "log"=>empty($response['data'])
        ]);
        $id       = auth()->user()->id;
        $opciones = $request->dinero;

        //validar el no dineros
        $efectivo  = auth()->user()->balance_general->balance;
        $referidos = auth()->user()->balance_ibox->balance;
        $cards     = auth()->user()->balance_card->balance;

        $valor_retirado = $request->cantidad;
        $nivel          = DB::table("configuraciones")->select('parametros')
            ->whereIn('nombre', ["feeds"])
            ->get()
            ->first();

        $nivel = json_decode($nivel->parametros);
        $valor = $nivel->parametros;

        $descuento   = ($valor_retirado * $valor) / 100;
        $total_final = $valor_retirado - $descuento;

        switch ($opciones) {
            case "efectivo":
                if ($valor_retirado > $efectivo) {
                    return back()->with('error', 'No tiene suficientes fondos para realizar este retiro');
                }

                if ($response->failed() || empty($response['data'])) {
                    $this->cashService->AddMoneyBalance($id, -$descuento, 'Cobro feed Wallet error');
                    return back()->with('error', 'La billetera no fue encontrada en la red TRON. Verifica que esté correctamente escrita. (Este proceso ha consumido su feed)');
                }

                $this->cashService->AddMoneyBalance($id, -$valor_retirado, 'Solicitud de retiro Balance');
                break;

            case "referidos":
                if ($valor_retirado > $referidos) {
                    return back()->with('error', 'No tiene suficientes fondos para realizar este retiro');
                }

                if ($response->failed() || empty($response['data'])) {
                    $this->cashService->AddMoneyCards($id, -$descuento, 'Consumo feed wallet referido');
                    $this->cashService->PayRefery($id, -$descuento, 'Cobro feed Wallet error');
                    return back()->with('error', 'La billetera no fue encontrada en la red TRON. Verifica que esté correctamente escrita. (Este proceso ha consumido su feed)');
                }

                if ($referidos <= $cards) {
                    $this->cashService->AddMoneyCards($id, -$valor_retirado, 'Consumo Ibox retiro referido');
                    $this->cashService->PayRefery($id, -$valor_retirado, 'Solicitud de retiro Referido');
                } else {
                    return back()->with('error', 'No posee suficientes IBOX para realizar este retiro de referidos. Por favor recargue.');
                }

                break;

            default:
                return back()->with('error', 'Error: por favor comuníquese con soporte');
        }

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
        $id = auth()->user()->id;

        $transacciones = DB::table("user_transaccion")
            ->select('id', 'user_id', 'amount', 'type', 'created_at')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                return $group->take(5);
            });

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
                    $id = 0;
                    return view("theme::pay", compact("action", "id", "user", "hash", "userId"));
                case 'inversion':
                    $paquete = DB::table("inversiones")
                        ->where('id', $id)
                        ->first();
                    if ($paquete) {
                        return view("theme::pay", compact("action", "paquete", "id", "user", "hash", "userId"));
                    } else {
                        return redirect('/');
                    }

                case 'ibox':
                    $paquete = DB::table("iboxes")
                        ->where('id', $id)
                        ->first();
                    if ($paquete) {
                        return view("theme::pay", compact("action", "paquete", "id", "user", "hash", "userId"));
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

    public function GenerateInvoice(Request $request)
    {
        $invoice = Invoice::create([
            'user_id' => $request->user_id, // ID del usuario
            'hash_id' => $request->hash_id, // Hash único
            'reason'  => $request->reason,  // Motivo de la transacción
            'amount'  => $request->amount,  // Monto
            'status'  => $request->status,  // Estado de la factura
        ]);
        return response(["data" => $invoice->id]);
        echo "Invoice creada con ID: " . $invoice->id;
    }

    public function UpdateInvoiceStatus(Request $request)
    {
        // Validar que lleguen los datos necesarios
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'status'     => 'required|string',
        ]);

        // Buscar la invoice y actualizar el status
        $invoice         = Invoice::find($request->invoice_id);
        $invoice->status = $request->status;
        $invoice->save();
        $estado = self::ValidadorEstado($invoice);
        //$managament = self::ManagamentPayValidation($invoice);
        return $estado;
    }

    public function ValidadorEstado($invocacion)
    {
        $estado = $invocacion->status;
        //solo hay 3 estados
        //SUCCESS,REVERT,FAILED
        switch ($estado) {
            case 'SUCCESS':
                $managament = self::ManagamentPayValidation($invocacion);
                //aqui ya pago lo que corresponde a la gente

                return $managament;
            //break;
            case 'REVERT':

                return ["estado" => "reverte"];
                break;
            case 'FAILED':
                return ["estado" => "fallo"];
                break;
            default:
                # code...
                break;
        }
        return response(["data" => $estado]);
    }

    public function ManagamentPayValidation($invocacion)
    {
        $dataevent;
        //return response(["data" => $invocacion]);
        //consultar si ya existe en pagos
        $consulta = DB::table("pagos")->where("transaction_hash", $invocacion->hash_id)->select()->first();
        if (! $consulta) {
            $blockchainresquest = self::getTransactionEvents($invocacion->hash_id);
            if (! empty($blockchainresquest['data'])) {
                $events = $blockchainresquest['data'];

                foreach ($events as $event) {
                    if ($event['event_name'] === "ReceivedUSDT" && isset($event['result'])) {
                        $sender = $event['result']['sender'] ?? null;
                        $amount = $event['result']['amount'] ?? null;
                        $reason = $event['result']['reason'] ?? null;
                        $udid   = $event['result']['idus'] ?? null;
                        $idmeta = $event['result']['idmeta'] ?? null;

                        $infofinal = [
                            'sender'           => $sender,
                            'amount'           => $amount / 1000000,
                            'reason'           => $reason,
                            'transaction_hash' => $invocacion->hash_id,
                            'user_id'          => $udid,
                            'id_meta'          => $idmeta,

                        ];

                        DB::table('pagos')->insert([
                            'sender'           => $sender,
                            'amount'           => $amount / 1000000,
                            'reason'           => $reason,
                            'transaction_hash' => $invocacion->hash_id,
                            'user_id'          => $udid,
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]);

                        $pagare    = self::Gestionadormoney($infofinal);
                        $dataevent = [
                            "estado"      => "Encontrado",
                            "informacion" => $pagare,
                        ];
                        break;
                    }
                }
                return $dataevent;
            } else {
                return $dataevent = ["estado" => "Evento no encontrado"];
            }

        } else {
            return $dataevent = ["estado" => "Transaccion ya existente"];
        }

    }

    public function getTransactionEvents($transactionHash)
    {
        $url = "https://nile.trongrid.io/v1/transactions/{$transactionHash}/events";

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

    public function Gestionadormoney($transation)
    {
        $razon   = $transation["reason"];
        $userId  = $transation["user_id"];
        $amount  = $transation["amount"];
        $id_meta = $transation["id_meta"];
        $message;
        switch ($razon) {
            case 'deposito':
                $result = $this->cashService->AddMoneyBalance($userId, $amount, 'Deposito');

                event(new BalanceUpdated($userId));

                if ($result) {
                    $message = "Se deposito el saldo correctamente";
                } else {
                    $message = "Error al depositar " . $razon . " pongase en contacto con el administrador";

                }
                break;
            case 'ibox':
                $compra_ibox = DB::table("iboxes")->where("id", "=", $id_meta)->first();
                $amount      = $compra_ibox->beneficio;
                $result      = $this->cashService->AddMoneyCards($userId, $amount, 'Compra Ibox');
                if ($result) {
                    $message = "Se deposito el saldo correctamente";
                } else {
                    $message = "Error al depositar " . $razon . " pongase en contacto con el administrador";

                }
                break;
            case 'inversion':

                $id_inversion = $id_meta;

                //primero pagamos a referidos
                self::PagosReferidos($userId, $amount, "referidos");
                //ahora creamos su paquete en la tabla
                //para ello consultamos primero el paquete id
                $consulta = DB::table("inversiones")->select()->where("id", $id_inversion)->first();
                $result   = UserPaquete::create([
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

                // Crea el registro de transacción
                Transaccions::create([
                    'user_id'       => $userId,
                    'amount'        => $amount,
                    'type'          => "Compra Paquete de inversion", // Define el tipo de transacción
                    'balance_after' => 0,
                ]);

                if ($result) {
                    $message = "Se deposito el saldo correctamente";
                } else {
                    $message = "Error al depositar " . $razon . " pongase en contacto con el administrador";

                }
                break;

            default:
                $message = "EL movimiento no existe";
                break;
        }
        return $message;
    }

    public function pagare(Request $request)
    {
        $limite = false;
        $limiteValor = null;
    
        $query = DB::table("retiros")
            ->select("billetera", "monto", "id")
            ->where("estado", "<>", "PAGADO");
    
        if ($request->has('limite') && is_numeric($request->limite)) {
            $limite = true;
            $limiteValor = (int)$request->limite;
            $query->limit($limiteValor);
        }
    
        $pagos = $query->get();
    
        return view("vendor.voyager.pays.index", compact("pagos", "limite", "limiteValor"));
    }

}
