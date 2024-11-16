<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class UserPaquete extends Model
{
    protected $table = 'user_paquetes';
    use HasFactory;
    protected $fillable = ["user_id","id_inversion","monto_depositar","monto_parcial","monto_invertido","paquete_nombre","paquete_porcentaje","paquete_meta"];
    	

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
