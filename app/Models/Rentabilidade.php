<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rentabilidade extends Model
{
    protected $table = 'rentabilidades';

    protected $fillable = [
        'id_inversion',
        'formato_rentabilidad'
    ];
 
}
