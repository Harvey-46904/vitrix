<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use kornrunner\Keccak;
use App\Models\UserPaquete;
use App\Models\Retiro;
use App\Services\CashMoney;
use App\Services\Referidos;
use App\Services\Wallets;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Livewire\Livewire;
use App\Events\BalanceUpdated;
class CashController extends Controller
{
    protected $cashService;
    protected $referidosService;
    protected $wallet;
    public function __construct(CashMoney $cashService,Referidos $referidosService,Wallets $wallet)
    {
        $this->cashService = $cashService;
        $this->referidosService=$referidosService;
        $this->wallet=$wallet;
    }
    function encodeFunctionData($amount, $reason) {
        $functionSignature = 'receiveUSDT(uint256,string)';
        $encodedFunction = '0x' . Keccak::hash($functionSignature, 256);
    
        // Codifica `amount` (uint256) a hexadecimal (debe ser de 64 caracteres)
        $encodedAmount = str_pad(dechex($amount), 64, '0', STR_PAD_LEFT);
    
        // Codifica `reason` (string) a hexadecimal UTF-8
        $encodedReason = bin2hex($reason);
        $encodedReason = str_pad($encodedReason, 64, '0', STR_PAD_RIGHT);  // Alinear a 32 bytes
    
        return $encodedFunction . $encodedAmount . $encodedReason;
    }
    
    public function generateQR($amount, $reason)
    {
        $contractAddress = 'TTnQXYX1HF2LZFgyTFXSRAncfMnQ8BLM7y';  // Dirección del contrato
        $hexData = self::encodeFunctionData(1000000, "Payment for services");  // Datos hexadecimales
    
        $url = "tron:{$contractAddress}?callFunction=triggerSmartContract&data={$hexData}";
    
        $qrCode = QrCode::size(250)->generate($url);

        return view('theme::Cashqr', compact('qrCode'));
    }

    public function tranfers(){
        return response(["datra"=>"por desarrollar"]);
    }

    public function addFunds(Request $request)
    {
        //return response(["data"=>$request->all()]);
          // Validar que se haya seleccionado al menos una opción o ingresado texto en la caja de texto
          $request->validate([
            'respuesta' => 'required_without:respuesta_extra',
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

    public function addFoundBono(Request $request){
        
        $request->validate([
            'id_user' => 'required|numeric', // El campo user es obligatorio y debe ser texto.
            'monto' => 'required|numeric|min:1', // El campo monto es obligatorio y debe ser un número mayor o igual a 1.
        ]);
    
        return self::FoundBalanceBono($request->id_user,$request->monto,'Bono de Vitrix');
    }
    public function addFoundinversion($id,Request $request){
        $id_inversion=$id;
        
        $userId =auth()->user()->id;
        //primero pagamos a referidos
        self::PagosReferidos($userId,$request->respuesta);
        //ahora creamos su paquete en la tabla
        //para ello consultamos primero el paquete id
        $consulta=DB::table("inversiones")->select()->where("id",$id_inversion)->first();
        UserPaquete::create([
            'user_id' => $userId,
            'id_inversion'=>$id_inversion,
            'monto_depositar' => 0 ,
            'monto_parcial'=>0,
            'monto_invertido' => $consulta->precio_base,
            'paquete_nombre' =>$consulta->nombre ,
            'paquete_porcentaje' =>$consulta->porcentaje_rentabilidad ,
            'paquete_meta' => $consulta->totalidad,
        ]
            
        );
       
        return redirect()->route('wave.paquetes.personal')->with('success', 'Configuraciones actualizadas exitosamente.');
       
        return response(["data"=>$consulta,"did"=>$id_inversion]);
       
       
    }
    public function PagosReferidos($userId,$Monto){
        return  $this->referidosService->PagosIboxReferidos($userId,$Monto);
    }




    public function FoundBalance($amount){
        
        $bonos=DB::table("bonos")->select('estado','Precio_USDT')->where('nombre','Bono de Bienvenida')->first();
      
       // return $this->wallet->generateNewAddress();
        $userId =$id=auth()->user()->id;
       
       
        //debo consultar si la opcion esta activa primero 
        $hasTransactions = DB::table('user_transaccion')
        ->where('user_id', $userId)
        ->exists();
            
            if (!$hasTransactions) {
                $recompenza=$bonos->estado=='0'?'none':self::FoundBalanceBono($userId,$bonos->Precio_USDT,'Bono de bienvenida');
          
            }
           
        $result = $this->cashService->AddMoneyBalance($userId, $amount,'Deposito');
       
        event(new BalanceUpdated($userId));
       
        if ($result) {
            return back();
        } else {
            return response()->json(['error' => 'Hubo un error al procesar la transacción'], 500);
        }
    }
    public function FoundBalanceBono($userId,$amount,$reason){
        $result = $this->cashService->AddMoneyBonos($userId, $amount,$reason);
        if ($result) {
            return back()->with('success', 'Monto bono depositado correctamente');
        } else {
            return response()->json(['error' => 'Hubo un error al procesar la transacción'], 500);
        }
    }

    public function retirar(){
        $id=auth()->user()->id;
        
       $balances=[
        "efectivo"=>auth()->user()->balance_general->balance,
        "inversion"=>auth()->user()->balance_inversion->balance,
        "referidos"=>auth()->user()->balance_ibox->balance,
        "bonos"=>auth()->user()->balance_bono->balance
       ]; 
       // return response(["data"=>$arbol]);
         $section="retiros";
       // return response(["data"=>$mispaquetes]);
         return view('theme::settings.index', compact('section','balances'));
    }

    public function SendInversionToEfectivo($id){
        $userPaquete = UserPaquete::where('id', $id)->first();
        //guardar valor
       $valor_gestionado= $userPaquete->monto_parcial;
       $userId= $userPaquete->user_id;
        //quitar monto de userpaquete
        $userPaquete->monto_parcial=0;
        $userPaquete->save();
        //tranferir
        $this->cashService->AddMoneyBalance($userId, $valor_gestionado,"Transferencia Rentabilidad");
        $this->cashService->AddMoneyInversion($userId, -$valor_gestionado);
        return back();
        return response(["data"=>$userPaquete]);
    }
    public function retirosvitrix(Request $request){
        //return response(["data"=>$request->all()]);
        $id=auth()->user()->id;
        $opciones=$request->dinero;
        //validar el no dineros
        switch ($opciones) {
            case  "efectivo":
                $this->cashService->AddMoneyBalance($id,-$request->cantidad,'Solicitud de retiro');
                break;
                case  "inversion":
                    $this->cashService->AddMoneyInversion($id,-$request->cantidad);
                    break;
                    case  "referidos":
                        $this->cashService->PayRefery($id,-$request->cantidad);
                        break;
                        case  "bonos":
                            $this->cashService->AddMoneyBonos($id,-$request->cantidad);
                            break;
                            default:
            return back()->with('error', 'Configuraciones actualizadas exitosamente.');
                break;
          
        }
        Retiro::create([
            'id_user' => $id,
            'billetera'=>$request->billetera,
            'monto' =>$request->cantidad,
        ]);

       
        
     
        return back()->with('success', 'Configuraciones actualizadas exitosamente.');
        return response(["data"=>$request->all()]);
    }

    public function index(){
        $id=auth()->user()->id;
        $transacciones=DB::table("user_transaccion")
        ->where("user_id",$id)
        ->get();
        return view('theme::notifications.Transacciones',compact('transacciones'));
    }
    public function generateQRs(){
        return view("theme::pay");
        // Datos del contrato y parámetros para la función logicusdt
        $contractAddress = "TTnQXYX1HF2LZFgyTFXSRAncfMnQ8BLM7y"; // Reemplaza con la dirección de tu contrato
        $amount = 1000000; // Cantidad en SUN (1 USDT = 1,000,000 SUN)
        $reason = "casino"; // Puede ser "casino", "bono", etc.

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

}