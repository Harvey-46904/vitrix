<?php
namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\Listnave;
use DB;

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
        $juegos = DB::table("juegos")->select()->get();
        $salas  = DB::table('salas')
            ->join('users as u1', 'salas.player_one', '=', 'u1.id')
            ->join('users as u2', 'salas.plater_two', '=', 'u2.id')
            ->select(
                'salas.*',
                'u1.username as player_one_name',
                'u2.username as player_two_name'
            )
            ->get();
        $banners = DB::table("banners")->where("activo", "=", 1)->get();
        $eventos = $this->ListNaves(); // Llama a tu función

      //  return response(["data" => $salas]);
        return view('theme::dashboard.index', compact('juegos', 'eventos', 'salas', 'banners'));
    }
}
