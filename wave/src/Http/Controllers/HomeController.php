<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(setting('auth.dashboard_redirect', true) != "null"){
    		if(!Auth::guest()){
    			return redirect('dashboard');
    		}
    	}

        $seo = [

            'title'         => setting('site.title', 'Laravel Wave'),
            'description'   => setting('site.description', 'Software as a Service Starter Kit'),
            'image'         => url('/og_image.png'),
            'type'          => 'website'

        ];
        $juegos=self::consulta_juegos();
        $banners=self::consulta_banners();
        return view('theme::home', compact('seo','juegos','banners'));
    }

    public function consulta_juegos(){
        return $juegos=DB::table("juegos")->get();
    }

    public function consulta_banners(){
        return $juegos=DB::table("banners")->where("activo","=",1)->get();
    }
}
