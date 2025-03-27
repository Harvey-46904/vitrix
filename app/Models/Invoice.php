<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Invoice extends Model
{
    use HasFactory;


    protected $fillable = ['user_id','hash_id','reason','amount','status'];


   

    public function setReasonAttribute($value)
    {
        $this->attributes['reason'] = Crypt::encryptString($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = Crypt::encryptString($value);
    }

    // 🔹 Desencripta al acceder
   
    public function getReasonAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getAmountAttribute($value)
    {
        return Crypt::decryptString($value);
    }

}
