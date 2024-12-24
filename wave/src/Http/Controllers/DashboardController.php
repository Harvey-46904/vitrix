<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Naveevento;
use App\Traits\Listnave;
class DashboardController extends Controller
{
    use Listnave;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
 
    public function index()
    {
        $juegos=DB::table("juegos")->select()->get();
        $salas=DB::table("salas")->get();
        $banners=DB::table("banners")->where("activo","=",1)->get();
        $eventos = $this->ListNaves(); // Llama a tu función
        
       //return response(["data"=>$eventos["lista"]]);
        return view('theme::dashboard.index',compact('juegos','eventos','salas','banners'));
    }
}
