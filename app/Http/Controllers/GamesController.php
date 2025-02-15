<?php
namespace App\Http\Controllers;

use App\Models\Naveevento;
use App\Models\User;
use App\Services\CashMoney;
use App\Services\PhotonService;
use App\Traits\Listnave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\IntentoFraude;
class GamesController extends Controller
{
    use Listnave;

    protected $cashService;
    public function __construct(CashMoney $cashService)
    {
        $this->cashService = $cashService;
    }
    public function Genius()
    {
        $token = self::getToken();
        // return view('Unity.unity-game',compact("token"));
        return view('Unity.genius', compact("token"));
    }
    public function Navial()
    {
        return view('Unity.navial');
    }
    public function Cars()
    {
        return view('Unity.cars');
    }

    public function GeniusPlayGame(Request $request)
    {

        $valor_apostado = $request->apuesta;
        $user           = Auth::user();
        $userId         = $user->id;
        $cash           = $this->cashService->GetMoneyBalance($userId);

        $validationhash = [
            'userId'         => $userId,
            'valor_apostado' => $valor_apostado,
        ];
        $arrayJson       = json_encode($validationhash);
        $arrayEncriptado = Crypt::encrypt($arrayJson);
        if (! $user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        if ($cash >= $valor_apostado) {
            $this->cashService->AddMoneyBalance($userId, -$valor_apostado, "Apuesta Casino");
            return response()->json([
                'status' => 'Suerte',
                'user'   => $arrayEncriptado,
            ]);
        } else {
            return response()->json([
                'status' => 'No tiene fondos',
                'user'   => "no user",
            ]);
        }
    }

    public function ApuestaSalvaGame(Request $request)
    {
        //return response(["data"=>$request->all()]);
        $multiplicador   = $request->multiplicador;
        $arrayEncriptado = $request->hash;
        try {
            $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
            // Si llega aquí, es porque el hash es válido
            return response()->json(['success' => true, 'data' => $arrayJsonDesencriptado]);
        } catch (DecryptException $e) {
            // El hash no es válido o fue alterado
            $user           = Auth::user();
            $userId         = $user->id;
            IntentoFraude::create([
                'usuario_id' => $userId,
                'motivo' => "Posible hash alterado",
                'direccion_ip' => $request->ip(),
                'agente_usuario' => $request->header('User-Agent'),
                'detectado_en' => now(),
            ]);
            return response()->json(['success' => false, 'message' => 'El hash proporcionado no es válido'], 400);
        }
        $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
        $arrayDesencriptado     = json_decode($arrayJsonDesencriptado, true);
        $multiplicador          = str_replace(',', '.', $multiplicador);
        $multiplicador          = (float) $multiplicador;
        $ganancia               = $arrayDesencriptado["valor_apostado"] * $multiplicador;
        $ganancia               = number_format($ganancia, 2, '.', '');
        $userId                 = $arrayDesencriptado["userId"];
        $this->cashService->AddMoneyBalance($userId, $ganancia, "Ganancia");
        return response(["data" => $ganancia]);
    }

    public function getToken()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        if (! $user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Generar el token JWT
        $token = JWTAuth::fromUser($user);
        return $token;
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60, // Tiempo de expiración en segundos
        ]);
    }

    public function CompetenciaNave(Request $request)
    {

        $naveevento = Naveevento::create([
            'id_evento'  => $this->ultimo_evento()->id,
            'id_jugador' => auth()->user()->id,   // Reemplaza con el valor correspondiente
            'puntuacion' => $request->puntuacion, // Reemplaza con el valor correspondiente
            'tiempo'     => $request->tiempo,     // Reemplaza con el valor correspondiente
        ]);
        $id = $naveevento->id;
        return $id;
    }

    public function createRoom(Request $request, PhotonService $photonService)
    {
        $url     = "https://wt-e4c18d407aa73a40e4182aaf00a2a2eb-0.run.webtask.io/realtime-webhooks-1.2";
        $headers = [
            'X-Secret' => 'YWxhZGRpbjpvcGVuc2VzYW1l',
            'X-Origin' => 'Photon',
        ];

        try {
            $response = Http::withHeaders($headers)->get($url);

            if ($response->successful()) {
                // Procesar la respuesta exitosa
                return response()->json($response->json());
            } else {
                // Procesar errores de respuesta
                return response()->json(['error' => $response->body()], $response->status());
            }
        } catch (\Exception $e) {
            // Manejar excepciones
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
