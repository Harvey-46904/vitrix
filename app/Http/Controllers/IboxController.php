<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CashMoney;
use DB;
class IboxController extends Controller
{
    protected $cashService;
    public function __construct(CashMoney $cashService)
    {
        $this->cashService = $cashService;
       
    }
    public function addFoundibox($id){
        $userId =auth()->user()->id;
        $compra_ibox=DB::table("iboxes")->where("id","=",$id)->first();
        $amount=$compra_ibox->beneficio;
       
        $this->cashService->AddMoneyCards($userId, $amount,'Compra Ibox');
        return redirect()->route('wave.dashboard')->with('success', 'Configuraciones actualizadas exitosamente.');
        return response(["data"=>"compra realizada correctametne"]);

    }

    public function addFoundiboxBalance($id){
        $user=auth()->user();
       
        $compra_ibox=DB::table("iboxes")->where("id","=",$id)->first();
       
        $precio_compra=$compra_ibox->precio_compra;
      
        $userId=$user->id;
       
        $balance=$user->balance_general->balance;
      
        if($balance>=$precio_compra){
           // return response(["data"=>"alteracion"]);
            $amount=$compra_ibox->beneficio;
            $this->cashService->AddMoneyBalance($userId,-$precio_compra,'Descuento compra Ibox');
            DB::table('pagos')->insert([
                'sender'           => "Balance",
                'amount'           => $precio_compra,
                'reason'           => "ibox",
                'transaction_hash' => "No hash",
                'user_id'          => $userId,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
            $this->cashService->AddMoneyCards($userId, $amount,'Compra Ibox con Balance');
            return response(["data"=>"Compra Realizada"]);
        }else{
            return response(["data"=>"alteracion"]);
        }
       
    }
}
