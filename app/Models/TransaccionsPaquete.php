<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class TransaccionsPaquete extends Model
{
    protected $table = 'paquete_transaccion';
    use HasFactory;
    protected $fillable = ['user_paquetes_id', 'amount','razon','created_at','updated_at'];

    public function userpaquete()
    {
        return $this->belongsTo(UserPaquete::class);
    }
}
