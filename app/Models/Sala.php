<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Sala extends Model
{
    public function apuestas()
    {
        return $this->hasMany(Apuesta::class);
    }

    public function actualizarCuotas()
{
    $totalApostado = $this->apuestas()->sum('monto');
    $apuestaOne = $this->apuestas()->where('jugador', 'player_one')->sum('monto');
    $apuestaTwo = $this->apuestas()->where('jugador', 'player_two')->sum('monto');

    // Evitar división por cero
    $this->cuota_player_one = $apuestaOne > 0 ? round($totalApostado / $apuestaOne, 2) : 2.00;
    $this->cuota_player_two = $apuestaTwo > 0 ? round($totalApostado / $apuestaTwo, 2) : 2.00;

    $this->save();
}
}
