<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Naveevento;
use App\Services\CashMoney;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;
use DB;
use App\Traits\Listnave;
class GamesController extends Controller
{
   use Listnave;

   protected $cashService;
   public function __construct(CashMoney $cashService)
   {
       $this->cashService = $cashService;
   }
   public function Genius(){
      $token= self::getToken();
   // return view('Unity.unity-game',compact("token"));
   return view('Unity.genius',compact("token"));
   }
   public function Navial(){
      return view('Unity.navial');
   }
   public function Cars(){
      return view('Unity.cars');
   }

   public function GeniusPlayGame(Request $request)
   {
     
      $valor_apostado=$request->apuesta;
      $user = Auth::user();
      $userId =$user->id;
      $cash=$this->cashService->GetMoneyBalance($userId);

      $validationhash=[
            'userId' => $userId,
            'valor_apostado' => $valor_apostado,
      ];
      $arrayJson = json_encode($validationhash);
      $arrayEncriptado = Crypt::encrypt($arrayJson);
       if (!$user) {
           return response()->json(['error' => 'Usuario no autenticado'], 401);
       }
       if($cash >= $valor_apostado){
         $this->cashService->AddMoneyBalance($userId, -$valor_apostado,"Apuesta Casino");
         return response()->json([
            'status' => 'Suerte',
            'user' => $arrayEncriptado,
         ]);
       }else{
         return response()->json([
            'status' => 'No tiene fondos',
            'user' => "no user",
         ]);
       }   
   }

   public function ApuestaSalvaGame(Request $request){
      $multiplicador=$request->multiplicador;
      $arrayEncriptado=$request->hash;
      $arrayJsonDesencriptado = Crypt::decrypt($arrayEncriptado);
      $arrayDesencriptado = json_decode($arrayJsonDesencriptado, true);
      $multiplicador = str_replace(',', '.', $multiplicador);
      $multiplicador = (float) $multiplicador; 
      $ganancia=$arrayDesencriptado["valor_apostado"]* $multiplicador;
      $ganancia = number_format($ganancia, 2, '.', ''); 
      $userId=$arrayDesencriptado["userId"];
      $this->cashService->AddMoneyBalance($userId, $ganancia,"Ganancia");
      return response(["data"=>$ganancia]);
   }

   public function getToken()
   {
       $user = Auth::user(); // Obtener el usuario autenticado
       if (!$user) {
           return response()->json(['error' => 'No autenticado'], 401);
       }

       // Generar el token JWT
       $token = JWTAuth::fromUser($user);
       return  $token;
       return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
           'expires_in' => auth('api')->factory()->getTTL() * 60, // Tiempo de expiración en segundos
       ]);
   }

  

   public function CompetenciaNave(Request $request){
      
     
      $naveevento = Naveevento::create([
         'id_evento' => $this->ultimo_evento()->id, 
         'id_jugador' => auth()->user()->id, // Reemplaza con el valor correspondiente
         'puntuacion' => $request->puntuacion, // Reemplaza con el valor correspondiente
         'tiempo' => $request->tiempo, // Reemplaza con el valor correspondiente
     ]);
     $id = $naveevento->id;
     return $id;
   }

  

   public function createRoom(Request $request)
   {
      //return response(["create"=>"creando room"]);
      
      $client = new Client();
      $appId = '726ec537-cf35-4d9d-a625-52d19dc9cab0';
      $region = 'eu';
      $roomName = $request->input('roomName');
      $maxPlayers = $request->input('maxPlayers');

      $response = $client->post("https://$region.exitgames.com:443/App/$appId/CreateRoom", [
         'json' => [
               'RoomName' => $roomName,
               'MaxPlayers' => $maxPlayers,
         ],
      ]);

      return response()->json(json_decode($response->getBody(), true));
   }
}
