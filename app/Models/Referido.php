<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Referido extends Model
{

    protected $table = 'referidos';

    protected $fillable = [
        'user_id',
        'referred_user_id'
    ];
 
 public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación para acceder al usuario que hizo la invitación
    public function referente()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
    
}
