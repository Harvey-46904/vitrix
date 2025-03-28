<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retiro extends Model
{
    protected $table = 'retiros';
    use HasFactory;
    protected $fillable = ['id_user','billetera','monto'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        // Formatear antes de guardar en la base de datos
        public function setMontoAttribute($value)
        {
            $this->attributes['monto'] = number_format($value, 2, '.', '');
        }
    
        // Formatear al recuperar
        public function getMontoAttribute($value)
        {
            return number_format($value, 2, '.', '');
        }
}
