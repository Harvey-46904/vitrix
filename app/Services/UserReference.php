<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
class UserReference
{
    public function RolUsuario($id_usuario){
        return response(["data"=>$id_usuario]);
    }
}