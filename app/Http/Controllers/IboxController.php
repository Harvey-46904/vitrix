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
}
