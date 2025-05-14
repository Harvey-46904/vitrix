<?php
namespace App\Http\Controllers;

use App\Models\Apuesta;
use App\Models\IntentoFraude;
use App\Models\Naveevento;
use App\Models\User;
use App\Models\Apuestascar;

use App\Services\CashMoney;
use App\Services\PhotonService;
use App\Services\Referidos;
use App\Traits\Listnave;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Livewire\Livewire;
class GamesController extends Controller
{
    use Listnave;

    protected $cashService;
    protected $referidosService;
    public function __construct(CashMoney $cashService, Referidos $referidosService)
    {

        $this->cashService      = $cashService;
        $this->referidosService = $referidosService;
    }
    public function Genius()
    {
        $token = self::getToken();
        // return view('Unity.unity-game',compact("token"));
        return view('Unity.genius', compact("token"));
    }
    public function Navial()
    {
        $evento = $this->ultimo_evento();
        $token  = self::getToken();
        $precio = self::cifrarMultiplicador($evento->precio);

        return view('Unity.navial', compact("token", "precio"));
    }
    public function Cars($id)
    {
       // return response(["data"=>"prueba"]);
        $user   = Auth::user();
        $userId = $user->id;

        ///obtengo el nombre de la sala sin espacio y junto
        $name      = DB::table("salas")
        ->select("nombre_sala", "player_one", "plater_two")
        ->where("id", $id)
        
        ->first();
        $name_sala = strtolower(str_replace(' ', '_', $name->nombre_sala));

        $player_one = $name->player_one; // Por ejemplo, obtenemos estos valores de la base de datos
        $player_two = $name->plater_two;
        $id_user    = $userId; // El id_user con el que quieres comparar

// Verificar si ambos jugadores son iguales al id_user
        if ($player_one == $id_user || $player_two == $id_user) {

            $token    = self::getToken();
            $nickname = $user->username;
            $base_url = "http://127.0.0.1:8000/";
            // return response(["sala" => $name_sala,"nickname"=>$nickname,"token"=>$token]);
            return view('Unity.cars', compact('token', 'nickname', 'name_sala','base_url'));
        } else {
            return redirect('/');
        }

    }

    public function GeniusPlayGame(Request $request)
    {

        $valor_apostado = $request->apuesta;
        $user           = Auth::user();
        $userId         = $user->id;

        $cash = $this->cashService->GetMoneyBalance($userId);
        if (! $user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        if ($cash >= $valor_apostado) {

            $multiplos = self::calcularMultiplicador($userId);
            $apuesta   = Apuesta::create([
                'user_id'    => $userId,
                'game_id'    => 2,
                'bet_amount' => $valor_apostado,
                'win_amount' => 0,
                'outcome'    => "Perdida",
            ]);
            $validationhash = [
                'userId'         => $userId,
                'valor_apostado' => $valor_apostado,
                'apuesta'        => $apuesta->id,
                'multiplos'      => $multiplos,
            ];
            $arrayJson       = json_encode($validationhash);
            $arrayEncriptado = Crypt::encrypt($arrayJson);
            $this->cashService->AddMoneyBalance($userId, -$valor_apostado, "Apuesta Genius");
            $this->referidosService->PagosIboxReferidos($userId, $valor_apostado, "genius");
            return response()->json([
                'status'    => 'Suerte',
                'user'      => $arrayEncriptado,
                'idapuesta' => $multiplos,
            ]);
        } else {
            return response()->json([
                'status'    => 'No tiene fondos',
                'user'      => "no user",
                'idapuesta' => 1245515,
            ]);
        }
    }

    public function cifrarMultiplicador($multiplicador)
    {
        $claveSecreta = 14545816115;
        return (float) (($multiplicador * 100) + $claveSecreta);
    }
    public function descifrarMultiplicador($valorCifrado)
    {
        $claveSecreta = 14545816115;
        return (float) (($valorCifrado - $claveSecreta) / 100);
    }
    public function calcularMultiplicador($userId)
    {
        $frpActual = Apuesta::calcularFRPDeJugador($userId); // Obtener el FRP actual

                                  // Definir los límites de los multiplicadores
        $multiplicadorMin = 1.01; // Mínimo (evita valores demasiado bajos)
        $multiplicadorMax = 3.0;  // Máximo (controla pagos altos)

        // Ajustar el multiplicador según el FRP
        if ($frpActual > 98) {
            $multiplicadorMax = 1.5; // Si el FRP es alto, reducimos el multiplicador
        } elseif ($frpActual < 95) {
            $multiplicadorMax = 3.0; // Si el FRP es bajo, permitimos multiplicadores más altos
        }

        // Generar un multiplicador aleatorio en el rango ajustado
        $mul = round(mt_rand($multiplicadorMin * 100, $multiplicadorMax * 100) / 100, 2);
        return self::cifrarMultiplicador($mul);
    }

    public function NavesPlayGame(Request $request)
    {
        // return response(["sda"=>self::cifrarMultiplicador(10)]);
        $valor_apostado = $request->apuesta;
        $user           = Auth::user();
        $userId         = $user->id;
        $cash           = $this->cashService->GetMoneyBalance($userId);

        if (! $user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        if ($cash >= $valor_apostado) {

            $validationhash = [
                'userId'         => $userId,
                'valor_apostado' => $valor_apostado,
            ];
            $arrayJson       = json_encode($validationhash);
            $arrayEncriptado = Crypt::encrypt($arrayJson);
            $this->cashService->AddMoneyBalance($userId, -$valor_apostado, "Apuesta Nebula Race");
            $this->referidosService->PagosIboxReferidos($userId, $valor_apostado, "nebula");
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
        //return response(["des"=>self::descifrarMultiplicador( $request->multiplicador)]);
        //return response(["data"=>$request->all()]);
        $multiplicador   = $request->multiplicador;
        $arrayEncriptado = $request->hash;
        try {
            $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
            // Si llega aquí, es porque el hash es válido
            // return response()->json(['success' => true, 'data' => $arrayJsonDesencriptado]);
        } catch (DecryptException $e) {
            // El hash no es válido o fue alterado
            $user   = Auth::user();
            $userId = $user->id;
            IntentoFraude::create([
                'usuario_id'     => $userId,
                'motivo'         => "Posible hash alterado",
                'direccion_ip'   => $request->ip(),
                'agente_usuario' => $request->header('User-Agent'),
                'detectado_en'   => now(),
            ]);
            return response()->json(['success' => false, 'message' => 'El hash proporcionado no es válido'], 400);
        }
        // $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
        $arrayDesencriptado = json_decode($arrayJsonDesencriptado, true);
        $multiplicador      = str_replace(',', '.', $multiplicador);
        $multiplicador      = (float) $multiplicador;
        $ganancia           = $arrayDesencriptado["valor_apostado"] * $multiplicador;
        $ganancia           = number_format($ganancia, 2, '.', '');
        $userId             = $arrayDesencriptado["userId"];
        $idapuesta          = $arrayDesencriptado["apuesta"];
        $multiplos          = $arrayDesencriptado["multiplos"];
        $multiplos          = self::descifrarMultiplicador($multiplos);
        if ($multiplos >= $multiplicador) {
            if($ganancia>0){
                Apuesta::where('id', $idapuesta)->update(['win_amount' => $ganancia, 'outcome' => "Ganadora"]);
                $this->cashService->AddMoneyBalance($userId, $ganancia, "Ganancia Genius");
            }
          
        } else {
            IntentoFraude::create([
                'usuario_id'     => $userId,
                'motivo'         => "Limite multiplicador: LIMITE:" . $multiplos . " el valor de usuario " . $multiplicador,
                'direccion_ip'   => $request->ip(),
                'agente_usuario' => $request->header('User-Agent'),
                'detectado_en'   => now(),
            ]);
            return response(["des" => "alteracion"]);
        }

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
        // return response(["data"=>$request->all()]);
        $arrayEncriptado = $request->hash;
        try {
            $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
            // Si llega aquí, es porque el hash es válido
            // return response()->json(['success' => true, 'data' => $arrayJsonDesencriptado]);
        } catch (DecryptException $e) {
            // El hash no es válido o fue alterado
            $user   = Auth::user();
            $userId = $user->id;
            IntentoFraude::create([
                'usuario_id'     => $userId,
                'motivo'         => "Posible hash alterado",
                'direccion_ip'   => $request->ip(),
                'agente_usuario' => $request->header('User-Agent'),
                'detectado_en'   => now(),
            ]);
            return response()->json(['success' => false, 'message' => 'El hash proporcionado no es válido'], 400);
        }
        $arrayDesencriptado = json_decode($arrayJsonDesencriptado, true);
        $userId             = $arrayDesencriptado["userId"];
        $naveevento         = Naveevento::create([
            'id_evento'  => $this->ultimo_evento()->id,
            'id_jugador' => $userId,
            'puntuacion' => $request->puntuacion,
            'tiempo'     => $request->tiempo,
        ]);
        $id = $naveevento->id;
        return $id;
    }

    public function Salaspropias($id)
    {
       
        $eventosala = DB::table("salas")
        ->select()
        ->where("id", $id)
        ->first();
        $eventosala = DB::table('salas')
            ->join('users as u1', 'salas.player_one', '=', 'u1.id')
            ->join('users as u2', 'salas.plater_two', '=', 'u2.id')
            ->select(
                'salas.*',
                'u1.name as player_one_name',
                'u2.name as player_two_name',
                'u1.id as id_one',
                'u2.id as id_two'
            )
            ->where("salas.id", $id)->first();

        return view('Unity.SalaGame', compact("eventosala"));
        return response(["data" => $eventosala]);
    }

    public function naveseventos(){

        $evento = $this->ultimo_evento();
        $banners = DB::table("banners")->where("activo", "=", 1)->get();
        return view('Unity.Nave',compact("evento","banners"));
       
    }

    public function sports()
    {

        $user    = Auth::user();
        $id_user = $user->id;
        // Consulta 1: cuando el id_user aparece en player_one o player_two
        $salasConJugador = DB::table('salas')
        ->where(function ($query) use ($id_user) {
            $query->where('player_one', $id_user)
                  ->orWhere('plater_two', $id_user);
        })
        ->where('estado', 'option5')
        ->get();

        // Consulta 2: cuando el id_user no aparece ni en player_one ni en player_two
        $salasSinJugador = DB::table('salas')
            ->join('users as u1', 'salas.player_one', '=', 'u1.id')
            ->join('users as u2', 'salas.plater_two', '=', 'u2.id')
            ->select(
                'salas.*',
                'u1.username as player_one_name',
                'u2.username as player_two_name'
            )
            ->where('salas.player_one', '!=', $id_user)
            ->where('salas.plater_two', '!=', $id_user)
            ->where('estado', "option5")
            ->get();

        $section = "sports";
        return view('theme::settings.index', compact('section', 'salasConJugador', 'salasSinJugador'));
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

    public function desafio($id)
    {
        $userId     = auth()->id(); // O el ID del usuario que quieras consultar
        $autorizado = false;
        $acepto     = false;
        $salas      = DB::table("salas")
            ->select()
            ->where("id", $id)
            ->where(function ($query) use ($userId) {
                $query->where("player_one", $userId)
                    ->orWhere("plater_two", $userId);
            })
            ->first();

        if ($salas) {
            $updateField = ($salas->player_one == $userId) ? "accept_one" : "accept_two";
            $status      = $salas->$updateField;
            if ($status == 1) {
                $acepto = true;
                $mesage = "Ya aceptaste el desafio";
                return view('theme::reto', compact("salas", "autorizado", "id", "acepto", "mesage"));
                return response(["data" => "ya acepto"]);
            }
            if ($status == -1) {
                $acepto = true;
                $mesage = "Rechazaste el desafio será para la proxima";
                return view('theme::reto', compact("salas", "autorizado", "id", "acepto", "mesage"));
            }

            $autorizado = true;
            return view('theme::reto', compact("salas", "autorizado", "id", "acepto"));
        }
        return view('theme::reto', compact("autorizado", "acepto"));
    }
    public function actiondesafio($action, $id)
    {
        $userId = auth()->id();

        $sala = DB::table("salas")
            ->select("player_one", "plater_two", "accept_one", "accept_two")
            ->where("id", $id)
            ->where(function ($query) use ($userId) {
                $query->where("player_one", $userId)
                    ->orWhere("plater_two", $userId);
            })
            ->first();

        if ($sala) {
            // Determinar qué columna actualizar
            $updateField = ($sala->player_one == $userId) ? "accept_one" : "accept_two";

            if ($action == "Aceptar") {

                // Actualizar la columna correspondiente
                $sala = tap(DB::table("salas")->where("id", $id))
                    ->update([$updateField => 1])
                    ->first();
              
                if($sala->accept_one==1 && $sala->accept_two==1){
                    DB::table("salas")
                    ->where("id", $id)
                    ->update(["estado" => "option5"]);
                    return back();
                }
                return back();
            } else {
                DB::table("salas")
                    ->where("id", $id)
                    ->update([$updateField => -1, "estado" => "option4"]);

                return back();
            }

        } else {
            return response(["data" => "No válido"]);
        }
    }


    public function apostarcars(Request $request,$id_sala){
        //validar montoo
        if($request->valor=="" || $request->valor==0 || $request->valor<0){
            return back()->with('error', 'El monto apostado no puede ser vacio , igual a cero o un valor negativo');
        }
        //validar dinero
        $efectivo  = auth()->user()->balance_general->balance;
        $monto_apostado=$request->valor;
        if($efectivo<$monto_apostado){
            return back()->with('error', 'No tiene saldo suficente para realizar esta apuesta.');
        }
        if($monto_apostado>50){
            return back()->with('error', 'Su apuesta supera el límite máximo por sala.');
        }


      
      
        $user   = Auth::user();
        $userId = $user->id;

        $this->cashService->AddMoneyBalance($userId, -$monto_apostado, 'Apuesta Speed Stakes');
        Apuestascar::create([
            'jugador_apostador'=>$userId,
            'sala_id' => $id_sala,
            'jugador' => $request->user,
            'monto' => $request->valor,
            'posible_ganancia' => $request->valor * $request->cuota, // Calculando la posible ganancia
            'cuota' => $request->cuota,
            'estado' => 'pendiente' // O el estado que manejes
        ]);

        Livewire::dispatch('actualizarCuotas');
        return back()->with('success', 'Apuesta Realizada Correctamente');
       


    }


    public function ApuestasSeperadas($id){
        $apuestasSubquery = DB::table('apuestascars')
        ->select('sala_id', 'jugador', DB::raw('SUM(posible_ganancia) as total_ganancia'), DB::raw('SUM(monto) as monto'))
        ->groupBy('sala_id', 'jugador');
    
        $sala = DB::table('salas')
        ->join('users as u1', 'salas.player_one', '=', 'u1.id')
        ->join('users as u2', 'salas.plater_two', '=', 'u2.id')
        ->leftJoinSub($apuestasSubquery, 'apuestas', function($join) {
            $join->on('salas.id', '=', 'apuestas.sala_id');
        })
        ->select(
            'salas.nombre_sala',
            'salas.cuota_player_one',
            'salas.cuota_player_two',
            'u1.name as player_one_name',
            'u2.name as player_two_name',
            'apuestas.jugador',
            'apuestas.total_ganancia',
            'monto'

        )
        ->where('salas.id', $id)
        ->get();
       //return response(["sala"=>$sala]);
        return view("vendor.voyager.apuestas.index",compact("sala"));
    }
}
