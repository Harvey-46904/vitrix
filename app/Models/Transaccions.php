<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class Transaccions extends Model
{
    protected $table = 'user_transaccion';
    use HasFactory;
    protected $fillable = ['user_id', 'amount','type','balance_after'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
