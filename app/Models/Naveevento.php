<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Naveevento extends Model
{
    protected $table = 'naveeventos';
    use HasFactory;
    protected $fillable = ["id_evento","id_jugador","puntuacion","tiempo"];
    
    public function setPuntuacionAttribute($value)
    {
        $this->attributes['puntuacion'] = Crypt::encryptString($value);
    }
    public function getPuntuacionAttribute($value)
    {
        return (int)Crypt::decryptString($value);
       
    }
    public function setTiempoAttribute($value)
    {
        $value= str_replace(',', ';', $value);
        $this->attributes['tiempo'] = Crypt::encryptString($value);
    }
    public function getTiempoAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_jugador');
    }

}
