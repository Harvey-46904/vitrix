<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
class Apuesta extends Model
{
    use HasFactory;
    protected $table = 'apuestas';

    protected $fillable = [
        'user_id',
        'game_id',
        'bet_amount',
        'win_amount',
        'outcome',
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function calcularFRPDeJugador($userId)
    {
        return self::selectRaw('
            SUM(win_amount) * 100.0 / NULLIF(SUM(bet_amount), 0) AS FRP
        ')
        ->where('user_id', $userId)
        ->first()->FRP ?? 0;
    }

}
