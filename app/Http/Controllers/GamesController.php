<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GamesController extends Controller
{
   public function Genius(){

    //return response(["data"=>"hola"]);
    return view('Unity.unity-game');
   }
   public function Navial(){

      //return response(["data"=>"hola"]);
      return view('Unity.navial');
   }
   public function Cars(){

      //return response(["data"=>"hola"]);
      return view('Unity.cars');
   }
}
