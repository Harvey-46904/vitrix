<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apuestascar extends Model
{
    use HasFactory;

    protected $fillable = ['sala_id','jugador','monto','posible_ganancia','cuota','estado','jugador_apostador'];

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
