<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\CashMoney;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class GamesController extends Controller
{

   protected $cashService;
   public function __construct(CashMoney $cashService)
   {
       $this->cashService = $cashService;
   }
   public function Genius(){
      $token= self::getToken();
    return view('Unity.unity-game',compact("token"));
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
}
