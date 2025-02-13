<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IboxController extends Controller
{
    public function addFoundibox($id){
        return response(["data"=>"hola".$id]);
    }
}
