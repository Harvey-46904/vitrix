<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class UserInversion extends Model
{
    protected $table = 'user_inversion';
    use HasFactory;
    protected $fillable = ['user_id', 'balance','balance_hash'];
    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = Crypt::encryptString($value);
    }
    public function getBalanceAttribute($value)
    {
        return $value ? number_format(Crypt::decryptString($value), 2, '.', '') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
