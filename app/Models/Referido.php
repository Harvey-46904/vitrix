<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Referido extends Model
{
    protected $fillable = [
        'user_id',
        'referred_user_id'
    ];
 
}
