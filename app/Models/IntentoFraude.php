<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntentoFraude extends Model
{
    use HasFactory;
    protected $table = 'intento_fraudes';

    protected $fillable = [
        'usuario_id',
        'motivo',
        'direccion_ip',
        'agente_usuario',
        'detectado_en',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
