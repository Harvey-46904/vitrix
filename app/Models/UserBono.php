<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class UserBono extends Model
{
    
    protected $table = 'user_bonos';
    use HasFactory;
    protected $fillable = ['user_id', 'balance','balance_hash'];
    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = Crypt::encryptString($value);
    }
    public function getBalanceAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
