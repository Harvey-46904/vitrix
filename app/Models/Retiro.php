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
}
